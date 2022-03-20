
const MAX_FILE_SIZE = 1966080;

$(document).ready(()  => {
    $('.tag-item').on('click', (event) => {
        changeTags(event.target)
    })
    $('.hover-image-block').mouseenter((event) => {
        hoverImageBlockOn(event)
    })
    $('.hover-image-block').mouseleave((event) => {
        hoverImageBlockOff(event)
    })
})

function hoverImageBlockOn(event){
    let $block = $(event.currentTarget);
    $block.append(getChangeHtmlBlock($block.attr('data-type'), $block.attr('data-id')));
}

function hoverImageBlockOff(event){
    $('#post-image-change').remove();
}

function getChangeHtmlBlock(type, id) {
    return '<div id="post-image-change">\n' +
        '                            <button type="button" class="btn btn-success" onclick="openFilemanager(\''+ type +'\', ' + id + ')">\n' +
        '                                <i class="fa fa-pen"></i>\n' +
        '                            </button>\n' +
        '                            <button type="button" class="btn btn-danger" onclick="deleteImage(\''+ type +'\', ' + id + ')">\n' +
        '                                <i class="fa fa-trash"></i>\n' +
        '                            </button>\n' +
        '                        </div>';
}

function deleteImage(type, id) {
    if(parseInt(id) === 0) {
        return;
    }
    let image = '/storage/noimg.png';
    let block = $('div.hover-image-block[data-id="' + id + '"][data-type="' + type + '"]');
    if(block.length > 0){
        $(block[0]).attr('data-id', 0);
        $(block[0]).find('img').attr('src', image);
        $(block[0]).find('input').val(0);
    }
}

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

function openFilemanager(type, id) {
    let count = $('#' + type).attr('data-count');
    $('#count-image').val(count);
    $('#image-id').val(id);
    $('#image-type').val(type);
    $('#modal-filemanager').modal('show');
    let data = {};
    let url = localStorage.getItem('filemanager-url');
    let page = localStorage.getItem('filemanager-page')
    if(url){
        data.url = url
    }
    if(page){
        data.page = page
    }
    loadData(data)

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
    localStorage.setItem('filemanager-url', data.url);
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
function filemanagerChangeItem() {
    let items = [];
    $('#modal-filemanager input:checkbox:checked').each((i, item) => {
        let block = $('div [data-id="' + $(item).val() + '"]');
        items.push({
            id: block.find('img').attr('data-id'),
            link: block.find('img').attr('src'),
            type: block.attr('data-type')
        })
    });
    filemanagerAddImages(items);
}

function filemanagerAddImages(items){
    let settings = getImagesSettingForFilemanager();
    for (let i = 0; i < items.length; i++) {
        if((i < settings.count) && (items[i].type === 'image')) {
            let block = $('div.hover-image-block[data-id="' + settings.id + '"][data-type="' + settings.type + '"]');
            if(block.length > 0){
                $(block[0]).attr('data-id', items[i].id);
                $(block[0]).find('img').attr('src', items[i].link);
                $(block[0]).find('input').val(items[i].id);
            }
        }
    }
    $('#modal-filemanager').modal('hide');
}

function filemanagerPageTo(page){
    let data = {
        url: $('#current-url').val(),
        page: page
    }
    localStorage.setItem('filemanager-page', page);
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
                html += '<img  data-id="' + item['file_id'] + '" src="' + item['src'] + '">';
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
function getImagesSettingForFilemanager() {
    return {
        id: $('#image-id').val(),
        count: $('#count-image').val(),
        type: $('#image-type').val()
    }
}

function bytesToSize(bytes) {
    var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    if (bytes === 0) return '0 Byte';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}

function tootlePostActive(id) {
    let url = $('#active-ajax-url') .val() + '/' + id;
    getRequest(url);
}
function modalRenameTag() {
    let modal = $('#modal-tag-rename');
    let id = modal.find('[name="id"]').val();
    let name = modal.find('[name="name"]').val();
    let url = modal.find('[name="ajax-rename-url"]').val();
    url = `${url}/${id}`;
    postRequest(url, { name: name}).then( result => {
        if(result){
            updateTagName(result);
            modal.find('[name="name"]').val('')
            modal.modal('hide');
        }  else {
            alert('Что то не так');
        }

    }).catch( error => {
        alert('Не удалось переиновать тег');
        console.log(error);
    });
}

function updateTagName(tag) {
    $('#tag-item-' + tag.id).find('div.tag-item__title').text(tag.title)
}

function openModalTagRename(id) {
    let tagName = $.trim($('#tag-item-' + id).find('div.tag-item__title').text());
    let modal = $('#modal-tag-rename');
    modal.find('.add-header').text(tagName);
    modal.find('[name="id"]').val(id);
    modal.modal('show');
}

function deleteTag(id) {
    let modal = $('#modal-tag-rename');
    let url = modal.find('[name="ajax-delete-url"]').val();
    url = `${url}/${id}`;
    getRequest(url).then( result => {
        if(result){
            $('#tag-item-' + result.id).remove();
        }  else {
            alert('Что то не так');
        }
        console.log(result)
    }).catch( error => {
        console.log(error)
    });
}



