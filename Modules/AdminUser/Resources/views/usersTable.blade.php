<table class="table table-striped table-bordered table-hover" id="appendRole" cellspacing="0"
                width="100%">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Phone</th>
                        <th>Publish</th>
                        <th>Action</th>
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
                <td>{{$detail->publish==1? 'Published':'Not published'}}</td>
                <td>
                <a title="Edit" class="btn btn-primary btn-sm" href="{{route('user.edit',$detail->id)}}">
                    <i class="fa fa-edit"></i>
                </a> 
                <button class="btn btn-danger delete" onclick="deleteUser(this,'{{ $detail->id }}')"  class="btn btn-danger" style="display:inline"><i class="fa fa-trash"></i></button>
                </td>
                </tr>
                @empty
        <tr>
            <td colspan="3">No Records </td>
        </tr>
        @endforelse
        

                    
                </tbody>

            </table>
            {{ $details->links() }}
 

            