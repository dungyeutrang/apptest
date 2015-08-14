<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                        <?= $this->HTML->image('/Manage/img/layout/wallet.jpg', array('class' => 'img-circle img-responsive', 'id' => 'icon_wallet')) ?>
                    </span>
                    <?php if ($wallet_id) { ?>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?= $wallet_name."&nbsp | <b>".$this->Number->format($wallet_amount)."</b>" ?></strong>&nbsp <b class="caret"></b></span></span> </a>
                    <?php } else { ?>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">All Wallet</strong><b class="caret"></b></span></span>
                       </a>
                        <?php } ?> 
                        <ul class="dropdown-menu dropdown-alerts">
                            <?php if ($wallet_id) {
                              foreach ($listWallet as $w):
                                  if($wallet_id!=$w->id){
                                    ?>
                                    <li><?= $this->HTML->link('<i class="fa fa-th-large"></i><span></span> &nbsp; ' . $w->name."&nbsp | <b>".$this->Number->format($w->amount)."</b>", ['_name' => 'transaction', 'wallet_id' => $w->id], array('escape' => false)) ?></li>
                                    <li class="divider"></li>
                                <?php } endforeach; ?> 
                            <?php } else {
                                foreach ($listWallet as $w):
                                    ?>
                                    <li><?= $this->HTML->link('<i class="fa fa-th-large"></i><span></span> &nbsp; ' . $w->name."&nbsp | <b>".$this->Number->format($w->amount)."</b>", ['_name' => 'transaction', 'wallet_id' => $w->id], array('escape' => false)) ?></li>
                                    <li class="divider"></li>
                                <?php endforeach; ?>
                            <?php } ?>
                            <li><?= $this->HTML->link('<i class="fa fa-plus"></i><span></span>&nbsp; Add new wallet', ['_name' => 'wallet_add'], array('escape' => false)) ?></li>
                        </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            <?php if ($wallet_id) { ?> 
                <li class="active"><?= $this->HTML->link('<i class="fa fa-list"></i><span class="nav-label">Transaction</span>', ['_name' => 'transaction', 'wallet_id' => $wallet_id], array("escape" => false)) ?></li>
                <li><?= $this->HTML->link('<i class="fa fa-list"></i><span class="nav-label">Category</span>', ['_name' => 'category', 'wallet_id' => $wallet_id], array("escape" => false)) ?></li>           
                <li><?= $this->HTML->link('<i class="fa fa-list"></i><span class="nav-label">Status</span>', ['_name' => 'wallet_expense', 'wallet_id' => $wallet_id], array("escape" => false)) ?></li>           
                <li><?= $this->HTML->link('<i class="fa fa-list"></i><span class="nav-label">Report Monthly</span>', ['_name' => 'report_monthly', 'wallet_id' => $wallet_id], array("escape" => false)) ?></li>
                <li>
                <a href="#"><i class="fa fa-refresh"></i> <span class="nav-label">Perform</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse" style="height: 0px;">
                      <li><?= $this->HTML->link('<i class="fa fa-edit"></i>Transfer Money', ['_name' => 'wallet_transfer', 'wallet_id' => $wallet_id], array("escape" => false)) ?></li>
                      <li><?= $this->HTML->link('<i class="fa fa-edit"></i>Edit', ['_name' => 'wallet_edit', 'wallet_id' => $wallet_id], array("escape" => false)) ?></li>
                      <li><?= $this->HTML->link('<i class="fa fa-remove"></i>Delete', ['_name' => 'wallet_delete', 'wallet_id' => $wallet_id], array("escape" => false)) ?></li>  
                      <li class="divider"></li>   
                </ul>
               </li>
            <?php }?>
        </ul>
    </div>
</nav>