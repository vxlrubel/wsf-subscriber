<?php

// directly access denied
defined('ABSPATH') || exit;
?>

<div class="wrap wsf-list-parent">
    <div class="wsf-title">
        <h2>Subscriber List</h2>
        <a href="<?php echo admin_url( "admin.php?page={$this->add_new_slug}" );?>">Add New</a>
    </div>

    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th width="50px">Serial</th>
                <th>Email Address</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
            
        </thead>

        <tbody>
            <tr data-item-id="1">
                <td>1</td>
                <td class="lowercase">example@gmail.com</td>
                <td>23 dec 2023</td>
                <td>24 dec 2023</td>
                <td>
                    <a href="javascript:void(0)" data-edit-id="1" class="wsf-item-edit">Edit</a>
                    <a href="javascript:void(0)" data-delete-id="1" class="wsf-item-delete">Delete</a>
                </td>
            </tr>
            <tr data-item-id="2">
                <td>2</td>
                <td class="lowercase">hellotest@gmail.com</td>
                <td>23 dec 2023</td>
                <td>24 dec 2023</td>
                <td>
                    <a href="javascript:void(0)" data-edit-id="2" class="wsf-item-edit">Edit</a>
                    <a href="javascript:void(0)" data-delete-id="2" class="wsf-item-delete">Delete</a>
                </td>
            </tr>
        </tbody>
        
        <tfoot>
           <tr>
               <th>Serial</th>
               <th>Email Address</th>
                <th>Created At</th>
                <th>Updated At</th>
               <th>Action</th>
           </tr>
        </tfoot>
    </table>
</div>