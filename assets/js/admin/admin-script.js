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
                $(this).empty().html('<span class="wsf-ajax-loading"></span>');

                setTimeout(()=>{
                    $(this).empty().text(selfTextStore);
                },1000);
            })
        }
    }

    const WSF = new WPSubscriberForm;

    // run the program.
    doc.ready(()=>{ WSF.init() });

})(jQuery);