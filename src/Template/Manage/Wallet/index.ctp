<?= $this->HTML->css('/Manage/css/datatable_all_page', ['block' => 'css_header']) ?>
<!-- Data table CSS -->
<?= $this->element('Manage/data_table_css') ?>

<div class="row wrapper border-bottom white-bg page-heading" id="head-title">
    <div class="col-lg-10">
        <h2>Manage Wallet</h2>
        <ol class="breadcrumb">
            <li>
                <a href="index.html">Manage</a>
            </li>
            <li>
                <a>Wallet</a>
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
                <h5>List Wallet </h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#">Config option 1</a>
                        </li>
                        <li><a href="#">Config option 2</a>
                        </li>
                    </ul>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div> <!-- end ibox-title -->
            <div class="ibox-content">
             <?= $this->HTML->link('Add',['prefix'=>'manage','controller'=>'Wallet','action'=>'add'],['id'=>'add-new-record','class'=>'btn btn-primary col-sm-2 col-md-2 col-lg-1 col-xs-2']) ?>
                <table class="table table-striped table-bordered table-hover dataTables-content" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="col-sm-1 text-center"><?= $this->Paginator->sort('id') ?></th>
                            <th class="col-sm-3 text-center"><?= $this->Paginator->sort('name') ?></th>
                            <th class="col-sm-3 text-center"><?= $this->Paginator->sort('amount') ?></th>
                            <th class="col-sm-2 text-center"><?= $this->Paginator->sort('Category') ?></th>
                            <th class="col-sm-3 text-center"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($wallet as $wallet):
                            ?>
                            <tr>
                                <td class="text-center"><?= $i++; ?></td>
                                <td class="text-center"><?= h($wallet->name) ?></td>
                                <td class="text-center"><?= $this->Number->format($wallet->amount) ?></td>
                                <td class="text-center"><?= $this->HTML->link('Manage',['_name'=>'category','wallet_id'=>$wallet->id],array('class'=>'btn btn-info')) ?></td>
                                <td class="text-center">
                                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $wallet->id],array('class'=>'btn btn-warning')) ?>
                                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $wallet->id], ['class'=>'btn btn-danger','confirm' => __('Are you sure you want to delete this record ?', $wallet->id)]) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- PAGINATION-->
                <div class="row">
                    <nav class="pull-right" id="nav-pagination">
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
            </div> <!-- end ibox content -->
        </div>
    </div>
</div>
<!-- Configuration --->
<?= $this->element('Manage/configuration') ?>
<!-- Data table JS -->
<?= $this->element('Manage/data_table_js') ?>
<?= $this->HTML->script('../Manage/js/datatable_all_page', array('block' => 'scriptBottom')) ?>