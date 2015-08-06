<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                        <?= $this->HTML->image('/Manage/img/layout/profile_small.jpg', array('class' => 'img-circle')) ?>
                    </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">David Williams</strong>
                            </span> <span class="text-muted text-xs block">Art Director <b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="profile.html">Profile</a></li>
                        <li><a href="contacts.html">Contacts</a></li>
                        <li><a href="mailbox.html">Mailbox</a></li>
                        <li class="divider"></li>
                       <li><?= $this->HTML->link('Log out', ['_name' => 'logout'])?></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
                    <li class="active"><?= $this->HTML->link('<i class="fa fa-th-large"></i><span class="nav-label">Wallet</span>', ['_name' => 'wallet'],array("escape"=>false)) ?></li> 
                    <li class=""><?= $this->HTML->link('<i class="fa fa-th-large"></i><span class="nav-label">Debt</span>', ['_name' => 'wallet'],array("escape"=>false)) ?></li>
                    <li class=""><?= $this->HTML->link('<i class="fa fa-th-large"></i><span class="nav-label">Event</span>', ['_name' => 'wallet'],array("escape"=>false)) ?></li> 
                    <li class=""><?= $this->HTML->link('<i class="fa fa-th-large"></i><span class="nav-label">Budget</span>', ['_name' => 'wallet'],array("escape"=>false)) ?></li>  
                    <li class=""><?= $this->HTML->link('<i class="fa fa-th-large"></i><span class="nav-label">Saving</span>', ['_name' => 'wallet'],array("escape"=>false)) ?></li>         
        </ul>
    </div>
</nav>