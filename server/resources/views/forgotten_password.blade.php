<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <center><img src="<?php echo $message->embed(storage_path('assets/images/akp_logo.png')); ?>" height="50"></center>
    <center>
        <div style="font-size:20pt">You have requested a password reset. Copy and paste the link below into your browser!</div>
        <a href="{{$obj}}">{{$obj}}</a><br>
    </center>
</body>

</html>