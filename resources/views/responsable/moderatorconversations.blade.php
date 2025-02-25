@include('layouts.moderatorheader')
<link rel="stylesheet" type="text/css" href="{{ asset('css/moderator/conversations.css') }}">
<section id="conversations">
    <h1>Manage Conversations</h1>
    <div class="conversations-table">
        <h2>All Conversations</h2>
        <table>
            <thead>
                <tr>
                    <th>Message</th>
                    <th>User</th>
                    <th>Article</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="conversations-list">
                @foreach($chats as $chat)
                <tr>
                    <td>{{ $chat->content }}</td>
                    <td>{{ $chat->user->name }}</td>
                    <td>{{ $chat->article->title }}</td>
                    <td>
                        <form action="{{ route('moderator.conversations.destroy', $chat->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-conversation-btn" data-id="{{ $chat->id }}">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-conversation-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            if (!confirm('Are you sure you want to delete this conversation?')) {
                event.preventDefault();
            }
        });
    });
});
</script>
</body>
</html>
