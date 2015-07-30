<?php
namespace App\Model\Table;

use App\Model\Entity\Wallet;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Wallet Model
 *
 * @property \Cake\ORM\Association\BelongsTo $TblUser
 */
class WalletTable extends Table
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

        $this->table('tbl_wallet');
        $this->displayField('name');
        $this->primaryKey('id');
        $this->belongsTo('TblUser', [
            'foreignKey' => 'user_id',
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->add('amount', 'valid', ['rule' => 'numeric'])
            ->requirePresence('amount', 'create')
            ->notEmpty('amount');

        $validator
            ->add('is_default', 'valid', ['rule' => 'numeric'])
            ->requirePresence('is_default', 'create')
            ->notEmpty('is_default');

        $validator
            ->add('date_created', 'valid', ['rule' => 'datetime'])
            ->requirePresence('date_created', 'create')
            ->notEmpty('date_created');

        $validator
            ->add('date_updated', 'valid', ['rule' => 'datetime'])
            ->requirePresence('date_updated', 'create')
            ->notEmpty('date_updated');

        $validator
            ->add('date_deleted', 'valid', ['rule' => 'datetime'])
            ->requirePresence('date_deleted', 'create')
            ->notEmpty('date_deleted');

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
        $rules->add($rules->existsIn(['user_id'], 'TblUser'));
        return $rules;
    }
}
