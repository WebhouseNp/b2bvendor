@extends('layouts.admin')

@section('page_title')Quotations @endsection

@section('styles')
<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">Quotations</div>
        </div>
        <div class="ibox-body">
            <table class="table table-striped table-responsive-sm table-bordered table-hover" id="quotation-table" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Query By</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quotations as $quotation)
                    <tr>
                        <td> {{ $loop->iteration }}</td>
                        <td> {{$quotation->purchase}}</td>
                        <td> {{$quotation->quantity}} {{ $quotation->unit }}</td>
                        <td> {{$quotation->name }}</td>
                        <td class="text-no-wrap d-flex">
                            <a title="view" class="btn btn-success border-0" href="{{ route('quotations.show',$quotation->id) }}">
                                <i class="fa fa-eye"></i> View
                            </a>
                            <div class="mx-2"></div>
                            <form action="{{ route('quotations.destroy', $quotation->id) }}" method="POST" class="js-delete-prdoduct-category-form form-inline d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger border-0"><i class="fa fa-trash"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            You do not have any Quotations yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('push_scripts')
<script src="{{asset('/assets/admin/vendors/DataTables/datatables.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        $('#quotation-table').DataTable({
            pageLength: 25
            , "bSortable": false
            , "aTargets": [-1, -2]
        });
    })

</script>
@endpush
