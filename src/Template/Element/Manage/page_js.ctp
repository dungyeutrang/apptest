<!-- Mainly scripts -->
    <?= $this->Html->script('/Common/js/jquery.js') ?> 
    <?= $this->Html->script('/Common/js/bootstrap.min.js') ?> 
    <?= $this->Html->script('/Manage/js/plugins/metisMenu/jquery.metisMenu.js') ?>    
    <?= $this->Html->script('/Manage/js/plugins/slimscroll/jquery.slimscroll.min.js') ?> 
<!-- Custom and plugin javascript -->
    <?= $this->Html->script('/Manage/js/home/inspinia.js') ?>    
    <?= $this->Html->script('/Manage/js/plugins/pace/pace.min.js') ?> 
<!-- jQuery UI -->
    <?= $this->Html->script('/Manage/js/plugins/jquery-ui/jquery-ui.min.js') ?> 
<!-- Toastr -->
      <?= $this->Html->script('/Manage/js/plugins/toastr/toastr.min.js') ?> 
    <?= $this->fetch('script') ?>