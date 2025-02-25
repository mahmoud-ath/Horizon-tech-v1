<meta name="csrf-token" content="{{ csrf_token() }}">

@php
    $isCurrentUser = auth()->id() === $comment->user->id;
@endphp
<div class="comment {{ $isCurrentUser ? 'current-user-comment' : '' }}">
    @if($comment->parent_id && $comment->parent)
        <p class="comment-author"><strong>{{ $comment->user->name }} -> {{ $comment->parent->user->name }} :</strong></p>
    @else
        <p class="comment-author"><strong>{{ $comment->user->name }} :</strong></p>
    @endif
    <p class="comment-content">{{ $comment->content }}</p>
    <button class="reply-button" data-comment-id="{{ $comment->id }}">Reply</button>
    @if($comment->replies)
        @foreach($comment->replies as $reply)
            @include('partials.comment', ['comment' => $reply])
        @endforeach
    @endif
    <!-- Reply form -->
    <form class="reply-form" data-comment-id="{{ $comment->id }}" style="display: none;">
        <textarea class="reply-text" placeholder="Reply to this comment..."></textarea>
        <button type="submit" class="btn">Publish</button>
    </form>
</div>
