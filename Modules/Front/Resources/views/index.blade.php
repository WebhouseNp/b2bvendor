@extends('layouts.admin')
@section('page_title') All Quotations list @endsection
@section('styles')

<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
@endsection
@section('content')
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All Quotations list</div>
        </div>


        <div class="ibox-body">
            <table class="table table-striped table-responsive-sm table-bordered table-hover" id="example-table" cellspacing="0"
                width="100%">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile Number</th>
                        <th>Product</th>
                    </tr>
                </thead>
                <tbody>

                    @if($quotations->count())
                    @foreach($quotations as $key => $quotation)

                    <tr>
                        <td> {{$key +1}}</td>

                        <td> {{$quotation->first_name}} {{$quotation->last_name}}</td>
                        <td> {{$quotation->email}}</td>
                        <td> {{$quotation->mobile_num}}</td>
                        <td>{{ $quotation->purchase }}</td>
                        
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8">
                            You do not have any Quotations yet.
                        </td>
                    </tr>
                    @endif
                </tbody>

            </table>
        </div>
    </div>

</div>

@endsection
@section('scripts')
<script src="{{asset('/assets/admin/vendors/DataTables/datatables.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        $('#example-table').DataTable({
            pageLength: 25,
        });
    })

</script>
@endsection