
const MAX_FILE_SIZE = 1966080;
var Toast;

$(document).ready(()  => {
    showError();
    $('.tag-item').on('click', (event) => {
        changeTags(event.target)
    })
    $('.hover-image-block').mouseenter((event) => {
        hoverImageBlockOn(event.currentTarget)
    })
    $('.hover-image-block').mouseleave(() => {
        hoverImageBlockOff()
    })
})

function showError(){
    Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
}

function alertSuccess(title) {
    Toast.fire({
        icon: 'success',
        title: title
    })
}

function alertError(json) {
    let title = '';
    if(json.errors) {
        let errors = json.errors;
        let keys = Object.keys(errors);
        for (error of keys) {
            title += ` ${errors[error]} <br>`
        }
    } else {
        title += json.message
    }
    Toast.fire({
        icon: 'error',
        title: title
    })
}

function hoverImageBlockOn(block){
    let $block = $(block);
    if(!$block.hasClass('no_editable')) {
        $block.append(getChangeHtmlBlock($block.attr('data-type'), $block.attr('data-id')));
    }
}

function hoverImageBlockOff(){
    $('#image-change').remove();
}

function getChangeHtmlBlock(type, id) {
    return '<div id="image-change">\n' +
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
        $(block[0]).find('input').val('');
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

function openFilemanager(type, id = 0) {
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
    if(!confirm("Вы лействительно хотите удалить файлы?")) {
        return;
    }
    let items = {
        files: []
    };
    $('#modal-filemanager input:checkbox:checked').each((i, item) => {
        let block = $('div [data-id="' + $(item).val() + '"]');
        items.files.push({
            url: block.attr('data-link'),
            id: block.attr('data-id')
        })
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
    let items = {
        images: []
    };
    $('#modal-filemanager input:checkbox:checked').each((i, item) => {
        let block = $('div [data-id="' + $(item).val() + '"]');
        if(block.attr('data-type') === 'image') {
            items['images'].push({
                id: block.find('img').attr('data-id'),
                link: block.find('img').attr('src'),
                type: block.attr('data-type')
            })
        }
    });
    if(Object.keys(items['images']).length > 0) {
        let settings = getImagesSettingForFilemanager();
        if(settings.count === 1) {
            filemanagerAddImage(items['images'][0]);
        } else {
            filemanagerAddImages(items['images'])
        }
    }

}

function filemanagerAddImages(items) {
    let settings = getImagesSettingForFilemanager();
    $('#modal-filemanager').modal('hide');
    for (let i = 0; i < items.length; i++) {
        if((i < settings.count)) {
            let oldValues = $(`div.gallary-block.gallary[data-id="${items[i].id}"]`)
            if(oldValues.length === 0) {
                let block = $('div#gallary-images').prepend(getGallaryItemHtmlTemplate(items[i]));
            }
        }
    }
}

function filemanagerAddImage(item){
    let settings = getImagesSettingForFilemanager();
    $('#modal-filemanager').modal('hide');
    let block = $('div.hover-image-block[data-id="' + settings.id + '"][data-type="' + settings.type + '"]');
    if(block.length > 0){
        $(block[0]).attr('data-id', item.id);
        $(block[0]).find('img').attr('src', item.link);
        $(block[0]).find('input').val(item.id);
    }
}

function getGallaryItemHtmlTemplate(item) {
    let html = `<div class="gallary-block gallary" data-type="${item.type}" data-id="${item.id}">`;
    html += `<img class="image" src="${item.link}">`
    html += `<input type="hidden" id="gallary-image-${item.id}" name="images[]" class="gallary-input" value="${item.id}">`;
    html += `<div>`;
    html += `<div class="custom-control custom-checkbox">`;
    html += `<input class="custom-control-input" type="checkbox" id="gallary-checkbox-image-${item.id}" value="${item.id}">`;
    html += `<label for="gallary-checkbox-image-${item.id}" class="custom-control-label">Выбрать</label>`;
    html += `</div>`;
    html += `</div>`;
    html += `</div>`;
    return html;
}

function deleteGallaryItem() {
    $('#gallary-images-section input:checkbox:checked').each((i, item) => {
        let id = $(item).val();
        $(`div.gallary-block.gallary[data-id="${id}"]`).first().remove();
    });
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
        id: parseInt($('#image-id').val()),
        count: parseInt($('#count-image').val()),
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
    postRequest(url, { title: name}).then( result => {
        if(result){
            updateTagName(result);
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

function addNewTagOnGrid(tag) {
    let html = `<div id="tag-item-${tag.id}" class="main-tags-page-item bg-primary">`;
    html += `<div class="tag-item__title">${tag.title}</div>`;
    html += `<div class="tag-item__edit-block">`;
    html += `<button type="button" onclick="openModalTagRename(${tag.id})" class="tag-item__edit btn-left tag-btn bg-gradient-success">`;
    html += `<i class="fa fa-pencil"></i></button>`;
    html += `<button type="button" onclick="deleteTag(${tag.id})" class="tag-item__delete btn-right tag-btn bg-gradient-danger">`;
    html += `<i class="fa fa-trash"></i></button>`;
    html += `</div>`;
    html += `</div>`;
    $('#main-tags-block').prepend(html);
}

function modalNewTag() {
    let modal = $('#modal-tag-rename');
    let name = modal.find('[name="name"]').val();
    let url = modal.find('[name="ajax-new-url"]').val();
    postRequest(url, {title: name}).then( result => {
        console.log(result);
        if(result) {
            addNewTagOnGrid(result);
            modal.modal('hide');
        } else {
            alert('Что то не так');
        }
    }).catch( error => {
        alert('Не удалось создать тег');
        console.log(error);
    })
}

function openModalTagRename(id) {
    let tagName = $.trim($('#tag-item-' + id).find('div.tag-item__title').text());
    let modal = $('#modal-tag-rename');
    modal.find('.modal-title').text(`Переименовать тег "${tagName}"`);
    modal.find('[name="id"]').val(id);
    modal.find('[name="name"]').val('');
    $(modal.find('.modal-footer').find('button')[1]).attr('onclick', 'modalRenameTag()').text('Переименовать');
    modal.modal('show');
}

function openModalNewTag() {
    let modal = $('#modal-tag-rename');
    modal.find('.modal-title').text(`Новый тег`);
    modal.find('[name="name"]').val('');
    $(modal.find('.modal-footer').find('button')[1]).attr('onclick', 'modalNewTag()').text('Сохранить');
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

// users

function openModalChangePassword(id) {
    let modal = $('#modal-user-new-password');
    modal.find('[name="id"]').val(id);
    let name = $('#user-' + id).find('[name="name"]').val();
    let surname = $('#user-' + id).find('[name="surname"]').val();
    modal.find('.modal-title').text(`Сменить пароль пользователя ${name} ${surname}`);
    modal.modal('show');
}

function modalNewUserPassword() {
    let modal = $('#modal-user-new-password');
    let id = modal.find('[name="id"]').val()
    let data = {
        id: id,
        password: modal.find('[name="password"]').val(),
        password_confirmation: modal.find('[name="password_confirmation"]').val(),
    }
    let url = $('[name="ajax-change-password-url"]').val();
    url = `${url}/${id}`;
    postRequest(url, data).then( () => {
        modal.modal('hide');
        Toast.fire({
            icon: 'success',
            title: 'Пароль успешно изменен!'
        })
        modal.find('[name="id"]').val('');
        modal.find('[name="password"]').val('');
        modal.find('[name="password_confirmation"]').val('');
    }).catch( error => {
        Toast.fire({
            icon: 'error',
            title: error.responseJSON.errors.password[0]
        })
    })
}

function showNewUserBlock() {

}

function hideNewUserBlock() {

}

function allowUserEditing(id, button) {
    let $button = $(button);
    $button.removeClass('bg-gradient-primary');
    $button.addClass('bg-gradient-success');
    $button.attr('onclick', `editUser(${id}, event.currentTarget)`);
    let userBlock = $('#user-' + id);
    userBlock.find('input').attr('disabled', false);
    userBlock.find('.hover-image-block').removeClass('no_editable');
}

function editUser(id, button) {
    let $button = $(button);
    $button.removeClass('bg-gradient-success');
    $button.addClass('bg-gradient-primary');
    $button.attr('onclick', `allowUserEditing(${id}, event.currentTarget)`);
    let userBlock = $('#user-' + id);
    userBlock.find('input').attr('disabled', true);
    userBlock.find('.hover-image-block').addClass('no_editable');
    let image = userBlock.find('[name="image_id"]').val();
    let name = userBlock.find('[name="name"]').val();
    let surname = userBlock.find('[name="surname"]').val();
    let email = userBlock.find('[name="email"]').val();
    let data = {
        image_id: image,
        name: name,
        surname: surname,
        email: email,
    }
    let url = $('#user-edit-url').val();
    url = `${url}/${id}`;
    postRequest(url, data).then( result => {
        console.log(result)
        alertSuccess(result['success']);
    }).catch( response => {
        alertError(response.responseJSON);
    })
}

function newUser() {

}

function deleteUser(id) {

}

function deleteAchievements(block) {
    $(block).parent('div').remove();
}

function addAchievements() {
    let modal = $('#modal-achievements');
    let count = parseInt($('#achievements-block').attr('data-last'));
    let name = modal.find('[name="name"]').val();
    if(name.length < 3){
        modal.find('[name="name"]').after(`<div class="text-danger">Название должно содержать минимум 3 символа</div>`);
        return;
    }
    let date = modal.find('[name="date"]').val();
    let template = document.getElementById('achievements');
    let clone = template.content.cloneNode(true);
    clone.querySelectorAll('.achievements-item')[0].setAttribute('id', `achievements-item-${count}`);
    let boxContent = clone.querySelectorAll('.info-box-content')[0];
    boxContent.querySelectorAll('.info-box-text')[0].innerText = name;
    boxContent.querySelectorAll('.info-box-number')[0].innerText = date.split('-').reverse().join('.');
    boxContent.querySelectorAll('.achievements-date')[0].value = date;
    boxContent.querySelectorAll('.achievements-date')[0].setAttribute('name', `achievements[${count}][date]`);
    boxContent.querySelectorAll('.achievements-name')[0].value = name;
    boxContent.querySelectorAll('.achievements-name')[0].setAttribute('name', `achievements[${count}][name]`);
    document.getElementById('achievements-block').appendChild(clone);
    count++;
    $('#achievements-block').attr('data-last', count)
    modal.find(':input').val('');
    modal.find('.text-danger').remove();
    modal.modal('hide');
}

function deleteGallary(id) {
    $(`#gallary-${id}`).remove();
    $(`#gallaries-select option[value="${id}"]`).attr('disabled', false);
}

function changeGallary(id){
    if (id === '') return;
    let option = $(`#gallaries-select option[value="${id}"]`)
    let count = option.attr('data-count');
    let imageSrc = option.attr('data-image');
    if (imageSrc) {
        imageSrc = imageSrc.replace('public', '/storage');
    }
    let index = parseInt($('#gallary-block').attr('data-count'));

    let template = document.getElementById('gallary-item');
    let clone = template.content.cloneNode(true);
    clone.querySelectorAll('.gallary-item')[0].id = `gallary-${id}`;
    clone.querySelectorAll('.image')[0].src = imageSrc;
    clone.querySelectorAll('.gallary-item-count')[0].innerText = count;
    clone.querySelectorAll('input')[0].value = id;
    clone.querySelectorAll('input')[0].name = `gallaries[${index}]`;
    clone.querySelectorAll('.btn-delete-gallary')[0].setAttribute('onclick', `deleteGallary(${id})`);
    document.getElementById('gallary-block').appendChild(clone);
    $(`#gallaries-select option[value="${id}"]`).attr('disabled', true);
    index++;
    $('#gallary-block').attr('data-count', index)
}



