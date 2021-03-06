<h2><?php echo __('Add a request on project %s', $this->Html->link($project['Project']['name'], array('controller' => 'requests',
                                                                                                      'action' => 'index',
                                                                                                      $project['Project']['id']))) ?></h2>
<div class="content-area">

    <?php

    echo $this->AForm->create('Request');
    echo $this->AForm->input('name', array('label' => __('Name:')));
    echo $this->AForm->textareaMce('description', array('label' => __('Description:')));
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

    echo $this->AForm->end(__('Create request'));
    ?>
</div>
