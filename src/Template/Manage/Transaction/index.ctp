<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Transaction'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tbl Category'), ['controller' => 'TblCategory', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tbl Category'), ['controller' => 'TblCategory', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="transaction index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('parent_transaction_id') ?></th>
            <th><?= $this->Paginator->sort('category_id') ?></th>
            <th><?= $this->Paginator->sort('amount') ?></th>
            <th><?= $this->Paginator->sort('create_at') ?></th>
            <th><?= $this->Paginator->sort('update_at') ?></th>
            <th><?= $this->Paginator->sort('delete_at') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($transaction as $transaction): ?>
        <tr>
            <td><?= $this->Number->format($transaction->id) ?></td>
            <td><?= $this->Number->format($transaction->parent_transaction_id) ?></td>
            <td>
                <?= $transaction->has('tbl_category') ? $this->Html->link($transaction->tbl_category->name, ['controller' => 'TblCategory', 'action' => 'view', $transaction->tbl_category->id]) : '' ?>
            </td>
            <td><?= $this->Number->format($transaction->amount) ?></td>
            <td><?= h($transaction->create_at) ?></td>
            <td><?= h($transaction->update_at) ?></td>
            <td><?= h($transaction->delete_at) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $transaction->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $transaction->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $transaction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $transaction->id)]) ?>
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
