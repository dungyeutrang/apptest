<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $tblUser->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $tblUser->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Tbl User'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="tblUser form large-10 medium-9 columns">
    <?= $this->Form->create($tblUser) ?>
    <fieldset>
        <legend><?= __('Edit Tbl User') ?></legend>
        <?php
            echo $this->Form->input('email');
            echo $this->Form->input('password');
            echo $this->Form->input('phone');
            echo $this->Form->input('last_name');
            echo $this->Form->input('first_name');
            echo $this->Form->input('birth_day', ['empty' => true, 'default' => '']);
            echo $this->Form->input('is_active');
            echo $this->Form->input('last_wallet_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
