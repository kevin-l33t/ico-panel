$(function () {
    function pageLoad() {

        var $image = $(".image-crop > img")
        $($image).cropper({
            aspectRatio: 1,
            preview: ".img-preview",
            done: function (data) {
                console.log(data);
            }
        });

        var $inputImage = $("#inputImage");
        if (window.FileReader) {
            $inputImage.change(function () {
                var fileReader = new FileReader(),
                    files = this.files,
                    file;

                if (!files.length) {
                    return;
                }

                file = files[0];
                
                if (file.size > 8388608) {
                    swal(
                        'Error',
                        'Max file size is 8M',
                        'error'
                    );
                    return;
                }

                if (! /^image\/\w+$/.test(file.type)) {
                    swal(
                        'Error',
                        'Please choose an image file.',
                        'error'
                    );
                    return;
                }
                fileReader.readAsDataURL(file);
                fileReader.onload = function () {
                    //$inputImage.val("");
                    $image.cropper("reset", true).cropper("replace", this.result);
                };
            });
        } else {
            $inputImage.addClass("hide");
        }

        $("#zoomIn").click(function () {
            $image.cropper("zoom", 0.1);
        });

        $("#zoomOut").click(function () {
            $image.cropper("zoom", -0.1);
        });

        $("#rotateLeft").click(function () {
            $image.cropper("rotate", 45);
        });

        $("#rotateRight").click(function () {
            $image.cropper("rotate", -45);
        });

        $("#setDrag").click(function () {
            $image.cropper("setDragMode", "crop");
        });

        $('form').submit(function (eventObj) {
            $('#profile_thumb').attr('value', $image.cropper("getDataURL"));
            return true;
        });

        $('.widget').widgster();
    }

    $('.clickable-row').click(function (event) {
        if (event.target.nodeName != 'A') {
            window.location = $(this).data('href');
        }
    });

    $('input[type=radio][name=role]').change(function() {
        if (this.value == '3') {
            $('#wrapper_whitepaper').show(300);
        } else {
            $('#wrapper_whitepaper').hide(100);
        }
    });

    if ($('input[type=radio][name=role]:checked').val() != '3') {
        $('#wrapper_whitepaper').hide(100);
    }
    pageLoad();
    PjaxApp.onPageLoad(pageLoad);
});