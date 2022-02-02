@extends('layouts.admin')

@section('page_title') Order @endsection

@section('content')
<div class="page-heading">
    <h2 class="page-title"> Order - #{{ $order->id }} ({{ $order->status }}) 
        @if (!$order->isDealCheckout())
        <span class="badge badge-primary">Deal Checkout</span>
        @endif
    </h2>
</div>

@include('admin.section.notifications')
<div class="ibox-body" id="validation-errors">
    <div class="row">
        <div class="col-md-8" id="get__print">
            <div class="card">
                <div class="card-body">
                    {{-- <h6 class="h6-responsive">Order Details</h6> --}}
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>Product Title</th>
                                <th></th>
                                <th>Shipping</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->packages as $package)
                            <tr>
                                <td colspan="42" class="bg-light">
                                    <div class="d-flex">
                                        <div>Pakage {{ $loop->iteration }} - Sold by STORE NAME HERE</div>
                                        <div class="ml-auto">
                                            <div class="badge badge-primary">
                                                {{ $package->status }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @foreach($package->orderLists as $orderList)
                            <tr>
                                <td id="product_title">
                                    <div>{{ $orderList->product_name }}</div>
                                    <div class="d-flex">
                                        @if (auth()->user()->hasRole('vendor'))
                                        <div class="badge badge-primary changeStatus" data-status="{{$orderList->status}}" data-order_id="{{$orderList->id}}">
                                            {{ $orderList->order_status }}
                                        </div>
                                        @else
                                        <div class="badge badge-primary">{{ $orderList->order_status }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-nowrap">{{ formatted_price($orderList->unit_price) }} x {{ $orderList->quantity }} = {{ formatted_price($orderList->subtotal_price) }}</td>
                                <td>{{ formatted_price($orderList->shipping_charge) }}</td>
                                <td class="text-nowrap">{{ formatted_price($orderList->total_price) }}</td>
                            </tr>
                            @endforeach
                            @endforeach
                            <tr>
                                <td colspan="2"></td>
                                <td class="">Subtotal</td>
                                <td>{{ formatted_price($subTotalPrice) }}</td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td class="">Shipping</td>
                                <td>{{ formatted_price($totalShippingPrice) }}</td>
                            </tr>
                            <tr class="font-weight-bold">
                                <td colspan="2"></td>
                                <td class="text-primary">Order Total</td>
                                <td class="text-primary text-nowrap">
                                    <div>{{ formatted_price($totalPrice) }}</div>
                                    <div class="{{ $order->payment_status == 'paid' ? 'bg-success' : 'bg-danger' }} text-white font-weight-normal p-2 rounded text-center">{{ $order->payment_status == 'paid' ? 'Paid' : 'Unpaid' }}</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Customer address --}}
            <div class="row mt-3">
                <div class="col-md-6">
                    @include('order::address-box', ['title' => 'Billing Address', 'address' => $order->billingAddress])
                </div>
                <div class="col-md-6">
                    @include('order::address-box', ['title' => 'Shipping Address', 'address' => $order->shippingAddress])
                </div>
            </div>

        </div>
        <div class="col-md-4">
            @if (auth()->user()->hasRole('vendor'))
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('orders.package.update', $package) }}" class="form" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Order Status</label>
                            <select name="status" class="custom-select form-control @error('status') is-invalid @enderror">
                                @foreach (config('constants.package_statuses') as $status)
                                <option value="{{ $status }}" @if (old('status', $package->status) == $status) selected @endif>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                            @error('status')
                            <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="update_silently" class="form-check=-input" value="1">
                                <span>Do not notify customer</span>
                            </label>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-block">Update Order</button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="my-5"></div>

    <button class="btn btn-sm print__button btn-primary">Print</button>
</div>
<!-- Modal -->
@include('dashboard::admin.modals.orderstatusmodal')
<div class="modal" id="popupModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="popup-modal-title" class="modal-title">
                    </h5>
            </div>
            <div class="modal-body">
                <div style="text-align: center;" id="popup-modal-body"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

<script src="/assets/admin/js/printThis.js"></script>
<script src="{{asset('/assets/admin/js/sweetalert.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $('.print__button').click(function() {
        $("#get__print").printThis({
            header: null
            , footer: null
        , });
    });

</script>
<script>
    function FailedResponseFromDatabase(message) {
        html_error = "";
        $.each(message, function(index, message) {
            html_error += '<p class ="error_message text-left"> <span class="fa fa-times"></span> ' + message + '</p>';
        });
        Swal.fire({
            type: 'error'
            , title: 'Oops...'
            , html: html_error
            , confirmButtonText: 'Close'
            , timer: 10000
        });
    }

    function DataSuccessInDatabase(message) {
        Swal.fire({
            // position: 'top-end',
            type: 'success'
            , title: 'Done'
            , html: message
            , confirmButtonText: 'Close'
            , timer: 10000
        });
    }

</script>
<script>
    $(document).ready(function() {
        $('body').on('click', '.changeStatus', function(e) {
            var order_id = $(this).data('order_id');
            $('#orderStatusModal').modal('show');

            $('#submitOrderStatus').on('click', function() {
                var status = $('#order_status').val();
                $.ajax({
                    url: "/api/updateorderstatus"
                    , type: "POST"
                    , data: {
                        "_token": "{{ csrf_token() }}"
                        , order_id: order_id
                        , status: status
                    , }
                    , success: function(response) {
                        if (response.status == 'successful') {
                            $('#orderStatusModal').modal('hide');
                            DataSuccessInDatabase(response.message);
                            location.reload();
                        }
                    }
                });
            });
        })
    });

    $(document).ready(function(e) {
        $('#order-update-form').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('id', id);
            $.ajax({
                type: 'POST'
                , url: "/api/updateorder"
                , data: formData
                , enctype: 'multipart/form-data'
                , cache: false
                , contentType: false
                , processData: false
                , headers: {
                    Authorization: "Bearer " + api_token
                }
                , success: function(response) {
                    if (response.status == 'successful') {
                        window.location.href = "/admin/order";
                        var validation_errors = JSON.stringify(response.message);
                        $('#validation-errors').html('');
                        $('#validation-errors').append('<div class="alert alert-success">' + validation_errors + '</div');
                    } else if (response.status == 'unsuccessful') {
                        var validation_errors = JSON.stringify(response.data);
                        var response = JSON.parse(validation_errors);
                        $('#validation-errors').html('');
                        $.each(response, function(key, value) {
                            $('#validation-errors').append('<div class="alert alert-danger">' + value + '</div');
                        });
                    }
                }
            });
        });
    });

</script>
@endsection
