<?php

/**
 * Contact Emails
 *
 * @category
 * @package BeardSite
 * @author Tim Marshall <Tim@CodingBeard.com>
 * @copyright (c) 2015, Tim Marshall
 * @license New BSD License
 */

namespace CodingBeard\Emails\Groups;

class Contact
{
    /**
     * Generate an array for a user comment
     * @param $name string
     * @param $email string
     * @param $message string
     * @return array
     */
    public static function comment($name, $email, $message)
    {
        return [
            'folder'    => 'contact',
            'file'      => 'comment',
            'variables' => [
                'name'    => $name,
                'email'   => $email,
                'message' => $message,
            ],
            'from_email' => 'No-reply@',
            'to'         => [['email' => 'tim@codingbeard.com', 'name' => 'Tim']],
            'subject'    => "Website comment from: " . $name,
        ];
    }

}
