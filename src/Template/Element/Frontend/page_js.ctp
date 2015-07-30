    <!-- jQuery -->
    <?= $this->Html->script('/Common/js/jquery.js') ?>    

    <!--Login -->
    <?= $this->Html->script('/Frontend/js/login.js') ?>    

    <!-- Bootstrap Core JavaScript -->
    <?= $this->Html->script('/Common/js/bootstrap.min.js') ?>    

    <!-- Plugin JavaScript -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <?= $this->Html->script('/Frontend/js/classie.js') ?>    
    <?= $this->Html->script('/Frontend/js/cbpAnimatedHeader.js') ?>        

    <!-- Contact Form JavaScript -->
    <?= $this->Html->script('/Frontend/js/jqBootstrapValidation.js') ?>    

    <!-- Custom Theme JavaScript -->
    <?= $this->Html->script('/Frontend/js/freelancer.js') ?>    
    
    <?= $this->fetch('script') ?>