@include('layouts.adminheader')
<link rel="stylesheet" href="{{ asset('css/admin/users.css') }}">
<!-- User Management Section -->
<section id="manage-users">
    <h2>Manage Users</h2>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table class="users-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr data-id="{{ $user->id }}">
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->usertype}}</td>
                    <td class="actions">
                        <form method="POST" action="{{ route('admin.users.switchRole', ['id' => $user->id]) }}" class="switch-role-form">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="edit-btn">Switch Role</button>
                        </form>
                        <form method="POST" action="{{ route('admin.users.destroy', ['id' => $user->id]) }}" class="delete-user-form" >
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn" data-id="{{ $user->id }}" id="remove-user-id" >Delete</button>
                        </form>  
                                       
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</section>

<script src="{{ asset('js/admin/manage-users.js') }}"></script>

</body>
</html>