@extends('layouts.admin')
@section('page_title') All Subscribers list @endsection
@section('styles')

<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
@endsection
@section('content')
@include('admin.section.notifications')
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All Subscribers list</div>
        </div>

        <div class="ibox-body">
            <table class="table table-striped table-responsive-sm table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Email</th>
                        <!-- <th>Status</th> -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    @if($subscribers->count())
                    @foreach($subscribers as $key => $subscriber_data)

                    <tr>
                        <td> {{$key +1}}</td>

                        <td> {{$subscriber_data->email}}</td>
                        <!-- <td>{{ $subscriber_data->status == 'publish' ? 'Active' : 'Inactive' }}</td> -->
                        <td>
                            <form action="{{ route('delete-subscriber', $subscriber_data->id) }}" method="get">
                                @csrf()
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure you want to delete this Subscriber?')" class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8">
                            You do not have any Subscribers list yet.
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