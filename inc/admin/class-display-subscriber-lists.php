<?php

namespace Wsf\Inc\Admin;

// directly access denied
defined('ABSPATH') || exit;

class Display_Subscriber_Lists{

    public function __construct( $add_new_subscriber_url = '' ){
        $this->show_subscriber( $add_new_subscriber_url );
    }

    /**
     * table list before html element
     *
     * @return void
     */
    private function list_table_start_before(){
        echo '<div class="wrap wsf-list-parent">';
    }
    
    /**
     * table list after html elements
     *
     * @return void
     */
    private function list_table_start_after(){
        echo '</div>';
    }

    /**
     * start the table section
     *
     * @return void
     */
    private function list_table_start(){
        echo '<table class="wp-list-table widefat fixed striped">';
    }

    /**
     * end the table section
     *
     * @return void
     */
    private function list_table_end(){
        echo '</table>';
    }

    /**
     * before the table section title and link
     *
     * @param [type] $add_new_subscriber_url
     * @return void
     */
    private function section_header( $add_new_subscriber_url ){

        $slug = sprintf( 'admin.php?page=%s', $add_new_subscriber_url );

        printf(
            '<div class="wsf-title"><h2>Subscriber List</h2><a href="%s">%s</a></div>',
            esc_url( admin_url( $slug ) ),
            esc_html('Add New')
        );
    }

    /**
     * define table header and footer heading
     *
     * @param string $tag_name
     * @return void
     */
    private function table_column_name( $tag_name = 'thead' ){
        printf(
            '<%s><tr><th width="50px">%s</th><th>%s</th><th>%s</th><th>%s</th><th>%s</th></tr></%s>',
            $tag_name,
            esc_html( 'Serial' ),
            esc_html( 'Email Address' ),
            esc_html( 'Created Date' ),
            esc_html( 'Updated Date' ),
            esc_html( 'Action' ),
            $tag_name
        );
    }

    /**
     * define the table body. here is retrive the all subscribers
     *
     * @return void
     */
    private function table_body(){

        global $wpdb;
        
        $serial = 1;

        $table = $wpdb->prefix . 'email_subscribers';

        $sql = "SELECT * FROM $table ORDER BY created_at DESC LIMIT 10";

        $rows = $wpdb->get_results( $sql );

        echo '<tbody>';

        foreach ( $rows as $key => $row ){ ?>
            <tr data-item-id="<?php echo esc_attr( $row->id ); ?>">
                <td><?php echo esc_html( $key + 1 ); ?></td>
                <td class="lowercase subscriber-email"><?php echo esc_html( $row->email ); ?></td>
                <td><?php echo esc_html( $row->created_at ); ?></td>
                <td><?php echo esc_html( $row->updated_at ); ?></td>
                <td>
                    <a href="javascript:void(0)" data-edit-id="<?php echo esc_attr( $row->id ); ?>" class="wsf-item-edit">Edit</a>
                    <a href="javascript:void(0)" data-delete-id="<?php echo esc_attr( $row->id ); ?>" class="wsf-item-delete">Delete</a>
                </td>
            </tr>
        <?php }
        echo '</tbody>';
    }


    protected function show_subscriber( $add_new_subscriber_url ){

        $this->list_table_start_before();
        $this->section_header( $add_new_subscriber_url );
        $this->list_table_start();
        $this->table_column_name();
        $this->table_body();
        $this->table_column_name('tfoot');
        $this->list_table_end();
        $this->list_table_start_after();
    }
}