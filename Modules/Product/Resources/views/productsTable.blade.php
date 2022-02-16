<table class="table table-responsive table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
    <thead>
        <tr class="border-0">
            <th>SN</th>
            <th>Image</th>
            <th style="width: 30%">Title</th>
            @if( auth()->user()->hasAnyRole('super_admin|admin'))
            <th>Vendor</th>
            @endif
            <th>Images</th>
            <!-- <th>Price</th> -->
            {{-- <th> Discount</th> --}}

            <th>Status</th>

            <th>Action</th>
        </tr>
    </thead>

    <tbody id="sortable">
        @forelse ($details as $key=>$detail)

        <tr>
            <td>{{ $details->firstItem() + $loop->index }}</td>
            <td>
                @if($detail->image)
                <img class="rounded" src="{{ $detail->imageUrl('thumbnail') }}" style="width: 4rem;">
                @else
                <p>N/A</p>
                @endif
            </td>
            <td>{{ $detail->title }}</td>
            @if( auth()->user()->hasAnyRole('super_admin|admin'))
            <td>{{ @$detail->user->vendor->shop_name }}</td>
            @endif
            <td style="text-align: center">
                <a href="{{route('product.images',$detail->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
            </td>
            <!-- <td>NPR. {{ number_format($detail->price)}}</td> -->
            {{-- <td>
                        @if($detail->discount)
                        {{  $detail->discount}}
            @endif
            </td> --}}

            <!-- <td>{{ $detail->status=='active'? 'Active':'Inactive' }}</td> -->
            <td>
                <input type="checkbox" id="toggle-event" data-toggle="toggle" class="ProductStatus btn btn-success btn-sm" rel="{{$detail->id}}" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger" data-size="mini" @if($detail->status == 'active') checked @endif>
            </td>
            <td>
                <a title="view" class="btn btn-success btn-sm" href="{{route('product.view',$detail->id)}}">
                    <i class="fa fa-eye"></i>
                </a>

                <a title="Edit" class="btn btn-primary btn-sm" href="{{route('product.edit',$detail->id)}}">
                    <i class="fa fa-edit"></i>
                </a>
                <!-- <button class="btn btn-danger btn-sm delete" onclick="deleteProduct(this,'{{ $detail->id }}')" style="display:inline"><i class="fa fa-trash"></i></button> -->
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8">No Products Yet </td>
        </tr>
        @endforelse



    </tbody>

</table>
{{ $details->links() }}