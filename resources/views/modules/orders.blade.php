@extends('layouts.app')

@section('title')
    Orders |
@endsection

@section('content')
    <div class="m-3">
        <div class="hstack justify-content-between">
            <h1>Orders</h1>
            <button id="modal_btn" class="align-self-start btn btn-primary">
                <i class="bi bi-cart-fill"></i>
                Add Order
            </button>
        </div>
        <table id="table" class="table table-striped table-hover responsive nowrap w-100">
            <thead>
                <th>Product Name</th>
                <th>User's Name</th>
                <th>Price</th>
                <th>Created At</th>
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
                    <form id="form" method="POST" action="{{ url('/orders') }}" class="mb-0">
                        @csrf
                        @method('POST')
                        <fieldset>
                            <div input-name="PRODUCT NAME" class="form-floating mb-3">
                                <select class="form-select" name="product_id" id="product_id" aria-label="product_id" data-list="{{ route('products.dataList') }}">
                                    <option disabled selected>Click to see options</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                    @endforeach
                                </select>
                                <label for="product_id">Product Name</label>
                            </div>
                            <div input-name="USER'S NAME" class="form-floating mb-3">
                                <select class="form-select" name="user_id" id="user_id" aria-label="user_id" data-list="{{ route('users.dataList') }}">
                                    <option selected disabled>Click to see options</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                                    @endforeach
                                </select>
                                <label for="user_id">User's Name</label>
                            </div>
                            <div input-name="PRICE" class="form-floating mb-3">
                                <input type="text" readonly class="form-control-plaintext" id="price" placeholder="price" value="--">
                                <label class="text-secondary" for="price">Price</label>
                            </div>
                            <div input-name="QUANTITY" class="form-floating mb-3">
                                <input type="text" readonly class="form-control-plaintext" id="quantity" placeholder="quantity" value="--">
                                <label class="text-secondary" for="quantity">Quantity</label>
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
                [3, 'desc']
            ],
            columns: [
                { data: 'formatted_product_id', name: 'formatted_product_id' },
                { data: 'formatted_user_id', name: 'formatted_user_id' },
                { data: 'price', name: 'price' },
                { data: 'formatted_created_at', name: 'formatted_created_at' },
            ]
        });

        /**
         * ----------------------------------------------------------------
         * Get the quantity
         * ----------------------------------------------------------------
         */
        $(document).on('change', 'select#product_id', function() {
            let price    = $('#price');
            let quantity = $('#quantity');
            let id       = $(this).val();
            let url      = `/products/${id}`;
            $.ajax({
                url,
                method: 'GET',
                success: (res) => {
                    price.val(res.price);
                    quantity.val(res.quantity);
                    if (!res.quantity) {
                        quantity.addClass('text-danger');
                        $(this).addClass('is-invalid');
                    } else {
                        quantity.removeClass('text-danger');
                        $(this).removeClass('is-invalid');
                    }
                }
            })
        })
    })
</script>
@endsection