$(document).ready(function () {
    Login.emailFieldListeners();
    Login.loginEnterKeyListener();
});

var Login = {
    emailFieldListeners: function () {
        var wasTrailingTextAdded = false;
        $("#email").click(function () {
            var currentValue = $(this).val();
            if (currentValue.indexOf('@') !== -1 && currentValue.indexOf(Constants.DOMAIN_EMAIL_EXT) < 0) {
                currentValue = currentValue.substring(0, currentValue.indexOf('@'));
            }

            if (currentValue.indexOf(Constants.DOMAIN_EMAIL_EXT) < 0 && currentValue !== "E-mail Address") {
                $(this).val(currentValue + Constants.DOMAIN_EMAIL_EXT);
                wasTrailingTextAdded = true;
            }
            if (!wasTrailingTextAdded) {
                $(this)[0].setSelectionRange(0, 0);
            }
            if (currentValue === Constants.DOMAIN_EMAIL_EXT || currentValue === "" || currentValue === "E-mail Address") {
                $(this).val(Constants.DOMAIN_EMAIL_EXT);
                $(this)[0].setSelectionRange(0, 0);
            }
        });

        $("#email").blur(function () {
            var error_div = $('#login-error-div');
            error_div.html('&nbsp;');
            var currentValue = $(this).val();
            var trimmedValue = currentValue.substring(0, currentValue.indexOf('@'));
            if (currentValue.indexOf('@') < 0 && currentValue !== "E-mail Address" && currentValue !== "") {
                $(this).val(currentValue + Constants.DOMAIN_EMAIL_EXT);
                $(this).css('color', Constants.MAIN_TEXT_COLOR);
            } else if (currentValue.indexOf('@') !== -1 && currentValue.indexOf(Constants.DOMAIN_EMAIL_EXT) < 0) {
                currentValue = currentValue.substring(0, currentValue.indexOf('@'));
                $(this).val(currentValue + Constants.DOMAIN_EMAIL_EXT);
                $(this).css('color', Constants.MAIN_TEXT_COLOR);
            } else if (currentValue.indexOf(Constants.DOMAIN_EMAIL_EXT) !== 0 && trimmedValue !== "") {
                $(this).css('color', Constants.MAIN_TEXT_COLOR);
            }

            if ($(this).val() === Constants.DOMAIN_EMAIL_EXT) {
                $(this).addClass('placeholder');
                $(this).val($(this).attr('placeholder'));
                $(this).css('color', '#aaaaaa');
            }

            if (!Core.isValidEmailAddress($(this).val())) {
                error_div.css('color', Constants.RED_COLOR);
                error_div.html('Please enter a valid e-mail address.');
            }
        });
    },
    loginEnterKeyListener: function () {
        var that = this;
        $("#password").keyup(function (event) {
            if (event.keyCode === 13) {
                that.loginUser();
            }
        });
    },
    loginUser: function () {
        var email = $("#email").val();
        var password = $("#password").val();
        var error_div = $('#login-error-div');
        error_div.html('&nbsp;');
        error_div.css('color', Constants.RED_COLOR);

        if (email.length < 1 || password.length < 1) {
            error_div.html("Please fill all the fields properly");
        } else if (!Core.isValidEmailAddress(email)) {
            error_div.html('Please enter a valid e-mail address.');
        } else {
            var params = {
                url: "ajax/login.php",
                method: "POST",
                data: {
                    email: email,
                    password: password
                },
                errorDiv: $("#login-error-div")
            };

            Core.ajax(params,
                    function (json) {
                        if (json.status === "success") {
                            window.location = "/home";
                        } else if (json.status === "invalid_info"
                                || json.status === "wrong_combination") {
                            error_div.html("Information you entered does not match with our records");
                        } else if (json.status === "invalid_domain_name") {
                            error_div.html("Please use your '" + Constants.DOMAIN_BODY + "' email");
                        } else if (json.status === "invalid_email_address") {
                            error_div.html("Please enter a valid email address");
                        } else if (json.status === "no_activation") {
                            window.location = "/activation";
                        } else if (json.status === "reset_password") {
                            window.location = "/reset-password/1/1";
                        } else {
                            error_div.html(json.status);
                        }
                    });
        }
    }
};