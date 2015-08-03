<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CategoryDeleteFixture
 *
 */
class CategoryDeleteFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'tbl_category_default_delete';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'wallet_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'category_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'wallet_id' => ['type' => 'index', 'columns' => ['wallet_id'], 'length' => []],
            'category_id' => ['type' => 'index', 'columns' => ['category_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'tbl_category_default_delete_ibfk_1' => ['type' => 'foreign', 'columns' => ['wallet_id'], 'references' => ['tbl_wallet', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'tbl_category_default_delete_ibfk_2' => ['type' => 'foreign', 'columns' => ['category_id'], 'references' => ['tbl_category', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_unicode_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'wallet_id' => 1,
            'category_id' => 1
        ],
    ];
}
