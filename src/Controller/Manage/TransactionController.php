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
            'limit' => $this->limit,
            'order' => [
                'Category.name' => 'asc'
            ],
        ];
        $dataWallet = $this->Wallet->checkExist($walletId);
        if (is_null($dataWallet)) {
            $this->Flash->error(__(Configure::read('message.wallet_not_found')));
            $this->redirect(['_name' => 'wallet']);
        }
        $this->TblUser->UpdateLastWallet($walletId, $this->Auth->user('id'));
        $this->set('walletId', $walletId);
        $this->set('dataWallet', $dataWallet);
        $sessionType = $this->request->session()->read('type');
        if (is_null($sessionType) || $sessionType == 1) {
            $this->set('transactions', $this->paginate($this->Transaction->getDataIndex($walletId)));
            $this->set('_serialize', ['transactions']);
            return $this->render('index');
        } else {
            $this->set('transactions', $this->paginate($this->Transaction->getDataIndexByCategory($walletId)));
            $this->set('_serialize', ['transactions']);
            return $this->render('index_category');
        }
    }

    public function query()
    {
        $query = $this->request->query_date;
        $walletId = $this->request->wallet_id;
        $this->paginate = [
            'limit' => $this->limit,
            'order' => [
                'Category.name' => 'asc'
            ],
        ];
        if (strtolower($query) == "today") {
            $type = 1;
        } else if (strtolower($query) == "this-week") {
            $type = 2;
        } else if (strtolower($query) == "this-month") {
            $type = 3;
        } else {
            $type = 4;
        }

        $dataWallet = $this->Wallet->checkExist($walletId);
        if ($this->request->is(['ajax', 'post'])) {
            $this->layout = "/Manage/ajax";
            $this->set('walletId', $walletId);
            $this->set('queryDate', $query);
            $this->set('dataWallet', $dataWallet);
            $sessionType = $this->request->session()->read('type');
            if (is_null($sessionType) || $sessionType == 1) {
                if ($type == 4) {
                    $dataQuery = explode("-to-", $query);
                    $trans = $this->Transaction->getDataQueryDate($walletId, $dataQuery[0], $dataQuery[1]);
                    $this->set('transactions', $this->paginate($trans));
                } else {
                    $this->set('transactions', $this->paginate($this->Transaction->getDataQuery($walletId, $type)));
                }
                $this->set('_serialize', ['transactions']);
                return $this->render('query_ajax');
            } else {
                if ($type == 4) {
                    $dataQuery = explode("-to-", $query);
                    $trans = $this->Transaction->getDataQueryDateCategory($walletId, $dataQuery[0], $dataQuery[1]);
                    $this->set('transactions', $this->paginate($trans));
                } else {
                    $this->set('transactions', $this->paginate($this->Transaction->getDataQueryCategory($walletId, $type)));
                }
                $this->set('_serialize', ['transactions']);
                return $this->render('query_ajax_category');
            }
        } else {

            if (is_null($dataWallet)) {
                $this->Flash->error(__(Configure::read('message.wallet_not_found')));
                $this->redirect(['_name' => 'wallet']);
            }
            $this->set('walletId', $walletId);
            $this->set('queryDate', $query);
            $this->set('dataWallet', $dataWallet);
            $sessionType = $this->request->session()->read('type');
            if (is_null($sessionType) || $sessionType == 1) {
                if ($type == 4) {
                    $dataQuery = explode("-to-", $query);
                    $trans = $this->Transaction->getDataQueryDate($walletId, $dataQuery[0], $dataQuery[1]);
                    $this->set('transactions', $this->paginate($trans));
                } else {
                    $this->set('transactions', $this->paginate($this->Transaction->getDataQuery($walletId, $type)));
                }
                $this->set('_serialize', ['transactions']);
                return $this->render('query');
            } else {
                if ($type == 4) {
                    $dataQuery = explode("-to-", $query);
                    $trans = $this->Transaction->getDataQueryDateCategory($walletId, $dataQuery[0], $dataQuery[1]);
                    $this->set('transactions', $this->paginate($trans));
                } else {
                    $this->set('transactions', $this->paginate($this->Transaction->getDataQueryCategory($walletId, $type)));
                }
                $this->set('_serialize', ['transactions']);
                return $this->render('query_category');
            }
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
                } else {
                    $this->Transaction->connection()->rollback();
                    $this->Flash->error(__(Configure::read('message.add_transaction_fail')));
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

    /**
     * get category for add method
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
                $oldCategory = $transaction->category_id;
                $transaction = $this->Transaction->patchEntity($transaction, $this->request->data);
                $amount = str_replace('.', '', $this->request->data['amount']);
                $transaction->amount = $amount;
                $dataWallet = $this->Wallet->checkExist($transaction->wallet_id);
                $this->Transaction->connection()->begin();
                $transaction->updated_at = new DateTime('now');
                try {
                    if ($this->Transaction->save($transaction)) {
                        $catalog =$this->Category->getCatalogId($transaction->category_id) ;
                        if ($transaction->category_id == $oldCategory) {
                            if ( $catalog== 1) {
                                $dataWallet->amount = $dataWallet->amount + $transaction->amount - $amountOld;
                            } else {
                                $dataWallet->amount = $dataWallet->amount - ($transaction->amount - $amountOld);
                            }
                        } else {
                            if ($catalog == 1) {
                                $dataWallet->amount = $dataWallet->amount + $transaction->amount + $amountOld;
                            } else {
                                $dataWallet->amount = $dataWallet->amount - ($transaction->amount + $amountOld);
                            }
                        }
                        $this->Wallet->save($dataWallet);
                        $this->Transaction->connection()->commit();
                        $this->Flash->success(__(Configure::read('message.update_transaction_success')));
                        return $this->redirect(['action' => 'index', 'wallet_id' => $transaction->wallet_id]);
                    } else {
                        $this->Transaction->connection()->rollback();
                        $this->Flash->error(__(Configure::read('message.update_transaction_fail')));
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
            $this->set('wallet_id', $transaction->wallet_id);
            $this->set('wallet_name', $this->Wallet->getWalletName($transaction->wallet_id));
            $this->set('wallet_amount', $this->Wallet->getWalletAmount($transaction->wallet_id));
        }
    }

    public function changeView()
    {
        $walletId = $this->request->wallet_id;
        $dataWallet = $this->Wallet->checkExist($walletId);
        if (is_null($dataWallet)) {
            $this->Flash->error(__(Configure::read('message.wallet_not_found')));
            $this->redirect(['_name' => 'wallet']);
        }

        if ($this->request->type == 1) {
            $this->request->session()->write("type", 1);
        } else {
            $this->request->session()->write("type", 2);
        }
        $this->redirect(['action' => 'index', 'wallet_id' => $walletId]);
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
            } else {

                $this->Transaction->connection()->rollback();
                $this->Flash->error(__(Configure::read('message.delete_transaction_fail')));
                return $this->redirect(['action' => 'index', 'wallet_id' => $transaction->wallet_id]);
            }
        } catch (Exception $ex) {
            $this->Transaction->connection()->rollback();
            $this->Flash->error(__(Configure::read('message.delete_transaction_fail')));
        }
    }

    /**
     * action report show report monthly
     */
    public function report()
    {
        $walletId = $this->request->wallet_id;
        $dataWallet = $this->Wallet->checkExist($walletId);
        if (is_null($dataWallet)) {
            $this->Flash->error(__(Configure::read('message.wallet_not_found')));
            $this->redirect(['_name' => 'wallet']);
        }
        $this->paginate = [
            'limit' => $this->limit,
            'contain' => ['Wallet', 'Category']
        ];
        $expense = $this->Transaction->getExpenseThisMonth($walletId);
        $totalExpense = 0;
        $data = array(); // storage data for display chart
        $count = count($expense);
        for ($i = 0; $i < $count; $i++) {
            $totalExpense+=$expense[$i]->total;
            $data[$i]['label'] = $expense[$i]->category->name;
            $data[$i]['data'] = $expense[$i]->total;
        }
        $this->set('data', json_encode($data));
        $this->set('total', $totalExpense);
        $this->set('expense', $expense);
        $this->set('dataWallet', $dataWallet);
        $this->set('transactions', $this->paginate($this->Transaction->getReport($walletId)));
        $this->set('_serialize', ['transactions']);
    }

    public function reportQuery()
    {
        $this->paginate = [
            'limit' => $this->limit,
            'contain' => ['Wallet', 'Category']
        ];
        $query = $this->request->query_date;
        $date = date_create($query);
        $month = date_format($date, "m");
        $year = date_format($date, "Y");
        $walletId = $this->request->wallet_id;
        $dataWallet = $this->Wallet->checkExist($walletId);
        if ($this->request->is(['ajax', 'post'])) {
            $this->layout = "/Manage/report";
            if (!is_null($dataWallet)) {
                $data = $this->Transaction->getReportByMonth($month, $year, $walletId);
                $this->set('transactions', $this->paginate($data));
                $this->set('query', $query);
                $this->set('walletId', $walletId);
                $this->set('_serialize', ['transactions']);

                $expense = $this->Transaction->getExpenseByMonth($walletId, $month, $year);
                $totalExpense = 0;
                $dataExpense = array(); // storage data for display chart
                $count = count($expense);
                for ($i = 0; $i < $count; $i++) {
                    $totalExpense+=$expense[$i]->total;
                    $dataExpense[$i]['label'] = $expense[$i]->category->name;
                    $dataExpense[$i]['data'] = $expense[$i]->total;
                }
                $this->set('data', json_encode($dataExpense));
                $this->set('total', $totalExpense);
                $this->set('expense', $expense);
                $this->set('dataWallet', $dataWallet);
                return $this->render('report_ajax');
            }
        } else {
            if (is_null($dataWallet)) {
                $this->Flash->error(__(Configure::read('message.wallet_not_found')));
                $this->redirect(['_name' => 'wallet']);
            }
            $data = $this->Transaction->getReportByMonth($month, $year, $walletId);
            $this->set('transactions', $this->paginate($data));
            $this->set('query', $query);
            $this->set('walletId', $walletId);
            $this->set('_serialize', ['transactions']);

            $expense = $this->Transaction->getExpenseByMonth($walletId, $month, $year);
            $totalExpense = 0;
            $dataExpense = array(); // storage data for display chart
            $count = count($expense);
            for ($i = 0; $i < $count; $i++) {
                $totalExpense+=$expense[$i]->total;
                $dataExpense[$i]['label'] = $expense[$i]->category->name;
                $dataExpense[$i]['data'] = $expense[$i]->total;
            }
            $this->set('data', json_encode($dataExpense));
            $this->set('total', $totalExpense);
            $this->set('expense', $expense);
            $this->set('dataWallet', $dataWallet);
            return $this->render('report_query');
        }
    }

    public function transfer()
    {
        $walletId = $this->request->wallet_id;
        $wallet = $this->Wallet->checkExist($walletId);
        if (!$wallet) {
            $this->Flash->error(__(Configure::read('message.wallet_not_found')));
            return $this->redirect(['action' => 'index']);
        }
        $transaction = $this->Transaction->newEntity();

        if ($this->request->is("post")) {
            $amount = str_replace('.', '', $this->request->data['amount']);
            $transaction = $this->Transaction->patchEntity($transaction, $this->request->data);
            $transaction->amount = $amount;
            $transaction->wallet_id = $this->request->data['wallet_id_from'];
            $walletFrom = $this->Wallet->checkExist($this->request->data['wallet_id_from']);
            $walletTo = $this->Wallet->checkExist($this->request->data['wallet_id_to']);
            if (!$walletFrom || !$walletTo) {
                $this->Flash->error(__(Configure::read('message.wallet_not_found')));
                return $this->redirect(['action' => 'index']);
            }
            $this->Transaction->connection()->begin();
            try {
                if ($this->Transaction->save($transaction)) {
                    $walletFrom->amount = $walletFrom->amount - $transaction->amount;
                    $this->Wallet->save($walletFrom);
                    $walletTo->amount = $walletTo->amount + $amount;
                    $data = [
                        'category_id' => 2, // default when add new wallet,
                        'wallet_id' => $walletTo->id,
                        'note' => Configure::read('message.add_transaction_transfer'),
                        'amount' => floatval($amount),
                        'created_at' => new DateTime('now')
                    ];
                    $newTransaction = $this->Transaction->newEntity();
                    $this->Transaction->patchEntity($newTransaction, $data);
                    $this->Transaction->save($newTransaction);
                    $this->Wallet->save($walletTo);
                    $this->Transaction->connection()->commit();
                    $this->Flash->success(__(Configure::read('message.add_transaction_success')));
                    return $this->redirect(['action' => 'index', 'wallet_id' => $walletId]);
                } else {
                    $this->Transaction->connection()->rollback();
                    $this->Flash->error(__(Configure::read('message.add_transaction_fail')));
                    return $this->redirect(['action' => 'index', 'wallet_id' => $walletId]);
                }
            } catch (Exception $ex) {
                $this->Transaction->connection()->rollback();
                $this->Flash->error(__(Configure::read('message.add_transaction_fail')));
            }
        }

        $tblCategory = $this->Category->getCategoryforTransfer($walletId);
        $allWallet = $this->Wallet->getWalletOfUser($this->Auth->user('id'));
//        $wallet = $this->Wallet->getWalletForTransfer($walletId, $this->Auth->user('id'));
        $this->set(compact('tblCategory', 'walletId', 'transaction', 'allWallet'));
        $this->set('_serialize', ['transaction']);
    }

    /**
     * get all transaction
     * @return type
     */
    public function all()
    {
        $this->paginate = [
            'limit' => $this->limit,
            'order' => [
                'Category.name' => 'asc'
            ],
        ];
        $amount = $this->Wallet->getAllAmount($this->Auth->user('id'));
        $sessionType = $this->request->session()->read('type');
        $this->set('amount', $amount);
        if (is_null($sessionType) || $sessionType == 1) {
            $data = $this->Transaction->allTransaction($this->Auth->user('id'));
            $this->set('transactions', $this->paginate($data));
            $this->set('_serialize', ['transactions']);
            return $this->render('all');
        } else {
            $data = $this->Transaction->allTransactionCategory($this->Auth->user('id'));
            $this->set('transactions', $this->paginate($data));
            $this->set('_serialize', ['transactions']);
            return $this->render('all_category');
        }
    }

    /**
     * action query date
     * @return type
     */
    public function allQueryDate()
    {
        $query = $this->request->query_date;
        $this->paginate = [
            'limit' => $this->limit,
            'order' => [
                'Category.name' => 'asc'
            ],
        ];
        if (strtolower($query) == "today") {
            $type = 1;
        } else if (strtolower($query) == "this-week") {
            $type = 2;
        } else if (strtolower($query) == "this-month") {
            $type = 3;
        } else {
            $type = 4;
        }

        if ($this->request->is(['ajax', 'post'])) {
            $this->layout = "/Manage/ajax";
            $this->set('queryDate', $query);
            $sessionType = $this->request->session()->read('type');
            if (is_null($sessionType) || $sessionType == 1) {
                if ($type == 4) {
                    $dataQuery = explode("-to-", $query);
                    $trans = $this->Transaction->getDataQueryDateAll($this->Auth->user('id'), $dataQuery[0], $dataQuery[1]);
                    $this->set('transactions', $this->paginate($trans));
                } else {
                    $this->set('transactions', $this->paginate($this->Transaction->getDataQueryAll($this->Auth->user('id'), $type)));
                }
                $this->set('_serialize', ['transactions']);
                return $this->render('query_ajax_all');
            } else {
                if ($type == 4) {
                    $dataQuery = explode("-to-", $query);
                    $trans = $this->Transaction->getDataQueryDateCategoryAll($this->Auth->user('id'), $dataQuery[0], $dataQuery[1]);
                    $this->set('transactions', $this->paginate($trans));
                } else {
                    $this->set('transactions', $this->paginate($this->Transaction->getDataQueryCategoryAll($this->Auth->user('id'), $type)));
                }
                $this->set('_serialize', ['transactions']);
                return $this->render('query_ajax_category_all');
            }
        } else {
            $this->set('queryDate', $query);
            $amount = $this->Wallet->getAllAmount($this->Auth->user('id'));
            $sessionType = $this->request->session()->read('type');
            $this->set('amount', $amount);
            if (is_null($sessionType) || $sessionType == 1) {
                if ($type == 4) {
                    $dataQuery = explode("-to-", $query);
                    $trans = $this->Transaction->getDataQueryDateAll($this->Auth->user('id'), $dataQuery[0], $dataQuery[1]);
                    $this->set('transactions', $this->paginate($trans));
                } else {
                    $this->set('transactions', $this->paginate($this->Transaction->getDataQueryAll($this->Auth->user('id'), $type)));
                }
                $this->set('_serialize', ['transactions']);
                return $this->render('query_all');
            } else {
                if ($type == 4) {
                    $dataQuery = explode("-to-", $query);
                    $trans = $this->Transaction->getDataQueryDateCategoryAll($this->Auth->user('id'), $dataQuery[0], $dataQuery[1]);
                    $this->set('transactions', $this->paginate($trans));
                } else {
                    $this->set('transactions', $this->paginate($this->Transaction->getDataQueryCategoryAll($this->Auth->user('id'), $type)));
                }
                $this->set('_serialize', ['transactions']);
                return $this->render('query_all_category');
            }
        }
    }

    /**
     * change display all transaction
     */
    public function changeAllView()
    {
        if ($this->request->type == 1) {
            $this->request->session()->write("type", 1);
        } else {
            $this->request->session()->write("type", 2);
        }
        $this->redirect(['action' => 'all']);
    }

}
