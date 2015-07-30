<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Transaction'), ['action' => 'edit', $transaction->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Transaction'), ['action' => 'delete', $transaction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $transaction->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Transaction'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Transaction'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tbl Category'), ['controller' => 'TblCategory', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tbl Category'), ['controller' => 'TblCategory', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="transaction view large-10 medium-9 columns">
    <h2><?= h($transaction->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Tbl Category') ?></h6>
            <p><?= $transaction->has('tbl_category') ? $this->Html->link($transaction->tbl_category->name, ['controller' => 'TblCategory', 'action' => 'view', $transaction->tbl_category->id]) : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($transaction->id) ?></p>
            <h6 class="subheader"><?= __('Parent Transaction Id') ?></h6>
            <p><?= $this->Number->format($transaction->parent_transaction_id) ?></p>
            <h6 class="subheader"><?= __('Amount') ?></h6>
            <p><?= $this->Number->format($transaction->amount) ?></p>
            <h6 class="subheader"><?= __('Status') ?></h6>
            <p><?= $this->Number->format($transaction->status) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Create At') ?></h6>
            <p><?= h($transaction->create_at) ?></p>
            <h6 class="subheader"><?= __('Update At') ?></h6>
            <p><?= h($transaction->update_at) ?></p>
            <h6 class="subheader"><?= __('Delete At') ?></h6>
            <p><?= h($transaction->delete_at) ?></p>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Note') ?></h6>
            <?= $this->Text->autoParagraph(h($transaction->note)) ?>
        </div>
    </div>
</div>
