<h3>Change password</h3>
<p>
Remember : <br>
You have to change pass right after first login. <br>
And you should not use the password we provided via mail, ever again.
</p>

<?php
echo $this->Form->create('User');
echo $this->Form->input('cur_password', array('label' => 'Current Password', 'type' => 'password'));
echo $this->Form->input('password');
echo $this->Form->input('confirm', array('type' => 'password'));
echo $this->Form->end('Change');
?>
