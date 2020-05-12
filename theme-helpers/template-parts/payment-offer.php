<?php
switch ($key) {
    case 0:
        $color = 'mainSche';
        break;
    case 1:
        $color = 'warning';
        break;
    case 2:
        $color = 'peach';
        break;
}
$lesson_price = round($offer['price'] / $offer['count'], -1);

$discount = 100 -(($lesson_price * 100)/$default_price);
?>

<div class="col-4">
    <div class="card top_rounded bottom_rounded p-4 shadow-lg">
        <div class="row">
            <div class="col-8">
                <p class="mb-1 h6">Пакет из</p>
                <p class="h4 mb-1"><?= $offer['count'];?> занятий</p>
                <p class="text-muted smaller"> из них <?= $offer['count'] / 4 ?> с учителем</p>
            </div>
            <div class="col-4 pl-0 priceImg">
                <img src="/wp-content/themes/scheduler_mvp/img/price_<?= $key; ?>.png?>"
                    class="mw-100 rounded-image border-<?= $color?>" alt="">
                <?php if($discount != 0){ ?>
                <p class="smaller text-center p-1 bg-<?= $color; ?>">Скидка <?= $discount; ?>%!</p>
                <?php } ?>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-8">
                <p class="h2 text-<?= $color;?>"><?= $offer['price']; ?> ₽</p>
            </div>
            <div class="col-4">
                <p class="mb-0 h6"><?= $lesson_price;?> ₽</p>
                <p class="smaller">за занятие</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <a href="javascript:void(0)" class="btn btn-primary btn-round py-2 px-4">
                    Buy lessons!
                </a>
            </div>
        </div>
    </div>
</div>