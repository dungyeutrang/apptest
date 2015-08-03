<?php

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CategoryDelete Model
 *
 * @property \Cake\ORM\Association\BelongsTo $TblWallet
 * @property \Cake\ORM\Association\BelongsTo $TblCategory
 */
class CategoryDeleteTable extends Table
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

        $this->table('tbl_category_default_delete');
        $this->displayField('category_id');
        $this->primaryKey('id');
        $this->belongsTo('Wallet', [
            'foreignKey' => 'wallet_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Category', [
            'foreignKey' => 'category_id',
            'joinType' => 'INNER'
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
        $rules->add($rules->existsIn(['category_id'], 'Category'));
        return $rules;
    }

    /**
     * add record 
     * @param type $walletId
     * @param type $categoryId
     * @return boolean
     */
    public function add($walletId, $categoryId)
    {
        $entity = $this->newEntity();
        $entity->wallet_id=$walletId;
        $entity->category_id =$categoryId;
        if($this->save($entity)){
            return true;
        }
        return false;
    }

}
