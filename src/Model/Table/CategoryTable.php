<?php

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Category Model
 *
 * @property \Cake\ORM\Association\BelongsTo $TblWallet
 * @property \Cake\ORM\Association\BelongsTo $MstCatalog
 * @property \Cake\ORM\Association\BelongsTo $ParentCategory
 * @property \Cake\ORM\Association\HasMany $ChildCategory
 */
class CategoryTable extends Table
{

    public $id; // id of wallet id

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('tbl_category');
        $this->displayField('name');
        $this->primaryKey('id');
        $this->belongsTo('Wallet', [
            'foreignKey' => 'wallet_id',
        ]);
        $this->belongsTo('MstCatalog', [
            'foreignKey' => 'catalog_id',
        ]);

        $this->belongsTo('Transaction', [
            'foreignKey' => 'category_id',
        ]);

        $this->hasOne('CategoryDelete', [
            'foreignKey' => 'category_id',
        ]);
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
                ->add('catalog_id', 'valid', ['rule' => 'numeric'])
                ->requirePresence('catalog_id', 'create')
                ->notEmpty('catalog_id');

        $validator
                ->add('parent_id', 'valid', ['rule' => 'numeric'])
                ->add('parent_id', 'custom', ['rule' => function ($value) {
                        $data = $this->find()->where(['id' => $value])->first();
                        if ($data) {
                            return true;
                        } else {
                            return false;
                        }
                    }])
                        ->allowEmpty('parent_id');

                $validator
                        ->add('avatar', 'file', ['rule' => array('mimeType', array('image/gif', 'image/png', 'image/jpg', 'image/jpeg')), 'message' => 'Type of image invalid'])
                        ->requirePresence('avatar', 'create')
                        ->allowEmpty('avatar');


                $validator
                        ->requirePresence('name', 'create')
                        ->notEmpty('name');

                return $validator;
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
                $rules->add($rules->existsIn(['wallet_id'], 'Wallet'));
                $rules->add($rules->existsIn(['catalog_id'], 'MstCatalog'));
                return $rules;
            }

            /**
             * return list category by wallet
             * @param type $id
             * @return type
             */
            public function getCategoryByWallet($id)
            {
                $this->id = $id;
                $data = $this->find()->where(function($exp) {
                                    return $exp->isNull('wallet_id');
                                })->orWhere(['wallet_id' => $id])
                                ->andWhere(function($exp) {
                                    $data = $this->CategoryDelete->find('list')->select(['category_id'])->where(['wallet_id' => $this->id])->toArray();
                                    if (count($data) != 0) {
                                        return $exp->notIn('Category.id', $data);
                                    } else {
                                        return $exp;
                                    }
                                })->andWhere(['Category.status' => 0]);
                return $data;
            }

            /**
             *  check Exist record
             * @param type $id
             * @return boolean
             */
            public function checkExist($id)
            {
                $data = $this->find()->where(['id' => $id])->first();
                if ($data) {
                    return $data;
                } else {
                    return false;
                }
            }

            /**
             * get Parent id for update 
             * @param type $catalogId
             * @param type $parentId
             * @return type
             */
            public function getParentidUpdate($catalogId, $parentId, $walletId, $id)
            {
                $this->id = $walletId;
                return $this->find('list', ['limit' => 200])
                                ->where(function($exp) {
                                    return $exp->isNull('wallet_id');
                                })->orWhere(['wallet_id' => $walletId])
                                ->andWhere(['catalog_id' => $catalogId])
                                ->andWhere(['parent_id' => 0, 'status' => 0])
                                ->orWhere(['parent_id' => $parentId, 'Category.id' => $id, 'catalog_id' => $catalogId])
                                ->andWhere(function($exp) {
                                    $data = $this->CategoryDelete->find('list')->where(['wallet_id' => $this->id])->select(['category_id'])->toArray();
                                    if (count($data) != 0) {
                                        return $exp->notIn('Category.id', $data);
                                    } else {
                                        return $exp;
                                    }
                                });
            }

            /**
             * get Parent id for add
             * @walletId
             * @return type
             */
            public function getParentidAdd($walletId)
            {
                $this->id = $walletId;
                $data = $this->find('list', ['limit' => 200])
                        ->andWhere(function($exp) {
                            return $exp->isNull('wallet_id');
                        })->orWhere(['wallet_id' => $this->id])
                        ->andWhere(['catalog_id' => 2, 'parent_id' => 0, 'status' => 0])
                        ->andWhere(function($exp) {
                    $categoryDelete = $this->CategoryDelete->find('list')->where(['wallet_id' => $this->id])->select(['category_id'])->toArray();
                    if (count($categoryDelete) != 0) {
                        return $exp->notIn('Category.id', $categoryDelete);
                    } else {
                        return $exp;
                    }
                });
                return $data;
            }

            /**
             * get category for change ajax
             * @param type $walletId
             * @param type $catalogId
             * @return type
             */
            public function getCategoryForAdd($walletId, $catalogId)
            {
                $this->id = $walletId;
                return $this->find()
                                ->select(['id', 'name'])->where(function($exp) {
                                    return $exp->isNull('wallet_id');
                                })->orWhere(['wallet_id' => $this->id])
                                ->andWhere(['catalog_id' => $catalogId, 'parent_id' => 0, 'status' => 0])
                                ->andWhere(function($exp) {
                                    $categoryDelete = $this->CategoryDelete->find('list')->where(['wallet_id' => $this->id])->select(['category_id'])->toArray();
                                    if (count($categoryDelete) != 0) {
                                        return $exp->notIn('Category.id', $categoryDelete);
                                    } else {
                                        return $exp;
                                    }
                                })
                                ->toArray();
            }

            /**
             * get category when update chane ajax
             * 
             * @param type $catalogId
             * @param type $parentId
             * @param type $walletId
             * @param type $id
             * @return type
             */
            public function getCategoryForUpdate($catalogId, $parentId, $walletId, $id)
            {
                $this->id = $walletId;
                return $this->find()
                                ->select(['id', 'name'])
                                ->where(function($exp) {
                                    return $exp->isNull('wallet_id');
                                })->orWhere(['wallet_id' => $walletId])
                                ->andWhere(['catalog_id' => $catalogId])
                                ->andWhere(['parent_id' => 0, 'status' => 0])
                                ->orWhere(['parent_id' => $parentId, 'Category.id' => $id, 'catalog_id' => $catalogId])
                                ->andWhere(function($exp) {
                                    $data = $this->CategoryDelete->find('list')->where(['wallet_id' => $this->id])->select(['category_id'])->toArray();
                                    return $exp->notIn('Category.id', $data);
                                    if (count($data) != 0) {
                                        return $exp->notIn('Category.id', $data);
                                    } else {
                                        return $exp;
                                    }
                                });
            }

            /**
             * get All catalog
             * @return type
             */
            public function getMstCatalog()
            {
                return $this->MstCatalog->find('list', ['limit' => 200])->order(['id'=>'DESC']);
            }

            /**
             * get transaction 
             * @param type $walletId
             * @param type $categoryId
             * @return type
             */
            public function getTransaction($walletId, $categoryId)
            {
                return $this->Transaction->find()
                                ->where(['wallet_id' => $walletId, 'category_id' => $categoryId, 'Transaction.status' => 0]);
            }

            /**
             * get category for add transaction
             * @param type $id
             * @return type
             */
            public function getCategoryforTransaction($id)
            {
                $this->id = $id;
                $data = $this->find('list', ['limit' => 200])->where(function($exp) {
                            return $exp->isNull('wallet_id');
                        })->orWhere(['wallet_id' => $this->id])
                        ->andWhere(['Category.status' => 0, 'Category.catalog_id' => 2])
                        ->andWhere(function($exp) {
                    $data = $this->CategoryDelete->find('list')->where(['wallet_id' => $this->id])->select(['category_id'])->toArray();
                    if (count($data) != 0) {
                        return $exp->notIn('Category.id', $data);
                    } else {
                        return $exp;
                    }
                });
                return $data;
            }

            /**
             * get Category for transfer
             * @param type $id
             * @return type
             */
            public function getCategoryforTransfer($id)
            {
                $this->id = $id;
                $data = $this->find('list', ['limit' => 200])->where(function($exp) {
                            return $exp->isNull('wallet_id');
                        })->orWhere(['wallet_id' => $this->id])
                        ->andWhere(['Category.status' => 0, 'Category.catalog_id' => 2])
                        ->andWhere(function($exp) {
                    $data = $this->CategoryDelete->find('list')->where(['wallet_id' => $this->id])->select(['category_id'])->toArray();
                    if (count($data) != 0) {
                        return $exp->notIn('Category.id', $data);
                    } else {
                        return $exp;
                    }
                });
                return $data;
            }

            /**
             * get category for transaction update
             * @param type $id
             * @return type
             */
            public function getCategoryUpdateTransaction($id, $catalogId)
            {
                $this->id = $id;
                $data = $this->find('list', ['limit' => 200])->where(function($exp) {
                            return $exp->isNull('wallet_id');
                        })->orWhere(['wallet_id' => $this->id])
                        ->andWhere(['Category.status' => 0, 'Category.catalog_id' => $catalogId])
                        ->andWhere(function($exp) {
                    $data = $this->CategoryDelete->find('list')->where(['wallet_id' => $this->id])->select(['category_id'])->toArray();
                    if (count($data) != 0) {
                        return $exp->notIn('Category.id', $data);
                    } else {
                        return $exp;
                    }
                });
                return $data;
            }

            /**
             * get category for add transaction
             * @param type $walletId
             * @param type $catalogId
             * @return type
             */
            public function getCategoryForAddTransaction($walletId, $catalogId)
            {
                $this->id = $walletId;
                return $this->find()
                                ->select(['id', 'name'])->where(function($exp) {
                                    return $exp->isNull('wallet_id');
                                })->orWhere(['wallet_id' => $this->id])
                                ->andWhere(['catalog_id' => $catalogId, 'status' => 0])
                                ->andWhere(function($exp) {
                                    $categoryDelete = $this->CategoryDelete->find('list')->where(['wallet_id' => $this->id])->select(['category_id'])->toArray();
                                    if (count($categoryDelete) != 0) {
                                        return $exp->notIn('Category.id', $categoryDelete);
                                    } else {
                                        return $exp;
                                    }
                                })
                                ->toArray();
            }

            /**
             * get catalogid 
             * @param type $id
             * @return type
             */
            public function getCatalogId($id)
            {

                return $this->find()->select(['catalog_id'])->where(['id' => $id])->first()->catalog_id;
            }

            /**
             *  delete category
             * @param type $walletId
             * @return type
             */
            public function deleteCategory($walletId)
            {
                return $this->updateAll(['status' => 1], ['wallet_id' => $walletId]);
            }                   

        }
        