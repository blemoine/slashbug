<h2><?php echo __('Add a user') ?></h2>
<div class="content-area">
    <?php
    echo $this->AForm->create('User');
    echo $this->AForm->input('firstname', array('label' => __('Firstname:')));
    echo $this->AForm->input('lastname', array('label' => __('Lastname:')));
    echo $this->AForm->input('username', array('label' => __('Username:')));
    echo $this->AForm->input('password', array('label' => __('Password:')));
    echo $this->AForm->input('email', array('label' => __('Email:')));
    echo $this->AForm->input('usertype', array('label' => __('Usertype:')));

    echo $this->AForm->end(__('Create user'));
    ?>
</div>
