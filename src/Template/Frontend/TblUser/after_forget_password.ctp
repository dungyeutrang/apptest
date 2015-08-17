<?=$this->HTML->css('/Frontend/css/style_after_send_mail_reset')?>
<div class="container" id="content">
<div class="row text-center">
     <?= $this->HTML->image('/Frontend/img/icon-mail.svg',array('class'=>'img-responsive center-block')); ?>
    <p id="message"><i>Check your inbox!</i><p>
</div>
    <div class="row" id="form-login-user">
<div class="text-center">
    <p id="notice">We've sent an email to </br> <b><?php echo $email ?></b> with instructions to <br/> reset your password.</p>
</div>
   <a href="<?= $this->Url->build('/login') ?>"><button id="back-login" class="btn btn-danger center-block"><b>GO BACK TO LOGIN</b></button></a>
</div>
</div>