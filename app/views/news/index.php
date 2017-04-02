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
    <div class="row">
        <form class="form-horizontal" method="POST" action="/comment/add">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="contentComment" class="col-sm-2 control-label">Comment</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="contentComment" name="content"></textarea>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="hidden" name="news_id" value="<?php echo $news['id'] ?>">
                    <input type="hidden" name="parent_id" value="">
                    <button type="submit" class="btn btn-default">Add comment</button>
                </div>
            </div>
        </form>
    </div>
    <?php if (!empty($this->getParams()->comments)) : ?>
        <?php $commentsData = $this->getParams()->comments["main"]; ?>
        <?php foreach ($commentsData as $singleComment): ?>
            <div class="row">
                <div class="col-sm-offset-2 col-md-6">
                    <div class="comment">
                        <p class="comment-header">
                            <span class="comment-like">
                            <span class="glyphicon glyphicon-thumbs-up js-comment-like" aria-hidden="true"
                                  data-val="<?php echo $singleComment['id']; ?>"></span>
                            <span class="glyphicon glyphicon-thumbs-down js-comment-like" aria-hidden="true"
                                  data-val="<?php echo $singleComment['id']; ?>"></span>
                        </span>
                            <strong><?php echo $singleComment['username']; ?></strong>
                        </p>
                        <p class="comment-body"><?php echo $singleComment['content']; ?></p>
                        <p class="comment-footer">
                            <?php if ($singleComment['user_id'] == $this->getCurrentUserId()) : ?>
                                <a href="#" class="edit-comment" data-val="<?php echo $singleComment['id']; ?>">Edit</a>
                            <?php endif; ?>
                            <a href="#" class="reply-comment" data-val="<?php echo $singleComment['id']; ?>">Reply</a>
                        <div class="row">
                            <form
                                class="form-horizontal comment-form js-comment-form-<?php echo $singleComment['id'] ?>"
                                method="POST" action="/comment/add">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="contentComment" class="col-sm-2 control-label">Comment</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="contentComment"
                                                      name="content"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <input type="hidden" name="news_id" value="<?php echo $news['id'] ?>">
                                        <input type="hidden" name="parent_id"
                                               value="<?php echo $singleComment['id']; ?>">
                                        <button type="submit" class="btn btn-default">Add comment</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        </p>
                    </div>
                    <?php echo $this->getCommentData($singleComment['id']); ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <script>
        jQuery(document).ready(function () {
            jQuery(document).on('click', '.edit-comment', function () {
                var element = jQuery(this),
                    commentId = element.data('val');
                window.location.replace("/comment/edit?id=" + commentId);
                return false;
            });

            jQuery(document).on('click', '.reply-comment', function () {
                jQuery('.comment-form').hide();
                jQuery('.js-comment-form-' + jQuery(this).data('val')).show();
                return false;
            });

            jQuery(document).on('click', '.js-comment-like', function () {
                var element = jQuery(this),
                    commentId = element.data('val'),
                    rate = element.hasClass('glyphicon-thumbs-up') ? 1 : -1;
                jQuery.ajax({
                    url: "/comment/rate",
                    method: "POST",
                    data: {id: commentId, rate: rate}
                }).done(function (response) {
                    alert('Ваш голос учтен.')
                });

                jQuery('.comment-form').hide();
                jQuery('.js-comment-form-' + jQuery(this).data('val')).show();
                return false;
            });

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









