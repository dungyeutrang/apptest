<?php

namespace App\Controller\Frontend;

use Cake\Core\Configure;
use Cake\Network\Email\Email;
use Cake\Routing\Router;

/**
 * TblUser Controller
 *
 * @property \App\Model\Table\TblUserTable $TblUser
 */
class TblUserController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('TblUser');
        $this->Auth->allow(['login', 'add', 'loginHome', 'resetPassword', 'forgetPassword']);
    }

    /**
     * login user at page home
     */
    public function loginHome()
    {
        if ($this->request->is('ajax')) {
            $user = $this->Auth->identify();
            $response = array();
            if ($user && $user['is_active'] == 1) {
                $this->Auth->setUser($user);
                $response['code'] = 1;
            } else if ($user && $user['is_active'] != 1) {
                $response['code'] = 2;
                $response['message'] = Configure::read('message.error_active');
            } else {
                $response['code'] = 2;
                $response['message'] = Configure::read('message.error_login');
            }
            echo json_encode($response);
            die();
        }
    }

    /**
     * login at page login
     * @return type
     */
    public function login()
    {
        if ($this->request->is("post")) {
            $user = $this->Auth->identify();
            if ($user && $user['is_active'] == 1) {
                $this->Auth->setUser($user);
                return $this->redirect(['controller' => 'Pages', 'action' => 'display']);
            } else if ($user && $user['is_active'] != 1) {
                $this->Flash->error(__(Configure::read('message.error_active')));
            } else {
                $this->Flash->error(__(Configure::read('message.error_login')));
            }
        }
    }

    /**
     * logout user
     */
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    /**
     * for get password
     */
    public function forgetPassword()
    {

        if ($this->request->is("post")) {
            $emailuser = $this->request->data('email');
            $user = $this->TblUser->getAccount($emailuser);
            if ($user) {
                $email = new Email('default');                
                $link = Router::url('/', true) . 'resetpassword/' . $token;
//                var_dump($link);die;
                $email->to($emailuser)
                        ->subject("Money Lover !.Reset password")
                        ->emailFormat("html")
                        ->send("<a href='" . $link . "'>Click here to reset your password<a>");
                return $this->redirect(['controller' => 'Pages', 'action' => 'display']);
            } else {
                $this->Flash->error(__(Configure::read('message.account_not_exist')));
            }
        }
    }

    public function resetPassword()
    {
       
        die();
    }

    /**
     * View method
     *
     * @param string|null $id Tbl User id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tblUser = $this->TblUser->get($id, [
            'contain' => ['LastWallets']
        ]);
        $this->set('tblUser', $tblUser);
        $this->set('_serialize', ['tblUser']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tblUser = $this->TblUser->newEntity();
        if ($this->request->is('post')) {
            $tblUser = $this->TblUser->patchEntity($tblUser, $this->request->data);
            if ($this->TblUser->save($tblUser)) {
                $this->Flash->success(__(Configure::read('message.register_success')), ['key' => 'register']);
                return $this->redirect(['controller' => 'Pages', 'action' => 'display']);
            } else {
                $this->Flash->error(__(Configure::read('message.register_fail')));
            }
        }
        $this->set(compact('tblUser'));
        $this->set('_serialize', ['tblUser']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Tbl User id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tblUser = $this->TblUser->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tblUser = $this->TblUser->patchEntity($tblUser, $this->request->data);
            if ($this->TblUser->save($tblUser)) {
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The tbl user could not be saved. Please, try again.'));
            }
        }
        $lastWallets = $this->TblUser->LastWallets->find('list', ['limit' => 200]);
        $this->set(compact('tblUser', 'lastWallets'));
        $this->set('_serialize', ['tblUser']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Tbl User id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tblUser = $this->TblUser->get($id);
        if ($this->TblUser->delete($tblUser)) {
            $this->Flash->success(__('The tbl user has been deleted.'));
        } else {
            $this->Flash->error(__('The tbl user could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
