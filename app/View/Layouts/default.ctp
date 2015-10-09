<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>
        
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $this->fetch('title'); ?></title>
        <?php echo $this->Html->meta('icon'); ?>
        
        <?php echo $this->Html->css('bootstrap.min'); ?>
        
        <?php echo $this->Html->css('ed'); ?>
        <?php echo $this->fetch('meta'); ?>
        <?php echo $this->fetch('css'); ?>
        <?php echo $this->fetch('script'); ?>
        
    </head>
    <body>
        <!-- navbar -->
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mynavbar-content">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">ED</a>
                </div>
                <div class="collapse navbar-collapse" id="mynavbar-content">
                    <ul class="nav navbar-nav">
<?php 
    if ($loggedIn === true) :
        echo $this->element("Navbar/navbar_for_user");
    else :
        echo $this->element("Navbar/navbar_for_guest");
    endif;
?>
                    </ul>
                </div>
            </div>
        </nav>
        
        <div id="content" class="container">
            <?php echo $this->Flash->render(); ?>
            <?php echo $this->fetch('content'); ?>
        </div>
        <footer class="footer">
            <div class="container">
                <p></p>
            </div>
        </footer>
        <?php // echo $this->element('sql_dump'); ?>
    
        <?php echo $this->Html->script('jquery-1.11.3.min'); ?>
        
        <?php echo $this->Html->script('bootstrap.min'); ?>
        
    </body>
</html>
