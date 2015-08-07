<?php

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Transaction Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ParentTransactions
 * @property \Cake\ORM\Association\BelongsTo $TblCategory
 * @property \Cake\ORM\Association\BelongsTo $TblWallet
 */
class TransactionTable extends Table
{

    public $id;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('tbl_transaction');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Category', [
            'foreignKey' => 'category_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Wallet', [
            'foreignKey' => 'wallet_id',
            'joinType' => 'INNER'
        ]);
//        $this->belongsTo('Transaction', [
//            'foreignKey' => 'wallet_id',
////            'joinType' => 'INNER'
//        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
                ->add('id', 'valid', ['rule' => 'numeric'])
                ->allowEmpty('id', 'create');

        $validator
                ->add('amount', 'valid', ['rule' => 'numeric'])
                ->requirePresence('amount', 'create')
                ->notEmpty('amount');

        $validator
                ->add('category_id', 'valid', ['rule' => 'numeric'])
                ->add('category_id', 'custom', ['rule' => function ($value) {
                        $data = $this->Category->find()->where(['id' => $value])->first();
                        if ($data) {
                            return true;
                        } else {
                            return false;
                        }
                    }])
                        ->requirePresence('category_id', 'create');


                $validator
                        ->allowEmpty('note');

                $validator
                        ->add('created_at', 'valid', ['rule' => 'date'])
                        ->requirePresence('created_at', 'create')
                        ->notEmpty('created_at');

                return $validator;
            }

            /**
             *  get data index 
             * @param type $walletId
             * @return type
             */
            public function getDataIndex($walletId)
            {
                $data = $this->find()->where(['Transaction.wallet_id' => $walletId])
                        ->andWhere(['DATE(Transaction.created_at)' => date('Y-m-d')])
                        ->andWhere(['Transaction.status' => 0])
                        ->contain(['Wallet', 'Category', 'Category.MstCatalog']);
                return $data;
            }

            public function getDataQuery($walletId, $type)
            {
                $date = new \DateTime('now');
                if ($type == 1) {
                    $data = $this->find()->where(['Transaction.wallet_id' => $walletId])
                            ->andWhere(['DATE(Transaction.created_at)' => date('Y-m-d')])
                            ->andWhere(['Transaction.status' => 0])
                            ->contain(['Wallet', 'Category', 'Category.MstCatalog']);
                } else if ($type == 2) {
//                var_dump($type);die;
                    $data = $this->find()->where(['Transaction.wallet_id' => $walletId])
                            ->andWhere(['week(Transaction.created_at)' => $date->format('W') - 1])
                            ->andWhere(['Transaction.status' => 0])
                            ->contain(['Wallet', 'Category', 'Category.MstCatalog']);
                } else {
                    $data = $this->find()->where(['Transaction.wallet_id' => $walletId])
                            ->andWhere(['month(Transaction.created_at)' => date('m')])
                            ->andWhere(['Transaction.status' => 0])
                            ->contain(['Wallet', 'Category', 'Category.MstCatalog']);
                }
                return $data;
            }

            /**
             * Returns a rules checker object that will be used for validating
             * application integrity.
             *
             * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
             * @return \Cake\ORM\RulesChecker
             */
            public function buildRules(RulesChecker $rules)
            {
                $rules->add($rules->existsIn(['category_id'], 'Category'));
                $rules->add($rules->existsIn(['wallet_id'], 'Wallet'));
                return $rules;
            }

            /**
             * return transaction
             * @param type $id
             */
            public function getTransaction($id)
            {
                return $this->find()->where(['Transaction.id' => $id])
                                ->contain(['Wallet', 'Category', 'Category.MstCatalog'])
                                ->first();
            }

            public function deleteTransaction($walletId, $categoryId)
            {
                $data = $this->find()->where(['Transaction.wallet_id' => $walletId, 'category_id' => $categoryId])->contain(['Wallet', 'Category', 'Category.MstCatalog']);
                foreach ($data as $dt) {
                    if ($dt->category->mst_catalog->id == 1) {
                        $dt->wallet->amount-= $dt->amount;
                    } else {
                        $dt->wallet->amount+=$dt->amount;
                    }
                    $this->Wallet->save($dt->wallet);
                    $dt->status = 1;
                    $this->save($dt);
                }
            }

            public function mergeTransaction($walletId, $categoryId, $categoryMerge)
            {
                $this->updateAll(['category_id' => $categoryMerge], ['wallet_id' => $walletId, 'category_id' => $categoryId]);
            }

            /**
             * 
             * @param type $walletId
             */
            public function deleteAllTransaction($walletId)
            {
                return $this->updateAll(['status' => 1], ['wallet_id' => $walletId]);
            }

            public function getReport($walletId)
            {
//                $table = \Cake\ORM\TableRegistry::get('tbl_')
                $data = $this->find('all');
                $total = $data->func()->sum('Transaction.amount');
                $data->select(['total'=>$total,'id','category_id','wallet_id','Category.name','Category.avatar','MstCatalog.name']);
                $data = $data->where(['month(Transaction.created_at)' => date('m'), 'Transaction.wallet_id' => $walletId, 'Transaction.status' => 0])
                        ->group(['category_id'])->contain(['Category','Category.MstCatalog']);
                return $data;
            }

        }
        