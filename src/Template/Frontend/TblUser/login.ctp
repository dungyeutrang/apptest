<?=$this->HTML->css('/Frontend/css/login.css')?>
<div class="container">
<div class="row text-center">
    <h3><?= __('Login') ?></h3>
</div>
    <div class="row" id="form-login-user">
<div class="text-center"> 
    <p class="text-danger"><?php echo $this->Flash->render(); ?></p>
</div>
    <?= $this->Form->create(null,
         array('class'=>'form form-horizontal',      
        )); ?>
        <?php
            echo $this->Form->input('email',array('class'=>'form-control'));
            echo $this->Form->input('password',array('class'=>'form-control'));     
        ?>
    <?= $this->Form->submit('Login',['type'=>'submit','class'=>'btn btn-success'])?>
    <?= $this->Form->end() ?>
</div>
</div>
