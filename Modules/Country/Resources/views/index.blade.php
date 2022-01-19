@extends('layouts.admin')

@section('styles')
<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="page-heading">
    @include('admin.section.notifications')
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All Countries</div>
            <div>
                <a class="btn btn-info btn-md" href="{{route('country.create')}}">Add New Country</a>
            </div>
        </div>
        <div class="ibox-body">
            <table id="countries-table" class="table table-responsive table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Flag</th>
                        <th>Published</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($countries->count())
                    @foreach($countries as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->name }}</td>
                        <td>
                            <img src="{{ $data->flagUrl() }}" alt="{{ $data->name }}" class="rounded" style="height: 3rem;">
                        </td>
                        <td>
                            {{ $data->publish ? 'Yes' : 'No' }}
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <a href="{{ route('country.edit', $data->id) }}" class="btn btn-link py-0 text-success"><i class="fa fa-edit"></i> Edit</a>
                                <div>|</div>
                                <form action="{{ route('country.destroy', $data->id) }}" method="post" class="d-inline">
                                    @csrf()
                                    @method('DELETE')
                                    <button onclick="return confirm('Are you sure you want to delete this Country?')" class="btn btn-link py-0 text-danger">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="42">
                            You do not have any data yet.
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
        $('#countries-table').DataTable({
            pageLength: 25
        });
    })

</script>
@endsection
