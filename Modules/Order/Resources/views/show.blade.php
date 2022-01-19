@extends('layouts.admin')

@section('page_title') Order @endsection

@section('content')
<div class="page-heading">
    <h2 class="page-title"> Order</h2>
</div>

@include('admin.section.notifications')
<div class="ibox-body" id="validation-errors">
    <form class="form form-responsive form-horizontal" id="order-update-form">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-8" id="get__print">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="h6-responsive">Order Details</h6>
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
                                        @foreach($order->orderList as $orderList)
                                        <tr>
                                            <td id="product_title">
                                                <div>{{ $orderList->product_name }}</div>
                                                <div class="d-flex">
                                                    <div class="badge badge-primary">{{ $orderList->order_status }}</div>
                                                </div>
                                            </td>
                                            <td class="text-nowrap">{{ formatted_price($orderList->unit_price) }} x {{ $orderList->quantity }} = {{ formatted_price($orderList->subtotal_price) }}</td>
                                            <td>{{ formatted_price($orderList->shipping_charge) }}</td>
                                            <td class="text-nowrap">{{ formatted_price($orderList->total_price) }}</td>
                                        </tr>
                                        @endforeach
                                        @if (auth()->user()->hasAnyRole('super-admin|admin'))
                                        <tr>
                                            <td colspan="2"></td>
                                            <td class="">Subtotal</td>
                                            <td>{{ formatted_price($order->subtotal_price) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td class="">Shipping</td>
                                            <td>{{ formatted_price($order->shipping_charge) }}</td>
                                        </tr>
                                        <tr class="text-primary font-weight-bold">
                                            <td colspan="2"></td>
                                            <td class="">Order Total</td>
                                            <td class="text-nowrap">{{ formatted_price($order->total_price) }}</td>
                                        </tr>
                                        @else
                                        <tr>
                                            <td colspan="2"></td>
                                            <td class="">Subtotal</td>
                                            <td>{{ formatted_price($order->orderList->sum->subtotal_price) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td class="">Shipping</td>
                                            <td>{{ formatted_price($order->orderList->sum->shipping_charge) }}</td>
                                        </tr>
                                        <tr class="text-primary font-weight-bold">
                                            <td colspan="2"></td>
                                            <td class="">Order Total</td>
                                            <td class="text-nowrap">{{ formatted_price($order->orderList->sum->total_price) }}</td>
                                        </tr>
                                        @endif
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
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="my-5"></div>

    <button class="btn btn-sm print__button btn-primary">Print</button>
</div>
<!-- Modal -->
{{-- @include('dashboard::admin.modals.orderstatusmodal')
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
    </div> --}}
@endsection
@section('scripts')

<script src="/assets/admin/js/printThis.js"></script>
<script type="text/javascript">
    $('.print__button').click(function() {
        $("#get__print").printThis({
            header: null
            , footer: null
        , });
    });

    // function showThumbnail(input) {
    //     if (input.files && input.files[0]) {
    //         var reader = new FileReader();
    //     }
    //     reader.onload = function(e) {
    //         $('#thumbnail').attr('src', e.target.result);
    //     }
    //     reader.readAsDataURL(input.files[0]);
    // }

</script>
<script>
    $(document).ready(function() {
        $('body').on('click', '.changeStatus', function(e) {
            var order_id = $(this).data('order_id');
            console.log(order_id)
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
                            var modal_title = "Success";
                            modal_title = modal_title.fontcolor('green');
                            $('#popup-modal-body').append(response.message);
                            $('#popup-modal-title').append(modal_title);
                            $('#popup-modal-btn').addClass('btn-success');
                            $("#popupModal").modal('show');
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
