@extends('backend.layouts.app')

@section('title', 'Product List')

@section('content')
<div class="container-fluid" style="padding: 25px 40px; background-color: #f9f9f9; min-height: 100vh;">

    {{-- Header --}}
    <div class="row align-items-center mb-4">
        <div class="col-md-7">
            <h2 style="font-weight:800; color:#111; font-size:32px;">Product Directory</h2>
            <p style="color:#666; font-size:15px;">
                Monitor and manage your products efficiently.
            </p>
        </div>
        <div class="col-md-5 text-md-end">
            <a href="{{ route('product.create') }}"
               class="btn btn-success shadow-sm"
               style="border-radius:12px; padding:12px 30px; font-weight:600;">
                <i class="fas fa-plus-circle me-2"></i> Add New Product
            </a>
        </div>
    </div>

    {{-- Card --}}
    <div class="card border-0 shadow-sm"
         style="border-radius:20px; overflow:hidden; background:#fff;">

        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="productTable"
                       class="table table-hover align-middle w-100">
                    <thead style="background:#fcfcfc;">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th class="pe-4 text-center" width="160">Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(function () {
    let table = $('#productTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("product.datatable") }}',
        order: [[0, 'desc']],
        columns: [
            { data: 'id', name: 'id', className: 'ps-4 fw-bold text-muted' },
            { data: 'thumbnail', name: 'thumbnail', orderable:false, searchable:false },
            { data: 'name', name: 'name', className:'fw-bold' },
            { data: 'price', name: 'price' },
            { data: 'stock', name: 'stock' },
            { data: 'status', name: 'status' },
            { data: 'actions', name: 'actions', orderable:false, searchable:false, className:'text-center pe-4' },
        ],
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        language: {
            search: "",
            searchPlaceholder: "Search product...",
            processing: '<div class="spinner-border text-success"></div>'
        },
        drawCallback: function () {
            $('#productTable tbody td').css({
                'padding-top':'20px',
                'padding-bottom':'20px',
                'border-bottom':'1px solid #f8f8f8'
            });
            $('[data-bs-toggle="tooltip"]').tooltip();
        }
    });

    $('.dataTables_filter input').css({
        'border':'1px solid #ddd',
        'border-radius':'10px',
        'padding':'8px 15px',
        'width':'300px'
    });
});
</script>
@endpush
