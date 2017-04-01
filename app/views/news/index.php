<?php if (isset($this->getParams()->news)) : ?>
    <?php $news = $this->getParams()->news; ?>
    <div class="row">
        <div class="col-md-12">
            <h1><?php echo $news['title']; ?></h1>
        </div>
    </div>

    <div class="row news-content">
        <div class="col-md-12">
            <img class="main-image" src="<?php echo $news['image'] ?>">
            <p><?php echo $news['content']; ?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <strong>Просмотрели: </strong><span class="news-viewed"><?php echo (int)$news['viewed']; ?></span>
        </div>
        <div class="col-md-2 ">
            <strong>Сейчас смотрят: </strong><span class="news-view"><?php echo $this->getParams()->nowRead; ?></span>
        </div>
    </div>
    <?php if (isset($this->getParams()->tags)) : ?>
        <div class="row">
            <div class="col-md-12">
                <?php foreach ($this->getParams()->tags as $tag): ?>
                    <span><a href="/tag?id=<?php echo $tag['id'] ?>"><?php echo $tag['name'] ?></a></span>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
    <script>
        jQuery(document).ready(function () {
            setInterval(function () {
                jQuery.ajax({
                    url: "/news/curview",
                    method: "POST",
                    data: {id:<?php echo $news['id']?>}
                }).done(function (response) {
                    var data = JSON.parse(response);
                    if (data.status == "error") {
                        console.log(data.errorMessage);
                    } else {
                        jQuery('.news-viewed').html(data.data.viewed)
                        jQuery('.news-view').html(data.data.curViewed)
                    }
                });
            }, 3000);
        });
    </script>
<?php endif; ?>









