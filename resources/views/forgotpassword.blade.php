<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>B2B</title>

        <!-- Fonts -->
        <link href="{{asset('/assets/admin/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet" />

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body>
       <div id="app">
           <forgotpassword/>
       </div>
    </body>
    <script src="{{mix('js/app.js')}}"></script>
    
</html>