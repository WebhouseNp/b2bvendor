<table class="table table-striped table-bordered table-hover" id="example1" cellspacing="0"
                width="100%">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Include in main menu</th>
                        <th>Featured</th>
                        <th>Category</th>
                        <th>Publish</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($details as $key=>$detail)

                <tr>
                <td>{{$key+1}}</td>
                <td>{{$detail->name}}</td>
                <td>
                @if($detail->image)
                    <img src="{{asset('images/listing/'.$detail->image)}}">
                    @else
                    <p>N/A</p>
                @endif
			</td>
                <td>{{$detail->include_in_main_menu==1? 'Yes':'No'}}</td>
                <td>{{$detail->is_featured==1? 'Yes':'No'}}</td>
                <td>{{$detail->category->name}}</td>
                <td>{{$detail->publish==1? 'Published':'Not published'}}</td>
                <td>
                <a title="view" class="btn btn-success btn-sm" href="{{route('subcategory.view',$detail->id)}}">
                    <i class="fa fa-eye"></i>
                </a> 
                <a title="Edit" class="btn btn-primary btn-sm" href="{{route('subcategory.edit',$detail->id)}}">
                    <i class="fa fa-edit"></i>
                </a> 
                <button class="btn btn-danger delete" onclick="return confirm('Do You want to delete this sub-category??') && deleteSubcategory(this,'{{ $detail->id }}')"  class="btn btn-danger" style="display:inline"><i class="fa fa-trash"></i></button>

                </td>
                </tr>
                @empty
        <tr>
            <td colspan="3">No Records </td>
        </tr>
        @endforelse
        

                    
                </tbody>

            </table>
 