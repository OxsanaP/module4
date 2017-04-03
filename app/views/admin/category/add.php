<?php use app\helpers\Main; ?>
<form class="form-horizontal" action="/admin/category/addpost" method="post">
    <div class="modal-body">
        <div class="form-group">
            <label for="inputCategory3" class="col-sm-2 control-label">Category Name</label>
            <div class="col-sm-5">
                <input type="text" class="form-control category-values" name="name" id="inputCategory3"
                       placeholder="Category">
            </div>
        </div>
        <div class="form-group">
            <label for="inputTags3" class="col-sm-2 control-label">Parent Category</label>
            <div class="col-sm-5">
                <select class="form-control" name="parent_id">
                    <?php foreach (Main::getCategories(true) as $id => $value): ?>
                        <option value="<?php echo $id ?>"><?php echo $value ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Add</button>
    </div>
</form>
