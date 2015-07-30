<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Wallet'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tbl User'), ['controller' => 'TblUser', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tbl User'), ['controller' => 'TblUser', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="wallet index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('user_id') ?></th>
            <th><?= $this->Paginator->sort('name') ?></th>
            <th><?= $this->Paginator->sort('amount') ?></th>
            <th><?= $this->Paginator->sort('is_default') ?></th>
            <th><?= $this->Paginator->sort('date_created') ?></th>
            <th><?= $this->Paginator->sort('date_updated') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($wallet as $wallet): ?>
        <tr>
            <td><?= $this->Number->format($wallet->id) ?></td>
            <td>
                <?= $wallet->has('tbl_user') ? $this->Html->link($wallet->tbl_user->id, ['controller' => 'TblUser', 'action' => 'view', $wallet->tbl_user->id]) : '' ?>
            </td>
            <td><?= h($wallet->name) ?></td>
            <td><?= $this->Number->format($wallet->amount) ?></td>
            <td><?= $this->Number->format($wallet->is_default) ?></td>
            <td><?= h($wallet->date_created) ?></td>
            <td><?= h($wallet->date_updated) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $wallet->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $wallet->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $wallet->id], ['confirm' => __('Are you sure you want to delete # {0}?', $wallet->id)]) ?>
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
