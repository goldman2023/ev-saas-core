<div>
    <h3 class="text-2xl mb-2">Comments</h3>
    @forelse ($comments as $comment)
        <div style="margin-bottom: 10px">
            <b>{{ $comment->username }} ({{ $comment->created_at->diffForHumans() }})</b>
            <br/>
            {{ $comment->comment_text }}
            <br/>
            <a wire:click.prevent="reply({{ $comment->id }})" href="#" style="text-decoration: underline; font-size: 12px">Reply
                to this comment</a>
        </div>
        @foreach ($comment->replies as $reply)
            <div style="padding-left: 30px; margin-bottom: 10px">
                <b>{{ $reply->username }} ({{ $reply->created_at->diffForHumans() }})</b>
                <br/>
                {{ $reply->comment_text }}
            </div>
        @endforeach
    @empty
        No comments yet.
    @endforelse
    <hr/>
    <h3 class="text-xl mt-2 mb-2">{{ is_null($replyCommentId) ? 'Add a comment' : 'Reply to a comment' }}</h3>
    <form wire:submit.prevent="save_comment">
        <div>
            <label class="block font-medium text-sm text-gray-700" for="username">
                Username*
            </label>
            <input wire:model.defer="username" type="text"
                   class="mt-2 text-sm sm:text-base pl-2 pr-4 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-blue-400" />
            @error('username')
            <div style="color: red; font-size: 12px">{{ $message }}</div>
            @enderror
        </div>
        <div class="mt-2 mb-2">
            <label class="block font-medium text-sm text-gray-700" for="comment_text">
                Comment text*
            </label>
            <textarea wire:model.defer="comment_text" rows="3"
                      class="mt-2 text-sm sm:text-base pl-2 pr-4 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-blue-400"></textarea>
            @error('comment_text')
            <div style="color: red; font-size: 12px">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
            Post Comment
        </button>
    </form>
</div>
