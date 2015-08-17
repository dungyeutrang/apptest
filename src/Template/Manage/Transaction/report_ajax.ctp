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
    <nav class="pull-right" id="nav-pagination">
        <ul class="pagination"> 
             <?=  $this->Paginator->options(array(
                                    'url' => array(
                                        '_name' => 'report_monthly_query',
                                        'wallet_id' => $walletId,
                                        'query_date' => $query
                                    )
                                ));
                                ?>
              <?php if ($this->Paginator->hasPage(2)): ?>
                            <?= $this->Paginator->prev('« Previous') ?>
                            <?= $this->Paginator->numbers() ?>
                            <?= $this->Paginator->next('Next »') ?>
            <?php endif; ?>
        </ul>
        <p><?=
           $this->Paginator->counter([
            'format' => 'Page {{page}} of {{pages}}, showing {{current}} records out of {{count}} total'
             ])
         ?></p>
    </nav>
</div>
<div class="row expense" id="expense">
    <div class="col-sm-10"><h3>Expense Total</h3></div>
    <div class="col-sm-2"><h3 class="text-danger"><?= $this->Number->format($total); ?></h3></div>
  <?php foreach($expense as $ex): ?>
    <div class="row expense">
        <div class="col-sm-10"><h5><?= $this->HTML->image($ex->category->avatar, array('class' => 'circle icon-category')); ?> &nbsp; <?= $ex->category->name ?></h5>       
        </div>
        <div class="col-sm-2"><h5 class="text-danger"><?= $this->Number->format($ex->total) ?></h5></div>
    </div>
  <?php endforeach; ?>
    <div id="donutchart" style="height: 400px;"></div>
</div>
<!-- Data table JS -->
 <?= $this->element('Manage/home_js') ?>
<?= $this->HTML->script('/Manage/js/wallet/expense', array('block' => 'scriptBottom')) ?>
<?= $this->append('scriptBottom') ?>
<script>
    $(function () {
        var data = <?= $data?>;
        donut(data);
    });
</script>
<?= $this->end(); ?>
