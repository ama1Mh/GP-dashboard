@extends('adminlte::page')

@section('title', 'Items Management')

@section('content_header')
    <h1>Manage Items</h1>
@stop

@section('content')
    <div class="row">
        <!-- Total Items Card -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Total Number of Items</h3>
                </div>
                <div class="card-body">
                    <h2>{{ $totalItems }}</h2>
                </div>
            </div>
        </div>

        <!-- Categories Card -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Categories</h3>
                </div>
                <div class="card-body">
                    <ul>
                        @foreach($categoryCounts as $category => $count)
                            <h2>{{ $category }} {{ $count }} category</h2>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Items Chart</h3>
                </div>
                <div class="card-body">
                    <canvas id="itemsChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Table Section -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Items Table</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>
                                        <!-- Edit Button -->
                                        <button class="btn btn-primary btn-sm"
                                            data-toggle="modal"
                                            data-target="#editModal"
                                            data-id="{{ $item->id }}"
                                            data-title="{{ $item->title }}"
                                            data-description="{{ $item->description }}"
                                            data-quantity="{{ $item->quantity }}">
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm" method="POST" action="{{ route('items.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="edit-id" name="id">
                       
                        <div class="form-group">
                            <label for="edit-title">Title</label>
                            <input type="text" class="form-control" id="edit-title" name="title" required>
                        </div>

                        <div class="form-group">
                            <label for="edit-description">Description</label>
                            <textarea class="form-control" id="edit-description" name="description" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="edit-quantity">Quantity</label>
                            <input type="number" class="form-control" id="edit-quantity" name="quantity" required>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var ctx = document.getElementById('itemsChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: 'Quantity',
                    data: {!! json_encode($values) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Handle edit button click
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var title = button.data('title');
            var description = button.data('description');
            var quantity = button.data('quantity');

            $('#edit-id').val(id);
            $('#edit-title').val(title);
            $('#edit-description').val(description);
            $('#edit-quantity').val(quantity);
        });
    });
</script>
@endpush
