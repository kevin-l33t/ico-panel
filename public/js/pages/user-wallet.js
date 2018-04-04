var slider;
function withdraw() {
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
        url: $('#form_withdraw').attr('action'),
        type: 'post',
        data: $('#form_withdraw').serialize(),
        success: function(data) {
            swal.close();
            swal({
                type : 'success',
                title : 'Good job!',
                text : 'Ethereum has been sent.',
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
    function onChange() {
        $('#amount').val(slider.getValue());
    }
    function pageLoad(){
        slider = $('.js-slider').slider()
                                .on('slide', onChange)
                                .data('slider');
        $('#amount').keyup(function(e) {
            console.log(parseFloat($('#amount').val()));
            slider.setValue(parseFloat($('#amount').val()));
        });
        $('#amount').change(function(e) {
            slider.setValue(parseFloat($('#amount').val()));
        });

        $('#button_withdraw').click(function() {
            var instance = $('#form_withdraw').parsley();
            instance.validate();
            if (instance.isValid()) {
                swal({
                    title: 'Are you sure?',
                    text: `Do you want to withdraw ${$('#amount').val()} Ether to ${$('#address').val()} ?`,
                    type: 'question',
                    showCancelButton: true
                }).then(result => {
                    if (result.value) {
                        withdraw();
                    }
                });
            }
        });

        $('.widget').widgster();
    }
    pageLoad();

    PjaxApp.onPageLoad(pageLoad);
});