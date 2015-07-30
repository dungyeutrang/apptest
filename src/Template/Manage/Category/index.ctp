<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Category'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tbl Wallet'), ['controller' => 'TblWallet', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tbl Wallet'), ['controller' => 'TblWallet', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Mst Catalog'), ['controller' => 'MstCatalog', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Mst Catalog'), ['controller' => 'MstCatalog', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="category index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('wallet_id') ?></th>
            <th><?= $this->Paginator->sort('catalog_id') ?></th>
            <th><?= $this->Paginator->sort('parent_id') ?></th>
            <th><?= $this->Paginator->sort('name') ?></th>
            <th><?= $this->Paginator->sort('is_default') ?></th>
            <th><?= $this->Paginator->sort('status') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($category as $category): ?>
        <tr>
            <td><?= $this->Number->format($category->id) ?></td>
            <td>
                <?= $category->has('tbl_wallet') ? $this->Html->link($category->tbl_wallet->name, ['controller' => 'TblWallet', 'action' => 'view', $category->tbl_wallet->id]) : '' ?>
            </td>
            <td>
                <?= $category->has('mst_catalog') ? $this->Html->link($category->mst_catalog->name, ['controller' => 'MstCatalog', 'action' => 'view', $category->mst_catalog->id]) : '' ?>
            </td>
            <td>
                <?= $category->has('parent_category') ? $this->Html->link($category->parent_category->name, ['controller' => 'Category', 'action' => 'view', $category->parent_category->id]) : '' ?>
            </td>
            <td><?= h($category->name) ?></td>
            <td><?= $this->Number->format($category->is_default) ?></td>
            <td><?= $this->Number->format($category->status) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $category->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $category->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $category->id], ['confirm' => __('Are you sure you want to delete # {0}?', $category->id)]) ?>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
