<?php

// directly access denied
defined('ABSPATH') || exit;
?>

<div class="wrap add-new-subscribe-form-parent">
    <div class="wsf-title">
        <h2>Add New Subscriber</h2>
        <a href="<?php echo admin_url( "admin.php?page={$this->parent_slug}" );?>">View Subscriber</a>
    </div>
    
    <form action="" class="wsf-add-new-subscriber-form">
        <div class="label-parent">
            <input type="email" placeholder="Enter Email Address">
            <button type="button" id="add_new_subscriber">Add New</button>
        </div>
    </form>
</div>