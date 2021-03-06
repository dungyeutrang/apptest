<?=

$this->HTML->link('Add', ['_name' => 'transaction_add', 'wallet_id' => $walletId], ['id' => 'add-new-record', 'class' => 'btn btn-primary col-sm-2 col-md-2 col-lg-1 col-xs-2']) ?>
<table id="main" class="table table-striped table-bordered table-hover dataTables-content" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('category') ?></th>
            <th><?= $this->Paginator->sort('type') ?></th>
            <th><?= $this->Paginator->sort('amount') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $i=1; foreach ($transactions as $transaction): ?>
        <tr>
            <td><?= $i++ ?></td>
            <td>   <?= $this->HTML->image($transaction->category->avatar,array('class'=>'circle icon-category')); ?> &nbsp; <?= h($transaction->category->name); ?></td>
            <td><?= $transaction->category->mst_catalog->name ?></td>
            <td><?= $this->Number->format($transaction->total) ?></td>
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
                        '_name' => 'transaction_query',
                        'wallet_id' => $walletId,
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