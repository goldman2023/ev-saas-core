<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        @import url('https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin-ext');
        body {font-family: 'Roboto', sans-serif;}
        .strong {
            font-weight: 700;
        }

        .center {
            text-align: center
        }
        .page-break {
            page-break-after: always;
        }

        .text-center {
            text-align: center;
            width: 100%;
        }

        .watermark {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: url('{{ get_site_logo() }}') no-repeat;
            opacity: 0.5;
            background-size: contain;
            background-position: center center;
            z-index: -1;
        }

    </style>
</head>

<body>
    @yield('content')
</body>

</html>
