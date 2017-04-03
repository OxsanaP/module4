<?php use app\helpers\Main; ?>
<?php if (!empty($this->getParams()->tree)) : ?>
    <?php $treeData = $this->getParams()->tree["main"]; ?>
    <?php foreach ($treeData as $single): ?>
        <div class="row">
            <div class="col-sm-8">
                <div class="comment">
                    <?php echo $single['name'] ?>
                    <span class="glyphicon glyphicon-trash js-category-delete" data-val="<?php echo $single['id']?>" aria-hidden="true"></span>
                </div>
                <?php echo Main::buildTreeCategory($this->getParams()->tree, $single['id']) ?>
            </div>

        </div>
    <?php endforeach; ?>
<?php endif; ?>

<script>
    jQuery(document).on('click', '.js-category-delete', function () {
        var element = jQuery(this),
            id = element.data('val');
        jQuery.ajax({
            url: "/admin/category/delete",
            method: "POST",
            data: {id: element.data('val')}
        }).done(function (response) {
            window.location.replace('/admin/category/')
        });
    });
</script>

