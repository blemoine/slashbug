<h2><?php echo __('All users') ?></h2>
<div class="content-area">

    <?php echo $this->Html->link(__('Add a user'), array('controller' => 'users',
                                                            'action' => 'add'), array('class' => 'button-green')); ?>

    <?php $this->Datatable->create('users-table', array('controller' => 'users',
                                                           'action' => 'listUsers')) ?>
    <div class="datatable-wrapper">
        <table id="users-table">
            <thead>
            <tr>
                <th><?php echo __('FirstName') ?></th>
                <th><?php echo __('LastName') ?></th>
                <th><?php echo __('UserName') ?></th>
                <th><?php echo __('Email') ?></th>
                <th><?php echo __('Usertype') ?></th>
            </tr>
            </thead>

            <tbody>
            </tbody>
        </table>
    </div>
</div>