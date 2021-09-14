function showOverlaySpinner() {
    $('.overlay-spinner').addClass('show');
    $('.overlay-spinner').attr('style', 'display:block');
}

function hideOverlaySpinner() {
    $('.overlay-spinner').removeClass('show');
    $('.overlay-spinner').attr('style', '');
}
