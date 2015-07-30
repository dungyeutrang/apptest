<?=$this->HTML->css('/Frontend/css/forgetpassword.css')?>
<div class="container" id="content-forget-password">
    <div class="row text-center">
     <?= $this->HTML->image('/Frontend/img/icon-key.svg',array('class'=>'img-responsive center-block')); ?>
        <p id="message"><i>Reset Password</i><p>
    </div>
    <div class="row" id="form-forget-password">
        <div class="row">
    <?php echo $this->Flash->render(); ?>
        </div>
<div></div>
<div class="row text-center" id="error-message">
        <?php  foreach($errors as $error):
        foreach($error as $data):
         ?>
        <li class="list-unstyled"><?php echo $data ?></li>
        <?php endforeach;
              endforeach;
        ?>
</div>     
    <?= $this->Form->create(null,
         array('class'=>'form form-horizontal col-sm-offset-4 col-sm-4 col-md-offset-4 col-md-4 col-lg-offset-4 col-lg-4',
        )); ?>
        <?php
            echo $this->Form->input('password',array('label' => 'New Password','type'=>'password','class'=>'form-control'));
        ?>
        <?php
            echo $this->Form->input('password_confirm',array('label'=>'Confirm Password','type'=>'password','class'=>'form-control'));
        ?>
        
    <?= $this->Form->submit('Reset',['type'=>'submit','class'=>'btn btn-success center-block','id'=>'btn-login'])?>
    <?= $this->Form->end() ?>
    </div>
</div>
