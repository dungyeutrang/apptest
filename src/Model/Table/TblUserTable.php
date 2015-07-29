<?php

namespace App\Model\Table;

use App\Model\Entity\TblUser;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TblUser Model
 *
 * @property \Cake\ORM\Association\BelongsTo $LastWallets
 */
class TblUserTable extends Table
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
        $this->table('tbl_user');
        $this->displayField('id');
        $this->primaryKey('id');
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
                ->add('email', 'valid', ['rule' => 'email'])
                ->requirePresence('email', 'create')
                ->notEmpty('email');

        $validator
                ->requirePresence('password', 'create')
                ->notEmpty('password');

        $validator->add('phone', ['minLength' => [
                'rule' => ['minLength', 10],
                'last' => true,
                'message' => 'Phone must be length more than or equal 10 character'
            ],
            'maxLength' => [
                'rule' => ['maxLength', 11],
                'message' => 'Phone must be length less than 11 character'
            ],
            'numeric' => [
                'rule' => 'numeric',
                'message' => 'Phone must be nummeric'
            ]
        ])->allowEmpty('phone');

        $validator
                ->requirePresence('last_name', 'create')
                ->notEmpty('last_name');

        $validator
                ->requirePresence('first_name', 'create')
                ->notEmpty('first_name');

        $validator
                ->add('birth_day', 'valid', ['rule' => 'date', 'message' => 'Format birthday not valid'])
                ->allowEmpty('birth_day');


        return $validator;
    }

    /**
     * validate when reset password
     * @param Validator $validator
     */
    public function validatorResetPassword()
    {
        $validator = new Validator();
        $validator->add('password', ['minLength' => [
                'rule' => ['minLength', 6],
                'last' => true,
                'message' => 'Password must be more or than equal 6 character'
            ],
        ])->requirePresence('password');

        $validator->add('password_confirm', 'compareWith', [
            'rule' => ['compareWith', 'password'],
            'message' => 'Passwords not equal.'
        ]);
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
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->isUnique(['phone']));
        return $rules;
    }

    public static function getAccount($email)
    {
        $user = TableRegistry::get('tbl_user');
        return $user->find()->where(['email' => $email])->first();
    }

}
