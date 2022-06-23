<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

</head>

<body>
    {{ translate('Prevented access.') }}
    <a href="{{ route('user.login') }}">
        {{ translate('Login here') }}
    </a>
</body>

</html>
