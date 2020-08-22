<?php
defined('INCLUDE_INDEX') or die('Restricted access');
?>
<div class="modal fade" id="addNewsModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Добавить новость</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="login-form" enctype="multipart/form-data" action="/admin/add/" method="POST">
      <div class="modal-body">
          <div class="form-group">
              <label for="inputName2">Наименование:</label>
              <input type="text" class="form-control" id="inputName2" placeholder="Название" name="name">
          </div>
          <div class="form-group">
              <label for="inputPriviewText2">Короткий текст:</label>
              <textarea class="form-control" id="inputPriviewText2" placeholder="Короткий текст" name="preview_text" rows="5"></textarea>
          </div>
          <div class="form-group">
              <label for="inputDetailText2">Подробный текст:</label>
              <textarea class="form-control" id="inputDetailText2" placeholder="Подробный текст" name="detail_text" rows="6"></textarea>
          </div>
          <div class="form-group">
              <label for="inputFile2">Изображение:</label>
              <input type="file" class="form-control-file" id="inputFile2" name="image">
          </div>
          
      </div>
      <div class="modal-footer">
        <div class="button-wrapper">
          <button type="submit" class="btn btn-success">Добавить</button>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>