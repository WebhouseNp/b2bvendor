<!DOCTYPE html>
<html>

<head>
    <title>Account Verificaion Mail</title>
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&display=swap"
        rel="stylesheet">
</head>
<style>
</style>

<body>
    
    <div style="font-color:#000000 ; padding: 15px; max-width: 500px; background-color: #ffff;font-family: 'Open Sans', sans-serif;
   margin: 0 0;">
        
        <div>
            <p>
                Dear {{ $name }}  , <br>
                Congratulations!! You have successfully registered in B2B. So as to login, account activation is
                required.
                </p>

               <strong> <a href="{{url('account-activate/'.$link)}}" target="_blank" style="overflow-wrap: break-word;">Click here</a> to
                activate your account.</strong>
                
                <br>
                <br>
                <i>(You can also activate your account via this code){{$otp}} </i>
                <br>
                <br>

            <div>

        </div>

    </div>

</body>

</html>