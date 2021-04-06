// Global agreement
$('.agreement-form-submit').on('click', function(){
    $(".agreement-form").submit()
    return false
})

$(".agreement-form").submit(function(event) {
    console.log($('input[name="is_agreed"]:checked').val())
    event.preventDefault();
    global_agreement()
})


function global_agreement() {
    var fd = new FormData();
    let is_agreed = $('input[name="is_agreed"]:checked').val();
    fd.append('is_agreed',is_agreed);
    fd.append('action','global_agreement');

    $.ajax({
        url: "/wp/wp-admin/admin-ajax.php",
        type: "POST",
        dataType: "JSON",
        data: fd,
        contentType: false,
        processData: false,
        cache: false,
        success: function(data) {
            console.log(data.type)
            showAlert(data.type, "<p><strong>"+ data.message +"</strong></p>");
            if(data.type == 'success') {
                $('.checkout-wrapper').addClass('agreed')
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(xhr.statusText);
            console.log(xhr.responseText);
            console.log(thrownError);
            console.log(ajaxOptions);
            showAlert("error", "<p><strong>"+ xhr.responseText +"</strong></p>");
            if ( xhr.responseText == 'success0') {
                console.log('да, успех')

            } else {
                console.log('не, не успех')
            }
        },
    });
}// Global agreement