<table class="table table-striped table-bordered table-hover" id="appendRole" cellspacing="0"
                width="100%">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Phone</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($details as $key=>$detail)
                <tr>
                <td>{{ $details->firstItem() + $loop->index }}</td>
                <td>{{ucfirst($detail->name)}}</td>
                <td>{{$detail->email}}</td>
                @foreach($detail->roles as $role)
                <td>{{ucfirst($role->name)}}</td>
                @endforeach
                <td>{{$detail->phone_num}}</td>
                </tr>
                @empty
        <tr>
            <td colspan="3">No Records </td>
        </tr>
        @endforelse
        </tbody>
    </table>
{{ $details->links() }}
 

            