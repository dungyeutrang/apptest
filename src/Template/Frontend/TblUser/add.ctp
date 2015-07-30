<?=$this->HTML->css('/Frontend/css/register.css')?>
<?=$this->HTML->css('/Common/css/jquery-ui.css')?>
<div class="container">
   <div class="row text-center">
     <?= $this->HTML->image('/Frontend/img/icon-boombox.svg',array('class'=>'img-responsive center-block')); ?>
        <p id="message"><i>Join with us!</i><p>
    </div>
  <div class="row text-center">
        <p>Sign Up or <a href="<?= $this->Url->build('/login') ?>"> Sign In</a></p>
    </div>
<div class="row" id="form-register">
<div class="row bg-danger"> 
</div>
    <?= $this->Form->create($tblUser,
         array('class'=>'form form-horizontal col-sm-offset-4 col-sm-4 col-md-offset-4 col-md-4 col-lg-offset-4 col-lg-4',      
        )); ?>
        <?php
            echo $this->Form->input('email',array('class'=>'form-control'));
            echo $this->Form->input('password',array('class'=>'form-control'));
            echo $this->Form->input('phone',array('class'=>'form-control'));
            echo $this->Form->input('last_name',array('class'=>'form-control'));
            echo $this->Form->input('first_name',array('class'=>'form-control'));
            echo $this->Form->input('birth_day',['type'=>'text','class'=>'form-control']);       
        ?>
    <?= $this->Form->submit('Register',['type'=>'submit','class'=>'btn btn-success center-block','id'=>'btn-login'])?>
    <?= $this->Form->end() ?>
</div>
</div>
<?= $this->HTML->script('/Frontend/js/register',['block'=>'scriptBottom']) ?>
<?= $this->HTML->script('/Common/js/jquery-ui.min',['block'=>'scriptBottom']) ?>