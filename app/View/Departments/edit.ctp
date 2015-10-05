<h3>Edit Department</h3>

<?php
echo $this->Form->create('Department');
echo $this->Form->input('name');
echo $this->Form->input('office_phone');
echo $this->Form->label('manager_id', 'Manager');
echo $this->Form->select('manager_id', $managers);
echo $this->Form->end('Add');
?>
