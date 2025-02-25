
    @include('layouts.adminheader')
<link rel="stylesheet" href="{{ asset('css/admin/themes.css') }}">
<!-- Manage Themes Section -->
<section id="manage-responsible-themes">
    <h2>Manage Themes</h2>

    <div class="themes-controls">
        <label for="theme-status-filter">Filter by Status:</label>
        <select id="theme-status-filter" name="status" onchange="filterThemes()">
            <option value="all">All Statuses</option>
            <option value="Public">Public</option>
            <option value="Private">Private</option>
        </select>
    </div>
<button type="button" onclick="showModal()">Add New Theme</button>
    <table class="themes-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Responsible</th>
                <th>Articles Count</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="themes-tbody">
            @if(!empty($themes))
            @foreach($themes as $theme)
            <tr data-status="{{ $theme->status }}">
                <td>{{ $theme->name }}</td>
                <td>{{ $theme->user->name ?? 'Unassigned' }}</td>
                <td>{{ $theme->articles_count }}</td>
                <td>{{ $theme->status }}</td>
                <td class="actions">
                    <form method="POST" action="{{ route('updateResponsible', $theme->id) }}">
                        @csrf
                        <select name="new_responsible">
                            <option value="">Unassigned</option>
                            @foreach($moderators as $moderator)
                            <option value="{{ $moderator->id }}" {{ $theme->user_id == $moderator->id ? 'selected' : '' }}>{{ $moderator->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="change-btn">Update Responsible</button>
                    </form>
                    <form method="POST" action="{{ route('toggleStatus', $theme->id) }}">
                        @csrf
                        <button type="submit" class="status-toggle-btn">Toggle Status</button>
                    </form>
                    <form method="POST" action="{{ route('admin.themes.destroy', $theme->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn">Delete Theme</button>
                    </form>
                </td>
            </tr>
            @endforeach
            @else
            <p>No themes found.</p>
            @endif
        </tbody>
    </table>

    

    <!-- Modal -->
    <div id="themeModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <form method="POST" action="{{ route('admin.themes.store') }}" enctype="multipart/form-data">
                @csrf
                <label for="theme_name">Theme Name:</label>
                <input type="text" id="theme_name" name="name" required>

                <label for="theme_description">Description:</label>
                <textarea id="theme_description" name="description" required></textarea>

                <label for="theme_image">Image:</label>
                <input type="file" id="theme_image" name="imagepath" required>

                <label for="theme_responsible">Responsible:</label>
                <select id="theme_responsible" name="user_id">
                    <option value="">Unassigned</option>
                    @foreach($moderators as $moderator)
                    <option value="{{ $moderator->id }}">{{ $moderator->name }}</option>
                    @endforeach
                </select>

                <label for="theme_status">Status:</label>
                <select id="theme_status" name="status">
                    <option value="Public">Public</option>
                    <option value="Private">Private</option>
                </select>

                <button type="submit">Create Theme</button>
            </form>
        </div>
    </div>
</section>


<script src="{{ asset('js/admin/manage-themes.js') }}"></script>

</body>
</html>