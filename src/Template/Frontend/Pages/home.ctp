<header>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">                    
                    <?= $this->Html->image('/Frontend/img/logo.png',array('class'=>'img-responsive')); ?>
                <div class="intro-text">
                    <span class="name">Monney Lover</span>
                    <hr class="star-light">
                    <span class="skills">Easy - Effective - Friendly</span>
                </div>
            </div>
        </div>
    </div>
</header>


<!-- Portfolio Grid Section -->
<section id="portfolio">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>Features</h2>
                <hr class="star-primary">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 portfolio-item">
                <a href="#portfolioModal1" class="portfolio-link" data-toggle="modal">
                    <div class="caption">
                        <div class="caption-content">
                            <i class="fa fa-search-plus fa-3x"></i>
                        </div>
                    </div>
                    <?= $this->Html->image('/Frontend/img/portfolio/money.png',array('class'=>'img-responsive')); ?>
                </a>
            </div>

            <div class="col-sm-4 portfolio-item">
                <a href="#portfolioModal5" class="portfolio-link" data-toggle="modal">
                    <div class="caption">
                        <div class="caption-content">
                            <i class="fa fa-search-plus fa-3x"></i>
                        </div>
                    </div>
                    <?= $this->Html->image('/Frontend/img/portfolio/security.png',array('class'=>'img-responsive')); ?></a>
            </div>
            <div class="col-sm-4 portfolio-item">
                <a href="#portfolioModal3" class="portfolio-link" data-toggle="modal">
                    <div class="caption">
                        <div class="caption-content">
                            <i class="fa fa-search-plus fa-3x"></i>
                        </div>
                    </div>
                    <?= $this->Html->image('/Frontend/img/portfolio/multiaccount.png',array('class'=>'img-responsive')); ?>
                </a>
            </div>             
            <div class="col-sm-4 portfolio-item">
                <a href="#portfolioModal2" class="portfolio-link" data-toggle="modal">
                    <div class="caption">
                        <div class="caption-content">
                            <i class="fa fa-search-plus fa-3x"></i>
                        </div>
                    </div>
                    <?= $this->Html->image('/Frontend/img/portfolio/synchronize.png',array('class'=>'img-responsive')); ?>
                </a>
            </div>

            <div class="col-sm-4 portfolio-item">
                <a href="#portfolioModal6" class="portfolio-link" data-toggle="modal">
                    <div class="caption">
                        <div class="caption-content">
                            <i class="fa fa-search-plus fa-3x"></i>
                        </div>
                    </div>
                    <?= $this->Html->image('/Frontend/img/portfolio/backup.png',array('class'=>'img-responsive')); ?>
                </a>
            </div>
            <div class="col-sm-4 portfolio-item">
                <a href="#portfolioModal4" class="portfolio-link" data-toggle="modal">
                    <div class="caption">
                        <div class="caption-content">
                            <i class="fa fa-search-plus fa-3x"></i>
                        </div>
                    </div>
                    <?= $this->Html->image('/Frontend/img/portfolio/language.png',array('class'=>'img-responsive')); ?>
                </a>
            </div>             
        </div>
    </div>
</section>

<!-- About Section -->
<section class="success" id="about">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>About</h2>
                <hr class="star-light">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-lg-offset-2">
                <p>Money Lover app is a finances and expenses manager for individuals. It allows you to track your expenses over time and manage your monthly or annual budget. So throughout the day, you could pull out Money Lover after making a purchase and log it into the app</p>
            </div>
            <div class="col-lg-4">
                <p>A powerful tool to track your personal finance: incomes, expenses, debts, and savings and  Lollipop with Material Design update released. You will experience the newest tech with Money Lover, as well as changes </p>
            </div>
            <div class="col-lg-8 col-lg-offset-2 text-center">
                <a href="https://play.google.com/store/apps/details?id=com.bookmark.money&hl=en" class="btn btn-lg btn-outline">
                    <i class="fa fa-newspaper-o"></i> Visit Money Lover
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
 <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Contact Me</h2>
                    <hr class="star-primary">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <!-- To configure the contact form email address, go to mail/contact_me.php and update the email address in the PHP file on line 19. -->
                    <!-- The form should work on most web servers, but if the form is not working you may need to configure your web server differently. -->
                    <form name="sentMessage" id="contactForm" novalidate>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>Name</label>
                                <input type="text" class="form-control" placeholder="Name" id="name" required data-validation-required-message="Please enter your name.">
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>Email Address</label>
                                <input type="email" class="form-control" placeholder="Email Address" id="email" required data-validation-required-message="Please enter your email address.">
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>Phone Number</label>
                                <input type="tel" class="form-control" placeholder="Phone Number" id="phone" required data-validation-required-message="Please enter your phone number.">
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>Message</label>
                                <textarea rows="5" class="form-control" placeholder="Message" id="message" required data-validation-required-message="Please enter a message."></textarea>
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <br>
                        <div id="success"></div>
                        <div class="row">
                            <div class="form-group col-xs-12">
                                <button type="submit" class="btn btn-success btn-lg">Send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php
    $this->start('feature')?>
    <?= $this->element('Frontend/feature'); ?>
    <?php $this->end();
     ?>
    <!-- feature Modals -->
    <?= $this->fetch('feature') ?>   

