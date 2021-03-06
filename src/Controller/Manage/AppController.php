<?php

namespace App\Controller\Manage;

use Cake\Controller\Controller;

/**
 * @author dungpv <dungpv@rikkeisoft.com>
 */
class AppController extends Controller
{

    public $limit=10;
    
    public function initialize()
    {
        parent::initialize();
        date_default_timezone_set("Asia/Bangkok");
        $this->layout = "Manage/index";
        $this->loadComponent("csrf");
        $this->loadComponent('Flash');
        $this->loadModel('Wallet');
        $this->loadComponent('Auth', [
            'loginAction' => [
                '_name' => 'login'
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
        $this->set('listWallet', $this->Wallet->getWallet($this->Auth->user('id')));
        $this->set('wallet_id', $this->request->wallet_id);
        if ($this->request->wallet_id) {
            $this->set('wallet_name', $this->Wallet->getWalletName($this->request->wallet_id));
            $this->set('wallet_amount', $this->Wallet->getWalletAmount($this->request->wallet_id));
        }
    }

}
