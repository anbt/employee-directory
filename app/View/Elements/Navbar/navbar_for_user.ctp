<?php echo $this->element('Navbar/navbar_shared'); ?>
                        <?php echo $curController == 'users' && $curAction == 'add' ? '<li class="active">' : '<li>';?>
<?php echo $this->Html->link('Add user', array('controller' => 'users', 'action' => 'add')); ?></li>
                        <?php echo $curController == 'users' && $curAction == 'changePass' ? '<li class="active">' : '<li>';?>
<?php echo $this->Html->link('Change password', array('controller' => 'users', 'action' => 'changePass')); ?></li>
                        <li><?php echo $this->Html->link('Log out', array('controller' => 'users', 'action' => 'logout')); ?></li>
