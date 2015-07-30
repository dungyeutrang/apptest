<?php
namespace App\Controller\Manage;


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
        $this->paginate = [
            'contain' => ['TblUser']
        ];
        $this->set('wallet', $this->paginate($this->Wallet));
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
