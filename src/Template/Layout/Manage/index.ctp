<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manage your expense</title>
        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css',$this->element('Manage/header')) ?>
        <?= $this->fetch('css_header') ?>
    </head>
    <body>
        <div id="wrapper">      
            <!-- nav bar  -->
            <?= $this->fetch('sidebar',$this->element('Manage/nav')) ?>

            <div id="page-wrapper" class="gray-bg dashbard-1">

            <!-- top bar   -->
            <?= $this->fetch('sidebar',$this->element('Manage/top')) ?>

            <!-- content -->
             <?= $this->fetch('content') ?>
            </div>
        </div>
        <!-- js -->
    <?= $this->fetch('script',$this->element('Manage/page_js')) ?>
    <?= $this->fetch('scriptBottom',['block' => true]) ?>
    </body>
</html>
