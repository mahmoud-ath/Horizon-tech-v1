@include('layouts.moderatorheader')
<link rel="stylesheet" type="text/css" href="{{ asset('css/moderator/subscribers.css') }}">
<!-- Manage Subscribers Section -->
<section id="subscribers">
    <h1>Manage Subscribers</h1>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="subscribers-table">
        <table>
            <thead>
                <tr>
                    <th>Full name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="subscribers-list">
                @foreach($subscribers as $subscriber)
                    <tr>
                        <td>{{ $subscriber->user->name }}</td>
                        <td>{{ $subscriber->user->email }}</td>
                        <td>
                            <form action="{{ route('moderator.subscribers.destroy', ['id' => $subscriber->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn" data-id="{{ $subscriber->id }}">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
<script src="{{ asset('js/moderator/subscribers.js') }}"></script>
</body>
</html>
