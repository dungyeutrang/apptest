<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller\Frontend;

use Cake\Controller\Controller;
use Cake\Routing\Router;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->layout = "Frontend/index";
        $this->loadComponent('Flash');
        $this->loadModel('Wallet');
        $this->loadModel('TblUser');
        $this->loadComponent("csrf");
        $this->loadComponent('Auth', [
            'loginAction' => [
                'prefix' => 'Frontend',
                'controller' => 'TblUser',
                'action' => 'login',
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
        $this->set('user', $this->Auth->user());
        if ($this->Auth->user()) {
            $this->set('walletDefault', $this->Wallet->getWalletDefault($this->Auth->user('id')));
        }
    }

}
