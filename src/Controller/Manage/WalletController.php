<?php

namespace App\Controller\Manage;

use Cake\Core\Configure;

/**
 * Wallet Controller
 *
 * @property \App\Model\Table\WalletTable $Wallet
 */
class WalletController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
//        $this->paginate = [
//            'contain' => ['TblUser']
//        ];
//        $this->loadModel('Category');
//        $this->set('wallet', $this->paginate($this->Wallet));
//        $this->set('_serialize', ['wallet']);
        
      
         $data=[
             'name'=>'kdqpdqkdpq',
             'user_id'=>$this->Auth->user('id'),
             'amount'=>1200,
             'category'=>[
                 [
                     'name'=>'nwofnww',
                     'catalog_id'=>1
                 ]
             ]
         ];
         $wallet = $this->Wallet->newEntity($data);
         $this->Wallet->save($wallet, ['associated'=>['category']]);
        die();
    }

    /**
     * View method
     *
     * @param string|null $id Wallet id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $wallet = $this->Wallet->get($id, [
            'contain' => ['TblUser']
        ]);
        $this->set('wallet', $wallet);
        $this->set('_serialize', ['wallet']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $wallet = $this->Wallet->newEntity();
        if ($this->request->is('post')) {
            $wallet->user_id = $this->Auth->user('id');
            $wallet->date_created = date("Y-m-d H:m:s");
            if ($this->Wallet->checkWalletDefault($this->Wallet, $this->Auth->user('id'))) {
                $wallet->is_default = 1;
            }

//              $this->request->data['category']=[['catalog_id' => 1, 'name' => 'chi tieu']];
//              var_dump($this->request->data);die;

            $wallet = $this->Wallet->patchEntity($wallet, $this->request->data);
            $wallet->category = [['catalog_id' => 1, 'name' => 'chi tieu']];
            $wallet->dirty('category', true);
//            var_dump($wallet);die;
//            var_dump($this->Wallet->save($wallet, ['associated' => ['category']]));die;
            
            if ($this->Wallet->save($wallet, ['associated' => ['category']])) {
                $this->Flash->success(__(Configure::read('message.add_wallet_success')));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__(Configure::read('message.add_wallet_fail')));
            }
        }
        $tblUser = $this->Wallet->TblUser->find('list', ['limit' => 200]);
        $this->set(compact('wallet', 'tblUser'));
        $this->set('_serialize', ['wallet']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Wallet id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $wallet = $this->Wallet->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $wallet = $this->Wallet->patchEntity($wallet, $this->request->data);
            if ($this->Wallet->save($wallet)) {
                $this->Flash->success(__('The wallet has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The wallet could not be saved. Please, try again.'));
            }
        }
        $tblUser = $this->Wallet->TblUser->find('list', ['limit' => 200]);
        $this->set(compact('wallet', 'tblUser'));
        $this->set('_serialize', ['wallet']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Wallet id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $wallet = $this->Wallet->get($id);
        if ($this->Wallet->delete($wallet)) {
            $this->Flash->success(__('The wallet has been deleted.'));
        } else {
            $this->Flash->error(__('The wallet could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
