<?=$this->HTML->css('/Frontend/css/forgetpassword.css')?>
<div class="container" id="content-forget-password">
    <div class="row text-center">
     <?= $this->HTML->image('/Frontend/img/icon-key.svg',array('class'=>'img-responsive center-block')); ?>
        <p id="message"><i>Forgot your password?</i><p>
    </div>
    <div class="row text-center">
        <p id="notice">Enter your email address associated with your account </br> to reset your password.</p>
    </div>
    <div class="row" id="form-forget-password">
        <div class="row">
    <?php echo $this->Flash->render(); ?>
        </div>
    <?= $this->Form->create(null,
         array('class'=>'form form-horizontal col-sm-offset-4 col-sm-4 col-md-offset-4 col-md-4 col-lg-offset-4 col-lg-4',
        )); ?>
        <?php
            echo $this->Form->input('email',array('class'=>'form-control','placeholder'=>'hello@gmail.com'));
        ?>
    <?= $this->Form->submit('Reset',['type'=>'submit','class'=>'btn btn-success center-block','id'=>'btn-login'])?>
    <?= $this->Form->end() ?>
    </div>
</div>