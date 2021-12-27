<table class="table table-bordered table-hover" id="example-table" cellspacing="0"
                width="100%">
                <thead>
                    <tr class="border-0">
                        <th>SN</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>User</th>
                        <!-- <th>Categories</th> -->
                        <!-- <th>Sub Categories</th> -->
                        <th>Stock Quantity</th>
                        <th>Product Images</th>
                        <th>Price</th>
                        <th> Discount</th>
                        
                        <th>Status</th>

                        <th>Action</th>
                    </tr>
                </thead>
                
                <tbody id="sortable">
                @forelse ($details as $key=>$detail)

                <tr>
                    <td>{{$key+1}}</td>
                    <td>
                        @if($detail->image)
                            <img src="{{asset('images/listing/'.$detail->image)}}">
                        @else
                        <p>N/A</p>
                        @endif
			        </td>
                    <td>{{$detail->title}}</td>
                    <td>{{$detail->user->name}}</td>
                    <!-- <td>{{$detail->category->name}}</td> -->
                    <!-- <td>
                    @foreach($detail->category->subcategory as $subcategory)
                        {{$subcategory->name}}
                    @endforeach
                    </td> -->
                    
                    <td>{{$detail->quantity}}</td>
                    <td>
                                <a href="{{route('product.images',$detail->id)}}" class="btn btn-primary"><i
                                        class="fa fa-edit"></i></a>
                            </td>
                    
                    <td>NPR. {{ number_format($detail->price)}}</td>
                    <td>
                        @if($detail->discount)
                        {{  $detail->discount}}
                        @endif
    
                    </td>

                    <td>{{$detail->status=='active'? 'Active':'Inactive'}}</td>
                    <td>
                        <a title="view" class="btn btn-success btn-sm" href="{{route('product.view',$detail->id)}}">
                            <i class="fa fa-eye"></i>
                        </a> 

                        <a title="Edit" class="btn btn-primary btn-sm" href="{{route('product.edit',$detail->id)}}">
                            <i class="fa fa-edit"></i>
                        </a> 
                        <button class="btn btn-danger delete" onclick="deleteProduct({{ $detail->id }})"  class="btn btn-danger" style="display:inline"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="8">No Products Yet </td>
                    </tr>
                @endforelse



                </tbody>

            </table>