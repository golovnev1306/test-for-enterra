'use strict'
$(document).ready(function() {
    init();
});

function init() {
    window.$body = $(document.body);
    const $modalAddContainer = $body.find('.js-modal-add-container');
    const $modalEditContainer = $body.find('.js-modal-edit-container');

    if($modalAddContainer.length !== 0) {       //если есть один из контейнером, значит мы на странице админа
        loadModal('add', $modalAddContainer);   //будем подгружать ajax некоторые данные после загрузки страницы,
        loadModal('edit', $modalEditContainer); //за счет этого, страница будет отображаться быстрее
    }
    const $butDeleteNews = $body.find('.js-btn-delete-news');
    const $butEditNews = $body.find('.js-btn-edit-modal-news');
    const $fileContainer = $body.find('.input-file-container');

    $butDeleteNews.on('click', function(ev){
        if (confirm('Уверены, что хотите удалить новость?')) {
            const id = $(this).closest('.js-news-admin-item').attr('data-id');
            $.ajax({
                url: `/admin/deleteajax`,
                method: 'POST',
                data: {id: id},
                success: function() {
                    location.reload();
                }
            });
        }
    });

    $butEditNews.on('click', async function(ev){
        const id = $(this).closest('.js-news-admin-item').attr('data-id');
        await insertDataInModal($modalEditContainer, id).then($('.js-edit-modal').modal());
    });

    // $fileContainer.droppable({
    //     drop: function(ev) {
    //             console.log(ev);
    //         }
    // });

    $fileContainer.on('dragover', function(event) {
        event.preventDefault();
        console.log(event);
    });

    $fileContainer.on('drop', function(ev) {
        console.log(ev);
    });

}

function loadModal(type, $containerModal) {
    $.ajax({
        url: `/modal/${type}ajax`,
        method: 'POST',
        success: function(data) {
            $containerModal.append(data);
        }
    });
}

async function insertDataInModal($containerModal, id) {
    return new Promise(async function(resolve, reject) {

        let $modal = $containerModal.find('.js-modal');
        if ($modal.length !== 0) {
            if (undefined !== window.$news[id]) {
                var fields = {
                    '#inputName3': window.$news[id].name,
                    '#inputPriviewText3' : window.$news[id].preview_text,
                    '#inputDetailText3' : window.$news[id].detail_text,
                };

                for (let key in fields) {
                    $modal.find(key).val(fields[key]);
                }
                resolve();
            }
        }
        reject();
    });
}