<?=$this->HTML->css('/Frontend/css/resetpassword.css') ?>
<div class="container">
<div class="row">
    <p class="text-center"> Please Enter your email !</p>
    <form class="form form-horizontal">
        <div class="form-group">
            <label class="control-label col-sm-2"> Email </label>
            <div class="col-sm-10">
                <input type="email" class="form-control" name="email" required data-validation-required-message="Please enter your email." />
                     <p class="help-block text-danger"></p>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-1 col-sm-offset-2">
                <input type="submit" name="Reset" class="btn btn-primary" />
            </div>
        </div>
    </form>
</div>
</div>

