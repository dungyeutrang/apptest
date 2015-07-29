<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Tbl User'), ['action' => 'add']) ?></li>
    </ul>
</div>
<div class="tblUser index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('email') ?></th>
            <th><?= $this->Paginator->sort('password') ?></th>
            <th><?= $this->Paginator->sort('phone') ?></th>
            <th><?= $this->Paginator->sort('last_name') ?></th>
            <th><?= $this->Paginator->sort('first_name') ?></th>
            <th><?= $this->Paginator->sort('birth_day') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($tblUser as $tblUser): ?>
        <tr>
            <td><?= $this->Number->format($tblUser->id) ?></td>
            <td><?= h($tblUser->email) ?></td>
            <td><?= h($tblUser->password) ?></td>
            <td><?= h($tblUser->phone) ?></td>
            <td><?= h($tblUser->last_name) ?></td>
            <td><?= h($tblUser->first_name) ?></td>
            <td><?= h($tblUser->birth_day) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $tblUser->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $tblUser->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $tblUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tblUser->id)]) ?>
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
