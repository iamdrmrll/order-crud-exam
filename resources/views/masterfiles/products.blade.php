@extends('layouts.app')

@section('title')
    Products |
@endsection

@section('content')
    <div class="m-3">
        <div class="hstack justify-content-between">
            <h1>Products Masterfile</h1>
            <button id="modal_btn" class="align-self-start btn btn-primary">
                <i class="bi bi-box-fill"></i>
                Add Product
            </button>
        </div>
        <table id="table" class="table table-striped table-hover responsive nowrap w-100">
            <thead>
                <th>Product Name</th>
                <th>Product Description</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Status</th>
                <th>Action</th>
            </thead>
        </table>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modal_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal_label"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form" method="POST" action="{{ url('/products') }}" class="mb-0">
                        @csrf
                        @method('POST')
                        <fieldset>
                            <div input-name="PRODUCT NAME" class="form-floating mb-3">
                                <input type="text" name="product_name" class="form-control" id="product_name" placeholder="product_name">
                                <label class="text-secondary" for="product_name">Product Name</label>
                            </div>
                            <div input-name="PRODUCT DESCRIPTION" class="form-floating mb-3">
                                <input type="text" name="product_description" class="form-control" id="product_description" placeholder="product_description">
                                <label class="text-secondary" for="product_description">Product Description</label>
                            </div>
                            <div input-name="QUANTITY" class="form-floating mb-3">
                                <input type="number" min="0" name="quantity" class="form-control" id="quantity" placeholder="quantity">
                                <label class="text-secondary" for="quantity">Quantity</label>
                            </div>
                            <div input-name="PRICE" class="form-floating mb-3">
                                <input type="number" min="1" name="price" class="form-control" id="price" placeholder="price">
                                <label class="text-secondary" for="price">Price</label>
                            </div>
                            <div input-name="STATUS" class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="status" name="status">
                                <label class="form-check-label" for="status">Status</label>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="modal-footer">
                    <button form="form" type="submit" class="btn btn-primary">
                        Save
                    </button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" data-bs-target="#modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            /**
             * ------------------------------------------------
             * Initialize DataTable
             * ------------------------------------------------
             */
            $('table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ $datatable_ajax }}",
                order: [
                    [5, 'desc']
                ],
                columns: [
                    { data: 'product_name', name: 'product_name' },
                    { data: 'product_description', name: 'product_description' },
                    { data: 'formatted_quantity', name: 'formatted_quantity' },
                    { data: 'price', name: 'price' },
                    { data: 'formatted_created_at', name: 'formatted_created_at' },
                    { data: 'formatted_updated_at', name: 'formatted_updated_at' },
                    { data: 'formatted_status', name: 'formatted_status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            /**
             * ------------------------------------------------------------
             * Have the border of warning effect when quantity is zero
             * ------------------------------------------------------------
             */
            function validateQuantity() {
                let quantity = $('#quantity');
                if (parseInt(quantity.val()) == 0) {
                    quantity.addClass('border border-warning');
                } else {
                    quantity.removeClass('border border-warning');
                }
            }
            $(document).on('shown.bs.modal', '#modal', function() {
                validateQuantity();
                $(document).on('change', '#quantity', function() {
                    validateQuantity();
                });
            });
        })
    </script>
@endsection