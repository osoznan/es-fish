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


        echo view('widgets.feedback-panel', [
            'id' => $this->id,
            'comments' => $comments
        ]);
    }

    public static function feedbackPanel(Request $request, array $data) {

        return response()->json(['content' => FeedbackPanel::widget([
            'id' => $data['id']
        ])]);
    }

    public static function addComment(Request $request, array $data) {
        $request = FeedbackCreateRequest::create('/', 'POST', $data);

        Validator::validate($data, $request->rules(), $request->messages());

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
