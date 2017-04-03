<?php if (isset($this->getParams()->advanced)) : ?>
<?php $advanced = $this->getParams()->advanced; ?>
    <div class="row news">
        <div class="col-md-12"><h4>Filtered by:</h4></div>
    </div>
    <?php if (!empty($advanced['start'])) : ?>
        <div class="row news">
            <div class="col-md-12"><strong>From: </strong><?php echo $advanced['start']?></div>
        </div>
    <?php endif; ?>
    <?php if (!empty($advanced['end'])) : ?>
        <div class="row news">
            <div class="col-md-12"><strong>To: </strong><?php echo $advanced['end']?></div>
        </div>
    <?php endif; ?>
    <?php if (!empty($advanced['category'])) : ?>
        <div class="row news">
            <div class="col-md-12"><strong>By category: </strong><?php echo $advanced['category']?></div>
        </div>
    <?php endif; ?>
    <?php if (!empty($advanced['tags'])) : ?>
        <div class="row news">
            <div class="col-md-12"><strong>By tags: </strong><?php echo $advanced['tags']?></div>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php $news = $this->getParams()->news; ?>
<?php if (isset($news) && count($news) > 0) : ?>
    <?php foreach ($news as $value) : ?>
        <div class="row news">
            <div class="col-md-12"><a href="/news?id=<?php echo $value['id'] ?>"><?php echo $this->upperFirstLetter($value['title']) ?></a></div>
        </div>
    <?php endforeach; ?>
    <?php $paginator = $this->getParams()->paginator; ?>
    <?php if ($paginator["count"] > 5) : ?>
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li <?php echo ($paginator["curPage"] == 1) ? 'class="disabled"' : "" ?>>
                    <a href="<?php echo ($paginator["curPage"] == 1) ? '' : $paginator["url"] . ($paginator["curPage"]-1) ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php
                    $start = $paginator["curPage"];
                    if($start>2){
                        $start = $start-2;
                    } else if($start>1){
                        $start = $start-1;
                    }
                ?>
                <?php for ($i = $start; $i <= $paginator["countPages"]; $i++): ?>
                    <li <?php echo ($i == $paginator["curPage"]) ? 'class="active"' : "" ?>>
                        <a href="<?php echo $paginator["url"] . $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor ?>
                <li <?php echo ($paginator["curPage"] == $paginator["countPages"]) ? 'class="disabled"' : "" ?>>
                    <a href="<?php echo ($paginator["curPage"] == $paginator["countPages"]) ? '' : $paginator["url"] . ($paginator["curPage"]+1) ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    <?php endif; ?>
<?php else : ?>
    <div class="row">
        <div class="col-md-12">Новостей пока нет</div>
    </div>
<?php endif; ?>

