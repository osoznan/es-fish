<?php
/** @var int $id */
/** @var \App\Models\Comment[] $comments */
?>

<div class="feedback__holder">
    <form class="feedback__form row" data-id="<?= $id ?>" onsubmit="return false">
        <div class="col-12 col-lg-3 mb-2">
            <div><?= trans('site.param.name') ?></div>
            <div id="name-error" class="bg-danger text-white"></div>
            <input class="feedback__form_name form-control">
        </div>
        <div class="col-12 col-lg-3 mb-2">
            <div><?= trans('site.param.message') ?></div>
            <div id="text-error" class="bg-danger text-white"></div>
            <textarea class="feedback__form_text form-control"></textarea>
        </div>
        <div class="col-12 col-lg-3">
            <div><?= trans('site.feedback.mark') ?></div>
            <?php foreach ([1, 2, 3, 4, 5] as $num): ?>
                <input type="radio" name="rate" value="<?= $num ?>" id="rating-thumb-<?= $num ?>" <?= $num == 5 ? 'checked' : '' ?>>
                <label class="fw-bold mr-2" for="rating-thumb-<?= $num ?>"><?= $num ?></label>
            <?php endforeach; ?>
        </div>
        <div class="col-12 col-lg-3">
            <div>&nbsp;</div>
            <button class="btn btn-primary" onclick="addComment(<?= $id ?>)"><?= trans('site.feedback.send') ?></button>
        </div>
    </form>
    <div class="feedback__form__result d-none" data-hide=".feedback__form">
        <?= trans('site.feedback.sent') ?>
    </div>

    <div class="feedback__list">
        <?php foreach ($comments as $comment): ?>
        <div class="feedback__comment">
            <div class="feedback__comment__date">{{ $comment->created_at }}</div>
            <div class="feedback__comment__name">{{ $comment->name }}</div>
            <div class="feedback__comment__text">{{ $comment->text }}</div>
            @if ($comment->answer)
                <div class="feedback__comment__answer">
                    <div class="feedback__comment__date">{{ $comment->answer_created_at }}</div>
                    {{ $comment->answer }}
                </div>
            @endif
        </div>
        <?php endforeach; ?>
    </div>
</div>
