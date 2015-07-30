<?php

namespace lib;

use Cake\Core\Configure;
use Cake\Network\Email\Email;
use Cake\Routing\Router;

/**
 * @author dungpv <dungpv@rikkeisoft.com>
 */
class SendMail
{

    /**
     * send mail 
     * @param type $id
     * @param type $email
     * @param type $url
     * @param type $subject
     * @param type $body
     */
    public function send($id, $email, $url, $subject, $body)
    {
        $mail = new Email('default');
        $key = Configure::read('key.encrypt');
        $token = sha1($id . $key);
        $link = Router::url('/', true) . $url . '/' . $token;
        $mail->to($email)
                ->subject($subject)
                ->emailFormat("html")
                ->send("<a href='" . $link . "'>" . $body . "<a>");
    }

}
