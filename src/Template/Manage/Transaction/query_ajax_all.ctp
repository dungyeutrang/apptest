<table id="main" class="table table-striped table-bordered table-hover dataTables-content" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('wallet') ?></th>
            <th><?= $this->Paginator->sort('category_id') ?></th>
            <th><?= $this->Paginator->sort('type') ?></th>
            <th><?= $this->Paginator->sort('amount') ?></th>
            <th><?= $this->Paginator->sort('date') ?></th>
            <th><?= $this->Paginator->sort('note') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1;
        foreach ($transactions as $transaction): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $transaction->wallet->name ?></td>
                <td>
    <?= $this->HTML->image($transaction->category->avatar, array('class' => 'circle icon-category')); ?> &nbsp; <?= h($transaction->category->name); ?>
                </td>
                <td>
    <?= $transaction->category->mst_catalog->name ?>
                </td>
                <td><?= $this->Number->format($transaction->amount) ?></td>
                <td><?= date_format($transaction->created_at, 'Y-m-d') ?></td>
                <td><?= $transaction->note ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $transaction->id], array('class' => 'btn btn-warning')) ?>
    <?= $this->Html->link(__('Delete'), ['action' => 'delete', $transaction->id], array('class' => 'btn btn-danger')) ?>
                </td>
            </tr>
<?php endforeach; ?>
    </tbody>
</table>
<!-- PAGINATION-->
<div class="row">
<?php if ($this->Paginator->hasPage(2)): ?>
        <nav class="pull-right" id="nav-pagination">
            <ul class="pagination">
                <?=
                $this->Paginator->options(array(
                    'url' => array(
                        '_name' => 'all_transaction_query_date',
                        'query_date' => $queryDate
                    )
                ));
                ?>
    <?= $this->Paginator->prev('« Previous') ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next('Next »') ?>
            </ul>
            <p> <?=
                $this->Paginator->counter([
                    'format' => 'Page {{page}} of {{pages}}, showing {{current}} records out of {{count}} total'
                ])
                ?></p>
        </nav>
<?php endif; ?>
</div>