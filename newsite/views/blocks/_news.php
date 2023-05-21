<?php
/** @var \NewSite\Models\Entities\NewsEntity $news */
?>
<div class="content_container">
    <div class="news_container">
        <h1 class="news_main_title">Новости</h1>
        <?php foreach ($news as $new):?>
            <div class="new_container">
                <div class="news_head">
                    <span class="news_date"><?= $new->getIdate() ?></span><a href="/new/?id=<?=$new->getId()?>"><h4 class="news_title"><?= $new->getTitle() ?></h4></a>
                </div>
                <div class="news_anons">
                    <?= $new->getAnnounce()?>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>
