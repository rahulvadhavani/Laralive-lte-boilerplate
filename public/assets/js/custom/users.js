function addModel() {
    var $alertas = $('#users_form');
    $alertas.validate().resetForm();
    $alertas.find('.error').removeClass('error');
    $('#users_form')[0].reset();
    $("#modal-add-update").modal('show');
    $("#id").val(0);
    $("#modal-add-update-title").text('Add User');
    $("#preview_div").hide();
    $('#project_btn').html('Add <span style="display: none" id="loader"><i class="fa fa-spinner fa-spin"></i></span>');
}
// View user
$(document).on('click', '.module_view_record', function () {
    const id = $(this).data("id");
    const url = $(this).data("url");
    $("#view_user_modal").modal('show');
    $("#view_user_modal .loader").addClass('d-flex');
    $.ajax({
        type: 'GET',
        data: {
            id: id,
            _method: 'SHOW'
        },
        url: `${url}/${id}`,
        headers: {
            'X-CSRF-TOKEN': csrf_token
        },
        success: function (response) {
            $("#view_user_modal .loader").removeClass('d-flex');
            if (response.status) {
                $.each(response.data, function (key, value) {
                    $(`#info_${key}`).text(value);
                    if (key == 'image') {
                        $(`#info_${key}`).attr("src", value);
                    }
                });
            } else {
                toastr.error(response.message);
            }
        },
        error: function () {
            $("#view_user_modal .loader").removeClass('d-flex');
            toastr.error('Please Reload Page.');
        }
    });

});

// delete user
$(document).on('click', '.module_delete_record', function () {
    const id = $(this).data("id");
    const url = $(this).data("url");
    deleteRecordModule(id, `${url}/${id}`);
});

// edit user
$(document).on('click', '.module_edit_record', function () {
    const id = $(this).data("id");
    const url = $(this).data("url");
    $("#modal-add-update").modal('show');
    $('#image_preview').attr("");
    $.ajax({
        type: 'GET',
        data: {
            id: id,
            _method: 'SHOW'
        },
        url: `${url}/${id}`,
        headers: {
            'X-CSRF-TOKEN': csrf_token
        },
        success: function (response) {
            if (response.status) {
                $.each(response.data, function (key, value) {
                    if (key == 'image') {
                        $('#image_preview').attr("src", value);
                    } else {
                        $(`#${key}`).val(value);
                    }
                });
            } else {
                toastr.error(response.message);
            }
        },
        error: function () {
            toastr.error('Please Reload Page.');
        }
    });
    $('#users_form_btn').html('Update <span style="display: none" id="users_form_loader"><i class="fa fa-spinner fa-spin"></i></span>');
});


$("#users_form").validate({
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
        email: {
            required: true,
            email: true,
        },
        image: {
            accept: "image/jpg,image/jpeg,image/png"
        },
        password: {
            minlength: 6,
        },
        password_confirmation: {
            equalTo: "#password"
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
        email: {
            required: "Please enter email",
            email: "Please enter valid email",
        },
        name: {
            required: "Please enter name",
        },
        image: {
            accept: 'Only allow image!'
        },
        password: {
            minlength: "Please enter password atleast 6 character!"
        },
        password_confirmation: {
            equalTo: "password and confirm password not match"
        },

    },
    submitHandler: function (form, e) {
        e.preventDefault();
        console.log(form)
        const formbtn = $('#users_form_btn');
        const formloader = $('#users_form_loader');
        console.log(formloader)
        $.ajax({
            url: form.action,
            type: "POST",
            data: new FormData(form),
            dataType: 'json',
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrf_token
            },
            beforeSend: function () {
                formloader.show();
                formbtn.prop('disabled', true);
            },
            success: function (result) {
                formloader.hide();
                formbtn.prop('disabled', false);
                if (result.status) {
                    $('#users_form')[0].reset();
                    $("#modal-add-update").modal('hide');
                    $('#example1').DataTable().ajax.reload();
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