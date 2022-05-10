<?php

namespace App\Http\Livewire\Actions;

use App\Traits\Livewire\WithCursorPagination;
use App\Models\SocialComment;
use Illuminate\Pagination\Cursor;
use Livewire\Component;
use App\Models\Activity;

class SocialComments extends Component
{
    use WithCursorPagination;

    public $postId;

    public $username;

    public $comments; // Comments

    public $comment_text;

    public $replyCommentId = null;

    public $item; // Activity

    public $include_reviews;

    protected $rules = [
        'comment_text' => 'required',
    ];

    protected function messages() { 
        return [
            'comment_text.required' => translate('Comment cannot be empty...'),
        ];
    }

    public function mount($item, $include_reviews = false)
    {
        $this->item = $item;
        $this->include_reviews = $include_reviews;
        $this->comments = new \Illuminate\Database\Eloquent\Collection();

        $this->perPage = 5;
        $this->loadComments();
    }

    public function loadComments() {
        if ($this->hasMorePages !== null  && ! $this->hasMorePages) {
            return;
        }

        $comments = SocialComment::whereNull('parent_id')
            ->with('replies')
            ->with('user')
            ->where('subject_id', $this->item->id)
            ->where('subject_type', $this->item::class)
            ->orderBy('id', 'desc');

        if ($this->include_reviews) {
            $comments = $comments->whereNotNull('rating');
        }

        $comments = $comments->cursorPaginate($this->perPage, ['*'], 'cursor', Cursor::fromEncoded($this->nextCursor));

        $this->comments->push(...$comments->items()); // Append paginated comments to `public $this->comments`
        $this->prepareNextPage($comments);
    }

    public function render()
    {
        return view('livewire.actions.social-comments');
    }

    public function save_comment()
    {
        $this->validate();

        // $item_id = $this->item->id;
        // $item_subject = $this->item::class;
        // if($this->item instanceof Activity) {
        //     $item_id = $this->item->id;
        //     $item_subject =$this->item->subject::class;
        // }

        // IMPORTANT: On Social Feed you can only comment to Activity or SocialPost!
        $new_comment = SocialComment::create([
            'subject_id' => $this->item->id,
            'subject_type' => $this->item::class,
            'user_id' => auth()->user()->id,
            'comment_text' => $this->comment_text,
            'parent_id' => $this->replyCommentId,
        ]);

        $this->comments->prepend($new_comment);

        $this->comment_text = '';
        $this->replyCommentId = null;

        $this->dispatchBrowserEvent('change-activity-comment-count', ['item_id' => $this->item->id]);
    }

    public function reply($commentId)
    {
        $this->replyCommentId = $commentId;
    }
}
