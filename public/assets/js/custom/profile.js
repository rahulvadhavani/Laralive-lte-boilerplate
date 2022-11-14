$("#profile_frm").validate({
    rules: {
        first_name: {
            required: true,
            lettersonly: true
        },
        last_name: {
            required: true,
            lettersonly: true
        },
        name: {
            required: true,
        },
        image: {
            accept: "image/jpg,image/jpeg,image/png"
        },
    },
    messages: {
        first_name: {
            required: "Please enter firstname",
            lettersonly: "Please enter valid firstname"
        },
        last_name: {
            required: "Please enter lastname",
            lettersonly: "Please enter valid lastname"
        },
        name: {
            required: "Please enter name",
            remote: "Username already taken!"
        },
        image: {
            accept: 'Only allow image!'
        },
    },
    submitHandler: function (form, e) {
        e.preventDefault();
        console.log(form)
        const formbtn = $('#profile_frm_btn');
        const formloader = $('#profile_frm_loader');
        console.log(formloader)
        $.ajax({
            url: form.action,
            type: "POST",
            data: new FormData(form),
            dataType: 'json',
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': csrf_token },
            beforeSend: function () {
                formloader.show();
                formbtn.prop('disabled', true);
            },
            success: function (result) {
                formloader.hide();
                formbtn.prop('disabled', false);
                if (result.status) {
                    toastr.success(result.message);
                } else {
                    toastr.error(result.message);
                }
            },
            error: function () {
                toastr.error('Please Reload Page.');
                formloader.hide();
                formbtn.prop('disabled', false);
            }
        });
        return false;
    }
});

$("#password_frm").validate({
    rules: {
        old_password: {
            required: true,
            minlength: 6,
        },
        password: {
            required: true,
            minlength: 6,
        },
        password_confirmation: {
            required: true,
            equalTo: "#password"
        },
    },
    messages: {

        old_password: {
            required: "Please enter old password",
            minlength: "Please enter old password atleast 6 character!"
        },
        password: {
            required: "Please enter password",
            minlength: "Please enter password atleast 6 character!"
        },
        password_confirmation: {
            required: "Please enter confirm password"
        },

    },
    submitHandler: function (form, e) {
        e.preventDefault();
        const formbtn = $('#password_frm_btn');
        const formloader = $('#password_frm_loader');
        $.ajax({
            url: form.action,
            type: "POST",
            data: new FormData(form),
            dataType: 'json',
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': csrf_token },
            beforeSend: function () {
                $(formloader).show();
                $(formbtn).prop('disabled', true);
            },
            success: function (result) {
                $(formloader).hide();
                $(formbtn).prop('disabled', false);
                if (result.status) {
                    $("#password,#password_confirmation,#old_password").val('');
                    toastr.success(result.message);
                } else {
                    toastr.error(result.message);
                }
            },
            error: function () {
                toastr.error('Please Reload Page.');
                $(formloader).hide();
                $(formbtn).prop('disabled', false);
            }
        });
        return false;
    }
});
