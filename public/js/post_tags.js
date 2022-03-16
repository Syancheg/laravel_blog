$(document).ready(()  => {
    $('.tag-item').on('click', (event) => {
        changeTags(event.target)
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
