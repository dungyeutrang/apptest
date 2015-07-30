<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Category Controller
 *
 * @property \App\Model\Table\CategoryTable $Category
 */
class CategoryController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['TblWallet', 'MstCatalog', 'ParentCategory']
        ];
        $this->set('category', $this->paginate($this->Category));
        $this->set('_serialize', ['category']);
    }

    /**
     * View method
     *
     * @param string|null $id Category id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $category = $this->Category->get($id, [
            'contain' => ['TblWallet', 'MstCatalog', 'ParentCategory', 'ChildCategory']
        ]);
        $this->set('category', $category);
        $this->set('_serialize', ['category']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $category = $this->Category->newEntity();
        if ($this->request->is('post')) {
            $category = $this->Category->patchEntity($category, $this->request->data);
            if ($this->Category->save($category)) {
                $this->Flash->success(__('The category has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The category could not be saved. Please, try again.'));
            }
        }
        $tblWallet = $this->Category->TblWallet->find('list', ['limit' => 200]);
        $mstCatalog = $this->Category->MstCatalog->find('list', ['limit' => 200]);
        $parentCategory = $this->Category->ParentCategory->find('list', ['limit' => 200]);
        $this->set(compact('category', 'tblWallet', 'mstCatalog', 'parentCategory'));
        $this->set('_serialize', ['category']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $category = $this->Category->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $category = $this->Category->patchEntity($category, $this->request->data);
            if ($this->Category->save($category)) {
                $this->Flash->success(__('The category has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The category could not be saved. Please, try again.'));
            }
        }
        $tblWallet = $this->Category->TblWallet->find('list', ['limit' => 200]);
        $mstCatalog = $this->Category->MstCatalog->find('list', ['limit' => 200]);
        $parentCategory = $this->Category->ParentCategory->find('list', ['limit' => 200]);
        $this->set(compact('category', 'tblWallet', 'mstCatalog', 'parentCategory'));
        $this->set('_serialize', ['category']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $category = $this->Category->get($id);
        if ($this->Category->delete($category)) {
            $this->Flash->success(__('The category has been deleted.'));
        } else {
            $this->Flash->error(__('The category could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
