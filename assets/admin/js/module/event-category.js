$(document).ready(function () {
    folder_name = $('#folder_name').val();
    $("#EventCategoryForm").validate({
        ignore: [],
        rules: {
            title: {
                required: true,
                remote: {
                    url: site_url + folder_name + "/check-event-category-title",
                    type: "post",
                    data: {
                        title: function () {
                            return $("#title").val();
                        },
                        id: function () {
                            return $("#id").val();
                        }
                    }
                }
            },
        },
        messages: {
            title: {
                remote: "Title is already existing."
            }
        },
    });
    $("#EventCategoryForm").submit(function () {
        if ($("#EventCategoryForm").valid()) {
            $('.loadingmessage').show();
        }
    });
    $('#RecordDelete').on('click', function () {
        var id = $("#record_id").val();
        $.ajax({
            url: site_url + folder_name + "/delete-category/" + id,
            type: "post",
            data: {token_id: csrf_token_name},
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
    });
});
function DeleteRecord(element) {
    var id = $(element).attr('data-id');
    var title = $(element).attr('title');
    $("#some_name").html(title);
    $("#confirm_msg").html("Are you sure you want to delete this record?");
    $("#record_id").val(id);
}