<?php

namespace Wsf\Inc\Admin;

// oirectly access denied
defined('ABSPATH') || exit;

class Subscribe_Form{
    
    public function __construct( $list_url = '' ){
        $this->add_new_form( $list_url );
    }

    /**
     * add new subscriber using this form
     *
     * @param [type] $list_url
     * @return void
     */
    public function add_new_form( $list_url ){
        ?>
            <div class="wrap add-new-subscribe-form-parent">
                
                <div class="wsf-title">
                    <h2>Add New Subscriber</h2>
                    <a href="<?php echo esc_url( admin_url( "admin.php?page={$list_url}" ) );?>">View Subscriber</a>
                </div>

                <form action="" class="wsf-add-new-subscriber-form">
                    <div class="label-parent">
                        <input type="email" placeholder="Enter Email Address" name="email">
                        <input type="hidden" name="action" value="add_new_subscriber">
                        <?php wp_nonce_field( 'add_new_subscriber' ); ?>
                        <button type="button" id="add_new_subscriber">Add New</button>
                    </div>
                </form>
                
            </div>
        <?php
    }
}