$(function(){
    function pageLoad(){
        $('.chzn-select').select2();
        $("#start_date").datetimepicker({
            format: false
        });
        $("#wizard").bootstrapWizard({
            onTabShow: function(tab, navigation, index) {
                var $total = navigation.find('li').length;
                var $current = index+1;
                var $percent = ($current/$total) * 100;
                var $wizard = $("#wizard");
                $wizard.find('.progress-bar').css({width:$percent+'%'});

                if($current >= $total) {
                    $wizard.find('.pager .next').hide();
                    $wizard.find('.pager .finish').show();
                    $wizard.find('.pager .finish').removeClass('disabled');
                } else {
                    $wizard.find('.pager .next').show();
                    $wizard.find('.pager .finish').hide();
                }
            }
        });

        $('.widget').widgster();
    }

    pageLoad();

    PjaxApp.onPageLoad(pageLoad);
});

function submit(url) {
    $.ajax({
        url: url,
        type: 'post',
        data: $('form').serialize(),
        success: function(data) {
            alert("success");
        }
    });
}