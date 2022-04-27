<?php

namespace App\Http\Livewire\Actions;

use App\Models\SocialComment;
use Livewire\Component;

class SocialComments extends Component
{
    public $postId;

    public $username;

    public $comment_text;

    public $replyCommentId = null;

    public $item;

    public $reviews;

    protected $rules = [
        'comment_text' => 'required',
    ];

    public function mount($item, $reviews = false)
    {
        $this->item = $item;
        $this->reviews = $reviews;
    }

    public function render()
    {
        /* TODO: Add pagination for comments */
        $comments = SocialComment::whereNull('parent_id')
            ->with('replies')
            ->with('user')
            ->where('subject_id', $this->item->subject->id)
            ->where('subject_type', $this->item->subject::class)
            ->take(5)
            ->latest();

        if ($this->reviews) {
            $comments->whereNotNull('rating');
        }

        $comments = $comments->get();

        return view('livewire.actions.social-comments', [
            'comments' => $comments,
        ]);
    }

    public function save_comment()
    {
        $this->validate();

        SocialComment::create([
            'subject_id' => $this->item->subject->id,
            'subject_type' => $this->item->subject::class,
            'user_id' => auth()->user()->id,
            'comment_text' => $this->comment_text,
            'parent_id' => $this->replyCommentId,
        ]);

        $this->comment_text = '';
        $this->replyCommentId = null;

        $this->dispatchBrowserEvent('change-activity-comment-count', ['item_id' => $this->item->id]);
    }

    public function reply($commentId)
    {
        $this->replyCommentId = $commentId;
    }
}
