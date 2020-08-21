$(document).ready(function() {
    init();
});

function init() {
    window.$body = $(document.body);
    $modalAddContainer = $body.find('.modal-add-container');
    $modalEditContainer = $body.find('.modal-edit-container');

    loadModalAdd($modalAddContainer);
    const $butDeleteNews = $body.find('.btn-delete-news');
    const $butEditNews = $body.find('.btn-edit-modal-news');

    $butDeleteNews.on('click', function(ev){
        if (confirm('Уверены, что хотите удалить новость?')) {
            const id = $(this).closest('.js-news-admin-item').attr('data-id');
            $.ajax({
                url: `/admin/delete`,
                method: 'POST',
                data: {id: id},
                success: function() {
                    location.reload();
                }
            });
        }
    });

    $butEditNews.on('click',function(ev){
        const id = $(this).closest('.js-news-admin-item').attr('data-id');
        loadModalEdit($modalEditContainer, id);
    })
}

function loadModalAdd($containerModal) {
    $.ajax({
        url: `/modal/addajax`,
        method: 'POST',
        success: function(data) {
            $containerModal.append(data);
        }
    });
}

function loadModalEdit($containerModal, id) {
    $.ajax({
        url: `/modal/editajax`,
        method: 'POST',
        data: {id: id},
        beforeSend: function() {
            $('#editNewsModal').remove();
            window.$body.append('<div class="overlay loading"><div class="loading-text">Загрузка данных новости...</div></div>');
        },

        success: function(data) {
            $('.loading').remove();
            $containerModal.append(data);
            $('#editNewsModal').modal();
        }
    });
}