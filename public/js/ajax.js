
function getRequest(url) {
    $.ajax({
        url: url,
        type: "GET",
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: (result) => {
            return result;
        },
        error: (error) => {
            return error;
        }
    });
}
