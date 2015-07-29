<?=$this->HTML->css('/Frontend/css/register.css')?>
<div class="container">
<div class="row text-center">
    <h3><?= __('Reset Password') ?></h3>
</div>
<div class="row" id="form-register">
<div class="row">
    <?php echo $this->Flash->render(); ?>
</div>
    <?= $this->Form->create(null,
         array('class'=>'form form-horizontal',      
        )); ?>
        <?php
            echo $this->Form->input('email',array('class'=>'form-control'));   
        ?>
    <?= $this->Form->submit('Reset',['type'=>'submit','class'=>'btn btn-success'])?>
    <?= $this->Form->end() ?>
</div>
</div>