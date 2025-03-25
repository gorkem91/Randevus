
// User Registration Form

$(document).ready(function () {
    $.validator.addMethod("passwordRule", function (value, element) {
        return this.optional(element) || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,20}$/.test(value);
    }, "Please enter valid password.");

    $("#Register_user").validate({
        ignore: [],
        rules: {
            first_name: {
                required: true,
            },
            last_name: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 8,
                maxlength: 15,
                passwordRule: true
            }
        },
        messages: {
            first_name: {
                required: "Please enter your firstname",
            },
            last_name: {
                required: "Please enter your lastname",
            },
            email: {
                required: "Please enter your email",
                email: "Please enter a valid email"
            },
            password: {
                required: "Please enter a password",
                minlength: "Please enter minimum 8 characters",
                maxlength: "Please enter maximum 15 characters"
            }
        },
    });

});

$(document).ready(function () {
    $('[data-toggle="popover"]').popover({
        placement: 'top',
        trigger: 'hover'
    });
});