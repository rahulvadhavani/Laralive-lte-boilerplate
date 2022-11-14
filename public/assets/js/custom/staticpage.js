CKEDITOR.replace( 'static_page_form_editor',{height: 350});
function saveStaticPage(url){
  var content = CKEDITOR.instances.static_page_form_editor.getData();
  var slug = $("#page_slug").val();
  $.ajax({
      type: 'POST',
      dataType: 'json',
      data: {
        slug: slug,
        content: content,
      },
      url: url,
      dataType: 'json',
      headers: {'X-CSRF-TOKEN': csrf_token},
      beforeSend: function () {
          $('#static_page_form_loader').show();
          $('#static_page_form_btn').prop('disabled', true);
      },
      success: function (response)
      {
        $('#static_page_form_loader').hide();
        $('#static_page_form_btn').prop('disabled', false);
        if (!response.status) {
          toastr.error(response.message);
        }else {
          toastr.success(response.message);
        }
      },
      error: function () {
        toastr.error('Please Reload Page.');
        $('#static_page_form_loader').hide();
        $('#static_page_form_btn').prop('disabled', false);
      }
  });
}