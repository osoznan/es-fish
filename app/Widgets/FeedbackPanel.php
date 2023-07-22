<?php

namespace App\Widgets;

use App\Components\ProductManager;
use App\Components\Widget;
use App\Http\Requests\FeedbackCreateRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeedbackPanel extends Widget {

    use AjaxWidget;

    public $id;

    public static function getAjaxHandlers() {
        return ['feedbackPanel', 'addComment'];
    }

    public function run() {
        $comments = Comment::searchActive()
            ->where('product_id', $this->id)
            ->get();

        ob_start();
        ?>
        <div class="feedback__holder">
            <form class="feedback__form row" data-id="<?= $this->id ?>" onsubmit="return false">
                <div class="col-12 col-lg-3 mb-2">
                    <div><?= trans('site.param.name') ?></div>
                    <div id="name-error" class="bg-danger"></div>
                    <input class="feedback__form_name form-control">
                </div>
                <div class="col-12 col-lg-3 mb-2">
                    <div><?= trans('site.param.message') ?></div>
                    <div id="text-error" class="bg-danger"></div>
                    <textarea class="feedback__form_text form-control"></textarea>
                </div>
                <div class="col-12 col-lg-2">
                    <div><?= trans('site.feedback.mark') ?></div>
                    <?php foreach ([1, 2, 3, 4, 5] as $num): ?>
                        <input type="radio" name="rate" value="<?= $num ?>" id="rating-thumb-<?= $num ?>" <?= $num == 5 ? 'checked' : '' ?>><label class="fw-bold mr-2" for="rating-thumb-<?= $num ?>"><?= $num ?>
                    <?php endforeach; ?>
                </div>
                <div class="col-12 col-lg-3">
                    <div>&nbsp;</div>
                    <button class="btn btn-primary" onclick="addComment(<?= $this->id ?>)"><?= trans('site.feedback.send') ?></button>
                </div>
            </form>
            <div class="feedback__form__result d-none" data-hide=".feedback__form">
                <?= trans('site.feedback.sent') ?>
            </div>

            <div class="feedback__list">
                <?php foreach ($comments as $comment): ?>
                    <div class="feedback__comment">
                        <div class="feedback__comment__date"><?= $comment->created_at ?></div>
                        <div class="feedback__comment__name"><?= $comment->name ?></div>
                        <div class="feedback_comment_text"><?= $comment->text ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    <?php
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

    public static function feedbackPanel(Request $request, array $data) {

        return response()->json(['content' => (new FeedbackPanel([
            'id' => $data['id']
        ]))->run()]);
    }

    public static function addComment(Request $request, array $data) {
        $request = FeedbackCreateRequest::create('/', 'POST', $data);

        Validator::validate($data, (new FeedbackCreateRequest)->rules());

        $comment = new Comment();
        $comment->product_id = $data['product_id'];
        $comment->name = $data['name'];
        $comment->text = $data['text'];
        $comment->rate = $data['rate'];
        $comment->hidden = 1;

        $comment->save();

        $rate = ProductManager::calculateRate($comment->product_id);

        $comment->product->rating = floor($rate);
        $comment->product->save();

        return response()->json(['content' => true]);
    }

}
