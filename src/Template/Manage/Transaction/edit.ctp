<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $transaction->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $transaction->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Transaction'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Tbl Category'), ['controller' => 'TblCategory', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tbl Category'), ['controller' => 'TblCategory', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="transaction form large-10 medium-9 columns">
    <?= $this->Form->create($transaction) ?>
    <fieldset>
        <legend><?= __('Edit Transaction') ?></legend>
        <?php
            echo $this->Form->input('parent_transaction_id');
            echo $this->Form->input('category_id', ['options' => $tblCategory]);
            echo $this->Form->input('amount');
            echo $this->Form->input('note');
            echo $this->Form->input('create_at');
            echo $this->Form->input('update_at');
            echo $this->Form->input('delete_at');
            echo $this->Form->input('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
