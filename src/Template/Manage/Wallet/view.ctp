<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Wallet'), ['action' => 'edit', $wallet->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Wallet'), ['action' => 'delete', $wallet->id], ['confirm' => __('Are you sure you want to delete # {0}?', $wallet->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Wallet'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Wallet'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tbl User'), ['controller' => 'TblUser', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tbl User'), ['controller' => 'TblUser', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="wallet view large-10 medium-9 columns">
    <h2><?= h($wallet->name) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Tbl User') ?></h6>
            <p><?= $wallet->has('tbl_user') ? $this->Html->link($wallet->tbl_user->id, ['controller' => 'TblUser', 'action' => 'view', $wallet->tbl_user->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Name') ?></h6>
            <p><?= h($wallet->name) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($wallet->id) ?></p>
            <h6 class="subheader"><?= __('Amount') ?></h6>
            <p><?= $this->Number->format($wallet->amount) ?></p>
            <h6 class="subheader"><?= __('Is Default') ?></h6>
            <p><?= $this->Number->format($wallet->is_default) ?></p>
            <h6 class="subheader"><?= __('Status') ?></h6>
            <p><?= $this->Number->format($wallet->status) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Date Created') ?></h6>
            <p><?= h($wallet->date_created) ?></p>
            <h6 class="subheader"><?= __('Date Updated') ?></h6>
            <p><?= h($wallet->date_updated) ?></p>
            <h6 class="subheader"><?= __('Date Deleted') ?></h6>
            <p><?= h($wallet->date_deleted) ?></p>
        </div>
    </div>
</div>
