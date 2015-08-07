<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Transaction Entity.
 */
class Transaction extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'parent_transaction_id' => true,
        'category_id' => true,
        'wallet_id' => true,
        'amount' => true,
        'note' => true,
        'created_at' => true,
        'updated_at'=>true
    ];
    
    
}
