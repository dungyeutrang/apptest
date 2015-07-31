<?= $this->HTML->css('/Manage/css/wallet/add',['block'=>'css_header']) ?>
<div class="container">
<div class="row center-block text-center">
    <?= $this->HTML->image('/Manage/img/wallet.png',array('class'=>'img-cirlce center-block'))  ?>
    <p id="title_add">Add Your Wallet !</p>
</div>
<div class="row">
    <?= $this->Form->create($wallet,array('class'=>'form-horizontal col-sm-offset-3 col-sm-6 col-md-offset-3 col-md-6 col-lg-offset-3 col-lg-6')) ?>
        <?php
            echo $this->Form->input('name',array('class'=>'form-control','placeholder'=>'salary..'));
            echo $this->Form->input('amount',array('class'=>'form-control','placeholder'=>'500.000','id'=>'amount'));
        ?>
    <?= $this->Form->button(__('Submit'),array('class'=>'btn btn-info')) ?>
    <?= $this->Form->end() ?>
</div>
</div>
<?= $this->HTML->script('/Manage/js/wallet/add',array('block'=>'scriptBottom')) ?>
