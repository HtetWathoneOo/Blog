<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function create()
    {
        $comment = new Comment;
        $comment->content = request()->content;
        $comment->article_id = request()->article_id;
        $comment->user_id = auth()->user()->id;
        $comment->save();

        return back();
    }
    public function delete($id)
    {
        $comment = Comment::find($id);

        if(Gate::denies('comment-delete', $comment)) {
            return back()->with('error', 'Unauthorize');
        }

        $comment->delete();
        return back();
    }
    public function _construct()
    {
        $this->middleware('auth');
    }
}
