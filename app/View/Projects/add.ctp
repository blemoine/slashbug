<h2><?php echo __('Add a project') ?></h2>
<div class="content-area">


    <?php
    echo $this->AForm->create('Project');
    echo $this->AForm->input('Project.name', array('label' => __('Project name:')));
    echo $this->AForm->textareaMce('Project.description', array('label'=> __('Description:')));
    echo $this->AForm->end(__('Insert project'));
    ?>
</div>
