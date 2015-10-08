<h3>Employee profile</h3>

<?php 
echo $this->Html->image(
        '/files/' . ($emp['Employee']['photo'] ? $emp['Employee']['photo'] : 'icon-profile.png'),
        array('alt' =>"Employee's picture", 'class' => array('img-responsive'))
    );
?>
<br>
<div class="table-responsive">
    <table class="table table-stripped">
        <tr>
            <th>Name</th>
            <th>Department</th>
            <th>Job Title</th>
            <th>Cellphone</th>
            <th>Email</th>
        </tr>
        <tr>
            <td><?php echo $emp['Employee']['name']; ?></td>
            <td><?php echo $emp['WorkingIn']['name']; ?></td>
            <td><?php echo $emp['Employee']['job_title']; ?></td>
            <td><?php echo $emp['Employee']['cellphone']; ?></td>
            <td><?php echo $emp['Employee']['email']; ?></td>
        </tr>
    </table>
</div>
<?php echo $this->Html->link("Back", array('controller' => 'employees', 'action' => 'index')); ?>
