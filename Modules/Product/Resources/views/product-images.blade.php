@extends('layouts.admin')
@section('page_title') {{ ($product) ? "Update" : "Add"}} Product @endsection

@push('styles')
<link href="{{ asset('assets/dropzone/dist/dropzone.css') }}" rel="stylesheet">
@endpush
@section('content')
<div class="page-content fade-in-up">
    <div class="page-heading d-flex mb-3">
        <h1 class="h4-responsive">Product images</h1>
        <div class="ml-auto">
            <a class="btn btn-info btn-md" href="/product/all">All Products</a>
        </div>
    </div>

    @include('product::__partials.product-form-tabs')
    <div>
        <div class="white p-3">
            <form id="myAwesomeDropzone" action="{{ route('ajax.product-images.store') }}" method="post" class="dropzone" enctype="form-data/multipart">
                @csrf
                <div class="fallback">
                    <input name="file" type="file" accept="image/*" multiple />
                </div>
                <div class="dz-default dz-message">
                    <span><strong>Drag & Drop</strong> product images here to upload or </span>
                    <div class="my-3">
                        <div class="btn btn-info z-depth-0">Browse Images</div>
                    </div>
                </div>
                <input type="number" name="product_id" value="{{ $product->id }}" hidden="true">
                <div class="dropzone-previews"></div>
            </form>

            <div id="images-loading" class="text-center pt-5">
                <div class="spinner-grow text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-secondary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-success" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-danger" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-warning" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-info" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-dark" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div id="productImages" class="row">
            </div>
        </div>

        <script type="text/template" id="image-template">
            <div class="col-6 col-sm-4 col-md-3 col-xl-2">
            <div class="img-wrap">
                    <img class="img-fluid" src="" alt="">
                    <div class="del-btn-wrapper">
                        <button class="del-image-btn btn btn-danger rounded-0" title="delete"><span class="icon"><i class="fa fa-trash-alt"></i></span> Delete</button>
                    </div>
            </div>
		</div>
	</script>

        <script type="text/template" id="no-image-template">
            <div id="no-image">
		<div class="image-icon">
			<i class="far fa-image"></i>
		</div>
		<div class="text">
			<strong>OOPS !!</strong>
			No Images to show
        </div>
	</div>
    
</script>
    </div>
    @endsection
    @push('push_scripts')
    <script type="text/javascript" src="{{ asset('assets/dropzone/dist/dropzone.js') }}"></script>
    <script>
        Dropzone.autoDiscover = false;
        $(function() {
            var images = $('#productImages');
            var imageTemplate = $('#image-template').html();
            var noImageTemplate = $('#no-image-template').html();
            var deleteUrl = "{{ route('ajax.product-images.destroy', 'IMAGE_ID ') }}";
            console.log(deleteUrl);

            function renderImageTemplate(image) {
                var templateItem = $(imageTemplate);
                templateItem.find('img').attr('src', image.url);
                templateItem.find('.del-image-btn').attr('data-id', image.id)
                images.append(templateItem);
            }

            function renderNoImageTemplate() {
                images.append(noImageTemplate)
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            function loadImages() {
                $('#images-loading').show();
                $.ajax("{{ route('ajax.product-images.listing', $product) }}", {
                    dataType: 'json',
                    success: function(data, status, xhr) {
                        // console.log(data);
                        images.empty();
                        console.log(typeof(data));
                        if (jQuery.isEmptyObject(data)) {
                            renderNoImageTemplate();
                        } else {
                            data.forEach(function(image) {
                                renderImageTemplate(image);
                            });
                        }
                    },
                    error: function(jqXhr, textStatus, errorMessage) {
                        console.log(errorMessage);
                    }
                }).done(function() {
                    $('#images-loading').hide();
                });
                console.log("Images Reloaded");
            }

            loadImages();

            var myAwesomeDropzone = new Dropzone("form#myAwesomeDropzone", {
                acceptedFiles: '.png,.jpg,.jpeg,.gif',
                previewsContainer: '.dropzone-previews',
                init: function() {
                    var myDropzone = this;
                    this.on("sendingmultiple", function() {});
                    this.on("successmultiple", function(files, response) {
                        console.log(response);
                    });
                    this.on("errormultiple", function(files, response) {
                        console.log(response);
                    });
                    this.on('complete', function(file, response) {
                        console.log('upload complete');
                        this.removeFile(file);
                        loadImages();
                    });
                }
            });
            images.on('click', '.del-image-btn', function(e) {
                event.preventDefault();
                var con = confirm('Are you absolutely sure to delete this image?');
                if (con) {
                    var dummyUrl = deleteUrl;
                    var imageDeleteUrl = dummyUrl.replace(/IMAGE_ID/, $(this).data('id'));
                    console.log("requesting to " + imageDeleteUrl);
                    $(this).hide();
                    $.ajax({
                            url: imageDeleteUrl,
                            type: 'POST',
                            data: {
                                _method: 'delete'
                            },
                        })
                        .done(function(response) {
                            console.log("success");
                        })
                        .fail(function(response) {
                            console.log("error");
                        })
                        .always(function() {
                            loadImages();
                            console.log("complete");
                        });
                    return false;
                } else {
                    return false;
                }
            });
        });
    </script>
    @endpush