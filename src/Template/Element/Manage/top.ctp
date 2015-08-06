<div class="row border-bottom">
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <form role="search" class="navbar-form-custom" method="post" action="search_results.html">
                <div class="form-group">
                    <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                </div>
            </form>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <span class="m-r-sm text-muted welcome-message">Welcome to INSPINIA+ Admin Theme.</span>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                    <i class="fa fa-envelope"></i>  <span class="label label-warning">16</span>
                </a>
                <ul class="dropdown-menu dropdown-messages">
                    <li>
                        <div class="dropdown-messages-box">
                            <a href="profile.html" class="pull-left">
                                <?= $this->HTML->image('/Manage/img/layout/a7.jpg', array('class' => 'img-circle')) ?>
                            </a>
                            <div class="media-body">
                                <small class="pull-right">46h ago</small>
                                <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                            </div>
                        </div>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <div class="dropdown-messages-box">
                            <a href="profile.html" class="pull-left">
                                <?= $this->HTML->image('/Manage/img/layout/a4.jpg', array('class' => 'img-circle')) ?>
                            </a>
                            <div class="media-body ">
                                <small class="pull-right text-navy">5h ago</small>
                                <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                            </div>
                        </div>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <div class="dropdown-messages-box">
                            <a href="profile.html" class="pull-left">
                                <?= $this->HTML->image('/Manage/img/layout/profile.jpg', array('class' => 'img-circle')) ?>
                            </a>
                            <div class="media-body ">
                                <small class="pull-right">23h ago</small>
                                <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                            </div>
                        </div>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <div class="text-center link-block">
                            <a href="mailbox.html">
                                <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                            </a>
                        </div>
                    </li>
                </ul>
            </li>
            
           <li class="dropdown">
             <?php
               if($wallet_id){ ?>
                 <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                  <?= $wallet_name ?></span>
                </a>       
               <?php }else{ ?>
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                    <i class="fa fa-google-wallet"></i> <span class="label label-primary" ></span>
               <?php } ?>                  
                <ul class="dropdown-menu dropdown-alerts">

               <?php
               if($wallet_id){
             foreach($listWallet as $w): ?>
             <?php if($w->id != $wallet_id): ?>
                   <li><?= $this->HTML->link('<i class="fa fa-th-large"></i><span></span> &nbsp; '.$w->name ,['_name'=>'transaction','wallet_id'=>$w->id],array('escape'=>false)) ?></li>
                    <li class="divider"></li>
               <?php endif; ?>
              <?php endforeach; ?>
                <?php }else{
                    foreach($listWallet as $w): ?>
                    <li><?= $this->HTML->link('<i class="fa fa-th-large"></i><span></span> &nbsp; '.$w->name ,['_name'=>'transaction','wallet_id'=>$w->id],array('escape'=>false)) ?></li>
                    <li class="divider"></li>
                <?php endforeach;?>
                <?php } ?>
                    <li><?= $this->HTML->link('<i class="fa fa-plus"></i><span></span>&nbsp; Add new wallet',['_name'=>'wallet_add'],array('escape'=>false)) ?></li>
                </ul>
            </li>
            <li>
            </li>          
        </ul>
    </nav>
</div>