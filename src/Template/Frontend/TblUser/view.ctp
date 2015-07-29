<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Tbl User'), ['action' => 'edit', $tblUser->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Tbl User'), ['action' => 'delete', $tblUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tblUser->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Tbl User'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tbl User'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="tblUser view large-10 medium-9 columns">
    <h2><?= h($tblUser->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Email') ?></h6>
            <p><?= h($tblUser->email) ?></p>
            <h6 class="subheader"><?= __('Password') ?></h6>
            <p><?= h($tblUser->password) ?></p>
            <h6 class="subheader"><?= __('Phone') ?></h6>
            <p><?= h($tblUser->phone) ?></p>
            <h6 class="subheader"><?= __('Last Name') ?></h6>
            <p><?= h($tblUser->last_name) ?></p>
            <h6 class="subheader"><?= __('First Name') ?></h6>
            <p><?= h($tblUser->first_name) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($tblUser->id) ?></p>
            <h6 class="subheader"><?= __('Is Active') ?></h6>
            <p><?= $this->Number->format($tblUser->is_active) ?></p>
            <h6 class="subheader"><?= __('Last Wallet Id') ?></h6>
            <p><?= $this->Number->format($tblUser->last_wallet_id) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Birth Day') ?></h6>
            <p><?= h($tblUser->birth_day) ?></p>
        </div>
    </div>
</div>
