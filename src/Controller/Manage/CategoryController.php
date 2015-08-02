<?php

namespace App\Controller\Manage;

use Cake\Core\Configure;
use lib\UploadFile;

/**
 * Category Controller
 *
 * @property \App\Model\Table\CategoryTable $Category
 */
class CategoryController extends AppController
{

    public $upload;

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Wallet');
        $this->loadModel('MstCatalog');
        $this->upload = new UploadFile();
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $id = $this->request->wallet_id;
        $this->paginate = [
            'limit' => 10,
            'order' => [
                'Category.name' => 'asc'
            ],
            'contain' => ['Wallet', 'MstCatalog']
        ];
        $dataWallet = $this->Wallet->checkExist($id);
        if (is_null($dataWallet)) {
            $this->Flash->error(__(Configure::read('message.wallet_not_found')));
            $this->redirect(['_name' => 'wallet']);
        }
        $this->set('walletId', $id);
        $this->set('walletName', $dataWallet->name);
        $this->set('category', $this->paginate($this->Category->getCategoryByWallet($id)));
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
        $id = $this->request->wallet_id;
        $dataWallet = $this->Wallet->checkExist($id);

        if (is_null($dataWallet)) {
            $this->Flash->error(__(Configure::read('message.wallet_not_found')));
            $this->redirect(['_name' => 'wallet']);
        }
        $category = $this->Category->newEntity();
        if ($this->request->is('post')) {
            $category = $this->Category->patchEntity($category, $this->request->data);
//            var_dump($this->Category->save($category));die;
            if ($this->Category->save($category)) {
                $dirUpload = '/Uploads' . '/' . $this->Auth->user('id');
                $this->upload->addDir($dirUpload);
                $filename = $this->request->data['avatar']['name'];
                $extension = pathinfo($filename, PATHINFO_EXTENSION);
                $avatar = $dirUpload . '/' . date('Y-m-d-H-m-s') . '.' . $extension;
                move_uploaded_file($this->request->data['avatar']['tmp_name'], BASE_URL . $avatar);
                $category->avatar = $avatar;
                $this->Category->save($category);
                $this->Flash->success(__(Configure::read('message.add_category_success')));
                return $this->redirect(['_name' => 'category', 'wallet_id' => $id]);
            } else {
                $this->Flash->error(__(Configure::read('message.add_category_fail')));
            }
        }
        $mstCatalog = $this->Category->MstCatalog->find('list');
        $parentCategory = $this->Category->find('list', ['limit' => 200])->where(['catalog_id' => 1])->toArray();
        $this->set(compact('category', 'mstCatalog', 'parentCategory'));
        $this->set('_serialize', ['category']);
        $this->set('walletId', $id);
    }

    /**
     * change data parent id 
     */
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
            $response['data'] = $this->Category->getCategoryForAdd($walletId, $catalogId);
            echo json_encode($response);
            die();
        }
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
        $mstCatalog = $this->Category->MstCatalog->find('list', ['limit' => 200]);
        $parentCategory = $this->Category->ParentCategory->find('list', ['limit' => 200]);
        $this->set(compact('category', 'mstCatalog', 'parentCategory'));
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
