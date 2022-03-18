<table class="table table-striped table-responsive-sm table-bordered table-hover" id="appendRole" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>S.N</th>
            <th>Name</th>
            <th>Email</th>
            @if($role=='vendor')
            <th>Vendor Type</th>
            @endif
            <th>Phone</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($details as $key=>$detail)
        <tr>
            <td>{{ $details->firstItem() + $loop->index }}</td>
            <td>{{ucfirst($detail->name)}}</td>
            <td>{{$detail->email}}</td>
            @if($role=='vendor')
            <td>
            <span class="btn btn-sm {{vendorStatus($detail->vendor_type) }} ">{{ ucfirst($detail->vendor_type) }}</span>
            </td>
            @endif
            <td>{{$detail->phone_num}}</td>
        </tr>
        @empty
        <tr>
            <td colspan="3">No Records </td>
        </tr>
        @endforelse
    </tbody>
</table>
<div class="d-flex">
    <div>
        Showing {{ $details->firstItem() }} to {{ $details->lastItem() }} of {{ $details->total() }} entries
    </div>
    <div class="ml-auto">
        {{ $details->links() }}
    </div>
</div>