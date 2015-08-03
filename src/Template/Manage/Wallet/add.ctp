<?= $this->HTML->css('/Manage/css/wallet/add', ['block' => 'css_header','inline'=>false]) ?>
<div class="row wrapper border-bottom white-bg page-heading" id="head-title">
    <div class="col-lg-10">
        <h2>Add Wallet</h2>
        <ol class="breadcrumb">
            <li>
                <a href="index.html">Manage</a>
            </li>
            <li>
                <a>Wallet</a>
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
            <p>Add name and amount for this wallet</p>
                 <?= $this->Form->create($wallet,array('class'=>'form-horizontal')) ?>
                    <?php
                        echo $this->Form->input('name',array('class'=>'form-control','placeholder'=>'salary..'));
                        echo $this->Form->input('amount',array('class'=>'form-control','placeholder'=>'500.000','id'=>'amount','type'=>'text'));                        
                    ?>
                <?= $this->Form->button(__('Add'),array('class'=>'btn btn-info')) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
<!-- Configuration --->
<?= $this->element('Manage/configuration') ?>
<?= $this->HTML->script('/Manage/js/wallet/add',array('block'=>'scriptBottom','inline'=>false)) ?>
