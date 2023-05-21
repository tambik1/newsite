<?php
/** @var $new object **/
?>
<div class="content_container">
    <div class="news_container">
        <h1 class="news_main_title"><?=$new[0]->getTitle()?></h1>
            <div class="new_container">
                <div class="news_content_detail">
                    <?= $new[0]->getContent()?>
                </div>
                <div class="new_link">
                    <a href="/">Все новости>></a>
                </div>
            </div>
    </div>
</div>