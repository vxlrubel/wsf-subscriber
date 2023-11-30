<?php

namespace Wsf\Inc\Admin;

// directly access denied
defined('ABSPATH') || exit;

class Ajax_Handler{

    // define add new subscriber action
    protected $add_action = 'add_new_subscriber';

    // define update action
    protected $update_action = 'subscribe_update';

    // define delete action
    protected $delete_action = 'delete_existing_subscriber';

    // defined refresh action
    protected $refresh_list_data = 'refresh_list_data';

    // custom table name
    private $table_name = 'email_subscribers';

    /**
     * Get subscriber table name
     *
     * @return void
     */
    private function get_table(){
        global $wpdb;
        $table = $wpdb->prefix . $this->table_name;
        return $table;
    }
    
    public function __construct(){

        // insert new subscriber
        add_action( "wp_ajax_{$this->add_action}", [ $this, 'add_new_subscriber'] );

        add_action( "wp_ajax_nopriv_{$this->add_action}", [ $this, 'add_new_subscriber'] );

        // update existing subscriber
        add_action( "wp_ajax_{$this->update_action}", [ $this, 'update_subscriber'] );

        // delete existing subscriber
        add_action( "wp_ajax_{$this->delete_action}", [ $this, 'delete_existing_subscriber'] );

        // refresh subscriber table list
        add_action( "wp_ajax_{$this->refresh_list_data}", [ $this, 'refresh_list_data'] );
    }

    /**
     * load subscriber table data
     *
     * @return void
     */
    public function refresh_list_data(){

        global $wpdb;
        $table = $this->get_table();
        $response = '';

        if( ! defined('DOING_AJAX') || ! DOING_AJAX ) return;

        $sql = "SELECT * FROM $table ORDER BY created_at DESC LIMIT 10";

        $rows = $wpdb->get_results( $sql );

        foreach ( $rows as $key => $row ){
            ob_start();
            ?>
            <tr data-item-id="<?php echo esc_attr( $row->id ); ?>">
                <td><?php echo esc_html( $key + 1 ); ?></td>
                <td class="lowercase subscriber-email"><?php echo esc_html( $row->email ); ?></td>
                <td class="create_time"><?php echo esc_html( $row->created_at ); ?></td>
                <td class="update_time"><?php echo esc_html( $row->updated_at ); ?></td>
                <td>
                    <a href="javascript:void(0)" data-edit-id="<?php echo esc_attr( $row->id ); ?>" class="wsf-item-edit">Edit</a>
                    <a href="javascript:void(0)" data-delete-id="<?php echo esc_attr( $row->id ); ?>" class="wsf-item-delete">Delete</a>
                </td>
            </tr>
            
            <?php
            $response .= ob_get_clean();
        }

        wp_send_json_success( $response );
    }

    /**
     * delete existing subscriber from database table
     *
     * @return void
     */
    public function delete_existing_subscriber(){
        
        global $wpdb;
        $table = $this->get_table();

        if( ! defined('DOING_AJAX') || ! DOING_AJAX ) return;

        if( empty( $_POST['id'] ) || $_POST['id'] == null ) {
            wp_send_json_error( 'something went wrong.' );
        }

        $where = [ 'id' => (int)$_POST['id'] ];
        
        $wpdb->delete( $table, $where );
        
        wp_send_json_success('delete successfully');
    }

    /**
     * update existing subscriber using their ID
     *
     * @return void
     */
    public function update_subscriber(){
        
        global $wpdb;
        $table = $this->get_table();
        
        if( ! defined('DOING_AJAX') || ! DOING_AJAX ) return;

        if( empty( $_POST['id'] ) || $_POST['id'] == null ) {
            wp_send_json_error( 'something went wrong.' );
        }

        if( empty( $_POST['email'] ) || $_POST['email'] == null ) {
            wp_send_json_error( 'Email is required' );
        }

        $id           = (int)$_POST['id'];
        $email        = sanitize_email( $_POST['email'] );
        $current_time = current_time( 'mysql' );

        $data = [
            'email'      => $email,
            'updated_at' => $current_time,
        ];

        $where = [
            'id' => $id
        ];

        $wpdb->update( $table, $data, $where );

        $response = [
            'id'          => $id,
            'email'       => $email,
            'update_time' => $current_time,
        ];
        
        wp_send_json_success( $response );
    }
    
    /**
     * Insert new subscriber into the database
     *
     * @return void
     */
    public function add_new_subscriber(){

        global $wpdb;
        $table = $this->get_table();

        if( ! defined('DOING_AJAX') || ! DOING_AJAX ) return;

        if( ! isset( $_POST['_wpnonce'] ) ) return;

        $email = sanitize_email( $_POST['email'] );

        if( empty( $email ) ){
            wp_send_json_error('Invalid Email or Empty');
        }

        $email_exists = $wpdb->get_var( $wpdb->prepare( "SELECT email FROM $table WHERE email = %s", $email ) );

        if( $email_exists ){
            wp_send_json_error('Email Alreay Exists');
        }

        $data = [ 'email' => $email ];

        // if email exit then return with error status

        $wpdb->insert( $table, $data );

        // notify to subscriber
        wp_mail( $email, 'New Subscribe', 'Thanks For Subscribe Our Newletter.' );

        wp_send_json_success( 'Add a new subscriber successfully.' );

    }

}