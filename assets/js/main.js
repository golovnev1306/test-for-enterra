'use strict'
$(document).ready(function() {
    init();
});

function init() {
    window.$body = $(document.body);
    const $modalAddContainer = $body.find('.js-modal-add-container');
    const $modalEditContainer = $body.find('.js-modal-edit-container');

    if($modalAddContainer.length !== 0) {     
                                //если есть один из контейнером, значит мы на странице админа
                                                //будем подгружать ajax некоторые данные после загрузки страницы,
                                                //за счет этого, страница будет отображаться быстрее
        loadModal('add', $modalAddContainer);
        loadModal('edit', $modalEditContainer).then(function() {
            const $form = window.$body.find('.js-form');
            const $fileContainer = window.$body.find('.js-input-file-container');
            window.$fileList = $fileContainer.parent().find('.js-files-list');
            const $fileInput = $fileContainer.find('.js-input-file');
            const $delFileLink = $fileContainer.parent().find('.js-delete-file');

            $fileInput.on('change', loadInInputClick);
            $fileContainer.on('dragenter', dragEventsHandler);
            $fileContainer.on('dragleave', dragEventsHandler);
            $fileContainer.on('dragover', cancelEvent);
            $fileContainer.on('drop', dropFileHandler);
            $delFileLink.on('click', deleteFile);
            $modalEditContainer.find('.js-edit-modal').on('hide.bs.modal', hiddedModal);

            $(".js-validate-form").validate({
                rules: {
                  name: "required",
                },
                messages: {
                  name: "Указание названия - обязательно",
                },
                focusInvalid: true,
                errorClass: "input-error",
              });
        });
    }

    $(".js-login-form").validate({
        rules: {
          login: "required",
          pass: "required",
        },
        messages: {
          login: "Укажите логин",
          pass: "Укажить пароль",
        },
        focusInvalid: true,
		errorClass: "input-error"
      });

    const $butDeleteNews = $body.find('.js-btn-delete-news');
    const $butEditNews = $body.find('.js-btn-edit-modal-news');

    $butDeleteNews.on('click', function(ev){
        if (confirm('Уверены, что хотите удалить новость?')) {
            const id = $(this).closest('.js-news-admin-item').attr('data-id');
            const oldImage = 
            $.ajax({
                url: `/admin/deleteajax`,
                method: 'POST',
                data: {
                    id: id,
                    oldImage: window.$news[id].image,
                },
                success: function() {
                    location.reload();
                }
            });
        }
    });

    $butEditNews.on('click', async function(ev){
        const id = $(this).closest('.js-news-admin-item').attr('data-id');
        await insertDataInModal($modalEditContainer, id).then($('.js-edit-modal').modal()); //ждем промис об успешном завершении получения 
                                                                                            //данных, затем открываем модальное окно с редактированием
    });
}

function loadModal(type, $containerModal) {
    return new Promise(async (resolve) => {
        await $.ajax({
            url: `/modal/${type}ajax`,
            method: 'POST',
            success: async function(data) {
                $containerModal.append(data);
            }
        });
        resolve();
    });
    
}

function insertDataInModal($containerModal, id) {
    return new Promise(function(resolve, reject) {

        let $modal = $containerModal.find('.js-modal');
        if ($modal.length !== 0) {
            if (undefined !== window.$news[id]) {
                var fields = {
                    '#inputName3': window.$news[id].name,
                    '#inputPriviewText3' : window.$news[id].preview_text,
                    '#inputDetailText3' : window.$news[id].detail_text,
                    '#inputId3' : window.$news[id].id,
                    '#inputOldImage3': window.$news[id].image,
                };

                if (null !== window.$news[id].image && window.$news[id].image.length > 0) {
                    let $filesPreview = $containerModal.find('.js-files-preview');
                    $filesPreview.css('display', 'flex');
                    let imgHtml = `<img src="/upload/${window.$news[id].image}" alt="">`;
                    $filesPreview.append(imgHtml);
                }

                for (let key in fields) {
                    $modal.find(key).val(fields[key]);
                }
                resolve();
            }
        }
        reject();
    });
}

function dragEventsHandler(ev) {
    ev.preventDefault();
    highlightToggle(this);
}

function dropFileHandler(ev) {
    ev.preventDefault();
    let $this = $(this);
    highlightToggle(this);
    window.file = ev.originalEvent.dataTransfer.files[0];
    $this.find('.js-input-file')[0].files = ev.originalEvent.dataTransfer.files;
    updateFileList();
    
}

function cancelEvent(ev) {
    ev.preventDefault();
}

function highlightToggle(elem) {
    $(elem).toggleClass('highlight');
}

function updateFileList() {
    let fileName = window.$fileList.find('.js-file-name');
    if (undefined !== window.file) {
        window.$fileList.css('display', 'flex');
        fileName.text(window.file.name);
    } else {
        window.$fileList.hide();
        fileName.text('');
    }
}

function deleteFile() {
    delete window.file;
    updateFileList();
}

function loadInInputClick(ev) {
    window.file = ev.target.files[0];
    updateFileList();
}

function hiddedModal() {
    let $filesPreview = $(this).find('.js-files-preview');
    $filesPreview.find('img').remove();
    $filesPreview.hide();
}