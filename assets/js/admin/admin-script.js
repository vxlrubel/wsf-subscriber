(function($){
    const doc = $(document);
    const AddNew = $('#add_new_subscriber');
    class WPSubscriberForm{
        init(){
            this.addNewSubscriber();
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
    }

    const WSF = new WPSubscriberForm;

    // run the program.
    doc.ready(()=>{ WSF.init() });

})(jQuery);