<?php

?>

<div class="column">
    <div class="blog-post-item">
        <div class="photo">
            <a href="<?=$model->url?>">
                <img src="<?=$model->photo->url?>" alt="Dragcards" />
            </a>
        </div>
        <div class="date">
            <div class="icon"><img src="/img/dragcards/blog/calendar-dark.svg" alt="Dragcards" /></div>
            <div class="text"><?=$model->publikalas_datuma?></div>
        </div>
        <div class="title">
            <a href="<?=$model->url?>"><?=$model->cim?></a>
        </div>
        <div class="read-more-row">
            <a href="<?=$model->url?>">Tovább olvasom</a>
        </div>
    </div>
</div>