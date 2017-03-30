<?php if(isset($this->getParams()->categories)) : ?>
    <?php $i = 1; ?>
    <?php foreach ($this->getParams()->categories as $category) : ?>
        <?php if($i == 1) : ?>
            <div class="row">
        <?php endif; ?>
            <div class="col-md-6 category-news">
                <div class="category-news-container">
                    <h3><a href="<?php echo $category['url'] ?>"><?php echo $category['name'] ?></a></h3>
                    <?php if(count($category['news'])==0) : ?>
                        <div class="row">
                            <div class="col-md-12">Новостей пока нет</div>
                        </div>
                    <?php endif; ?>
                    <?php foreach ($category['news'] as $news) : ?>
                        <div class="row news">
                            <div class="col-md-12"><?php echo $news['title'] ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
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
