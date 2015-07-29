<?=$this->HTML->css('/Frontend/css/register.css')?>
<?=$this->HTML->css('/Frontend/css/jquery-ui.css')?>
<div class="container">
<div class="row text-center">
    <h3><?= __('Sign Up') ?></h3>
</div>
<div class="row" id="form-register">
<div class="row bg-danger"> 
</div>
    <?= $this->Form->create($tblUser,
         array('class'=>'form form-horizontal',      
        )); ?>
        <?php
            echo $this->Form->input('email',array('class'=>'form-control'));
            echo $this->Form->input('password',array('class'=>'form-control'));
            echo $this->Form->input('phone',array('class'=>'form-control'));
            echo $this->Form->input('last_name',array('class'=>'form-control'));
            echo $this->Form->input('first_name',array('class'=>'form-control'));
            echo $this->Form->input('birth_day',['type'=>'text','class'=>'form-control']);       
        ?>
    <?= $this->Form->submit('Register',['type'=>'submit','class'=>'btn btn-success'])?>
    <?= $this->Form->end() ?>
</div>
</div>
<?= $this->HTML->script('/Frontend/js/register',['block'=>'scriptBottom']) ?>
<?= $this->HTML->script('/Frontend/js/jquery-ui.min',['block'=>'scriptBottom']) ?>

