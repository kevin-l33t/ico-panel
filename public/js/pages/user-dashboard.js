$(function(){
    function pageLoad(){
        $('.widget').widgster();
    }

    $('.clickable-row').click(function (event) {
        if (event.target.nodeName != 'A') {
            window.location = $(this).data('href');
        }
    });

    pageLoad();
    PjaxApp.onPageLoad(pageLoad);
});