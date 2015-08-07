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
        $this->loadModel('Category');
        $this->loadModel('Transaction');        
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
        $this->set('wallet', $this->paginate($this->Wallet->find()->where(['status' => 0, 'user_id' => $this->Auth->user('id')])));
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
            $amount = str_replace('.', '', $this->request->data['amount']);
            if ($this->request->data('amount')) {
                $data = [
                    'category_id' => 3, // default when add new wallet
                    'note' => Configure::read('message.add_transaction_wallet_new'),
                    'amount' => floatval($amount),
                    'created_at' => new DateTime('now')
                ];
                $this->request->data['transaction'] = [$data];
            }
            $wallet = $this->Wallet->patchEntity($wallet, $this->request->data, ['amount']);
            $wallet->amount = floatval($amount);
            $this->Wallet->connection()->begin();
            try {
                if ($this->Wallet->save($wallet, ['associated' => ['transaction']])) {
                    $this->Wallet->connection()->commit();
                    $this->Flash->success(__(Configure::read('message.add_wallet_success')));
                    return $this->redirect(['_name' => 'transaction','wallet_id'=>$wallet->id]);
                } else {
                    $this->Flash->error(__(Configure::read('message.add_wallet_fail')));
                }
            } catch (Exception $ex) {
                $this->Wallet->connection()->rollback();
            }
        }
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
    public function edit()
    {
        $id = $this->request->wallet_id;
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
                return $this->redirect(['_name' => 'transaction','wallet_id'=>$id]);
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
    public function delete()
    {
        $id = $this->request->wallet_id;
        $wallet = $this->Wallet->checkExist($id);
        if (!$wallet) {
            $this->Flash->error(__(Configure::read('message.wallet_not_found')));
            return $this->redirect(['action' => 'index']);
        }
        $this->Wallet->connection()->begin();
        try {
            $this->Category->deleteCategory($id);
            $this->Wallet->deleteWallet($id);
            $this->Transaction->deleteAllTransaction($id);
            $this->Wallet->connection()->commit();
            $this->Flash->success(__(Configure::read('message.delete_wallet_success')));
        } catch (Exception $ex) {
            $this->Wallet->connection()->rollback();
            $this->Flash->error(__(Configure::read('message.delete_wallet_fail')));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     *  show status of wallet
     * @return type
     */
    public function expense()
    {
        $id = $this->request->wallet_id;
        $wallet = $this->Wallet->checkExist($id);
        if (!$wallet) {
            $this->Flash->error(__(Configure::read('message.wallet_not_found')));
            return $this->redirect(['action' => 'index']);
        }
        $dataExpense = $this->Wallet->getExpense($id);
        $dataIncome = $this->Wallet->getIncome($id);
        $balance =$this->Wallet->getAmount($id);
        $dataJsExpense =array();
        $dataJsIncome =array();
        foreach($dataExpense as $index=>$dt){
            $dataJsExpense[$index]['label']=$dt->category->name;
            $dataJsExpense[$index]['data']=$dt->amount;
        }
        $dataExpense=  json_encode($dataJsExpense);
        foreach($dataIncome as $index=>$dt){
            $dataJsIncome[$index]['label']=$dt->category->name;
            $dataJsIncome[$index]['data']=$dt->amount;
        }
        $dataIncome =  json_encode($dataJsIncome);        
        $this->set('dataExpense',$dataExpense);
        $this->set('dataIncome',$dataIncome);
        $this->set('balance',$balance);
    }

}
