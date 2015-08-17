<?=$this->HTML->css('/Manage/css/common/datatable_all_page', ['block' => 'css_header']) ?>
<?= $this->HTML->css('/Manage/css/transaction/index', ['block' => 'css_header']) ?>
<?= $this->HTML->css('/Manage/css/transaction/report', ['block' => 'css_header']) ?>
<!-- Data table CSS -->
<?= $this->element('Manage/data_table_css') ?>
<div class="row wrapper border-bottom white-bg page-heading" id="head-title">
    <div class="col-lg-10">
        <h2>Manage  Transaction</h2>
        <ol class="breadcrumb">
            <li>
                <a href="#">Manage</a>
            </li>
            <li>
                <a>Wallet</a>
            </li>
            <li>
                <a>Transaction</a>
            </li>
            <li class="active">
                <strong>Report</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
    </div>
</div>
<!-- message success -->
<?= $this->Flash->render(); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5 id="title-balance"><b>Balance: <?= $this->Number->format($dataWallet->amount) ?></b>  
                    <?= $this->Form->create(null) ?> 
                    <div class="input-group col-sm-4">
                        <input id="input_search_date" type="text" class="form-control" id="inputGroupSuccess2" aria-describedby="inputGroupSuccess2Status" placeholder='2015-08'>
                        <span value="<?= $this->Url->build(['_name' => 'report_monthly', 'wallet_id' => $wallet_id]) ?>" id="btn_search_month" class="input-group-addon btn btn-primary" >Search</span>             
                    </div> 
                    <?= $this->Form->end() ?>
                </h5>        
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>           
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div> <!-- end ibox-title -->
            <div id="ibox-content" class="ibox-content"> 
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
                        <?php $i = 1;
                        foreach ($transactions as $transaction): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td>   <?= $this->HTML->image($transaction->category->avatar, array('class' => 'circle icon-category')); ?> &nbsp; <?= h($transaction->category->name); ?></td>
                            <td><?= $transaction->category->mst_catalog->name ?></td>
                            <td><?= $this->Number->format($transaction->total) ?></td>
                        </tr>
<?php endforeach; ?>
                    </tbody>
                </table>
                <!-- PAGINATION-->
<?php if ($this->Paginator->hasPage(2)): ?>
                <div class="row">
                    <nav class="pull-right" id="nav-pagination">
<?=  $this->Paginator->options(array(
                                    'url' => array(
                                        '_name' => 'report_monthly_query',
                                        'wallet_id' => $walletId,
                                        'query_date' => $query
                                    )
                                ));
                                ?>
                        <ul class="pagination"> 
                                <?= $this->Paginator->prev('« Previous') ?>
                                <?= $this->Paginator->numbers() ?>
    <?= $this->Paginator->next('Next »') ?>
                        </ul>
                        <p><?=
                                $this->Paginator->counter([
                                    'format' => 'Page {{page}} of {{pages}}, showing {{current}} records out of {{count}} total'
                                ])
                                ?></p>
                    </nav>
                </div>
<?php endif; ?>
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
                    <div id="donutchart" style="height: 300px;"></div>
                </div>
            </div> <!-- end ibox content --> 
        </div>
    </div>
</div>
<div  id="loading">
</div>
<!-- Configuration --->
<?= $this->element('Manage/configuration') ?>
<!-- Data table JS -->
<?= $this->element('Manage/data_table_js') ?>
<?= $this->element('Manage/configuration') ?>
 <?= $this->element('Manage/home_js') ?>
<?= $this->HTML->script('../Manage/js/common/datatable_all_page', array('block' => 'scriptBottom')) ?> 
<?= $this->HTML->script('../Manage/js/transaction/transaction_report', array('block' => 'scriptBottom')) ?> 
<?= $this->HTML->script('../Manage/js/transaction/spin.min', array('block' => 'scriptBottom')) ?>
<?= $this->HTML->script('/Manage/js/wallet/expense', array('block' => 'scriptBottom')) ?>
<?= $this->append('scriptBottom') ?>
<script>
    $(function () {
        var data = <?= $data?>;
        donut(data);
    });
</script>
<?= $this->end(); ?>