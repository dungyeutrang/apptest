<nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo $this->Url->build('/', true); ?>">Monney Lover</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-left">
                  <?php if($this->request->url){?>
                    <li class="hidden">
                        <a href="<?= $this->Url->build('/') ?>#page-top"></a>
                    </li>
                    <li class="page-scroll">
                        <a href="<?= $this->Url->build('/') ?>#portfolio">Home</a>
                    </li>
                    <li class="page-scroll">
                        <a href="<?= $this->Url->build('/')?>#about">About</a>
                    </li>
                    <li class="page-scroll">
                        <a href="<?= $this->Url->build('/')?>#contact">Contact</a>
                    </li>
                   <?php }else{ ?>
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li class="page-scroll">
                        <a href="#portfolio">Home</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#about">About</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#contact">Contact</a>
                    </li>
                   <?php }?>
                </ul>
            <ul class="nav navbar-nav navbar-right">
            <?php if(!$user){ ?>
                <li><a href="#" data-toggle="modal" data-target="#myModal">Login</a></li>
             <?php }else{ ?>
                <li class="dropdown"><a href="#"  class="dropdown-toggle" data-toggle="dropdown" role="button">Hi!&nbsp;<?php echo $user['last_name'].$user['first_name'] ?> <span class="caret"></a>
                   <ul class="dropdown-menu">
                   <li><?= $walletDefault?$this->HTML->link('Manage',['_name'=>'transaction','wallet_id'=>$walletDefault]):$this->HTML->link('Manage',['_name'=>'wallet_add']) ?></li>
                   <li><?= $this->HTML->link('Update Profile',['_name'=>'update_profile']) ?></li>
                   <li><?= $this->HTML->link('Change Password',['_name'=>'change_password']) ?></li>
                   <li><a href="<?php echo $this->Url->build('/logout',true) ?>">Logout</a></li>
                 </ul>
                </li>
            <?php } ?>
            </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
