<?php

// directly access denied
defined('ABSPATH') || exit;
?>

<div class="wrap">
    <div class="wsf-title">
        <h2>Add New Subscriber</h2>
        <a href="<?php echo admin_url( "admin.php?page={$this->slug}" );?>">View Subscriber</a>
    </div>
    <div class="wsf-notice">
        Successfully add a new subscriber...
    </div>
    <form action="" class="wsf-add-new-subscriber-form">
        <div class="label-parent">
            <input type="email" placeholder="Enter Email Address">
            <button type="button" id="add_new_subscriber"><span class="wsf-ajax-loading"></span></button>
        </div>
    </form>
</div>