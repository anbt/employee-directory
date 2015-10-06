<h3>Add user</h3>

<?php
echo $this->Form->create('User');
echo $this->Form->input('username');
echo $this->Form->input('email');
echo $this->Form->end('Add');
?>
