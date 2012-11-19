<h2><?php echo __('All requests for project %s', $project['Project']['name']) ?></h2>
<div class="content-area">

    <?php echo $this->Html->link(__('Add a request'), array('controller' => 'requests',
                                                            'action' => 'add'), array('class' => 'button-green')); ?>

    <?php $this->Datatable->create('requests-table', array('controller' => 'requests',
                                                           'action' => 'listRequests',
                                                           $project['Project']['id'])) ?>

    <div class="datatable-wrapper">
        <table id="requests-table">
            <thead>
            <tr>
                <th><?php echo __('Request name') ?></th>
                <th><?php echo __('Type') ?></th>
                <th><?php echo __('Created by') ?></th>
                <th><?php echo __('Date of creation') ?></th>
                <th><?php echo __('Assigned to') ?></th>
                <th><?php echo __('Status') ?></th>
            </tr>
            </thead>

            <tbody>
            </tbody>
        </table>
    </div>
</div>