<?php use app\helpers\Main; ?>
<form class="form-horizontal" action="/admin/news/addpost" method="post" enctype="multipart/form-data">
    <div class="modal-body">
        <div class="form-group">
            <label for="inputCategory3" class="col-sm-2 control-label">Title</label>
            <div class="col-sm-5">
                <input type="text" class="form-control category-values" name="title" id="inputCategory3"
                       placeholder="Title">
            </div>
        </div>
        <div class="form-group">
            <label for="inputTags3" class="col-sm-2 control-label">Category</label>
            <div class="col-sm-5">
                <select multiple class="form-control" name="category[]">
                    <?php foreach (Main::getCategories(true) as $id => $value): ?>
                        <?php if ($id == '') continue; ?>
                        <option value="<?php echo $id ?>"><?php echo $value ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="inputCategory3" class="col-sm-2 control-label">Content</label>
            <div class="col-sm-9">
                <textarea name="content" class="form-control" rows="5"></textarea>

            </div>
        </div>

        <div class="form-group">
            <label for="inputCategory3" class="col-sm-2 control-label">Main Image</label>
            <div class="col-sm-9">
                <input type="file" name="image" id="inputCategory3" placeholder="Main Image">
            </div>
        </div>

        <div class="form-group">
            <label for="inputTags3" class="col-sm-2 control-label">Tags</label>
            <div class="col-sm-5">
                <select multiple class="form-control" name="tags[]">
                    <?php foreach (Main::getTags() as $id => $value): ?>
                        <?php if ($id == '') continue; ?>
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
