<?php $comment = $this->getParams()->comment; ?>

<div class="row">
    <form class="form-horizontal" method="POST" action="/comment/editpost">
        <div class="col-md-12">
            <div class="form-group">
                <label for="contentComment" class="col-sm-2 control-label">Comment</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="contentComment" name="content"><?php echo $comment['content'] ?></textarea>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="hidden" name="id" value="<?php echo $comment['id'] ?>">
                <button type="submit" class="btn btn-default">Edit comment</button>
            </div>
        </div>
    </form>
</div>