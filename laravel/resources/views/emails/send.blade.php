<html>
<head></head>
<body style="background: black; color: white">
<h1>{{$title}}</h1>
@if ($flag == 1)
    <p>Reason for block your account:</p>
@else
<p>Your account have been unlocked!</p>
@endif
<p>{{$content}}</p>
</body>
</html>