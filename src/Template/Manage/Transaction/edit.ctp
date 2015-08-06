<?= $this->HTML->css('/Manage/css/wallet/add', ['block' => 'css_header', 'inline' => false]) ?>
<div class="row wrapper border-bottom white-bg page-heading" id="head-title">
    <div class="col-lg-10">
        <h2>Add Transaction</h2>
        <ol class="breadcrumb">
            <li>
                <a href="index.html">Manage</a>
            </li>
            <li>
                <a>Wallet</a>
            </li>
            <li>
                <a>Transaction</a>
            </li>
            <li class="active">
                <strong>Update</strong>
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
                <p>Update transaction for this wallet</p>
                <?= $this->Form->create($transaction,array('class'=>'form-horizontal')) ?>
                <?php
                echo $this->Form->input('catalog_id', ['options' => $tblCatalog,'class'=>'form-control','default'=>$transaction->category->mst_catalog->id]);
                echo $this->Form->input('category_id', ['options' => $tblCategory,'class'=>'form-control']);
                echo $this->Form->input('amount',array('type'=>'text','class'=>'form-control'));
                echo $this->Form->input('created_at',array('value'=> date_format($transaction->created_at,'Y-m-d'),'type'=>'text','label'=>'Date','class'=>'form-control'));
                echo $this->Form->input('note',array('class'=>'form-control'));
                ?>
                <?= $this->Form->button(__('Change'),array('class' => 'btn btn-info')) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
<!-- Configuration --->
<?= $this->element('Manage/configuration') ?>
<?= $this->HTML->script('/Manage/js/wallet/add', array('block' => 'scriptBottom', 'inline' => false)) ?>
<?= $this->HTML->script('/Manage/js/transaction/transaction_update', array('block' => 'scriptBottom')) ?>
<?= $this->append('scriptBottom') ?>
<script>
var url ='<?= $this->Url->build(['_name'=>'transaction_get_data','wallet_id'=>$transaction->wallet_id]) ?>';
changeData(url);
</script>
<?= $this->end(); ?>