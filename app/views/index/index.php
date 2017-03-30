

<?php if(isset($data['categories'])) : ?>
    <?php $i = 1; ?>
    <?php foreach ($data['categories'] as $category) : ?>
        <?php if($i == 1) : ?>
            <div class="row">
        <?php endif; ?>
            <div class="col-md-6"><?php echo $category['name'] ?>
                <?php foreach ($category['news'] as $news) : ?>
                    <div class="row">
                        <div class="col-md-12"><?php echo $news['title'] ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php $i++; ?>
        <?php if($i>2) : ?>
            </div>
        <?php endif; ?>
        <?php $i = ($i>2) ? 1 :$i;  ?>
    <?php endforeach; ?>
    <?php if($i==2) : ?>
        </div>
    <?php endif; ?>
<?php endif; ?>
