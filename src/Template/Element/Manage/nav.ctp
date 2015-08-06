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
          <?php if($wallet_id){?> 
                      <li class="active"><?= $this->HTML->link('<i class="fa fa-th-large"></i><span class="nav-label"></span>'.$wallet_name, ['_name' => 'transaction','wallet_id'=>$wallet_id],array("escape"=>false)) ?> 
                        <ul class="nav nav-second-level">                     
                             <li><?= $this->HTML->link('Update',['_name'=>'wallet_edit','wallet_id'=>$wallet_id]) ?></li>
                             <li><?= $this->HTML->link('Delete',['_name'=>'wallet_delete','wallet_id'=>$wallet_id]) ?></li>  
                        </ul>
                      </li>
        <li><?= $this->HTML->link('Transaction',['_name'=>'transaction','wallet_id'=>$wallet_id]) ?></li>
        <li><?= $this->HTML->link('Category',['_name'=>'category','wallet_id'=>$wallet_id]) ?></li>           
        <li><?= $this->HTML->link('Status',['_name'=>'wallet_expense','wallet_id'=>$wallet_id]) ?></li>           
          <?php }else{
                    foreach($listWallet as $w): ?>
                    <li><?= $this->HTML->link('<i class="fa fa-th-large"></i><span></span> &nbsp; '.$w->name ,['_name'=>'transaction','wallet_id'=>$w->id],array('escape'=>false)) ?></li>
                    <li class="divider"></li>
                <?php endforeach;?>      
          <?php }?>     
        </ul>
    </div>
</nav>