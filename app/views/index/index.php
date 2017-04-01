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
    <script>
        jQuery(document).ready(function ($) {
            setInterval(function () {
                moveRight();
            }, 3000);

            var slideCount = $('#slider ul li').length;
            var slideWidth = $('#slider ul li').width();
            var slideHeight = $('#slider ul li').height();
            var sliderUlWidth = slideCount * slideWidth;

            $('#slider').css({width: slideWidth, height: slideHeight});

            $('#slider ul').css({width: sliderUlWidth, marginLeft: -slideWidth});

            $('#slider ul li:last-child').prependTo('#slider ul');

            function moveLeft() {
                $('#slider ul').animate({
                    left: +slideWidth
                }, 200, function () {
                    $('#slider ul li:last-child').prependTo('#slider ul');
                    $('#slider ul').css('left', '');
                });
            };

            function moveRight() {
                $('#slider ul').animate({
                    left: -slideWidth
                }, 200, function () {
                    $('#slider ul li:first-child').appendTo('#slider ul');
                    $('#slider ul').css('left', '');
                });
            };

            $('a.control_prev').click(function () {
                moveLeft();
                return false;
            });

            $('a.control_next').click(function () {
                moveRight();
                return false;
            });

        });

    </script>
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
