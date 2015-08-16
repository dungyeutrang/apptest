<?php

namespace App\Controller\Manage;

use Cake\Core\Configure;
use lib\UploadFile;
use Cake\I18n\I18n;

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
        $this->loadModel('CategoryDelete');
        $this->loadModel('Transaction');
        $this->loadModel('TblUser');
        $this->upload = new UploadFile();
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        I18n::locale('vi');
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
        $this->TblUser->UpdateLastWallet($id, $this->Auth->user('id'));
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
            $this->request->data['wallet_id'] = $id;
            $category = $this->Category->patchEntity($category, $this->request->data);
            $category->avatar=Configure::read('constant.category_default_url');            
            if ($this->Category->save($category)) {
                if (!empty($this->request->data['avatar']['name'])){
                    $dirUpload = '/Uploads' . '/' . $this->Auth->user('id');
                    $this->upload->addDir($dirUpload);
                    $filename = $this->request->data['avatar']['name'];
                    $extension = pathinfo($filename, PATHINFO_EXTENSION);
                    $avatar = $dirUpload . '/' . date('Y-m-d-H-m-s') . '.' . $extension;
                    move_uploaded_file($this->request->data['avatar']['tmp_name'], BASE_URL . $avatar);
                    $category->avatar = $avatar;
                    $this->Category->save($category);
                }                
                $this->Flash->success(__(Configure::read('message.add_category_success')));
                return $this->redirect(['_name' => 'category', 'wallet_id' => $id]);
            } else {
                $this->Flash->error(__(Configure::read('message.add_category_fail')));
            }
        }
        $mstCatalog = $this->Category->getMstCatalog();
        $parentCategory = $this->Category->getParentidAdd($id);
        $this->set(compact('category', 'mstCatalog', 'parentCategory'));
        $this->set('_serialize', ['category']);
        $this->set('walletId', $id);
    }

    /**
     * change data parent id for add method 
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

    public function getDataUpdate()
    {

        $response = array();
        $walletId = $this->request->wallet_id;
        $catalogId = $this->request->data('catalogId');
        $parentId = $this->request->parent_id;
        $id = $this->request->id;

        $dataWallet = $this->Wallet->checkExist($walletId);
        $dataCatalog = $this->MstCatalog->checkExist($catalogId);
        $category = $this->Category->checkExist($id);

        if (is_null($dataWallet || is_null($dataCatalog) || is_null($category))) {
            $response['code'] = 1;
            echo json_encode($response);
            die;
        } else {
            $response['code'] = 2;
            $response['data'] = $this->Category->getCategoryForUpdate($catalogId, $parentId, $walletId, $id);
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
    public function edit()
    {
        $id = $this->request->id;
        $category = $this->Category->checkExist($id);
//        var_dump($category->is_default);die;
        if (!$category) {
            $this->Flash->error(__(Configure::read('message.category_not_found')));
            return $this->redirect(['_name' => 'wallet']);
        }
        if ($category->is_default == 1) {
            $this->Flash->error(__(Configure::read('message.category_not_update')));
            return $this->redirect($this->referer());
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $avatarOld = $category->avatar;
            $category = $this->Category->patchEntity($category, $this->request->data);
            if (empty($this->request->data['avatar']['name'])) {
                $category->avatar = $avatarOld;
            }
            if ($this->Category->save($category)) {
                if (!empty($this->request->data['avatar']['name'])) {
                    $dirUpload = '/Uploads' . '/' . $this->Auth->user('id');
                    $this->upload->deleteFile($avatarOld);
                    $filename = $this->request->data['avatar']['name'];
                    $extension = pathinfo($filename, PATHINFO_EXTENSION);
                    $avatar = $dirUpload . '/' . date('Y-m-d-H-m-s') . '.' . $extension;
                    move_uploaded_file($this->request->data['avatar']['tmp_name'], BASE_URL . $avatar);
                    $category->avatar = $avatar;
                    $this->Category->save($category);
                }
                $this->Flash->success(__(Configure::read('message.update_category_success')));
                return $this->redirect(['action' => 'index', 'wallet_id' => $category->wallet_id]);
            } else {
                $this->Flash->error(__(Configure::read('message.update_category_fail')));
            }
        }

        $mstCatalog = $this->Category->getMstCatalog();
        $parentCategory = $this->Category->getParentidUpdate($category->catalog_id, $category->parent_id, $category->wallet_id, $category->id);
        $this->set(compact('category', 'mstCatalog', 'parentCategory'));
        $this->set('_serialize', ['category']);
        $this->set('wallet_id', $category->wallet_id);
        $this->set('wallet_name', $this->Wallet->getWalletName($category->wallet_id));
    }

    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete()
    {
        $id = $this->request->id;
        $walletId = $this->request->wallet_id;
        $dataWallet = $this->Wallet->checkExist($walletId);
        $category = $this->Category->checkExist($id);
        // delete by merge
        if ($this->request->is('ajax')) {
            $idMerge = $this->request->data['id'];
            $categoryMerge = $this->Category->checkExist($id);
            $response = array();
            if (is_null($dataWallet) || is_null($category) || is_null($categoryMerge)) {
                $response['code'] = 1;
            } else {
                $this->Transaction->connection()->begin();
                try {
                    if ($category->is_default == 1 && $category->is_perform == 1) {
                        $this->Transaction->mergeTransaction($walletId, $id, $idMerge);
                        $this->CategoryDelete->add($walletId, $category->id);
                        $response['code'] = 2;
                        $this->Transaction->connection()->commit();
                    } else if ($category->is_default == 1 && $category->is_perform == 0) {
                        $response['code'] = 3;
                    } else {
                        $this->Transaction->mergeTransaction($walletId, $id, $idMerge);
                        $category->status = 1;
                        $this->Category->save($category);
                        $response['code'] = 2;
                        $this->Transaction->connection()->commit();
                    }
                } catch (Exception $ex) {
                    $this->Transaction->connection()->rollback();
                    $response['code'] = 4;
                }
            }
            echo json_encode($response);
            die();
        }
        if (is_null($dataWallet)) {
            $this->Flash->error(__(Configure::read('message.wallet_not_found')));
            return $this->redirect(['_name' => 'wallet']);
        }

        if (!$category) {
            $this->Flash->error(__(Configure::read('message.category_not_found')));
            $this->redirect(['action' => 'index', 'wallet_id' => $walletId]);
        }

        // check transaction of wallet and category
        $transaction = $this->Category->getTransaction($walletId, $category->id)->toArray();
        if (count($transaction) == 0) {
            if ($category->is_default == 1 && $category->is_perform == 1) {
                if ($this->CategoryDelete->add($walletId, $category->id)) {
                    $this->Flash->success(__(Configure::read('message.delete_category_success')));
                } else {
                    $this->Flash->error(__(Configure::read('message.delete_category_fail')));
                }
            } else if ($category->is_default == 1 && $category->is_perform == 0) {
                // message error delete 
                $this->Flash->error(__(Configure::read('message.category_default')));
            } else {
                $category->status = 1;
                if ($this->Category->save($category)) {
                    $this->Flash->success(__(Configure::read('message.delete_category_success')));
                } else {
                    $this->Flash->error(__(Configure::read('message.delete_category_fail')));
                }
            }
        } else {
//            $this->Flash->error(__(Configure::read('message.delete_category_constraint')));
            $this->Transaction->connection()->begin();
            try {
                $this->Transaction->deleteTransaction($walletId, $category->id);
                if ($category->is_default == 1 && $category->is_perform == 1) {
                    $this->CategoryDelete->add($walletId, $category->id);
                } else if ($category->is_default == 1 && $category->is_perform == 0) {
                    $this->Flash->error(__(Configure::read('message.category_default')));
                } else {
                    $category->status = 1;
                    $this->Category->save($category);
                }
                $this->Transaction->connection()->commit();
                $this->Flash->success(__(Configure::read('message.delete_category_success')));
            } catch (Exception $ex) {
                $this->Transaction->connection()->rollback();
                $this->Flash->error(__(Configure::read('message.delete_category_fail')));
            }
        }
        return $this->redirect(['action' => 'index', 'wallet_id' => $walletId]);
    }

    /**
     * check delete data
     */
    public function check()
    {
        if ($this->request->is('ajax')) {
            $response = array();
            $walletId = $this->request->wallet_id;
            $id = $this->request->id;
            $dataWallet = $this->Wallet->checkExist($walletId);
            $category = $this->Category->checkExist($id);
            if (is_null($dataWallet || is_null($category))) {
                $response['code'] = 1;
                echo json_encode($response);
                die;
            }
            // end if  
            $response['code'] = 2;
            $transaction = $this->Category->getTransaction($walletId, $id)->toArray();
            if (count($transaction) == 0) {
                $response['check'] = 1;
            } else {
                $response['check'] = 2;
            }
            echo json_encode($response);
            die();
        } else {
            return $this->redirect(['_name' => 'wallet']);
        }
    }

}
