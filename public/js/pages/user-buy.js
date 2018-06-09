var slider, ethAmount, ethAmountWithFee, usdAmount;
const MIN_REQUIRED_ETH = 0.0005;
function updatePrice() {

    slider.setValue(parseInt($('#amount').val()));

    var ethBalance = Number($('#eth_balance').html().split(' ')[0]);
    ethAmount = $('#amount').val() * tokenEthPrice;
    ethAmountWithFee = ethAmount + MIN_REQUIRED_ETH;
    usdAmount = $('#amount').val() * tokenUsdPrice;
    $('#bank_amount').html(`USD ${(usdAmount + 30).toLocaleString('en', {minimumFractionDigits: 2})}`);
    $('#credit_card_amount').html(`USD ${(usdAmount * 1.055).toLocaleString('en', {minimumFractionDigits: 2})}`);
    $('#usd_value').val(usdAmount);

    $('#button_buy').prop('disabled', ethBalance < ethAmount + MIN_REQUIRED_ETH);
}

function updatePriceByToken() {
    updatePrice();
    $('#eth_value').val(ethAmount.toFixed(5));
}

function updatePriceByEther() {
    var tokenAmount = parseFloat($('#eth_value').val()) / tokenEthPrice;
    $('#amount').val(tokenAmount);
    updatePrice();
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
        updatePriceByToken();
    }

    function pageLoad() {
        slider = $('.js-slider').slider()
                                .on('slide', onChange)
                                .data('slider');
        $('#amount').keyup(function(e) {
            updatePriceByToken();
        });
        $('#amount').change(function(e) {
            updatePriceByToken();
        });
        $('#eth_value').keyup(function(e) {
            updatePriceByEther();
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

        $('#button_buy_bank').click(function() {
            $('#form_buy').attr('action', $(this).data('action'));
            $('#form_buy').submit();
        });

        $('.widget').widgster();
    }
    pageLoad();
    updatePriceByToken();

    PjaxApp.onPageLoad(pageLoad);
});