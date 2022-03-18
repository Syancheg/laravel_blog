
const MAX_FILE_SIZE = 1966080;

$(document).ready(()  => {
    $('.tag-item').on('click', (event) => {
        changeTags(event.target)
    })
    $('#active-switch').on('change', (event) => {
        $(event.target).val($(event.target).is(':checked'))
    })
})

function changeTags(target) {
    let $target =  $(target);
    let status = $target.attr('data-status');
    let tagId = $target.attr('data-id');
    let curTags = $('#tags-input').val();
    if(curTags === '') {
        curTags = [];
    } else {
        curTags = curTags.split('.');
    }
    if (status === 'new') {
        curTags.push(tagId);
        $target.attr('data-status', 'cur');
        $target.removeClass('bg-warning');
        $target.addClass('bg-success');
        $('#current-tags').append($target);
    } else if (status === 'cur') {
        let index = curTags.indexOf(tagId)
        if (index !== -1 ) {
            curTags.splice(index, 1);
        }
        $target.attr('data-status', 'new');
        $target.removeClass('bg-success');
        $target.addClass('bg-warning');
        $('#all-tags').append($target);
    }
    curTags  = curTags.join('.');
    $('#tags-input').val(curTags);
}

function openFilemanager() {
    $('#modal-filemanager').modal('show');
    loadData({})
}

function addFileListener() {
    let input = $('#filemanager-modal-file-input');
    input.bind({
        change: function() {
            input.off();
            if(this.files.length > 0){
                uploadFiles(this.files)
            }
        }
    });
}

function uploadFiles(files) {
    let formData = new FormData();
    let i = 1;
    for (const file of files) {
        if(file.size > MAX_FILE_SIZE){
            let fileSizeStr = bytesToSize(file.size);
            let maxSizeStr = bytesToSize(MAX_FILE_SIZE);
            alert(`Слишком большой файл! ${file.name}, его разамер ${fileSizeStr}, максимальный  допустимый размер файла ${maxSizeStr}`);
            $('#filemanager-modal-file-input').val()
            return;
        } else {
            formData.append(`file_${i}`, file);
            i++;
        }
    }


    let dir_path = getDirPath();
    formData.append('dir_path', dir_path);
    $('#filemanager-modal-file-input').val('')
    let url = $('#upload-url').val();
    startLoader();
    postRequest(url, formData, true).then((result) => {
        if (result === '1'){
            loadData({
                url: getDirPath()
            });
        } else {
            alert(result['message']);
        }
    }).catch((error) => {
        alert('Не удалось загрузить файлы');
    });
}

function setupBaseUrls($data) {
    $('#upload-url').val($data['upload_url']);
    $('#delete-url').val($data['delete_url']);
    $('#new-folder-url').val($data['new_folder_url']);
}

function loadData(data) {
    startLoader();
    let url = getFilemanagegUrl();
    postRequest(url, data).then( (result)=>{
        stopLoader();
        setupBaseUrls(result['base_settings']);
        if(result['items'].length === 0){
            let html = getError('В данной папке нет подходящих файлов!');
            $('#modal-header-url').text('Home'+ result['current_directory']);
            $('#current-url').val(result['current_directory']);
            $('#filemanager-modal-content').html(html);
        } else {
            getPagination(result['pages'], result['page']);
            let html = generateHtml(result);
            $('#modal-header-url').text('Home'+ result['current_directory']);
            $('#current-url').val(result['current_directory']);
            $('#filemanager-modal-content').html(html);
        }
    }).catch((error)=>{
        let html = getError('На сервере произвошла ошибка, либо такой папки не существует!');
        stopLoader();
        $('#filemanager-modal-content').html(html);
    });
}

function getPagination(total, current) {
     $('#filemanager-pagination').remove();
     $('#current-page').val(current);
     $('#all-pages').val(total);
     if(current === total) return;
     let html = '<div class="clearfix" id="filemanager-pagination">';
     html += '<ul class="pagination pagination-sm m-0 float-right">';
     html += '<li class="page-item"><button onclick="filemanagerPageTo(1)" class="page-link">«</button></li>';
     for(let i = 1; i <= total; i++){
         let active = '';
         if (i === parseInt(current)) active = 'active';
         html += '<li class="page-item ' + active + '"><button onclick="filemanagerPageTo(' + i + ')" class="page-link">' + i + '</button></li>';
     }
     html += '<li class="page-item"><button onclick="filemanagerPageTo(' + total + ')" class="page-link">»</button></li>';
     html += '</ul>';
     html += '</div>';
     $('#filemanager-modal-close').after(html);
}

function getError(message) {
    let html = '<div class="error-filemanager">';
    html += '<div>';
    html += '<div>';
    html += '<i class="fa-solid fa-cloud-exclamation"></i>';
    html += '</div>';
    html += '<span>' + message + '</span>';
    html += '<button onclick="filemanagerBack()" type="button" class="btn bg-gradient-warning">Назад</button>';
    html += '</div>';
    html += '</div>';
    return html;
}

function filemanagerBack() {
    let oldUlr = $('#current-url').val();
    let data = {
        url: oldUlr.slice(0, oldUlr.lastIndexOf('/')),
    }
    loadData(data);
}
function filemanagerRefresh() {
    let dir_path = getDirPath();
    let data = {
        url: dir_path,
        page: $('#current-page').val()
    }
    loadData(data);
}
function filemanagerUpload() {
    addFileListener()
}

function openDirnameInput(){

    let input =  '<div class="input-group filemanager-dir-input">' +
        '<input type="text" id="dir-name-input" class="form-control">\n' +
        '<div onclick="filemanagerCreateDir()" class="input-group-append">\n' +
        '<span class="input-group-text"><i class="fas fa-check"></i></span>\n' +
        '</div>\n' +
        '</div>';
    $('#dir-name-block').append(input);
}

function getDirName() {
    let name = $('#dir-name-input').val();
    if(name !== undefined && name.length > 3) {
        $('.filemanager-dir-input').remove();
        return name;
    }  else {
        alert('Имя должно содержать минимум 3 символа');
    }
}


function filemanagerCreateDir() {
    let name = `/${getDirName()}`
    let url = $('#new-folder-url').val();
    let data = {
        url: getDirPath() + name
    }
    postRequest(url, data).then((result) => {
        if (result === '1'){
            filemanagerRefresh()
        } else {
            alert(result['message']);
        }
    }).catch((error) => {
        alert('Не удалось создать папку!');
    });

}
function filemanagerDelete() {
    if(!confirm("Вы лействительно хотите удалить  файлы?")) {
        return;
    }
    let items = {
        files: {}
    };
    $('#modal-filemanager input:checkbox:checked').each((i, item) => {
        let block = $('div [data-id="' + $(item).val() + '"]');
        items['files'][i] = {
            url: block.attr('data-link'),
            id: block.attr('data-id')
        }
    });
    if(Object.keys(items).length > 0) {
        let url = getDeleteUrl();
        postRequest(url,items).then(result => {
            if (result === '1'){
                filemanagerRefresh()
            } else {
                alert(result['message']);
            }
        }).catch(error => {
            alert('error')
        });
    }
}
function filemanagerCheckItem(event) {
    console.log(event);
}

function filemanagerPageTo(page){
    let data = {
        url: $('#current-url').val(),
        page: page
    }
    loadData(data);
}

function clickItemFilemanager(id) {
    let block = $('div [data-id="' + id + '"]');
    let link = block.attr('data-link');
    let type = block.attr('data-type');
    switch (type){
        case 'dir':
            let data = {
                url: link
            }
            $('#current-url').val(link);
            loadData(data);
            break;
        case 'image':

            break;
        case 'video':

            break;
    }
}

function generateHtml(result) {
    let html = '';
    for (item of result['items']) {
        html += '<div class="filemanager-modal-item filemanager '+ item['type'] + '" data-id="' + item['id'] + '" data-type="' + item['type'] + '" data-link="'+ item['link'] + '">';
        html += '<div onclick="clickItemFilemanager(' + item['id'] + ')" class="filemanager-image-block">';
        switch (item['type']){
            case 'dir':
                html += '<i class="fa-solid fa-folder"></i>';
                break;
            case 'image':
                html += '<img src="' + item['src'] + '">';
                break;
            case 'video':
                html += '<video></video>';
                break;
        }
        html += '</div>';
        html += '<div class="custom-control custom-checkbox">';
        html += '<input class="custom-control-input filemanager-checkbox" value="' + item['id'] + '" type="checkbox" id="file-checkbox-' + item['id'] + '">';
        html += '<label for="file-checkbox-' + item['id'] + '" class="custom-control-label">'+ item['name'] + '</label>';
        html += '</div>';
        html += '</div>';
    }
    return html;
}

function startLoader() {
    let html = '<div class="loader active">\n' +
        '                        <div class="wrapper-loader">\n' +
        '                            <div class="circle-loader"></div>\n' +
        '                            <div class="circle-loader"></div>\n' +
        '                            <div class="circle-loader"></div>\n' +
        '                            <div class="shadow-loader"></div>\n' +
        '                            <div class="shadow-loader"></div>\n' +
        '                            <div class="shadow-loader"></div>\n' +
        '                            <span>Loading</span>\n' +
        '                        </div>\n' +
        '                    </div>';
    $('#filemanager-modal-content').html(html);
}
function stopLoader() {
    $('#filemanager-modal-content').empty();
}

function getDirPath() {
    let dir_path = $('#current-url').val();
    if(dir_path === '/'){
        dir_path = '';
    }
    return dir_path;
}
function getDeleteUrl(){
    return $('#delete-url').val();
}
function getFilemanagegUrl(){
    return $('#filemanage-ajax').val();
}

function bytesToSize(bytes) {
    var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    if (bytes === 0) return '0 Byte';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}


