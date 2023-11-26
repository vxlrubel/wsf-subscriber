(function($){
    const doc = $(document);
    const subscriberButton = $('#add_new_subscriber');
    const subscriberForm = $('.wsf-add-new-subscriber-form');
    const SubscriberListParent = $('.wsf-list-parent');
    class WPSubscriberForm{
        init(){
            this.subscriberDeleteEdit();
            this.removeUpdatedNotice();
            this.addNewSubscriberSubmitionForm();
        }

        get_ajax_notice( message, cssClass = 'success' ){
            let html  = `<div class="wsf-notice ${cssClass}"><span>${message}</span><span class="wsf-notice-dismiss">&times;</span></div>`;

            return html;
        }
        insert_data_using_ajax_submition(){

            let data = subscriberForm.serialize();
            let buttonText = subscriberButton.text();
            

            $.ajax({
                type   : 'POST',
                url    : ws.ajax_url,
                data   : data,
                success: (response)=>{

                    // success status
                    if( response.success ){
                        subscriberForm.before( this.get_ajax_notice( response.data ) );
                        
                        // reset email field
                        subscriberForm.find('input[type="email"]').val('');
                    }

                    // error status
                    if(! response.success ){
                        subscriberForm.before( this.get_ajax_notice( response.data, 'wsf-error' ) );
                    }
                    
                    subscriberButton.empty().text(buttonText);
                },
                beforeSend: ()=>{
                    subscriberButton.empty().html('<span class="wsf-ajax-loading"></span>')
                }
            });
        }
        addNewSubscriberSubmitionForm(){
            subscriberForm.on('submit', (e)=>{
                e.preventDefault();

                this.insert_data_using_ajax_submition();
            });

            subscriberButton.on('click', (e)=>{
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

        subscriberDeleteEdit(){
            SubscriberListParent.on('click', function(e){
                
                let dataId      = e.target.attributes[1].nodeValue;
                let targetClass = e.target.className;

                // data delete
                if( 'wsf-item-delete' == targetClass ){
                    e.preventDefault();
                    let targetRow = $(this).find('tr[data-item-id="'+dataId+'"]');
                   targetRow.css('background-color', '#f53b57').fadeOut(300, ()=>{
                        targetRow.remove();
                   });
                }

                // data edit
                if( 'wsf-item-edit' == targetClass ){
                    e.preventDefault();
                    let targetRow = $(this).find('tr[data-item-id="'+dataId+'"]');
                    targetRow.css('backgroundColor', 'blue');
                }

            });
        }
        
    }

    const WSF = new WPSubscriberForm;

    // run the program.
    doc.ready(()=>{ WSF.init() });

})(jQuery);