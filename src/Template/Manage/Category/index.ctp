<?= $this->HTML->css('/Manage/css/datatable_all_page', ['block' => 'css_header']) ?>
<!-- Data table CSS -->
<?= $this->element('Manage/data_table_css') ?>

<div class="row wrapper border-bottom white-bg page-heading" id="head-title">
    <div class="col-lg-10">
        <h2>Manage Category</h2>
        <ol class="breadcrumb">
            <li>
                <a href="#">Manage</a>
            </li>
            <li>
                <a>Wallet</a>
            </li>
            <li>
                <a>Category</a>
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
                <?= $this->HTML->link('Add', ['_name'=>'category_add','wallet_id'=>$walletId], ['id' => 'add-new-record', 'class' => 'btn btn-primary col-sm-2 col-md-2 col-lg-1 col-xs-2']) ?>
                <table class="table table-striped table-bordered table-hover dataTables-content" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="col-sm-1"><?= $this->Paginator->sort('id'); ?></th>
                            <th class="col-sm-3"><?= $this->Paginator->sort('wallet_id') ?></th>
                            <th class="col-sm-2"><?= $this->Paginator->sort('catalog_id') ?></th>
                            <th class="col-sm-3"><?= $this->Paginator->sort('name') ?></th>
                            <th class="col-sm-1"><?= $this->Paginator->sort('avatar') ?></th>
                            <th class="actions col-sm-2"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach ($category as $category): ?>
                            <tr>
                                <td class="col-sm-1"><?= $i++ ?></td>
                                <td class="col-sm-3">
                                    <?= h($walletName) ?>
                                </td>
                                <td class="col-sm-2">
                                    <?= $category->has('mst_catalog') ? $this->Html->link($category->mst_catalog->name, ['controller' => 'MstCatalog', 'action' => 'view', $category->mst_catalog->id]) : '' ?>
                                </td>                                
                                <td class="col-sm-3"><?= h($category->name) ?></td>
                                <td class="col-sm-1"><?= $this->HTML->image($category->avatar,array('class'=>'img-circle avatar-category')) ?></td>
                                <td class="actions col-sm-2">
                                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $category->id],array('class'=>'btn btn-warning')) ?>
                                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $category->id], ['class'=>'btn btn-danger','confirm' => __('Are you sure you want to delete # {0}?', $category->id)]) ?>
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