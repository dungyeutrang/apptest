<?php

namespace App\Controller\Manage;

use Cake\Controller\Controller;

/**
 * @author dungpv <dungpv@rikkeisoft.com>
 */
class AppController extends Controller
{

    public function initialize()
    {
        parent::initialize();
        $this->layout = "Manage/index";
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'loginAction' => [
              '_name'=>'login'
            ],
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password'
                    ],
                    'userModel' => 'TblUser'
                ]
            ],
            'logoutRedirect' => [
                'prefix' => 'Frontend',
                'controller' => 'Pages',
                'action' => 'display',
                'home'
            ]
        ]);
    }

}
