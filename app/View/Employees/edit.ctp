<h3>Edit Employee</h3>

<?php
echo $this->Form->create('Employee', array('type' => 'file'));
echo $this->Form->input('name', array('label' => 'Employee Name'));
echo $this->Form->label('department_id', 'Department');
echo $this->Form->select('department_id', $departments);
echo $this->Form->input('job_title');
echo $this->Form->input('cellphone');
echo $this->Form->input('email');
echo $this->Html->image(
        '/files/' . ($imageName ? $imageName : 'icon-profile.png'),
        array('alt' => "Employee's picture", 'class' => array('img-responsive'))
    );
echo $this->Form->input('photo', array('type' => 'file', 'label' => false, 'required' => false));
echo $this->Form->end('Edit');
?>
