(function($){
    const doc = $(document);
    const AddNew = $('#add_new_subscriber');
    const SubscriberListParent = $('.wsf-list-parent');
    class WPSubscriberForm{
        init(){
            this.addNewSubscriber();
            this.subscriberDeleteEdit();
        }

        addNewSubscriber(){
            AddNew.on('click', function(e){
                e.preventDefault();
                let selfTextStore = $(this).text();
                let noticeSuccess = '<div class="wsf-notice"><span>Successfully add a new subscriber...</span><span class="wsf-notice-dismiss">&times;</span></div>';
                $(this).empty().html('<span class="wsf-ajax-loading"></span>');

                setTimeout(()=>{
                    $(this).empty().text(selfTextStore);
                    $(this).closest('.wrap').children('.wsf-title').after(noticeSuccess)
                },1000);
            });

            $('.add-new-subscribe-form-parent').on('click', function(e){
                console.dir(e.target.className);
                if( e.target.className == 'wsf-notice-dismiss' ){
                    $(this).find('.wsf-notice').fadeOut(400);
                    setTimeout(() => {
                        $(this).find('.wsf-notice').remove();
                    }, 500);
                }
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
                   targetRow.css('backgroundColor', '#f53b57').fadeOut(300);
                   setTimeout(() => {
                    targetRow.remove();
                   }, 300);
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