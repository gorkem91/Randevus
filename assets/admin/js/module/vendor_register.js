
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
                email: true,
                remote: {
                    url: base_url + "check-vendor-email",
                    type: "post",
                    data: {
                        title: function () {
                            return $("#email").val();
                        }
                    }
                }
            },
            password: {
                required: true,
                minlength: 8,
                maxlength: 15,
                passwordRule: true
            },
            company: {
                required: true
            },
            website: {
                required: true,
                 url: true
            },
            phone: {
                required: true,
                remote: {
                    url: base_url + "check-vendor-phone",
                    type: "post",
                    data: {
                        title: function () {
                            return $("#phone").val();
                        }
                    }
                }
            },
        },
        messages: {
            first_name: {
                required: "Please enter your firstname"
            },
            last_name: {
                required: "Please enter your lastname"
            },
            email: {
                required: "Please enter your email",
                email: "Please enter a valid email",
                remote: "Email is already existing."
            },
            password: {
                required: "Please enter a password",
                minlength: "Please enter minimum 8 characters",
                maxlength: "Please enter maximum 15 characters"
            },
            company: {
                required: "Please enter your company name"
            },
            website: {
                required: "Please enter your website name",
                url : "Please enter valid url"
            },
            phone: {
                required: "Please enter your phone number",
                remote: "Phone is already existing."
            },
        },
    });

});

$(document).ready(function () {
    $('[data-toggle="popover"]').popover({
        placement: 'top',
        trigger: 'hover'
    });
});