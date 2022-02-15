@extends('layouts.admin')
@section('page_title') Sales Report @endsection
@section('styles')

<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
@section('content')
<div class="ibox-body" id="validation-errors">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">Sales Report</div>
        </div>
        <div class="ibox-body">
            <table class="table table-responsive table-bordered table-hover" cellspacing="0" width="100%">
                <thead>
                    <tr class="border-0">
                        <th>S.N</th>
                        <th>Source</th>
                        @if( auth()->user()->hasAnyRole('super_admin|admin'))
                        <th>Vendor</th>
                        @endif
                        <th>Amount</th>
                        <th>Payment Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $detail)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <a href="{{ route('orders.show', $detail->order) }}">
                                #{{$detail->order->id}}
                            </a>
                        </td>
                        @if( auth()->user()->hasAnyRole('super_admin|admin'))
                        <td class="text-capitalize">{{ $detail->vendorShop->shop_name }}</td>
                        @endif
                        <td>{{ formatted_price($detail->total_price) }}</td>
                        <td>
                            <div style="display:inline-block; width:100px" class="badge {{ $detail->order->isPaid() ? 'bg-success' : 'badge-danger' }}">{{ ucfirst($detail->order->payment_status) }}</div>
                        </td>
                        <td>
                            <div>{{ $detail->order->created_at->format('d M, Y') }}</div>
                            <div>{{ date('g:i A', strtotime($detail->order->created_at)) }}</div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">No Report found </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $orders->links() }}
        </div>

    </div>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">Sales Report in Chart</div>
        </div>
        <div class="ibox-body">
            <canvas id="myChart"></canvas>
            Total Sales Amount:: Rs. <input type="text" id="total_amt" value="{{$total_sales}}" disabled>
        </div>
    </div>
</div>
@endsection
@push('push_scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>
    var months_day = <?php echo json_encode($months_day); ?>;
    var dailySales = <?php echo json_encode($amt); ?>;
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'line',
        // The data for our dataset
        data: {
            labels: months_day,
            datasets: [{
                label: 'sales',
                //    backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: dailySales,
            }]
        },

        // Configuration options go here
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: !0
                    }
                }],
                xAxes: [{
                    stacked: false,
                    beginAtZero: true,
                    scaleLabel: {
                        labelString: 'Month'
                    },
                    ticks: {
                        stepSize: 1,
                        min: 0,
                        autoSkip: false
                    }
                }]
            }
        }
    });
</script>


@endpush