<?= $this->HTML->css('/Manage/css/common/datatable_all_page', ['block' => 'css_header']) ?>
<?= $this->HTML->css('/Manage/css/transaction/index', ['block' => 'css_header']) ?>
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
                <strong>Index</strong>
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
                <h5 id="title-balance"><b id="balance">Balance: <?= $this->Number->format($dataWallet->amount) ?></b>
                    <?= $this->Form->create(null) ?>
                    <select id="change-date">
                        <option value="<?= $this->Url->build(['_name' => 'transaction_query', 'wallet_id' => $walletId, 'query_date' => 'today']) ?>">To day</option>
                        <option value="<?= $this->Url->build(['_name' => 'transaction_query', 'wallet_id' => $walletId, 'query_date' => 'this-week']) ?>">This Week</option>
                        <option value="<?= $this->Url->build(['_name' => 'transaction_query', 'wallet_id' => $walletId, 'query_date' => 'this-month']) ?>">This Month</option>
                    </select>
                    <button type="button" value="<?= $this->Url->build(['_name' => 'transaction', 'wallet_id' => $walletId]) ?>" id="search_time_other" class="btn btn-primary">Search time other</button>
                    <?= $this->Form->end() ?>
                </h5>
                <div class="ibox-tools">
                    <a class="collapse-link btn-lg">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle btn-lg" data-toggle="dropdown" href="#">
                        <i class="fa fa-cog fa-spin"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?= $this->Url->build(['_name'=>'transaction_change_view','wallet_id'=>$walletId,'type'=>1]) ?>">View by Transaction</a>
                        </li>
                        <li><a href="<?=   $this->Url->build(['_name'=>'transaction_change_view','wallet_id'=>$walletId,'type'=>2])  ?>">View by Category</a>
                        </li>
                    </ul>
                    <a class="close-link btn-lg">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div> <!-- end ibox-title -->
            <div id="ibox-content" class="ibox-content">
                <?= $this->HTML->link('Add', ['_name' => 'transaction_add', 'wallet_id' => $walletId], ['id' => 'add-new-record', 'class' => 'btn btn-primary col-sm-2 col-md-2 col-lg-1 col-xs-2']) ?>
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
                            <p><?=
                                $this->Paginator->counter([
                                    'format' => 'Page {{page}} of {{pages}}, showing {{current}} records out of {{count}} total'
                                ])
                                ?></p>
                        </nav>
<?php endif; ?>
                </div>
            </div> <!-- end ibox content -->
        </div>
    </div>
</div>
<div  id="loading">
</div>
<!-- Modal Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Delete Category</h4>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this wallet ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button id="btn-delete" type="button" class="btn btn-primary">Delete</button>
            </div>
        </div>
    </div>
</div>
<!-- modal change time -->
<div id="myModal10" class="modal" data-easein="bounceIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="opacity: 1; display: block; transform: scaleX(1) scaleY(1);">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Please select time !</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form id="form_change_time" class="form-horizontal">
                        <div class="form-group">
                            <label for="First time" class="col-sm-2 control-label">Start Time</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="first_time">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="End time" class="col-sm-2 control-label">End Time</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="last_time" >
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                <button type="button" id="btn_query" class="btn btn-primary">Search</button>
            </div>
        </div>
    </div>
</div>
<!-- Configuration --->
<?= $this->element('Manage/configuration') ?>
<!-- Data table JS -->
<?= $this->element('Manage/data_table_js') ?>
<?= $this->HTML->script('../Manage/js/common/datatable_all_page', array('block' => 'scriptBottom')) ?>
<?= $this->HTML->script('../Manage/js/transaction/transaction_index_category', array('block' => 'scriptBottom')) ?>
<?= $this->HTML->script('../Manage/js/transaction/spin.min', array('block' => 'scriptBottom')) ?>
<?= $this->append('scriptBottom') ?>
<script src="//cdn.jsdelivr.net/velocity/1.2.2/velocity.min.js"></script>
<script src="//cdn.jsdelivr.net/velocity/1.2.2/velocity.ui.min.js"></script>
<?= $this->end() ?>
