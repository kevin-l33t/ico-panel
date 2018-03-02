var slider;
function updatePrice() {
    var ethBalance = Number($('#eth_balance').html().split(' ')[0]);
    var ethAmount = $('#amount').val() * tokenEthPrice;
    var usdAmount = $('#amount').val() * tokenUsdPrice;
    $('#eth_amount').html(ethAmount.toFixed(5) + ' ETH');
    $('#usd_amount').html(usdAmount.toFixed(2) + ' USD');
    $('#eth_value').val(ethAmount);

    $('#button_buy').prop('disabled', ethBalance < ethAmount);
}

function buy() {
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
        url: $('#form_buy').attr('action'),
        type: 'post',
        data: $('form').serialize(),
        success: function(data) {
            swal.close();
            swal({
                type : 'success',
                title : 'Good job!',
                text : 'Token was issued. It will take some time to approve.',
                footer : `check transaction on <a href="https://ropsten.etherscan.io/tx/${data.tx_hash}">Etherscan.io</a>`
            }).then(result => {
                $('#wrapper_console').show(500);
                $('#link_tx_hash').html(data.tx_hash.substring(1, 30) + "...");
                $('#link_tx_hash').attr('href', `https://ropsten.etherscan.io/tx/${data.tx_hash}`);
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
        updatePrice();
    }
    function pageLoad(){
        slider = $('.js-slider').slider()
                                .on('slide', onChange)
                                .data('slider');
        $('#amount').keyup(function(e) {
            slider.setValue(parseInt($('#amount').val()));
            updatePrice();
        });

        $('#button_buy').click(function() {
            swal({
                title: 'Are you sure?',
                text: 'Do you want to buy tokens for ' + $('#eth_amount').html() + ' ?',
                type: 'question',
                showCancelButton: true
            }).then(result => {
                if (result.value) {
                    buy();
                }
            });
        });

        $('.widget').widgster();
    }
    updatePrice();
    pageLoad();

    PjaxApp.onPageLoad(pageLoad);
});