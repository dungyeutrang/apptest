<?= $this->HTML->css('/Manage/css/wallet/add', ['block' => 'css_header']) ?>
<div class="row wrapper border-bottom white-bg page-heading" id="head-title">
    <div class="col-lg-10">
        <h2>Add Category</h2>
        <ol class="breadcrumb">
            <li>
                <a href="index.html">Manage</a>
            </li>
            <li>
                <a>Wallet</a>
            </li>
            <li>
                <a>Category</a>
            </li>
            <li class="active">
                <strong>Add</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
    </div>
</div>

<!-- message success -->
<div class="row"> <?= $this->Flash->render(); ?> </div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Add new wallet</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <p>Add new category  for this wallet</p>
                <?= $this->Form->create($category, array('enctype' => 'multipart/form-data','id'=>'form-content', 'class' => 'form-horizontal')) ?>
                <?php
                echo $this->Form->input('catalog_id', ['label' => 'Kind Of Category', 'options' => $mstCatalog, 'class' => 'form-control']);
                echo $this->Form->input('parent_id', ['required'=>false,'type'=>'select','label' => 'Parent Category', 'options' => $parentCategory, 'class' => 'form-control','empty'=>true]);
                echo $this->Form->input('name', ['class' => 'form-control']);
                ?>
                <div class="input">
                    <label for="avatar">Avatar</label>
                    <input type="file" name="avatar" div="input" class="form-control" required="required" id="avatar">
                </div>
                <?= $this->Form->button(__('Add'), array('class' => 'btn btn-info')) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
<!-- Configuration --->
<?= $this->element('Manage/configuration') ?>
<?= $this->HTML->script('/Manage/js/wallet/add', array('block' => 'scriptBottom')) ?>
<?= $this->HTML->script('/Manage/js/category/add', array('block' => 'scriptBottom')) ?>
<?= $this->append('scriptBottom') ?>
<script>
var url ='<?= $this->Url->build(['_name'=>'category_get_data','wallet_id'=>$walletId]) ?>';
changeData(url);
</script>
<?= $this->end(); ?>
