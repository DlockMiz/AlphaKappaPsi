<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <center><img src="<?php echo $message->embed(storage_path('assets/images/akp_logo.png')); ?>" height="50"></center>
    <div style="font-size: 14pt;">
        {{$obj->user_name}} is requesting a switch out of an event, here are the details.
        <div>
            <br>
            <div>Event: {{$obj->event_title}}</div>
            <br>
            <div>Where: {{$obj->event_location}}</div>
            <br>
            <div>When: {{$obj->event_date}} at {{$obj->event_time}}</div>
            <br>
            <div>Details: {{$obj->event_description}}</div>
        </div>
        <br>
        Go to this event to approve or deny the request!
    </div>
</body>

</html>