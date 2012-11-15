<h2><?php echo __('All projects') ?></h2>
<div class="content-area">




    <script type="text/javascript">
        $(document).ready(function () {

            instrumentAjaxDatatable('#projects-table', '<?php echo $this->Html->url(array('controller' => 'projects',
                                                                                           'action' => 'listProjects'));?>', [

            ]);

        });
    </script>

    <div class="datatable-wrapper">
        <table id="projects-table">
            <thead>
            <tr>
                <th><?php echo __('Project name') ?></th>
                <th><?php echo __('Date of creation') ?></th>
                <th><?php echo __('Requests in progress') ?></th>
                <th><?php echo __('Requests done') ?></th>
                <th><?php echo __('Total Requests') ?></th>
            </tr>
            </thead>

            <tbody>
            </tbody>
        </table>
    </div>
</div>