$(document).ready(function () {
    if ($('.demo').length) {
        $(".demo").minicolors({
            control: $(this).attr('data-control') || 'hue',
            defaultValue: $(this).attr('data-defaultValue') || '',
            format: $(this).attr('data-format') || 'hex',
            keywords: $(this).attr('data-keywords') || '',
            inline: $(this).attr('data-inline') === 'true',
            letterCase: $(this).attr('data-letterCase') || 'lowercase',
            opacity: $(this).attr('data-opacity'),
            position: $(this).attr('data-position') || 'bottom left',
            swatches: $(this).attr('data-swatches') ? $(this).attr('data-swatches').split('|') : [],
            change: function (value, opacity) {
                if (!value)
                    return;
                if (opacity)
                    value += ', ' + opacity;
                if (typeof console === 'object') {
                    console.log(value);
                }
            },
            theme: 'bootstrap'
        });
    }

    $("#site_form").submit(function (e) {
        if ($("#site_form").valid()) {
            $("body").preloader({
                percent: 10,
                duration: 15000
            });
        } else {
            e.preventDefault();
        }
    });
    $("#site_business_form").submit(function (e) {
        if ($("#site_business_form").valid()) {
            $("body").preloader({
                percent: 10,
                duration: 15000
            });
        } else {
            e.preventDefault();
        }
    });
    $("#site_business_form").validate({
        ignore: [],
        rules: {
            commission_percentage: {
                required: true
            },
            minimum_vendor_payout: {
                required: true
            }
        },
    });
    $("#site_email_form").validate({
        ignore: [],
        rules: {
            smtp_host: {
                required: true
            },
            smtp_password: {
                required: true
            },
            smtp_secure: {
                required: true
            },
            smtp_port: {
                required: true,
                number: true
            },
            smtp_username: {
                required: true
            },
            email_from_name: {
                required: true
            }
        },
    });
    $("#site_email_form").submit(function (e) {
        if ($("#site_email_form").valid()) {
            $("body").preloader({
                percent: 10,
                duration: 15000
            });
        } else {
            e.preventDefault();
        }
    });
});
// Profile Image On Click Function 
function readURL(input) {
    var id = $(input).attr("id");
    var image = '#' + id;
    //alert(image);
    var ext = input.files[0]['name'].substring(input.files[0]['name'].lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
        var reader = new FileReader();
    reader.onload = function (e) {
        $('img' + image).attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
}
// Profile Image On Click Function 
function readURLIcon(input) {
    var id = $(input).attr("id");
    var image = '#' + id;
    //alert(image);
    var ext = input.files[0]['name'].substring(input.files[0]['name'].lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0] && (ext == "ico"))
        var reader = new FileReader();
    reader.onload = function (e) {
        $('img' + image).attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
}

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

// Steppers                
$(document).ready(function () {
    var navListItems = $('div.setup-panel-2 div a'),
            allWells = $('.setup-content-2'),
            allNextBtn = $('.nextBtn-2'),
            allPrevBtn = $('.prevBtn-2');

    allWells.hide();

    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
                $item = $(this);

        if (!$item.hasClass('disabled')) {
            navListItems.removeClass('btn-amber').addClass('btn-blue-grey');
            $item.addClass('btn-amber');
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });

    allPrevBtn.click(function () {
        var curStep = $(this).closest(".setup-content-2"),
                curStepBtn = curStep.attr("id"),
                prevStepSteps = $('div.setup-panel-2 div a[href="#' + curStepBtn + '"]').parent().prev().children("a");

        prevStepSteps.removeAttr('disabled').trigger('click');
    });

    allNextBtn.click(function () {
        var curStep = $(this).closest(".setup-content-2"),
                curStepBtn = curStep.attr("id"),
                nextStepSteps = $('div.setup-panel-2 div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                curInputs = curStep.find("input[type='number'], input[type='text'],input[type='url'],input[type='email'],input[type='file'], textarea ,select"),
                isValid = true;

        var form = $("#site_form");
        form.validate({
            ignore: [],
            rules: {
                company_name: {
                    required: true
                },
                company_email1: {
                    required: true,
                    email: true
                },
                home_page: {
                    required: true
                },
                Pro_img: {
                    extension: "png|jpeg|jpg",
                },
                banner_img: {
                    extension: "png|jpeg|jpg",
                },
                fevicon_icon: {
                    extension: "ico",
                }
            },
            messages: {
                company_name: {
                    required: "Please Enter Company name"
                },
                company_email1: {
                    required: "Please enter email ",
                    email: "Please enter valid email "
                },
                home_page: {
                    required: "Please select home page ",
                },
                Pro_img: {
                    extension: "File must be JPEG or PNG "
                },
                banner_img: {
                    extension: "File must be JPEG or PNG "
                }

            },
            errorElement: 'div',
            errorPlacement: function (error, element) {
                element.parents(".form-group").append(error);
            }
        });
        if (!curInputs.valid()) {
            return false;
        }
        if (isValid)
            nextStepSteps.removeAttr('disabled').trigger('click');
    });

    $('div.setup-panel-2 div a.btn-amber').trigger('click');


});

function update_display_setting(element) {
    var id = $(element).attr("id");


    var updata_arr = ['display_record_per_page', 'google_location_search_key', 'google_map_key', 'footer_color_code', 'header_color_code']
    if ($.inArray(id, updata_arr) != -1) {
        if ($(element).val() != '') {
          
            if (id == 'display_record_per_page') {
                up_data = parseInt($(element).val());
                if (up_data == "" || up_data <= 0 || isNaN(up_data)) {
                    up_data = 12;
                }
            } else {
                up_data = $(element).val();
            }
            $.ajax({
                url: site_url + "admin/update-display-setting",
                type: "post",
                data: {token_id: csrf_token_name, up_data: up_data, name: id, action: 'perpage_setting'},
                beforeSend: function () {
                    $("body").preloader({
                        percent: 10,
                        duration: 15000
                    });
                },
                success: function (data) {
                    if (data == true) {
                        window.location.reload();
                    } else {
                        window.location.reload();
                    }
                }
            });
        }
    } else {
        if ($(element).is(":checked")) {
            is_display = 'Y';
        } else {
            is_display = 'N';
        }
        $.ajax({
            url: site_url + "admin/update-display-setting",
            type: "post",
            data: {token_id: csrf_token_name, action: 'display_setting', display: is_display, name: id},
            beforeSend: function () {
                $("body").preloader({
                    percent: 10,
                    duration: 15000
                });
            },
            success: function (data) {
                if (data == true) {
                    window.location.reload();
                } else {
                    window.location.reload();
                }
            }
        });
    }
}
