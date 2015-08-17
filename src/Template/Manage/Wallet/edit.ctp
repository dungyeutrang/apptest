<?= $this->HTML->css('/Manage/css/wallet/add', ['block' => 'css_header']) ?>
<div class="row wrapper border-bottom white-bg page-heading" id="head-title">
    <div class="col-lg-10">
        <h2>Update Wallet</h2>
        <ol class="breadcrumb">
            <li>
                <a href="index.html">Manage</a>
            </li>
            <li>
                <a>Wallet</a>
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
                <h5>Update your wallet</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
    <div class="row">  <?= $this->Flash->render(); ?> </div>
            <p>Change name for this wallet</p>
                 <?= $this->Form->create($wallet,array('class'=>'form-horizontal')) ?>
                    <?php
                        echo $this->Form->input('name',array('class'=>'form-control','placeholder'=>'salary..'));                        
                    ?>
                <?= $this->Form->button(__('Change'),array('class'=>'btn btn-info')) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
<!-- Configuration --->
<?= $this->element('Manage/configuration') ?>
<?= $this->HTML->script('/Manage/js/wallet/add',array('block'=>'scriptBottom')) ?>