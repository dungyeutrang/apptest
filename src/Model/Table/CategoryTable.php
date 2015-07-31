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
        $this->belongsTo('TblWallet', [
            'foreignKey' => 'wallet_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('MstCatalog', [
            'foreignKey' => 'catalog_id',
            'joinType' => 'INNER'
        ]);
//        $this->belongsTo('ParentCategory', [
//            'className' => 'Category',
//            'foreignKey' => 'parent_id'
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

//        $validator
//            ->requirePresence('name', 'create')
//            ->notEmpty('name');

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
}
