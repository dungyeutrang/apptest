<div class="row border-bottom">
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                    <i class="fa fa-user"></i> Hi! <?= $user['first_name']. $user['last_name'] ?>
                </a>
                 <ul class="dropdown-menu dropdown-alerts">
                        <li><?= $this->HTML->link('Profile',['_name'=>'update_profile']) ?></li>
                        <li><a href="contacts.html">Contacts</a></li>
                        <li><a href="mailbox.html">Mailbox</a></li>
                        <li class="divider"></li>
                       <li><?= $this->HTML->link('Log out', ['_name' => 'logout'])?></li> 
                </ul> 
            </li> 
        </ul>
    </nav>
</div>