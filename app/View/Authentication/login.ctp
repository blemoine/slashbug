<h2><?php echo __('Login') ?></h2>
<div class="content-area">
    <?php echo $this->AForm->create('User'); ?>

    <fieldset>
        <legend><?php echo __('Please enter your username and password'); ?></legend>
        <br />
        <?php
        echo $this->AForm->input('username', array('label' => __('Username')));
        echo $this->AForm->input('password', array('label' => __('Password')));
        ?>
    </fieldset>

    <?php echo $this->AForm->end(__('Login')); ?>

</div>