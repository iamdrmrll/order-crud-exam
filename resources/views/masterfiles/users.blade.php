@extends('layouts.app')

@section('title')
    Users |
@endsection

@section('content')
    <div class="m-3">
        <div class="hstack justify-content-between">
            <h1>Users Masterfile</h1>
            <button id="modal_btn" class="align-self-start btn btn-primary">
                <i class="bi bi-person-fill"></i>
                Add User
            </button>
        </div>
        <table id="table" class="table table-striped table-hover responsive nowrap w-100">
            <thead>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email Address</th>
                <th>Mobile Number</th>
                <th>Address</th>
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
                    <form id="form" method="POST" action="{{ url('/users') }}" class="mb-0">
                        @csrf
                        @method('POST')
                        <fieldset>
                            <div input-name="FIRST NAME" class="form-floating mb-3">
                                <input type="text" name="first_name" class="form-control" id="first_name" placeholder="first_name">
                                <label class="text-secondary" for="first_name">First Name</label>
                            </div>
                            <div input-name="LAST NAME" class="form-floating mb-3">
                                <input type="text" name="last_name" class="form-control" id="last_name" placeholder="last_name">
                                <label class="text-secondary" for="last_name">Last Name</label>
                            </div>
                            <div input-name="EMAIL ADDRESS" class="form-floating mb-3">
                                <input type="email" name="email_address" class="form-control" id="email_address" placeholder="email_address">
                                <label class="text-secondary" for="email_address">Email Address</label>
                            </div>
                            <div input-name="MOBILE NUMBER" class="form-floating mb-3">
                                <input type="tel" name="mobile_number" class="form-control" id="mobile_number" placeholder="mobile_number">
                                <label class="text-secondary" for="mobile_number">Mobile Number</label>
                            </div>
                            <div input-name="ADDRESS" class="form-floating mb-3">
                                <input type="text" name="address" class="form-control" id="address" placeholder="address">
                                <label class="text-secondary" for="address">Address</label>
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
                    [6, 'desc']
                ],
                columns: [
                    { data: 'first_name', name: 'first_name' },
                    { data: 'last_name', name: 'last_name' },
                    { data: 'email_address', name: 'email_address' },
                    { data: 'mobile_number', name: 'mobile_number' },
                    { data: 'address', name: 'address' },
                    { data: 'formatted_created_at', name: 'formatted_created_at' },
                    { data: 'formatted_updated_at', name: 'formatted_updated_at' },
                    { data: 'formatted_status', name: 'formatted_status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
        })
    </script>
@endsection