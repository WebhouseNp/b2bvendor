<table class="table table-striped table-bordered table-hover" id="appendRole" cellspacing="0"
                width="100%">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <td>Name</td>
                        <th>Publish</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($details as $key=>$detail)

                <tr>
                <td>{{$key+1}}</td>
                <td>{{$detail->name}}</td>
                <td>{{$detail->publish}}</td>
                <td>
                <a title="view" class="btn btn-success btn-sm" href="{{route('role.view',$detail->id)}}">
                    <i class="fa fa-eye"></i>
                </a> 
                <!-- <button type="button" title="View" class="btn btn-success btn-sm view" onclick="viewrole({{ $detail->id }})" data-id="{{$detail->id}}">
                    <i class="fa fa-eye"></i>
                </button> -->
                <a title="Edit" class="btn btn-primary btn-sm" href="{{route('role.edit',$detail->id)}}">
                    <i class="fa fa-edit"></i>
                </a> 
                <button class="btn btn-danger delete" onclick="deleteRole({{ $detail->id }})"  class="btn btn-danger" style="display:inline"><i class="fa fa-trash"></i></button>
                </td>
                </tr>
                @empty
        <tr>
            <td colspan="3">No Records </td>
        </tr>
        @endforelse
        

                    
                </tbody>

            </table>
 
 

            <script> 
            function viewrole(id){
                debugger
                $.ajax({ 
           type: "get", 
		//   url: url,

           url:"/api/view-role", 
           data:{id:id},
           success: function(response) {
               console.log(response.data.id)
            //    $('#appendRole').html(response.html)
                // $("#modal-body #title").html(response.data.name);
                // $('#myModal').modal('show');
        //    location.reload();
           }
       });
            }
            </script>