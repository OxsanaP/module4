<?php $comments = $this->getParams()->comments; ?>
<?php if (isset($comments) && count($comments) > 0) : ?>
    <?php foreach ($comments as $value) : ?>
        <div class="row news">
            <div class="col-md-12"><?php echo $value['content'] ?></div>
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
        <div class="col-md-12">Комментариев нет</div>
    </div>
<?php endif; ?>

