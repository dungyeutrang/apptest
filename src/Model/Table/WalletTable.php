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
        $this->hasMany('Category', [
            'foreignKey' => 'wallet_id'
        ]);
        $this->hasMany('Transaction', ['foreignKey' => 'wallet_id']
        );
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator->add('name', ['maxLength' => [
                        'rule' => ['maxLength', 128],
                        'last' => true,
                        'message' => 'Name must be length less 128 character'
            ]])
                ->requirePresence('name', 'create')
                ->notEmpty('name');
        $validator
                ->add('amount', 'valid', ['rule' => 'numeric']);
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

    /**
     * check exist wallet with user id 
     * @param type $wallet
     * @param type $userId
     * @return boolean
     */
    public function checkWalletDefault($wallet, $userId)
    {
        $data = $wallet->find()->where(['user_id' => $userId])->toArray();
        if (count($data) == 0) {
            return true;
        }
        return false;
    }

    /**
     *  check wallet exist
     * @param type $id
     * @return array
     */
    public function checkExist($id)
    {
        return $this->find()->where(['id' => $id])->first();
    }
    
    

}
