<div class="row">
    <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Employee profile</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4">
<?php 
echo $this->Html->image(
        '/files/' . ($emp['Employee']['photo'] ? $emp['Employee']['photo'] : 'icon-profile.png'),
        array('alt' =>"Employee's picture", 'class' => array('img-responsive'))
    );
?>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-stripped">
                            <tr>
                                <th>Name</th>
                                <td><?php echo $emp['Employee']['name']; ?></td>
                            </tr>
                            <tr>
                                <th>Department</th>
                                <td><?php echo $emp['WorkingIn']['name']; ?></td>
                            <tr>
                                <th>Job Title</th>
                                <td><?php echo $emp['Employee']['job_title']; ?></td>
                            </tr>    
                            <tr>
                                <th>Cellphone</th>
                                <td><?php echo $emp['Employee']['cellphone']; ?></td>.
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?php echo $emp['Employee']['email']; ?></td>
                            </tr>
                        </table>
                        <?php echo $this->Html->link(
                                "Back", 
                                array('controller' => 'employees', 'action' => 'index'),
                                array('class' => array('btn', 'btn-info'))
                            ); 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
