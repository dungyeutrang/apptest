<?= $this->HTML->css('/Manage/css/common/datatable_all_page', ['block' => 'css_header']) ?>
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
                                <td class="col-sm-2">
                                    <?= $category->mst_catalog->name ?>
                                </td>
                                <td class="col-sm-3"><?= h($category->name) ?></td>
                                <td class="col-sm-1"><?= $this->HTML->image($category->avatar,array('class'=>'img-circle avatar-category')) ?></td>
                                <td class="actions col-sm-2">
                                  <?php if($category->is_default!=1){?>                                    
                                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $category->id],array('class'=>'btn btn-warning')) ?>
                                    <?= $this->Html->link(__('Delete'), ['_name' => 'category_delete','wallet_id'=>$walletId, 'id'=>$category->id],
                                    array('class'=>'btn btn-danger btn-delete','catalog'=>$category->catalog_id,'urlcheck'=>$this->Url->build(['_name'=>'category_check'
                                    ,'wallet_id'=>$walletId,'id'=>$category->id]) )) ?>
                                   <?php }else if($category->is_default==1&&$category->is_perform==1){ ?>
                                       <?= $this->Html->link(__('Edit'),'#',array('class'=>'btn btn-warning btn-edit-default')) ?>
                                     <?= $this->Html->link(__('Delete'), ['_name' => 'category_delete','wallet_id'=>$walletId, 'id'=>$category->id],
                                    array('class'=>'btn btn-danger btn-delete','catalog'=>$category->catalog_id,'urlcheck'=>$this->Url->build(['_name'=>'category_check'
                                    ,'wallet_id'=>$walletId,'id'=>$category->id]) )) ?>
                                   <?php }else{?>
                                    <?= $this->Html->link(__('Edit'),'#',array('class'=>'btn btn-warning btn-edit-default')) ?>
                                    <?= $this->Html->link(__('Delete'),'#',
                                    array('class'=>'btn btn-danger btn-delete-default')) ?>
                                  <?php }?>
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
<!-- Modal Delete Merg -->
<div class="modal fade" id="deleteMergeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Delete category</h4>
      </div>
      <div class="modal-body">
        <p id="content-title">
        This category contain transaction.If you want to delete it,you may click button merge to merge with category difference</br>
        or Click  button delete to delete all transaction !
        </p>
       <div url="<?= $this->Url->build(['_name'=>'transaction_get_data','wallet_id'=>$walletId]) ?>" id="form-delete" style="display:none">
                    <?= $this->Form->create(null,array('class'=>'form-horizontal')) ?>                                        
                    <?=  $this->Form->input('category_id', ['label'=>'Category','options' =>[],'class'=>'form-control']); ?> 
                    <?= $this->Form->end() ?>  
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="btn-delete-merge" type="button" class="btn btn-primary">Merge</button>
        <button id="btn-delete-all" type="button" class="btn btn-primary">Delete</button>
      </div>
    </div>
  </div>
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
       Are you sure you want to delete this category ? 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="btn-delete" type="button" class="btn btn-primary">Delete</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Delete default-->
<div class="modal fade" id="delete_category_default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Notice!</h4>
      </div>
      <div class="modal-body">
        You can not delete or update category default of system !
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- LOADING -->
<div  id="loading">
</div>
<!-- Configuration --->
<?= $this->element('Manage/configuration') ?>
<!-- Data table JS -->
<?= $this->element('Manage/data_table_js') ?>
<?= $this->HTML->script('../Manage/js/common/datatable_all_page', array('block' => 'scriptBottom')) ?>
<?= $this->HTML->script('../Manage/js/category/index', array('block' => 'scriptBottom')) ?>
<?= $this->HTML->script('../Manage/js/transaction/spin.min', array('block' => 'scriptBottom')) ?> 
<?= $this->end(); ?>