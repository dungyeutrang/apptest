<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h2 class="text-center"><img src="//placehold.it/110" class="img-circle"><br>Login</h2>
            </div>
            <p id="error_message_login" class="message"></p>
            <div class="modal-body row">
                <h6 class="text-center">COMPLETE THESE FIELDS TO SIGN UP</h6>
                 <?php echo  $this->Form->create(null,[ 'url' =>'/loginHome','class'=>'col-md-10 col-md-offset-1 col-xs-12 col-xs-offset-0','id'=>'form-login']) ?>
                    <div class="form-group">
                        <input id="email" required type="email" class="form-control input-lg" placeholder="Email">                        
                    </div>
                    <div class="form-group">
                        <input id="password"  required type="password" class="form-control input-lg" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-danger btn-lg btn-block">Sign In</button>
                        <span class="pull-right"><a href="<?= $this->Url->build('/register', true); ?>">Register</a></span><span><a href="<?= $this->Url->build('/forgetpassword',true) ?>">Forgot Password ?</a></span>
                    </div>
                <?php $this->Form->end() ?>
            </div>
            <div class="modal-footer">
                <h6 class="text-center"><a href="">Privacy is important to us. Click here to read why.</a></h6>
            </div>
        </div>
    </div>
</div>