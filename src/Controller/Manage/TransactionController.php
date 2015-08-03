<?php

namespace App\Controller\Manage;

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
            'contain' => ['Wallet', 'Category']
        ];
        $dataWallet = $this->Wallet->checkExist($walletId);
        if (is_null($dataWallet)) {
            $this->Flash->error(__(Configure::read('message.wallet_not_found')));
            $this->redirect(['_name' => 'wallet']);
        }
        $this->set('walletId', $walletId);
        $this->set('transaction', $this->paginate($this->Transaction->getDataIndex($walletId)));
        $this->set('_serialize', ['transaction']);
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
            $transaction = $this->Transaction->patchEntity($transaction, $this->request->data);
            if ($this->Transaction->save($transaction)) {
                $this->Flash->success(__('The transaction has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The transaction could not be saved. Please, try again.'));
            }
        }
        $tblCategory = $this->Category->getCategoryforTransaction($walletId);        
        $this->set(compact('transaction', 'tblCategory'));
        $this->set('_serialize', ['transaction']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Transaction id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $transaction = $this->Transaction->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $transaction = $this->Transaction->patchEntity($transaction, $this->request->data);
            if ($this->Transaction->save($transaction)) {
                $this->Flash->success(__('The transaction has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The transaction could not be saved. Please, try again.'));
            }
        }
        $parentTransactions = $this->Transaction->ParentTransactions->find('list', ['limit' => 200]);
        $tblCategory = $this->Transaction->TblCategory->find('list', ['limit' => 200]);
        $this->set(compact('transaction', 'parentTransactions', 'tblCategory'));
        $this->set('_serialize', ['transaction']);
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
        $this->request->allowMethod(['post', 'delete']);
        $transaction = $this->Transaction->get($id);
        if ($this->Transaction->delete($transaction)) {
            $this->Flash->success(__('The transaction has been deleted.'));
        } else {
            $this->Flash->error(__('The transaction could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
