<?php use app\helpers\Main; ?>
<form class="form-horizontal" action="/category/result" method="get">
    <div class="modal-body">
        <div class="form-group input-daterange">
            <label for="inputData3" class="col-sm-2 control-label">Date period</label>
            <div class="col-sm-4">
                From <input type="text" class="input-small" name="start"/>
            </div>
            <div class="col-sm-4">
                to <input type="text" class="input-small" name="end"/>

            </div>
        </div>
        <div class="form-group">
            <label for="inputCategory3" class="col-sm-2 control-label">Category</label>
            <div class="col-sm-5">
                <input type="text" class="form-control category-values" name="category" id="inputCategory3"
                       placeholder="Category">
            </div>
            <div class="col-md-4">
                <select class="category">
                    <?php foreach (Main::getCategories() as $id => $value): ?>
                        <option value="<?php echo $id ?>"><?php echo $value ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

        </div>
        <div class="form-group">
            <label for="inputTags3" class="col-sm-2 control-label">Tags</label>
            <div class="col-sm-5">
                <input type="text" class="form-control tags-values" name="tags" id="inputTags3"
                       placeholder="Tags">
            </div>
            <div class="col-md-4">
                <select class="tags">
                    <?php foreach (Main::getTags() as $id => $value): ?>
                        <option value="<?php echo $id ?>"><?php echo $value ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('.input-daterange').datepicker({
            todayBtn: "linked"
        });
        jQuery(document).on("change", ".category", function () {
            var element = jQuery(".category-values"),
                select = jQuery(".category option:selected"),
                curval = element.val();

            curval = (curval == "") ? "" : curval + ",";
            element.val(curval + select.text());
        });
        jQuery(document).on("change", ".tags", function () {
            var element = jQuery(".tags-values"),
                select = jQuery(".tags option:selected"),
                curval = element.val();

            curval = (curval == "") ? "" : curval + ",";
            element.val(curval + select.text());
        });

    });
</script>