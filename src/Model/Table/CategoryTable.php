<?php

namespace App\Model\Table;

use App\Model\Entity\Category;
use Cake\ORM\Query;
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
                        }else {
                            return false;
                        }
                    }])
                        ->allowEmpty('parent_id');

                $validator
                        ->add('avatar', 'file', ['rule' => ['mimeType', ['image/jpeg', 'image/png']]])
                        ->requirePresence('avatar', 'create')
                        ->notEmpty('avatar');


                $validator
                        ->requirePresence('name', 'create')
                        ->notEmpty('name');

//        $validator
//            ->add('is_default', 'valid', ['rule' => 'numeric'])
//            ->requirePresence('is_default', 'create')
//            ->notEmpty('is_default');
//        $validator
//            ->add('status', 'valid', ['rule' => 'numeric'])
//            ->requirePresence('status', 'create')
//            ->notEmpty('status');

                return $validator;
            }

//    public function existData($check)
//    {
//       $values = array_values($check);
//        $value = $values[0];
//        var_dump($value);die;
//    }

            /**
             * Returns a rules checker object that will be used for validating
             * application integrity.
             *
             * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
             * @return \Cake\ORM\RulesChecker
             */
            public function buildRules(RulesChecker $rules)
            {
                $rules->add($rules->existsIn(['wallet_id'], 'TblWallet'));
                $rules->add($rules->existsIn(['catalog_id'], 'MstCatalog'));
//        $rules->add($rules->existsIn(['parent_id'], 'ParentCategory'));
                return $rules;
            }

            /**
             * return list category by wallet
             * @param type $id
             * @return type
             */
            public function getCategoryByWallet($id)
            {
                return $this->find()->where(function($exp) {
                            return $exp->isNull('wallet_id');
                        })->orWhere(['wallet_id' => $id])->andWhere(['Category.status' => 0]);
            }

            public function getCategoryForAdd($walletId, $catalogId)
            {
                return $this->find()->select(['id', 'name'])->where(function($exp) {
                            return $exp->isNull('wallet_id');
                        })->orWhere(['wallet_id' => $walletId])->andWhere(['catalog_id' => $catalogId])->toArray();
            }

        }
