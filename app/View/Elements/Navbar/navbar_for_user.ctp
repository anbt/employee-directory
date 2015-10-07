<?php echo $this->element('Navbar/navbar_shared'); ?>
&nbsp;
<?php echo $this->Html->link("Logout", array('controller' => 'users', 'action' => 'logout')); ?>
&nbsp;
<?php echo $this->Html->link("Add user", array('controller' => 'users', 'action' => 'add')); ?>
&nbsp;
<?php echo $this->Html->link("Change password", array('controller' => 'users', 'action' => 'changePass')); ?>
