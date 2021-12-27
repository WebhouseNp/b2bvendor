<table class="table table-striped table-bordered table-hover" id="example-table"  cellspacing="0"
                width="100%">
                <thead>
                    <tr class="border-0">
                        <th>S.N</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Link</th>
                        <th>Publish</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="sortable">
                @forelse ($details as $key=>$detail)

                <tr>
                <td>{{$key+1}}</td>
                <td>{{$detail->title}}</td>
                <td>
                @if($detail->image)
                    <img src="{{asset('images/listing/'.$detail->image)}}">
                    @else
                    <p>N/A</p>
                @endif
			</td>
                <td>{{$detail->link}}</td>
            
                <td>{{$detail->status=='Publish'? 'Published':'Not published'}}</td>
                <td>
                <!-- <a title="view" class="btn btn-success btn-sm" href="{{route('category.view',$detail->id)}}">
                    <i class="fa fa-eye"></i>
                </a>  -->
                <!-- <button type="button" title="View" class="btn btn-success btn-sm view" onclick="viewrole({{ $detail->id }})" data-id="{{$detail->id}}">
                    <i class="fa fa-eye"></i>
                </button> -->
                <a title="Edit" class="btn btn-primary btn-sm" href="{{route('advertisement.edit',$detail->id)}}">
                    <i class="fa fa-edit"></i>
                </a> 
                <button class="btn btn-danger delete" onclick="deleteAdvertisement({{ $detail->id }})"  class="btn btn-danger" style="display:inline"><i class="fa fa-trash"></i></button>
                </td>
                </tr>
                @empty
        <tr>
            <td colspan="3">No Records </td>
        </tr>
        @endforelse
        

                    
                </tbody>

            </table>
 
                     

            