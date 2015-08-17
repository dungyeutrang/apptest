<!-- content -->
</div>
             <?= $this->fetch('content') ?>
</div>
<?= $this->Html->script('/Common/js/jquery.js') ?> 
<!-- jQuery UI -->
<?= $this->Html->script('/Manage/js/plugins/jquery-ui/jquery-ui.min.js') ?> 
<?= $this->fetch('scriptBottom',['block' => true]) ?>