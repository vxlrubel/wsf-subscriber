;(function($){
    const doc = $(document);
    const SUBSCRIBER_BUTTON = $('#add_new_subscriber');
    const SUBSCRIBER_FORM = $('.wsf-add-new-subscriber-form');

    class ADD_NEW_SUBSCRIBER{
        
        init(){
            this.insertSubscriber();
            this.popupNoticeDestroy();
        }

        popupNoticeDestroy(){
            $('body').on('click', 'div.wsf-overlay', function(e){
                e.preventDefault();
                let selfClass = $(this).attr('class');

                if( selfClass === e.target.className ){
                    $(this).fadeOut(300, ()=>{
                        $(this).remove();
                    })
                }
            });
        }

        popup_notice( notice, statusColor = 'green' ){
            let html = `
                <div class="wsf-overlay">
                    <div class="notice">
                        <span style="color:${statusColor};">${notice}</span>
                    </div>
                </div>
            `;
            $('body').prepend( html );
        }
        
        insert_data_using_ajax_submition(){
            let data       = SUBSCRIBER_FORM.serialize();
            let buttonText = SUBSCRIBER_BUTTON.text();

            $.ajax({
                type   : 'POST',
                url    : WPSFORM.ajax_url,
                data   : data,
                success: (response)=>{

                    // success status
                    if( response.success ){
                        // reset email field
                        SUBSCRIBER_FORM.find('input[type="email"]').val('');
                        this.popup_notice( response.data );
                    }
                    // error status
                    if( ! response.success ){
                        this.popup_notice( response.data, 'red' );
                    }
                    
                    SUBSCRIBER_BUTTON.empty().text(buttonText);
                },
                beforeSend: ()=>{
                    SUBSCRIBER_BUTTON.empty().text('loading...');
                }
            });
        }
        
        insertSubscriber(){
            SUBSCRIBER_FORM.on('submit', (e)=>{
                e.preventDefault();
                this.insert_data_using_ajax_submition();
            });

            SUBSCRIBER_BUTTON.on('click', (e)=>{
                e.preventDefault();
                this.insert_data_using_ajax_submition();
            });
        }
    }

    const wsf = new ADD_NEW_SUBSCRIBER;

    doc.ready(()=>{wsf.init()});

})(jQuery);