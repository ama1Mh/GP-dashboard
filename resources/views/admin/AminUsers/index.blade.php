@extends('adminlte::page')

@section('title', 'User Table')

@section('content_header')
    <h1>User Data</h1>
@stop

@section('content')
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email Verified At</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->userID }}</td> 
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email_verified_at ? $user->email_verified_at->format('Y-m-d H:i') : 'Not Verified' }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <!-- Edit Button -->
                        <button class="btn btn-primary btn-sm"
                                data-toggle="modal"
                                data-target="#editModal"
                                data-user-id="{{ $user->userID }}"
                                data-name="{{ $user->name }}"
                                data-email="{{ $user->email }}">
                            Edit
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm" method="POST" action="">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        <!-- Hidden input to hold the userID -->
                        <input type="hidden" id="edit-id" name="userID">

                        <div class="form-group">
                            <label for="edit-name">Name</label>
                            <input type="text" class="form-control" id="edit-name" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="edit-email">Email</label>
                            <input type="email" class="form-control" id="edit-email" name="email" required>
                        </div>

                        <div class="form-group">
                            <label for="edit-password">Password</label>
                            <input type="password" class="form-control" id="edit-password" name="password">
                            <small>If you want to change the password, enter it here.</small>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@push('js')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Handle edit button click
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var userID = button.data('user-id');
            var name = button.data('name');
            var email = button.data('email');

            // Set values in the modal
            $('#edit-id').val(userID);
            $('#edit-name').val(name);
            $('#edit-email').val(email);

            // Set the form action dynamically
            var actionUrl = "{{ route('aminuser.update', ['userID' => ':userID']) }}";
            actionUrl = actionUrl.replace(':userID', userID); // Replace placeholder with actual userID
            $('#editForm').attr('action', actionUrl);
        });
    });
</script>
@endpush
