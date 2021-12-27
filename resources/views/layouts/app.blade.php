<!DOCTYPE html>
 
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login || Sasto Whole Sale</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
     
    <!-- GLOBAL MAINLY STYLES-->
    <link href="{{asset('/assets/admin/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/admin/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/admin/vendors/themify-icons/css/themify-icons.css')}}" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="{{asset('/assets/admin/css/main.css')}}" rel="stylesheet" />
    <!-- PAGE LEVEL STYLES-->
    <link href="{{asset('/assets/admin/css/pages/auth-light.css')}}" rel="stylesheet" />
</head>

<body class="bg-silver-300">
    @yield('content')
    <!-- BEGIN PAGA BACKDROPS-->
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div>
    <!-- END PAGA BACKDROPS-->
    <!-- CORE PLUGINS -->
    <script src="{{asset('/assets/admin/vendors/jquery/dist/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/assets/admin/vendors/popper.js/dist/umd/popper.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/assets/admin/vendors/bootstrap/dist/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <!-- PAGE LEVEL PLUGINS -->
    <script src="{{asset('/assets/admin/vendors/jquery-validation/dist/jquery.validate.min.js')}}" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="{{asset('/assets/admin/js/app.js')}}" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script type="text/javascript">
        $(function() {
            $('#login-form').validate({
                errorClass: "help-block",
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true
                    }
                },
                highlight: function(e) {
                    $(e).closest(".form-group").addClass("has-error")
                },
                unhighlight: function(e) {
                    $(e).closest(".form-group").removeClass("has-error")
                },
            });
        });
    </script>
    <script>
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

	$('#submitUser').on('click', function(){
        
     var email = $('#email').val();
     var password = $('#password').val();
     var redirect_url = "{{route('dashboard')}}"
     $.ajax({
          url: "/postLogin",
          type:"POST",
          data:{
            "_token": "{{ csrf_token() }}",
            email:email,
            password:password,
          },
          success:function(response){
              
            if(response.status_code == 200){
                
                window.location.href = redirect_url;
              
          //     var modal_title = "Success";
					// modal_title = modal_title.fontcolor('green');
          // $('#popup-modal-body').append(response.message);
          // $('#popup-modal-title').append(modal_title);
          // $('#popup-modal-btn').addClass('btn-success');
					// $("#popupModal").modal('show');
        //   window.location.href = "/admin/brand";
        //   var validation_errors = JSON.stringify(response.message);
        //     $('#validation-errors').html('');
        //     $('#validation-errors').append('<div class="alert alert-success">'+validation_errors+'</div');
        //     } else if(response.status == 'unsuccessful') {
        //       var validation_errors = JSON.stringify(response.data);
        //     var response = JSON.parse(validation_errors);
        //     $('#validation-errors').html('');
        //     $.each( response, function( key, value) {
        //     $('#validation-errors').append('<div class="alert alert-danger">'+value+'</div');
        // });
            }
          }
         
         });
        
	});
</script>

</body>

</html>