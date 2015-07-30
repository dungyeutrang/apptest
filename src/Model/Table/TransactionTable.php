<?php
namespace App\Model\Table;

use App\Model\Entity\Transaction;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Transaction Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ParentTransactions
 * @property \Cake\ORM\Association\BelongsTo $TblCategory
 */
class TransactionTable extends Table
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

        $this->table('tbl_transaction');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('ParentTransactions', [
            'foreignKey' => 'parent_transaction_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('TblCategory', [
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

        $validator
            ->add('amount', 'valid', ['rule' => 'numeric'])
            ->requirePresence('amount', 'create')
            ->notEmpty('amount');

        $validator
            ->allowEmpty('note');

        $validator
            ->add('create_at', 'valid', ['rule' => 'datetime'])
            ->requirePresence('create_at', 'create')
            ->notEmpty('create_at');

        $validator
            ->add('update_at', 'valid', ['rule' => 'datetime'])
            ->allowEmpty('update_at');

        $validator
            ->add('delete_at', 'valid', ['rule' => 'datetime'])
            ->allowEmpty('delete_at');

        $validator
            ->add('status', 'valid', ['rule' => 'numeric'])
            ->requirePresence('status', 'create')
            ->notEmpty('status');

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
        $rules->add($rules->existsIn(['parent_transaction_id'], 'ParentTransactions'));
        $rules->add($rules->existsIn(['category_id'], 'TblCategory'));
        return $rules;
    }
}
