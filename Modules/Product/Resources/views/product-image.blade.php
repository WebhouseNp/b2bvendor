@extends('layouts.admin')
@section('page_title') {{ ($product_info) ? "Update" : "Add"}} Product @endsection
@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css" />
@endsection

@section('content')

<div class="page-heading">
    <h1 class="page-title"> Product</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href=""><i class="la la-home font-20"></i> Home</a>
        </li>
        <li class="breadcrumb-item"> {{ ($product_info) ? "Update" : "Add"}} Product</li>
    </ol>

</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">{{ ($product_info) ? "Update" : "Add"}} Product</div>
            <div>
                <a class="btn btn-info btn-md" href="{{route('product.index',['type'=>'all'])}}">All Products</a>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <!-- <br />
        <h3 align="center">Multiple Product Image Upload </h3>
        <br /> -->

        <div class="panel panel-default">
            <!-- <div class="panel-heading">
                <h3 class="panel-title">Select Images</h3>
            </div> -->
            <div class="panel-body">
                <form id="dropzoneForm" class="dropzone" action="{{ route('dropzone.upload', $product_info->id) }}">
                    @csrf
                </form>
                <br>
                <div align="center">
                    <button type="button" class="btn btn-info" id="submit-all">Upload</button>
                </div>
            </div>
        </div>
        <br />
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Uploaded Image</h3>
            </div>
            <!-- <div class="panel-body" id="uploaded_image"> -->
            <div class="row">
                @if(isset($product_info->productimage) && $product_info->productimage->count())
                @foreach($product_info->productimage as $image_key => $image_data)
                <div class="col-lg-3 col-md-12 col-12  image_id{{$image_data->id}}">
                    <div class="ibox">

                        @if(isset($image_data->images) && !empty($image_data->images) &&
                        file_exists(public_path().'/uploads/product/other-image/'.$image_data->images))

                        <div class="form-group">
                            <div class="m-r-10 product_images">
                                <div class="remove_image" data-image_id="{{$image_data->id}}"><i class="fa fa-times"></i></div>
                                <img src="{{asset('/uploads/product/other-image/'.$image_data->images)}}" alt="No Image" class=" img img-thumbnail  img-sm rounded" id="thumbnail">
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
                @endif

            </div>
            <!-- </div> -->
        </div>
    </div>



</div>

@endsection
@section('scripts')
<script src="{{asset('/assets/admin/js/sweetalert.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/admin/js/jquery-ui.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>

<script type="text/javascript">
    Dropzone.options.dropzone = {
        maxFilesize: 10,
        renameFile: function(file) {
            var dt = new Date();
            var time = dt.getTime();
            return time + file.name;
        },
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        addRemoveLinks: true,
        timeout: 60000,
        success: function(file, response) {
            console.log(response);
        },
        error: function(file, response) {
            return false;
        }
    };
    // Dropzone.options.dropzoneForm = {
    //     autoProcessQueue: false,
    //     acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg",

    //     init: function() {
    //         var submitButton = document.querySelector("#submit-all");
    //         myDropzone = this;

    //         submitButton.addEventListener('click', function() {
    //             myDropzone.processQueue();
    //         });

    //         this.on("complete", function() {
    //             if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
    //                 var _this = this;
    //                 _this.removeAllFiles();
    //             }
    //             load_images();
    //         });

    //     }

    // };

    // load_images(id);

    // function load_images() {
    //     var id = $(this).attr('id');
    //     $.ajax({
    //         url: 'dropzone/fetch/' + id,
    //         data: {
    //             id: id
    //         },
    //         success: function(data) {
    //             $('#uploaded_image').html(data);
    //         }
    //     })
    // }

    // $(document).on('click', '.remove_image', function() {
    //     var name = $(this).attr('id');
    //     $.ajax({
    //         url: "{{ route('dropzone.delete') }}",
    //         data: {
    //             name: name
    //         },
    //         success: function(data) {
    //             load_images();
    //         }
    //     })
    // });
</script>
<script>
    function showThumbnail(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
        }
        reader.onload = function(e) {
            $('#thumbnail').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }

    $(document).ready(function() {
        $('body').on('click', '.remove_image', function(e) {
            e.preventDefault();
            var image_id = $(this).data('image_id');
            // alert(image_id);
            $.ajax({
                url: "{{route('deleteImageById')}}",
                method: "POST",
                data: {
                    id: image_id,
                    _token: "{{csrf_token()}}"
                },
                success: function(response) {
                    if (response.status == false) {
                        FailedResponseFromDatabase(response.message);
                    }
                    if (response.status == true) {
                        $('.image_id' + image_id).fadeOut(2000);
                        DataSuccessInDatabase(response.message);
                    }
                }
            })
        })
    })

    function FailedResponseFromDatabase(message) {
        html_error = "";
        $.each(message, function(index, message) {
            html_error += '<p class ="error_message text-left"> <span class="fa fa-times"></span> ' + message + '</p>';
        });
        Swal.fire({
            type: 'error',
            title: 'Oops...',
            html: html_error,
            confirmButtonText: 'Close',
            timer: 10000
        });
    }

    function DataSuccessInDatabase(message) {
        Swal.fire({
            // position: 'top-end',
            type: 'success',
            title: 'Done',
            html: message,
            confirmButtonText: 'Close',
            timer: 10000
        });
    }
</script>

@endsection