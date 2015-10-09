                        <?php echo $curController == 'departments' ? '<li class="active">' : '<li>';?>
<?php echo $this->Html->link('Departments', array('controller' => 'departments', 'action' => 'index')); ?></li>
                        <?php echo $curController == 'employees' ? '<li class="active">' : '<li>';?>
<?php echo $this->Html->link('Employees', array('controller' => 'employees', 'action' => 'index')); ?></li>
