@include('layouts.adminheader')
<link rel="stylesheet" href="{{ asset('css/message_modal.css') }}">
<main class="admin-page container">
    <h1>Admin Messages</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($messages as $message)
                <tr>
                    <td>{{ $message->name }}</td>
                    <td>{{ $message->email }}</td>
                    <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                    <td><button class="btn view-btn" data-message="{{ $message->message }}">View</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</main>

<div id="messageModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Message</h5>
                <button type="button" class="close close-btn">&times;</button>
            </div>
            <div class="modal-body">
                <p id="modalMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn cancel-btn">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/message_modal.js') }}"></script>
</body>
</html>
