<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Category'), ['action' => 'edit', $category->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Category'), ['action' => 'delete', $category->id], ['confirm' => __('Are you sure you want to delete # {0}?', $category->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Category'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tbl Wallet'), ['controller' => 'TblWallet', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tbl Wallet'), ['controller' => 'TblWallet', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Mst Catalog'), ['controller' => 'MstCatalog', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Mst Catalog'), ['controller' => 'MstCatalog', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Parent Category'), ['controller' => 'Category', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Parent Category'), ['controller' => 'Category', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="category view large-10 medium-9 columns">
    <h2><?= h($category->name) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Tbl Wallet') ?></h6>
            <p><?= $category->has('tbl_wallet') ? $this->Html->link($category->tbl_wallet->name, ['controller' => 'TblWallet', 'action' => 'view', $category->tbl_wallet->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Mst Catalog') ?></h6>
            <p><?= $category->has('mst_catalog') ? $this->Html->link($category->mst_catalog->name, ['controller' => 'MstCatalog', 'action' => 'view', $category->mst_catalog->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Parent Category') ?></h6>
            <p><?= $category->has('parent_category') ? $this->Html->link($category->parent_category->name, ['controller' => 'Category', 'action' => 'view', $category->parent_category->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Name') ?></h6>
            <p><?= h($category->name) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($category->id) ?></p>
            <h6 class="subheader"><?= __('Is Default') ?></h6>
            <p><?= $this->Number->format($category->is_default) ?></p>
            <h6 class="subheader"><?= __('Status') ?></h6>
            <p><?= $this->Number->format($category->status) ?></p>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Category') ?></h4>
    <?php if (!empty($category->child_category)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Wallet Id') ?></th>
            <th><?= __('Catalog Id') ?></th>
            <th><?= __('Parent Id') ?></th>
            <th><?= __('Name') ?></th>
            <th><?= __('Is Default') ?></th>
            <th><?= __('Status') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($category->child_category as $childCategory): ?>
        <tr>
            <td><?= h($childCategory->id) ?></td>
            <td><?= h($childCategory->wallet_id) ?></td>
            <td><?= h($childCategory->catalog_id) ?></td>
            <td><?= h($childCategory->parent_id) ?></td>
            <td><?= h($childCategory->name) ?></td>
            <td><?= h($childCategory->is_default) ?></td>
            <td><?= h($childCategory->status) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Category', 'action' => 'view', $childCategory->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Category', 'action' => 'edit', $childCategory->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Category', 'action' => 'delete', $childCategory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childCategory->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
