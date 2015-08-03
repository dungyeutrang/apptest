<?php

namespace App\Controller\Manage;

use Cake\Core\Configure;
use DateTime;

//use App\Model\Table\TransactionTable;

/**
 * Wallet Controller
 *
 * @property \App\Model\Table\WalletTable $Wallet
 */
class WalletController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['TblUser']
        ];
        $this->set('wallet', $this->paginate($this->Wallet->find()->where(['user_id' => $this->Auth->user('id')])));
        $this->set('_serialize', ['wallet']);
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
            $wallet->created_at = date("Y-m-d H:m:s");
            if ($this->Wallet->checkWalletDefault($this->Wallet, $this->Auth->user('id'))) {
                $wallet->is_default = 1;
            }
            $amount =  str_replace('.', '',$this->request->data['amount']);                       
            if ($this->request->data('amount')){
                $data = [
                    'category_id' => 3, // default when add new wallet
                    'note' => Configure::read('message.add_transaction_wallet_new'),
                    'amount' => $amount,
                    'created_at' => new DateTime('now')
                ];
                $this->request->data['transaction'] = [$data];
            }
            $wallet = $this->Wallet->patchEntity($wallet, $this->request->data);
            $wallet->amount=$amount;
            $this->Wallet->connection()->begin();
            try {
                if($this->Wallet->save($wallet, ['associated' => ['Transaction']])){                    
                $this->Wallet->connection()->commit();
                $this->Flash->success(__(Configure::read('message.add_wallet_success')));
                return $this->redirect(['action' => 'index']);
                }else{                    
                $this->Flash->error(__(Configure::read('message.add_wallet_fail')));
                }                
            } catch (Exception $ex) {
                $this->Wallet->connection()->rollback();
            }
        }
//        $tblUser = $this->Wallet->TblUser->find('list', ['limit' => 200]);
        $this->set(compact('wallet'));
        $this->set('_serialize', ['wallet']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Wallet id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id)
    {
        $wallet = $this->Wallet->checkExist($id);
        if (!$wallet) {
            $this->Flash->error(__(Configure::read('message.wallet_not_found')));
            return $this->redirect(['action' => 'index']);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->request->data['updated_at'] = new DateTime('now');
            $wallet = $this->Wallet->patchEntity($wallet, $this->request->data);
            if ($this->Wallet->save($wallet)) {
                $this->Flash->success(__(Configure::read('message.update_wallet_success')));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__(Configure::read('message.update_wallet_fail')));
            }
        }
//        $tblUser = $this->Wallet->TblUser->find('list', ['limit' => 200]);
        $this->set(compact('wallet'));
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
