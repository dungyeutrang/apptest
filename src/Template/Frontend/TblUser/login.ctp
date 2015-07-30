<?=$this->HTML->css('/Frontend/css/login.css')?>
<div class="container">
    <div class="row text-center">
     <?= $this->HTML->image('/Frontend/img/icon-shades.svg',array('class'=>'img-responsive center-block')); ?>
        <p id="message"><i>Hello Gorgeous!</i><p>
    </div>
    <div class="row text-center">
        <p>Sign In or <a href="<?= $this->Url->build('/register') ?>"> Sign Up</a></p>
    </div>
    <div class="row" id="form-login-user">
        <div class="text-center">
            <p class="text-danger"><?php echo $this->Flash->render(); ?></p>
        </div>
    <?= $this->Form->create(null,
         array('class'=>'form form-horizontal col-sm-offset-4 col-sm-4 col-md-offset-4 col-md-4 col-lg-offset-4 col-lg-4',
        )); ?>
        <?php
            echo $this->Form->input('email',array('class'=>'form-control'));
            echo $this->Form->input('password',array('class'=>'form-control'));     
        ?>
    <?= $this->Form->submit('Login',['type'=>'submit','class'=>'btn btn-success center-block','id'=>'btn-login'])?>
    <?= $this->Form->end() ?>
    </div>
</div>
