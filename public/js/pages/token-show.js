$(function(){
    function pageLoad(){
        $('.date-picker').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss'
        });
    }

    $("#form_stage").parsley({
        errorsContainer: function ( parsleyField ) {
            return parsleyField.$element.parents(".form-group").children("label");
        }
    });

    pageLoad();
    PjaxApp.onPageLoad(pageLoad);
});