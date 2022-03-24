
<template id="achievements">
    <div class="col-12 achievements-item" id="">
        <div class="info-box">
            <span class="info-box-icon bg-warning"><i class="fa fa-trophy"></i></span>
            <div class="info-box-content">
                <span class="info-box-text"></span>
                <span class="info-box-number"></span>
                <input class="achievements-id" type="hidden" name="" value="">
                <input class="achievements-date" type="hidden" name="" value="">
                <input class="achievements-name" type="hidden" name="" value="">
            </div>
        </div>
        <button type="button" onclick="deleteAchievements(event.currentTarget)" class="btn achievement-delete-button">
            <i class="fas fa-trash-alt">
            </i>
        </button>
    </div>
</template>
