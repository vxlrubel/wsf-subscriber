(function($){
    const doc = $(document);
    const SUBSCRIBER_BUTTON = $('#add_new_subscriber');
    const SUBSCRIBER_FORM = $('.wsf-add-new-subscriber-form');
    const SUBSCRIBER_LIST_PARENT = $('.wsf-list-parent');
    class WPSUBSCRIBER_FORM{

        init(){
            this.openSubscriberPopupForm();
            this.removeUpdatedNotice();
            this.addNewSubscriberSubmitionForm();
            this.updateSubscriber();
            this.destroyPopupUpdateForm();
            this.deleteExistingSubscriber();
            this.refreshSubscriberList();
        }

        refreshSubscriberList(){
            SUBSCRIBER_LIST_PARENT.on('click', 'button.wsf-list-refresh', function(e){
                e.preventDefault();

                let data = {
                    action: 'refresh_list_data'
                }

                $.ajax({
                    type   : 'GET',
                    url    : ws.ajax_url,
                    data   : data,
                    success: (response) => {
                        SUBSCRIBER_LIST_PARENT.find('tbody').empty().html( response.data );
                        SUBSCRIBER_LIST_PARENT.find('span.wsf-loading').fadeOut( 300, ()=>{
                            SUBSCRIBER_LIST_PARENT.find('span.wsf-loading').remove();
                        } );
                        
                        $(this).removeAttr('disabled');
                    },
                    beforeSend: () => {
                        $(this).attr( 'disabled', 'disabled' );
                        $(this).after('<span class="wsf-loading"></span>');
                    }
                });
                
            });
        }

        deleteExistingSubscriber(){
            SUBSCRIBER_LIST_PARENT.on('click', 'a.wsf-item-delete', function(e){
                e.preventDefault();
                let id   = $(this).data('delete-id');
                let data = {
                    id    : id,
                    action: 'delete_existing_subscriber'
                }
                
                $.ajax({
                    type   : 'POST',
                    url    : ws.ajax_url,
                    data   : data,
                    success: ()=>{
                        let deleted_row = $(this).closest(`tr[data-item-id="${id}"]`);
                        deleted_row
                        .css( 'background-color', '#FC427B' )
                        .fadeOut( 300, ()=>{
                            deleted_row.remove();
                        } );
                    },
                    
                    beforeSend: ()=>{
                        $(this).text('loading...')
                    }
                });
            })
        }
        
        destroyPopupUpdateForm(){
            SUBSCRIBER_LIST_PARENT.on('click', 'div.wsf-overlay', function(e){
                e.preventDefault();

                let selfClass = $(this).attr('class');

                if( selfClass === e.target.className ){
                   $(this).fadeOut(300, ()=>{
                        $(this).remove();
                   });
                }
            });
        }

        update_subscriber(){
            let button = $('button.update-subscriber');
            let buttonText = button.text();
            let data = $('form#wsf-update-form').serialize();
            
            $.ajax({
                type   : 'POST',
                url    : ws.ajax_url,
                data   : data,
                success:  (response) => {
                    let wrapper = SUBSCRIBER_LIST_PARENT.find('[data-item-id="' + response.data.id + '"]');
                    button.text(buttonText);
                    
                    $('div.wsf-overlay').fadeOut(300, ()=>{
                        $('div.wsf-overlay').remove();
                    });

                    // update email
                    wrapper.find('td.subscriber-email').text( response.data.email );
                    
                    // update updated time
                    wrapper.find('td.update_time').text( response.data.update_time );
                    
                },
                beforeSend: ()=>{
                    button.text('loading...');
                }
            });
        }

        updateSubscriber(){
            SUBSCRIBER_LIST_PARENT.on('click', 'button.update-subscriber', (e)=>{
                e.preventDefault();
                this.update_subscriber();
            });
            
            SUBSCRIBER_LIST_PARENT.on('submit', 'form#wsf-update-form', (e)=>{
                e.preventDefault();
                this.update_subscriber();
            });
        }

        get_ajax_notice( message, cssClass = 'success' ){

            let html  = `<div class="wsf-notice ${cssClass}"><span>${message}</span><span class="wsf-notice-dismiss">&times;</span></div>`;

            return html;
        }

        insert_data_using_ajax_submition(){
            let data = SUBSCRIBER_FORM.serialize();
            let buttonText = SUBSCRIBER_BUTTON.text();

            $.ajax({
                type   : 'POST',
                url    : ws.ajax_url,
                data   : data,
                success: (response)=>{

                    // success status
                    if( response.success ){

                        SUBSCRIBER_FORM.before( this.get_ajax_notice( response.data ) );
                        
                        // reset email field
                        SUBSCRIBER_FORM.find('input[type="email"]').val('');
                    }

                    // error status
                    if(! response.success ){
                        SUBSCRIBER_FORM.before( this.get_ajax_notice( response.data, 'wsf-error' ) );
                    }
                    
                    SUBSCRIBER_BUTTON.empty().text(buttonText);
                },
                beforeSend: ()=>{
                    SUBSCRIBER_BUTTON.empty().html('<span class="wsf-ajax-loading"></span>')
                }
            });
        }
        
        addNewSubscriberSubmitionForm(){
            SUBSCRIBER_FORM.on('submit', (e)=>{
                e.preventDefault();
                this.insert_data_using_ajax_submition();
            });

            SUBSCRIBER_BUTTON.on('click', (e)=>{
                e.preventDefault();
                this.insert_data_using_ajax_submition();
            });
        }

        removeUpdatedNotice(){
            $('.add-new-subscribe-form-parent').on('click', 'span.wsf-notice-dismiss', function(e){
                let notice = $(this).closest('.wsf-notice');

                notice.fadeOut(300, ()=>{
                    notice.remove();
                });
            });
        }

        openSubscriberPopupForm(){
            SUBSCRIBER_LIST_PARENT.on( 'click', 'a.wsf-item-edit', function(e){
                e.preventDefault();

                let id = $(this).data('edit-id');
                let email = $(this).closest('tr').find('.subscriber-email').text();

                let html = `
                    <div class="wsf-overlay">
                        <form class="edit-form" id="wsf-update-form" method="POST">
                            <input type="email" name="email" value="${email}">
                            <input type="hidden" name="id" value="${id}">
                            <input type="hidden" name="action" value="subscribe_update">
                            <button type="button" class="update-subscriber">Update</button>
                        </form>
                    </div>
                `;

                SUBSCRIBER_LIST_PARENT.prepend( html );
            } );
        }
        
    }

    const WSF = new WPSUBSCRIBER_FORM;

    // run the program.
    doc.ready(()=>{ WSF.init() });

})(jQuery);