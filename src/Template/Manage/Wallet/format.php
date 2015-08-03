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
                <?= $this->HTML->link('Add', ['_name' => 'category_add', 'wallet_id' => $walletId], ['id' => 'add-new-record', 'class' => 'btn btn-primary col-sm-2 col-md-2 col-lg-1 col-xs-2']) ?>
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