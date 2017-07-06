
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CoreCMF</title>
    <link rel="shortcut icon" href="{{ config('website.icon') }}">
    <!--[if lt IE 9]>
        <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href={{ asset('/vendor/corecmf/css/app.min.css') }} rel=stylesheet>
    <script>
        window.config = {
            apiUrl: '/api/corecmf/main',
            csrfToken:'{{ csrf_token() }}',
        }
    </script>
</head>
<body>
    <div id=app></div>
    <script type=text/javascript src={{ asset('/vendor/corecmf/js/manifest.min.js') }}></script>
    <script type=text/javascript src={{ asset('/vendor/corecmf/js/vendor.min.js') }}></script>
    <script type=text/javascript src={{ asset('/vendor/corecmf/js/app.min.js') }}></script>
</body>
</html>
