@extends('adminlte::page')

@section('title', 'Requests Table')

@section('content_header')
    <h1>Requests Data</h1>
@stop

@section('content')
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Request ID</th>
                <th>User ID</th>
                <th>Provider ID</th>
                <th>Status</th>
                <th>Type</th>
                <th>Priority</th>
                <th>Description</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $request)
                <tr>
                    <td>{{ $request->requestID }}</td>
                    <td>{{ $request->userID }}</td>
                    <td>{{ $request->providerID }}</td>
                    <td>{{ $request->status }}</td>
                    <td>{{ $request->requestType }}</td>
                    <td>{{ $request->priority }}</td>
                    <td>{{ $request->description }}</td>
                    <td>{{ $request->created_at }}</td>
                    <td>{{ $request->updated_at }}</td>
                    <td>
                        <button class="btn btn-primary btn-sm"
                                data-toggle="modal"
                                data-target="#editModal"
                                data-request-id="{{ $request->requestID }}"
                                data-status="{{ $request->status }}"
                                data-priority="{{ $request->priority }}"
                                data-description="{{ $request->description }}">
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
                    <h5 class="modal-title" id="editModalLabel">Edit Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm" method="POST" action="">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        <input type="hidden" id="edit-id" name="requestID">

                        <div class="form-group">
                            <label for="edit-status">Status</label>
                            <input type="text" class="form-control" id="edit-status" name="status" required>
                        </div>

                        <div class="form-group">
                            <label for="edit-priority">Priority</label>
                            <input type="text" class="form-control" id="edit-priority" name="priority" required>
                        </div>

                        <div class="form-group">
                            <label for="edit-description">Description</label>
                            <textarea class="form-control" id="edit-description" name="description"></textarea>
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
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var requestID = button.data('request-id');
            var status = button.data('status');
            var priority = button.data('priority');
            var description = button.data('description');

            $('#edit-id').val(requestID);
            $('#edit-status').val(status);
            $('#edit-priority').val(priority);
            $('#edit-description').val(description);

            var actionUrl = "{{ route('request.update', ['requestID' => ':requestID']) }}";
            actionUrl = actionUrl.replace(':requestID', requestID);
            $('#editForm').attr('action', actionUrl);
        });
    });
</script>
@endpush
