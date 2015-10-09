<?php echo $this->element('Navbar/navbar_shared'); ?>
                        
<?php echo $curController == 'users' && $curAction == 'login' ? '<li class="active">' : '<li>';?>
<?php echo $this->Html->link('Log in', array('controller' => 'users', 'action' => 'login')); ?></li>
