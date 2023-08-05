<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackCreateRequest;
use App\Models\Comment;

class FeedbackController extends TopController
{

    public function create(FeedbackCreateRequest $request)
    {
        $comment = new Comment();

        /*    $validator = Validator::make($request->all(), [
                'name' => 'required|max:50',
                'text' => 'required|min:50',
                'rate' => 'required|min:1|max:5',
                'answer' => 'min:50',
                'product_id' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 404);
            }*/

        $comment->product_id = $request->product_id;
        $comment->name = $request->name;
        $comment->text = $request->text;
        $comment->rate = $request->rate;
        $comment->hidden = $request->hidden;

        if ($comment->save()) {
            return 1;
        }
    }
}
