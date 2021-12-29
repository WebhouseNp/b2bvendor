@extends('layouts.admin')

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
            <table id="example-table" class="table table-striped table-bordered table-hover" cellspacing="0"
                width="100%">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Flag</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    @if($countries->count())
                    @foreach($countries as $key => $data)

                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$data->name}}</td>
                        <td>
                            <div class="m-r-10">
                                <a href="{{$data->flag}}" target="_adimage">
                                    <img src="{{$data->flag}}" alt="No Image" class="rounded" width="70">
                                </a> 
                            </div>
                            <!-- @if(!empty($data->flag) && file_exists(public_path().'/uploads/country/'.$data->flag))
                                <div class="m-r-10">
                                <a href="{{asset('/uploads/country/'.$data->flag)}}" target="_adimage">
                                    <img src="{{asset('/uploads/country/'.$data->flag)}}" alt="No Image" class="rounded" width="70">
                                </a> 
                                </div>
                            @endif -->
                        </td>
                        <td>
                            <ul class="action_list">
                                <li>
                                    <a href="{{route('country.edit', $data->id)}}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                    
                                </li>
                                <li>
                                    <form action="{{ route('country.destroy', $data->id) }}" method="post">
                                        @csrf()
                                        @method('DELETE')
                                        <button   onclick="return confirm('Are you sure you want to delete this Country?')" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                    
                                </li>
                            </ul>
                        </td>
                        
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8">
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
        $('#example-table').DataTable({
            pageLength: 25,
        });
    })
</script>
@endsection