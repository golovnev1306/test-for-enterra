<?php
defined('INCLUDE_INDEX') or die('Restricted access');
?>
<div class="modal fade js-modal js-edit-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Изменить новость</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="login-form" enctype="multipart/form-data" action="/admin/add/" method="POST">
      <div class="modal-body">
          <div class="form-group">
              <label for="inputName3">Наименование:</label>
              <input type="text" class="form-control" id="inputName3" placeholder="Название" name="name" value="">
          </div>
          <div class="form-group">
              <label for="inputPriviewText3">Короткий текст:</label>
              <textarea type="text" class="form-control" id="inputPriviewText3" placeholder="Короткий текст" name="preview_text" rows="6"></textarea>
          </div>
          <div class="form-group">
              <label for="inputDetailText3">Подробный текст:</label>
              <textarea type="text" class="form-control" id="inputDetailText3" placeholder="Подробный текст" name="detail_text" rows="6"></textarea>
          </div>
          <div class="form-group">
            <div class="input-file-container">
              <label class="input-file-label" for="inputFile3"></label>
              <div class="input-file-text">Перетащите, или кликните чтобы выбрать изображение</div>
              <input class="form-control-file input-file" id="inputFile3" type="file"  name="image">
          </div>
          
      </div>
      <div class="modal-footer">
        <div class="button-wrapper">
          <button type="submit" class="btn btn-success">Изменить</button>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
$news = <?=json_encode($news);?>
</script>