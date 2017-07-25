function isSpDevice() {
    if (document.body.clientWidth > 768) {
        return false;
    }
    return true;
}

function isset(variable) {
    return typeof variable != 'undefined' ? true : false;
}
