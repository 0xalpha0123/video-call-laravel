function basicAlert(message)
{
    Swal.fire({
        title: message,
        confirmButtonClass: 'btn btn-primary',
        buttonsStyling: false,
        confirmButtonText: 'はい'
    });
}
