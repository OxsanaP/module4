<?php if (isset($this->getParams()->slider)) : ?>
    <div class="row">
        <div class="col-md-12">
            <div id="slider">
                <a href="#" class="control_next">>></a>
                <a href="#" class="control_prev"><</a>
                <ul>
                    <?php foreach ($this->getParams()->slider as $slide): ?>
                        <li>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-2">
                                        <img width="100%" src="<?php echo $slide['image'] ?>"/>
                                    </div>
                                    <div class="col-md-4">
                                        <h2><?php echo $slide['title'] ?></h2>
                                        <p><?php echo $this->cutText($slide['content'],300) ?>...</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (isset($this->getParams()->categories)) : ?>
    <?php $i = 1; ?>
    <?php foreach ($this->getParams()->categories as $category) : ?>
        <?php if ($i == 1) : ?>
            <div class="row">
        <?php endif; ?>
        <div class="col-md-6 category-news">
            <div class="category-news-container">
                <h3><a href="<?php echo $category['url'] ?>"><?php echo $category['name'] ?></a></h3>
                <?php if (count($category['news']) == 0) : ?>
                    <div class="row">
                        <div class="col-md-12">Новостей пока нет</div>
                    </div>
                <?php endif; ?>
                <?php foreach ($category['news'] as $news) : ?>
                    <div class="row news">
                        <div class="col-md-12"><a
                                href="/news?id=<?php echo $news['id'] ?>"><?php echo $this->upperFirstLetter($news['title']) ?></></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php $i++; ?>
        <?php if ($i > 2) : ?>
            </div>

        <?php endif; ?>
        <?php $i = ($i > 2) ? 1 : $i; ?>
    <?php endforeach; ?>
    <?php if ($i == 2) : ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<script src="/js/slider.js" ></script>