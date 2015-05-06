<?php

/**
 * Account Emails
 *
 * @category
 * @package BeardSite
 * @author Tim Marshall <Tim@CodingBeard.com>
 * @copyright (c) 2015, Tim Marshall
 * @license New BSD License
 */


namespace CodingBeard\Emails\Groups;

use models\Users;
use models\Emailchanges;

class Account
{

    /**
     * Send an email verification email
     * @param Users $user
     * @param string $token
     * @return array
     */
    public static function emailVerification($user, $token)
    {
        return [
            'folder'     => 'account',
            'file'       => 'emailVerification',
            'variables'  => [
                'user'  => $user,
                'token' => $token,
            ],
            'from_email' => 'No-reply@',
            'to'         => [['email' => $user->email, 'name' => $user->getName()]],
            'subject'    => "Thanks for registering at CodingBeard! Please verify your email",
        ];
    }

    /**
     * Send an rest pass email
     * @param Users $user
     * @param string $token
     * @return array
     */
    public static function resetPass($user, $token)
    {
        return [
            'folder'     => 'account',
            'file'       => 'resetPass',
            'variables'  => [
                'user'  => $user,
                'token' => $token,
            ],
            'from_email' => 'No-reply@',
            'to'         => [['email' => $user->email, 'name' => $user->getName()]],
            'subject'    => "Password reset",
        ];
    }

    /**
     * Send an email change confirmation/revoke email
     * @param Users $user
     * @param Emailchanges $emailChange
     * @param string $token
     * @return array
     */
    public static function changeEmail($user, $emailChange, $token)
    {
        return [
            [
                'folder'     => 'account',
                'file'       => 'changeEmailRevoke',
                'variables'  => [
                    'user'     => $user,
                    'oldEmail' => $emailChange->oldEmail,
                    'token'    => $token,
                ],
                'from_email' => 'No-reply@',
                'to'         => [['email' => $emailChange->oldEmail, 'name' => $user->getName()]],
                'subject'    => "Your CodingBeard email has been changed",
            ],
            [
                'folder'     => 'account',
                'file'       => 'changeEmailNotice',
                'variables'  => [
                    'user'     => $user,
                    'oldEmail' => $emailChange->oldEmail,
                    'token'    => $token,
                ],
                'from_email' => 'No-reply@',
                'to'         => [['email' => $user->email, 'name' => $user->getName()]],
                'subject'    => "Your CodingBeard email has been changed",
            ],
        ];
    }

}
