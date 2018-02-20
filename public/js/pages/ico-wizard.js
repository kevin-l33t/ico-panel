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

function submit_wizard(url, success_url) {
    swal({
        title: 'Please wait...',
        text: 'Issuing new ICO.',
        timer: 30000,
        allowOutsideClick: false,
        allowEscapeKey: false,
        onOpen: () => {
            swal.showLoading()
        }
    }).then((result) => {
        if (result.dismiss === swal.DismissReason.timer) {
            swal({
                type : 'error',
                title : 'Oops...',
                text : 'Request timeout. Please try again later.'
            });
        }
    });
    $.ajax({
        url: url,
        type: 'post',
        data: $('form').serialize(),
        success: function(data) {
            swal.close();
            console.log(data);
            swal({
                type : 'success',
                title : 'Good job!',
                text : 'Token was issued. It will take some time to approve.',
                footer : `check transaction on <a href="https://ropsten.etherscan.io/tx/${data.tx_hash}">Etherscan.io</a>`
            }).then(result => {
                window.location.href = success_url;
            });
        },
        error: function(data) {
            swal.close();
            swal({
                type : 'error',
                title : 'Oops...',
                text : 'Something went wrong. Please try again later.'
            });
            console.log(data);
        }
    });
}