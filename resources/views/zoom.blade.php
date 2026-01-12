<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Zoom Webinar</title>
</head>
<body>

<form method="POST" action="{{ route('zoom.addQuestion') }}">
    @csrf

    <button type="submit">
        Add Zoom Custom Question
    </button>
</form>

</body>
</html>
