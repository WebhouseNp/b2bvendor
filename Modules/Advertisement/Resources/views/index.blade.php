<?php
$user = Auth::user();
$api_token = $user->api_token;
?>
@extends('layouts.admin')
@section('page_title') All Advertisements @endsection
@section('styles')
<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
@endsection
@section('content')
<div class="ibox-body" id="validation-errors">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
</div>
<div class="page-content fade-in-up">
  <div class="ibox">
    <div class="ibox-head">
      <div class="ibox-title">All Advertisements</div>
      <div>
        <a class="btn btn-info btn-md" href="{{route('advertisement.create')}}">Add Advertisement</a>
      </div>
    </div>

    <div class="ibox-body " id="validation-errors">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    </div>
    <div class="ibox-body" id="appendAdvertisement">
      <table class="table table-striped table-responsive table-bordered table-hover" id="example-table" style="width:100%">
        <thead>
          <tr class="border-0">
            <th>S.N</th>
            <th>Title</th>
            <th>Image</th>
            <th style="width: 30%">Link</th>
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
              <a title="Edit" class="btn btn-primary btn-sm" href="{{route('advertisement.edit',$detail->id)}}">
                <i class="fa fa-edit"></i>
              </a>
              <button class="btn btn-danger btn-sm delete" onclick="deleteAdvertisement({{ $detail->id }})" class="btn btn-danger" style="display:inline"><i class="fa fa-trash"></i></button>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="3">No Records </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>

@endsection
@section('scripts')
<script src="{{asset('/assets/admin/vendors/DataTables/datatables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/admin/js/sweetalert.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/admin/js/jquery-ui.js')}}"></script>
<script type="text/javascript">
  $(function() {
    $('#example-table').DataTable({
      pageLength: 15,
    });
  })
  $("#sortable").sortable({
    stop: function() {
      $.map($(this).find('tr'), function(el) {
        var itemID = el.id;
        var itemIndex = $(el).index();
        $.ajax({
          url: "",
          method: "post",
          data: {
            itemID: itemID,
            itemIndex: itemIndex
          },
          success: function(data) {

          }
        })
      });
    }
  });
</script>

<script>
  function advertisements() {
    var api_token = '<?php echo $api_token; ?>';

    $.ajax({
      type: 'GET',
      url: '/api/alladvertisements',
      headers: {
        Authorization: "Bearer " + api_token
      },
      success: function(response) {
        $('#appendAdvertisement').html(response.html)
        // $('#example-table').DataTable();
      },
      error: function(error) {
        $('#notification-bar').text('An error occurred');
      }
    });
  }

  // advertisements()
  function deleteAdvertisement(id) {
    var api_token = '<?php echo $api_token; ?>';

    alert("Are you sure you want to delete??");
    $.ajax({
      type: "post",
      url: "{{route('api.deleteadvertisement')}}",
      data: {
        id: id
      },
      headers: {
        Authorization: "Bearer " + api_token
      },
      success: function(response) {
        var validation_errors = JSON.stringify(response.message);
        $('#validation-errors').html('');
        $('#validation-errors').append('<div class="alert alert-success">' + validation_errors + '</div');
        window.location.href = "/admin/advertisement";
      }
    });
  }
</script>
@endsection