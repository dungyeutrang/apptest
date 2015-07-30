<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Category'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Tbl Wallet'), ['controller' => 'TblWallet', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tbl Wallet'), ['controller' => 'TblWallet', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Mst Catalog'), ['controller' => 'MstCatalog', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Mst Catalog'), ['controller' => 'MstCatalog', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Parent Category'), ['controller' => 'Category', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Parent Category'), ['controller' => 'Category', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="category form large-10 medium-9 columns">
    <?= $this->Form->create($category) ?>
    <fieldset>
        <legend><?= __('Add Category') ?></legend>
        <?php
            echo $this->Form->input('wallet_id', ['options' => $tblWallet]);
            echo $this->Form->input('catalog_id', ['options' => $mstCatalog]);
            echo $this->Form->input('parent_id', ['options' => $parentCategory]);
            echo $this->Form->input('name');
            echo $this->Form->input('is_default');
            echo $this->Form->input('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
