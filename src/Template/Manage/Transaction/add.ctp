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
                <p>Add transaction for this wallet</p>
                <?= $this->Form->create($transaction,array('class'=>'form-horizontal')) ?>
                <?php
                echo $this->Form->input('catalog_id', ['options' => $tblCatalog,'class'=>'form-control']);
                echo $this->Form->input('category_id', ['options' => $tblCategory,'class'=>'form-control']);
                echo $this->Form->input('amount',array('type'=>'text','class'=>'form-control','placeholder'=>'500.000'));
                echo $this->Form->input('created_at',array('type'=>'text','label'=>'Date','class'=>'form-control','placeholder'=>'2015-11-25'));
                echo $this->Form->input('note',array('class'=>'form-control','placeholder'=>'comment this here'));
                ?>
                <?= $this->Form->button(__('Add'),array('class' => 'btn btn-info')) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
<!-- Configuration --->
<?= $this->element('Manage/configuration') ?>
<?= $this->HTML->script('/Manage/js/wallet/add', array('block' => 'scriptBottom', 'inline' => false)) ?>
<?= $this->HTML->script('/Manage/js/transaction/transaction_add', array('block' => 'scriptBottom')) ?>
<?= $this->append('scriptBottom') ?>
<script>
var url ='<?= $this->Url->build(['_name'=>'transaction_get_data','wallet_id'=>$walletId]) ?>';
changeData(url);
</script>
<?= $this->end(); ?>