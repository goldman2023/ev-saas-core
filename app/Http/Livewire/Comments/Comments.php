<?php

namespace App\Http\Livewire\Actions;

use App\Models\SocialComment;
use Livewire\Component;

class Comments extends Component
{
    public $postId;

    public $username;

    public $comment_text;

    public $replyCommentId = null;

    protected $rules = [
        'username' => 'required',
        'comment_text' => 'required',
    ];

    public function render()
    {
        $comments = SocialComment::whereNull('parent_id')
            ->with('replies')
            ->latest()
            ->get();

        return view('livewire.comments', [
            'comments' => $comments,
        ]);
    }

    public function save_comment()
    {
        $this->validate();

        SocialComment::create([
            'post_id' => $this->postId,
            'username' => $this->username,
            'comment_text' => $this->comment_text,
            'parent_id' => $this->replyCommentId,
        ]);

        $this->username = '';
        $this->comment_text = '';
        $this->replyCommentId = null;
    }

    public function reply($commentId)
    {
        $this->replyCommentId = $commentId;
    }
}
