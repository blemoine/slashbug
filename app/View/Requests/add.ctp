<h2><?php echo __('Add a request') ?></h2>
<div class="content-area">

    <?php

    echo $this->AForm->create('Request');
    echo $this->AForm->input('name', array('label' => __('Name:')));
    echo $this->AForm->textareaMce('description', array('label' => __('Description:')));
    echo $this->AForm->input('created_by', array('label' => __('Created by:'),
                                                 'options' => $users));
    echo $this->AForm->input('project_id', array('Project:'));
    echo $this->AForm->input('type', array('options' => $types,
                                           'label' => 'Type:'));
    echo $this->AForm->input('priority', array('options' => $priorities,
                                               'label' => 'Priority:'));
    echo $this->AForm->input('status', array('options' => $status,
                                             'label' => 'Status:'));
    echo $this->AForm->input('minute_spent', array('label' => 'Minute spent:',
                                                    'type' => 'number'));
    echo $this->AForm->input('assigned_to', array('label' => __('Assigned to:'),
                                                  'empty' => __('None'),
                                                  'type' => 'select',
                                                  'options' => $users));

    echo $this->AForm->endFormGrey(__('Create request'));
    ?>
</div>
