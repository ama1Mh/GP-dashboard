@extends('adminlte::page')

@section('title', 'User Reports')

@section('content_header')
    <h1>User Reports</h1>
@stop

@section('content')
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Report ID</th>
                <th>User ID</th>
                <th>Description</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
                <tr>
                    <td>{{ $report->reportID }}</td>
                    <td>{{ $report->userID }}</td>
                    <td>{{ $report->description }}</td>
                    <td>{{ $report->status }}</td>
                    <td>
                        <button class="btn btn-primary btn-sm"
                                data-toggle="modal"
                                data-target="#editModal"
                                data-report-id="{{ $report->reportID }}"
                                data-status="{{ $report->status }}">
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
                    <h5 class="modal-title" id="editModalLabel">Edit Report</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm" method="POST" action="">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        <input type="hidden" id="edit-id" name="reportID">

                        <div class="form-group">
                            <label for="edit-status">Status</label>
                            <select class="form-control" id="edit-status" name="status" required>
                                <option value="Pending">Pending</option>
                                <option value="Reviewed">Reviewed</option>
                                <option value="Resolved">Resolved</option>
                            </select>
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
            var reportID = button.data('report-id');
            var status = button.data('status');

            $('#edit-id').val(reportID);
            $('#edit-status').val(status);

            var actionUrl = "{{ route('UserReports.update', ['reportID' => ':reportID']) }}";
            actionUrl = actionUrl.replace(':reportID', reportID);
            $('#editForm').attr('action', actionUrl);
        });
    });
</script>
@endpush
