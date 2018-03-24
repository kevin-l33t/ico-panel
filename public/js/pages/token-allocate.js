function allocate() {
    swal({
        title: 'Please wait...',
        text: 'Processing transaction',
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
        url: $('#form_allocate').attr('action'),
        type: 'post',
        data: $('#form_allocate').serialize(),
        success: function(data) {
            swal.close();
            swal({
                type : 'success',
                title : 'Good job!',
                text : 'Token was allocated. It will take some time to approve.',
                footer : `check transaction on <a target="_blank" href="https://etherscan.io/tx/${data.tx_hash}">Etherscan.io</a>`
            }).then(result => {
                $('#wrapper_console').show(500);
                $('#link_tx_hash').html(data.tx_hash);
                $('#link_tx_hash').attr('href', `https://etherscan.io/tx/${data.tx_hash}`);
            });
        },
        error: function(data) {
            swal.close();
            var message = "Something went wrong. Please try again later.";
            if (data.responseJSON) {
                message = data.responseJSON.message;
            }
            swal({
                type : 'error',
                title : 'Oops...',
                text : message
            });
        }
    });
}

$(function(){
    function pageLoad(){

        $(".select2").each(function(){
            $(this).select2($(this).data());
        });

        $('.widget').widgster();
    }

    $('#form_allocate').submit(function() {
        swal({
            title: 'Are you sure?',
            text: 'Do you want to allocate ' + $('#amount').val() + ' coins ?',
            type: 'question',
            showCancelButton: true
        }).then(result => {
            if (result) {
                allocate();
            }
        });
        return false;
    });

    pageLoad();

    PjaxApp.onPageLoad(pageLoad);
});