@extends('adminlte::page')

@section('title', 'Service Providers')

@section('content_header')
    <h1>Service Providers</h1>
@stop

@section('content')
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Provider ID</th>
                <th>Name</th>
                <th>Service Type</th>
                <th>Contact Info</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($serviceProviders as $provider)
                <tr>
                    <td>{{ $provider->providerID }}</td>
                    <td>{{ $provider->name }}</td>
                    <td>{{ $provider->service_type }}</td>
                    <td>{{ $provider->contact_info ?? 'Not Provided' }}</td>
                    <td>
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal"
                                data-provider-id="{{ $provider->providerID }}"
                                data-name="{{ $provider->name }}"
                                data-service-type="{{ $provider->service_type }}"
                                data-contact-info="{{ $provider->contact_info }}">
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
                    <h5 class="modal-title" id="editModalLabel">Edit Service Provider</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm" method="POST" action="">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        <input type="hidden" id="edit-id" name="providerID">

                        <div class="form-group">
                            <label for="edit-name">Name</label>
                            <input type="text" class="form-control" id="edit-name" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="edit-service-type">Service Type</label>
                            <input type="text" class="form-control" id="edit-service-type" name="service_type" required>
                        </div>

                        <div class="form-group">
                            <label for="edit-contact-info">Contact Info</label>
                            <input type="text" class="form-control" id="edit-contact-info" name="contact_info">
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
            var providerID = button.data('provider-id');
            var name = button.data('name');
            var serviceType = button.data('service-type');
            var contactInfo = button.data('contact-info');

            // Set values in the modal
            $('#edit-id').val(providerID);
            $('#edit-name').val(name);
            $('#edit-service-type').val(serviceType);
            $('#edit-contact-info').val(contactInfo);

            // Set the form action dynamically
            var actionUrl = "{{ route('service-providers.update', ['providerID' => ':providerID']) }}";
            actionUrl = actionUrl.replace(':providerID', providerID);
            $('#editForm').attr('action', actionUrl);
        });
    });
</script>
@endpush
