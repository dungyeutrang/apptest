<?=
$this->HTML->css('/Manage/css/wallet/add', ['block' => 'css_header','inline'=>false]) ?>
<div class="row wrapper border-bottom white-bg page-heading" id="head-title">
    <div class="col-lg-10">
        <h2>Status of Wallet</h2>
        <ol class="breadcrumb">
            <li>
                <a href="index.html">Manage</a>
            </li>
            <li>
                <a>Wallet</a>
            </li>
            <li class="active">
                <strong>Status</strong>
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
                <h5>Status of wallet</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-sm-offset-3 col-sm-6 ">
                        <div id="donutchart" style="height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Configuration --->
<?= $this->element('Manage/configuration') ?>
 <?= $this->element('Manage/home_js') ?>
<?= $this->HTML->script('/Manage/js/wallet/expense', array('block' => 'scriptBottom')) ?>
<?= $this->append('scriptBottom') ?>
<script>
    $(function () {
        var amount = <?= $balance ?>;
        var data = <?= $dataExpense ?>; 
        total = new Object();
        total.label="balance";
        total.data=amount;
        data.push(total);
        donut(data);
    });
</script>
<?= $this->end(); ?>