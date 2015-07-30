<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Wallet'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Tbl User'), ['controller' => 'TblUser', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tbl User'), ['controller' => 'TblUser', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="wallet form large-10 medium-9 columns">
    <?= $this->Form->create($wallet) ?>
    <fieldset>
        <legend><?= __('Add Wallet') ?></legend>
        <?php
            echo $this->Form->input('user_id', ['options' => $tblUser]);
            echo $this->Form->input('name');
            echo $this->Form->input('amount');
            echo $this->Form->input('is_default');
            echo $this->Form->input('date_created');
            echo $this->Form->input('date_updated');
            echo $this->Form->input('date_deleted');
            echo $this->Form->input('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
