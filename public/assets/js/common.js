
var toast = Swal.mixin({
    toast: true,
    icon: 'success',
    title: 'General Title',
    animation: false,
    position: 'top-right',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

function toaster(msg, status = true) {
    let icon = status == 'false' ? 'error' : 'success';
    toast.fire({
        title: msg,
        icon: icon
    });
}

window.addEventListener('viewModal', event => {
    $("#viewModal").modal('show');
});

window.addEventListener('alert', event => {
    toaster(event.detail.message, event.detail.status);
});

window.addEventListener('viewDelete', event => {
    event.preventDefault();
    Swal.fire({
        text: 'Are you sure you want to delete this record.?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            Livewire.emit('deleteRecrod', event.detail.id)
        }
    })
});

window.addEventListener('close-modal', event => {
    $("#pageModal").modal('hide');
})
window.addEventListener('addUpdateModal', event => {
    $("#pageModal").modal('show');
})

$(".sign_me_out").click(function (e) {
    e.preventDefault();
    Swal.fire({
        text: 'Are you sure you want to logout?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Logout'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.replace($(this).attr('href'));
        }
    })
});

function load_preview_image(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $("#preview_div").show();
            $('#image_preview').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        $("#preview_div").hide();
    }
}