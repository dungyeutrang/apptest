<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Monney Lover</title>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css',$this->element('Frontend/header')) ?>
</head>
<body id="page-top" class="index">

    <!-- Navigation -->
       <?= $this->fetch('nav',$this->element('Frontend/nav')) ?> 

    <!-- Content -->
    <div class="row">
      <?= $this->fetch('content') ?>
    </div>

    <!-- Footer -->
    <?= $this->fetch('footer',$this->element('Frontend/footer')) ?>

    <!-- modal-->
   <?php if(!$user): ?>
   <?= $this->fetch('nav',$this->element('Frontend/login')) ?>
   <?php endif; ?>

   <!-- icon bottom to top -->
    <div class="scroll-top page-scroll visible-xs visible-sm visible-md visible-lg">
        <a class="btn btn-danger" href="#page-top">
            <i class="fa fa-chevron-up"></i>
        </a>
    </div>
    
    <!-- js -->
    <?= $this->fetch('script',$this->element('Frontend/page_js')) ?>
    <?= $this->fetch('scriptBottom') ?>

</body>
</html>