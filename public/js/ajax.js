
function getRequest(url) {
    return new Promise((resolve, reject) =>{
        $.ajax({
            url: url,
            type: "GET",
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: (result) => {
                resolve(result);
            },
            error: (error) => {
                reject(error);
            }
        });
    })
}
function postRequest(url, data, file = false) {
    return new Promise((resolve, reject)=>{
        let settings = {
            url: url,
            type: "POST",
            data: data,
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: (result) => {
                resolve(result);
            },
            error: (error) => {
                reject(error);
            }
        }
        if(file) {
            settings.contentType = false;
            settings.processData = false;
        }

        $.ajax(settings);
    })
}
