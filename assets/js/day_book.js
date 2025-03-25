function apply_coupon_code() {
    var event_id = $("#event_id").val();
    var discount_coupon = $("#discount_coupon").val();
    if (discount_coupon != "" && discount_coupon != null) {
        url = base_url + "discount_coupon";
        $.ajax({
            type: "POST",
            url: url,
            data: {discount_coupon: discount_coupon, event_id: event_id},
            beforeSend: function () {
                $('#loadingmessage').show();
            },
            success: function (responseJSON) {
                $('#loadingmessage').hide();
                var response = JSON.parse(responseJSON);
                if (response.status == false) {
                    $("#discount_coupon_error").html(response.message);
                } else {
                    $("#discount_coupon_error").html("");
                    $("#amount").val(response.price);
                    $("#discount_coupon_id").val(response.id);
                    $("#discount_coupon_price").html('$' + response.price.toFixed(2) + " / " + discount_coupon + " " + response.message);

                }
            }
        });
    }
}

function confirm_time(e) {
    $(e).parents(".row").find(".time-display").removeClass("w-49 pull-left time-display");
    $(e).parents(".row").find(".time-confirm").addClass("hide-confirm");
    $(e).addClass("w-49 pull-left time-display");
    $(e).next(".time-confirm").removeClass("hide-confirm");
}

function confirm_form(e) {
    $("#time_slots_model").modal('hide');
    var date = $(e).data("date");
    var time = $(e).prev("#time-select").html();
    $("#confirm_close").remove();
    $("#confirm_back").prepend('<button type="button" id="confirm_close" class="close" data-dismiss="modal" onclick="get_time_slots(this);" data-date="' + date + '">&#8592;</button>');
    $("#user_datetime").val(date + " " + time);
    $("#datetime_list").text(date + " " + time);
    $("#confirm_model").modal('show');
    $("body").addClass("model-scroll");
}

function valid_stripe() {
    if ($("#BookForm").valid()) {
        get_stripe();
    }
}
function valid_book(value) {
    if ($("#BookForm").valid()) {
        if ($('#payment_method').val() == value) {
            var stripeToken = $('input[name="stripeToken"]').val();
            if (stripeToken) {
                $("#paymentloadingmessage").show();
                $("#BookForm").submit();
            } else {
                get_stripe('stripe');
            }
        } else {
            $('#loadingmessage').show();
            $("#BookForm").submit();
        }
    }
}

function valid_on_cash() {
    if ($("#BookForm").valid()) {
        $('#loadingmessage').show();
        $("#BookForm").submit();
    }
}

function valid_paypal() {
    if ($("#BookForm").valid()) {
        $('#loadingmessage').show();
        $("#BookForm").attr("action", base_url + "booking-paypal");
        $("#BookForm").submit();
    }
}
function valid_free() {
    if ($("#BookForm").valid()) {
        $('#loadingmessage').show();
        $("#BookForm").attr("action", base_url + "booking-free");
        $("#BookForm").submit();
    }
}
function check_pos(e) {
    var pos = $('#day-carousel').find('.carousel-item.active').index() + parseInt(1);
    var slide = $('#day-carousel').find('.carousel-item').length;
    var c = $(e).attr('class');
    if (!c) {
        $(e).find('.week-control.left').css({"pointer-events": "none", "color": "gray", "opacity": "0.4"});
    } else if (c == 'week-control right') {
        if (slide - parseInt(1) == pos) {
            $(e).css({"pointer-events": "none", "color": "gray", "opacity": "0.4"});
            $(".week-control.left").removeAttr('style');
        } else {
            $(".week-control").removeAttr('style');
        }
    } else if (c == 'week-control left') {
        if (parseInt(2) == pos) {
            $(e).css({"pointer-events": "none", "color": "gray", "opacity": "0.4"});
            $(".week-control.right").removeAttr('style');
        } else {
            $(".week-control").removeAttr('style');
        }
    }
}
$(document).on('keydown', '.integers', function (e) {
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            (e.keyCode == 65 && e.ctrlKey === true) ||
            (e.keyCode == 67 && e.ctrlKey === true) ||
            (e.keyCode == 88 && e.ctrlKey === true) ||
            (e.keyCode >= 35 && e.keyCode <= 39)) {
        return;
    }
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
});
