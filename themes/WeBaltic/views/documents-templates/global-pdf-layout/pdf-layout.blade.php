<!DOCTYPE html>
<html lang="lt">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    {{-- This is the only tailwind which actually works... --}}
    <link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> 
    <style>
        * { 
          font-family: DejaVu Sans !important; 
        }
        .w-full {
            width: 100%;
        }
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

    @stack('styles')
</head>

<body>
    @yield('content')
</body>

</html>
