<?php

/**
 * Account controller, url: /account
 *
 * @category
 * @package BeardSite
 * @author Tim Marshall <Tim@CodingBeard.com>
 * @copyright (c) 2015, Tim Marshall
 * @license New BSD License
 */

namespace frontend\controllers;

use CodingBeard\Emails\Groups\Account;
use CodingBeard\Forms\Fields\Captcha;
use CodingBeard\Forms\Fields\Checkbox;
use CodingBeard\Forms\Fields\Dateselect;
use CodingBeard\Forms\Fields\Password;
use CodingBeard\Forms\Fields\Textbox;
use models\Authtokens;
use models\Emailchanges;
use models\Users;

class AccountController extends ControllerBase
{

    /**
     * Registration page
     */
    public function registerAction()
    {
        $this->tag->appendTitle("Register");

        $form = $this->forms;
        $form->title = 'Register';
        $form->description = 'Create an account';
        $form->submitButton = 'Create';

        $form
            ->addField(new Textbox(['key' => 'firstName', 'label' => 'First Name', 'required' => true, 'size' => 6]))
            ->addField(new Textbox(['key' => 'lastName', 'label' => 'Last Name', 'required' => true, 'size' => 6]))
            ->addField(new Textbox([
                'key' => 'email',
                'label' => 'Email',
                'required' => true,
                'unique' => ['model' => '\models\Users', 'field' => 'email', 'message' => 'That email is already registered'],
                'repeat' => true,
                'size' => 6
            ]))
            ->addField(new Password([
                'key' => 'password',
                'label' => 'Password',
                'sublabel' => 'Minimum of 8 characters',
                'required' => true,
                'repeat' => true,
                'pattern' => '^.{8,1000}$',
                'size' => 6
            ]))
            ->addField(new Dateselect(['key' => 'DoB', 'label' => 'Date of birth', 'required' => true]))
            ->addField(new Checkbox([
                'key' => 'tos',
                'label' => 'I have read and agree to the <a href="/site/terms">Terms</a>',
                'required' => true
            ]))
            ->addField(new Captcha());

        if ($form->validate()) {
            $user = $form->addToModel(new Users());
            $user->hashPass();
            $user->active = 1;

            if ($user->save()) {
                $user->addRole('Member');
                $user->addRole('Unverified Email');

                $authtoken = Authtokens::newToken(['user_id' => $user->id, 'type' => 'emailverification']);
                $token = $authtoken->string;

                $this->emails->queue(Account::emailVerification($user, $token));

                return $this->auth->redirect('login', 'success', 'Account created successfully, please login.');
            }
        }
        $form->render();
    }

    /**
     * Verify an email
     * @param string $token
     * @return bool
     */
    public function verifyemailAction($token = false)
    {
        if (!$token) {
            return $this->auth->redirect('', 'error', 'Token is missing.');
        }

        if (!($authtoken = Authtokens::checkToken('emailverification', $token))) {
            sleep(1);
            return $this->auth->redirect('', 'error', 'That token is not valid.');
        }

        $user = $authtoken->users;
        $user->removeRole('Unverified Email');
        $user->addRole('Verified Email');

        return $this->auth->redirect('', 'success', 'Thanks for verifying your email.');
    }

    /**
     * Reset password page
     * @param string $token
     * @return bool
     */
    public function resetpassAction($token = false)
    {
        $this->tag->appendTitle("Reset Password");

        if ($token) {
            if (($authtoken = Authtokens::checkToken('passreset', $token))) {
                $this->auth->logUserIn($authtoken->users);
                $this->session->set('reset-pass', true);
                return $this->auth->redirect('account/change-pass', 'success', 'Please set a new password.');
            }
        }
        $form = $this->forms;
        $form->title = 'Reset Password';
        $form->description = 'We will send you an email so you can reset your password';
        $form->cancelHref = '/';

        $form
            ->addField(new Textbox([
                'key' => 'email',
                'label' => 'Email',
                'sublabel' => 'The address you registered with',
                'required' => true,
                'exists' => ['model' => '\Users', 'field' => 'email', 'message' => 'That account does not exists'],
            ]))
            ->addField(new Captcha());

        if ($form->validate()) {
            $user = Users::findFirstByEmail($this->request->getPost('email', 'trim'));
            $authtoken = Authtokens::newToken(['user_id' => $user->id, 'type' => 'passreset', 'unique' => true, 'expires' => 1]);
            $token = $authtoken->string;

            $this->emails->queue(Account::resetPass($user, $token));

            $this->auth->redirect('account/reset-pass', 'success', 'Password reset email sent, please check your spam folder if you cannot find it.');
        }
        $form->render();
    }

    /**
     * Change password page
     * @return bool
     */
    public function changepassAction()
    {
        $this->tag->appendTitle("Change Password");

        $form = $this->forms;
        $form->title = 'Change Password';
        $form->cancelHref = 'account';

        if (!$this->session->has('reset-pass')) {
            $form
                ->addField(new Password([
                    'key' => 'oldpassword',
                    'label' => 'Old Password',
                    'required' => true,
                ]));
        }

        $form
            ->addField(new Password([
                'key' => 'password',
                'label' => 'New Password',
                'sublabel' => 'Minimum of 8 characters',
                'required' => true,
                'repeat' => true,
                'pattern' => '^.{8,1000}$',
                'size' => 6
            ]));

        if ($form->validate()) {
            $user = $this->auth->getUser();

            if ($this->session->has('reset-pass')) {
                $this->session->remove('reset-pass');
            }
            else {
                if (!$user->checkPass($this->request->getPost('oldpassword', 'trim'))) {
                    return $this->auth->redirect('account/change-pass', 'error', 'Incorrect password.');
                }
            }

            $user->password = $this->request->getPost('password', 'trim');
            $user->hashPass();
            $user->save();

            $this->auth->redirect('account', 'success', 'Password changed.');
        }
        $form->render();
    }

    /**
     * Change Email address page
     * @param string $token
     * @return type
     */
    public function changeemailAction()
    {
        $this->tag->appendTitle("Change Email");

        $form = $this->forms;
        $form->title = 'Change Email';
        $form->cancelHref = 'account';

        $form
            ->addField(new Password([
                'key' => 'password',
                'label' => 'Current Password',
                'required' => true,
            ]))
            ->addField(new Textbox([
                'key' => 'email',
                'label' => 'New Email',
                'required' => true,
                'unique' => ['model' => '\Models\Users', 'field' => 'email', 'message' => 'That email is already registered'],
                'repeat' => true,
                'size' => 6
            ]));

        if ($form->validate()) {
            $user = $this->auth->getUser();

            if (!$user->checkPass($this->request->getPost('password', 'trim'))) {
                return $this->auth->redirect('account/change-email', 'error', 'Incorrect password.');
            }

            $authtoken = Authtokens::newToken(['user_id' => $user->id, 'type' => 'emailchangerevoke', 'unique' => true, 'expires' => 7]);
            $token = $authtoken->string;

            $change = new Emailchanges();
            $change->user_id = $user->id;
            $change->authtoken_id = $authtoken->id;
            $change->date = date('Y-m-d H:i:s');
            $change->oldEmail = $user->email;
            $change->save();

            $user->email = $this->request->getPost('email', 'trim');
            $user->save();

            $this->emails->queue(Account::changeEmail($user, $change, $token));

            $this->auth->redirect('account', 'success', 'Email changed.');
        }
        $form->render();
    }

    /**
     * Check a token to revoke an email change
     * @param string $token
     * @return bool
     */
    public function revokeemailchangeAction($token = false)
    {
        if ($token) {
            if (($authtoken = Authtokens::checkToken('emailchangerevoke', $token))) {
                $user = $authtoken->users;
                $change = Emailchanges::findFirstByAuthtoken_id($authtoken->id);

                $user->email = $change->oldEmail;
                $user->save();

                return $this->auth->redirect('account', 'success', 'Email address change revoked.');
            }
        }
        return $this->auth->redirect('account', 'danger', 'Invalid Token.');
    }

    /**
     * Update account info
     */
    public function changeinfoAction()
    {
        $this->tag->appendTitle("Update Account");

        $form = $this->forms;
        $form->title = 'Update Account';
        $form->submitButton = 'Update';
        $form->cancelHref = 'account';

        $form
            ->addField(new Textbox([
                'key' => 'firstName',
                'label' => 'First Name',
                'required' => true,
                'default' => $this->auth->getUser()->firstName,
                'size' => 6
            ]))
            ->addField(new Textbox([
                'key' => 'lastName',
                'label' => 'Last Name',
                'required' => true,
                'default' => $this->auth->getUser()->lastName,
                'size' => 6
            ]))
            ->addField(new Dateselect([
                'key' => 'DoB',
                'label' => 'Date of birth',
                'required' => true,
                'default' => $this->auth->getUser()->DoB,
            ]));

        if ($form->validate()) {
            $user = $form->addToModel($this->auth->getUser());

            if ($user->save()) {
                $this->auth->redirect('account', 'success', 'Account details updated');
            }
        }
        $form->render();
    }

    /**
     * Account
     */
    public function indexAction()
    {
        $this->tag->appendTitle("Account");
    }

}
