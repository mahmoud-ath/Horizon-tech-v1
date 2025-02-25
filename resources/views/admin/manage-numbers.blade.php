@include('layouts.adminheader')

<link rel="stylesheet" href="{{ asset('css/admin/numbers.css') }}"></head>

 <!-- Manage Numbers Section -->
<section id="manage-numbers">
    <h2>Manage Issues</h2>
    <div class="issues-controls">
        <label for="issue-status-filter">Filter by Status:</label>
        <select id="issue-status-filter" name="status" onchange="filterIssues()">
            <option value="all">All Statuses</option>
            <option value="public">Public</option>
            <option value="private">Private</option>
        </select>
        <button id="add-issue-btn" onclick="showAddIssueModal()">Add Issue</button>
    </div>

    <div class="issues-container">
        @foreach($issues as $issue)
            <div class="issue-box" data-status="{{ $issue->status }}">
                <div class="issue-header">
                    <h3>{{ $issue->name }}</h3>
                    <img src="{{ asset('admin_numbers/' . $issue->imagepath) }}" alt="{{ $issue->name }}" width="50">
                </div>
                <div class="issue-details">
                    
                    <p>Publication Date: {{ $issue->publication_date }}</p>
                    <p>Status: {{ $issue->status }}</p>
                </div>
                <div class="issue-actions">
                    <form id="switchStatusForm-{{ $issue->id }}" action="{{ route('admin.issues.updateStatus', $issue->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="{{ $issue->status === 'public' ? 'private' : 'public' }}">
                        <button type="button" onclick="switchStatus({{ $issue->id }})">Switch Status</button>
                    </form>
                    <form id="deleteIssueForm-{{ $issue->id }}" action="{{ route('admin.issues.destroy', $issue->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="deleteIssue({{ $issue->id }})">Remove</button>
                    </form>
                    <button type="button" onclick="showIssuePage({{ $issue->id }})">View</button>
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- Add Issue Modal -->
<div id="addIssueModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeAddIssueModal()">&times;</span>
        <form action="{{ route('admin.issues.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br>
            <label for="imagepath">Image Path:</label>
            <input type="file" id="imagepath" name="imagepath" required><br>
            <label for="publication_date">Publication Date:</label>
            <input type="text" id="publication_date" name="publication_date" value="{{ date('Y-m-d') }}" readonly><br>
            <label for="status">Status:</label>
            <select id="status" name="status">
                <option value="public">Public</option>
                <option value="private">Private</option>
            </select><br>
            <button type="submit">Add Issue</button>
        </form>
    </div>
</div>

<script src="{{ asset('js/admin/manage-numbers.js') }}"></script>

</body>
</html>