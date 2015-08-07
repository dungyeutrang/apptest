<?php

namespace App\Controller\Manage;

use Cake\Core\Configure;
use DateTime;

/**
 * Transaction Controller
 *
 * @property \App\Model\Table\TransactionTable $Transaction
 */
class TransactionController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Category');
        $this->loadModel('MstCatalog');
        $this->loadModel('CategoryDelete');
        $this->loadModel('Wallet'); 
        $this->loadModel('TblUser');
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $walletId = $this->request->wallet_id;
        $this->paginate = [
            'limit' => 10,
            'order' => [
                'Category.name' => 'asc'
            ],
        ];
        $dataWallet = $this->Wallet->checkExist($walletId);
        if (is_null($dataWallet)) {
            $this->Flash->error(__(Configure::read('message.wallet_not_found')));
            $this->redirect(['_name' => 'wallet']);
        }
        $this->TblUser->UpdateLastWallet($walletId,$this->Auth->user('id'));
        $this->set('walletId', $walletId);
        $this->set('dataWallet', $dataWallet);
        $this->set('transaction', $this->paginate($this->Transaction->getDataIndex($walletId)));
        $this->set('_serialize', ['transaction']);
    }

    public function query()
    {

        $query = $this->request->query_date;
        $walletId = $this->request->wallet_id;
        $this->paginate = [
            'limit' => 2,
            'order' => [
                'Category.name' => 'asc'
            ],
        ];
        if ($query == "today") {
            $type = 1;
        } else if ($query == "this-week") {
            $type = 2;
        } else {
            $type = 3;
        }
        $dataWallet = $this->Wallet->checkExist($walletId);
        if ($this->request->is(['ajax', 'post'])) {

            $this->layout = "/Manage/ajax";
            $this->set('walletId', $walletId);
            $this->set('queryDate', $query);
            $this->set('dataWallet', $dataWallet);
            $this->set('transaction', $this->paginate($this->Transaction->getDataQuery($walletId, $type)));
            $this->set('_serialize', ['transaction']);
            $this->render('/Manage/Transaction/query_ajax');
        } else {


            if (is_null($dataWallet)) {
                $this->Flash->error(__(Configure::read('message.wallet_not_found')));
                $this->redirect(['_name' => 'wallet']);
            }
            $this->set('walletId', $walletId);
            $this->set('queryDate', $query);
            $this->set('dataWallet', $dataWallet);
            $this->set('transaction', $this->paginate($this->Transaction->getDataQuery($walletId, $type)));
            $this->set('_serialize', ['transaction']);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Transaction id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $transaction = $this->Transaction->get($id, [
            'contain' => ['ParentTransactions', 'TblCategory']
        ]);
        $this->set('transaction', $transaction);
        $this->set('_serialize', ['transaction']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $walletId = $this->request->wallet_id;
        $dataWallet = $this->Wallet->checkExist($walletId);
        if (is_null($dataWallet)) {
            $this->Flash->error(__(Configure::read('message.wallet_not_found')));
            $this->redirect(['_name' => 'wallet']);
        }
        $transaction = $this->Transaction->newEntity();
        if ($this->request->is('post')) {
            $amount = str_replace('.', '', $this->request->data['amount']);
            $transaction = $this->Transaction->patchEntity($transaction, $this->request->data);
            $transaction->amount = $amount;
            $transaction->wallet_id = $walletId;
            $this->Transaction->connection()->begin();
            try {
                if ($this->Transaction->save($transaction)) {
                    if ($this->Category->getCatalogId($transaction->category_id) == 1) {
                        $dataWallet->amount = $dataWallet->amount + $transaction->amount;
                    } else {
                        $dataWallet->amount = $dataWallet->amount - $transaction->amount;
                    }
                    $this->Wallet->save($dataWallet);
                    $this->Transaction->connection()->commit();
                    $this->Flash->success(__(Configure::read('message.add_transaction_success')));
                    return $this->redirect(['action' => 'index', 'wallet_id' => $walletId]);
                }
            } catch (Exception $ex) {
                $this->Transaction->connection()->rollback();
                $this->Flash->error(__(Configure::read('message.add_transaction_fail')));
            }
        }
        $tblCategory = $this->Category->getCategoryforTransaction($walletId);
        $tblCatalog = $this->Category->getMstCatalog();
        $this->set(compact('transaction', 'tblCategory', 'tblCatalog', 'walletId'));
        $this->set('_serialize', ['transaction']);
    }

    public function getData()
    {
        $response = array();
        $walletId = $this->request->wallet_id;
        $catalogId = $this->request->data('catalogId');
        $dataWallet = $this->Wallet->checkExist($walletId);
        $dataCatalog = $this->MstCatalog->checkExist($catalogId);
        if (is_null($dataWallet || is_null($dataCatalog))) {
            $response['code'] = 1;
            echo json_encode($response);
            die;
        } else {
            $response['code'] = 2;
            $response['data'] = $this->Category->getCategoryForAddTransaction($walletId, $catalogId);
            echo json_encode($response);
            die();
        }
    }

    /**
     * Edit method     
     * @param string|null $id Transaction id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit()
    {
        $id = $this->request->id;
        $transaction = $this->Transaction->getTransaction($id);
        if (!$transaction) {
            $this->Flash->error(__(Configure::read('message.transaction_not_found')));
            return $this->redirect(['_name' => 'wallet']);
        } else {
            if ($this->request->is(['post', ['put']])) {
                $amountOld = $transaction->amount;
                $transaction = $this->Transaction->patchEntity($transaction, $this->request->data);
                $amount = str_replace('.', '', $this->request->data['amount']);
                $transaction->amount = $amount;
                $dataWallet = $this->Wallet->checkExist($transaction->wallet_id);
                $this->Transaction->connection()->begin();
                $transaction->updated_at = new DateTime('now');
                try {
                    if ($this->Transaction->save($transaction)) {
                        if ($this->Category->getCatalogId($transaction->category_id) == 1) {
                            $dataWallet->amount = $dataWallet->amount + $transaction->amount - $amountOld;
                        } else {
                            $dataWallet->amount = $dataWallet->amount - ($transaction->amount - $amountOld);
                        }
                        $this->Wallet->save($dataWallet);
                        $this->Transaction->connection()->commit();
                        $this->Flash->success(__(Configure::read('message.update_transaction_success')));
                        return $this->redirect(['action' => 'index', 'wallet_id' => $transaction->wallet_id]);
                    }
                } catch (Exception $ex) {
                    $this->Transaction->connection()->rollback();
                    $this->Flash->error(__(Configure::read('message.update_transaction_fail')));
                }
            }
            $tblCategory = $this->Category->getCategoryUpdateTransaction($transaction->wallet_id, $transaction->category->mst_catalog->id);
            $tblCatalog = $this->Category->getMstCatalog();
            $this->set(compact('transaction', 'tblCategory', 'tblCatalog', 'walletId'));
            $this->set('_serialize', ['transaction']);
            $this->set('wallet_id',$transaction->wallet_id);
            $this->set('wallet_name',$this->Wallet->getWalletName($transaction->wallet_id));
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Transaction id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $id = $this->request->id;
        $transaction = $this->Transaction->getTransaction($id);
        if (!$transaction) {
            $this->Flash->error(__(Configure::read('message.transaction_not_found')));
            return $this->redirect(['_name' => 'wallet']);
        }
        $transaction->status = 1;
        $dataWallet = $this->Wallet->checkExist($transaction->wallet_id);
        try {
            if ($this->Transaction->save($transaction)) {
                if ($this->Category->getCatalogId($transaction->category_id) == 1) {
                    $dataWallet->amount = $dataWallet->amount - $transaction->amount;
                } else {
                    $dataWallet->amount = $dataWallet->amount + $transaction->amount;
                }
                $this->Wallet->save($dataWallet);
                $this->Transaction->connection()->commit();
                $this->Flash->success(__(Configure::read('message.delete_transaction_success')));
                return $this->redirect(['action' => 'index', 'wallet_id' => $transaction->wallet_id]);
            }
        } catch (Exception $ex) {
            $this->Flash->error(__(Configure::read('message.delete_transaction_fail')));
        }
    }

}
