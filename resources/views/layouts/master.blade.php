<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>@yield('title', 'Dashboard')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">



    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        #layoutSidenav {
            flex: 1;
            display: flex;
            flex-direction: row;
            overflow: hidden;
        }

        nav.sb-sidenav {
            width: 250px;
            background-color: #343a40;
            color: white;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: sticky;
            top: 0;
            transition: width 0.3s ease;
        }

        #layoutSidenav_content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            background-color: #f8f9fa;
            transition: margin-left 0.3s ease;
        }

        main {
            flex-grow: 1;
            padding: 20px;
        }

        footer {
            background-color: #343a40;
            color: white;
            padding: 15px;
            text-align: center;
            width: 100%;
            flex-shrink: 0;
        }

        /* Classe pour cacher le sidebar */
        #layoutSidenav.collapsed nav.sb-sidenav {
            width: 0;
            overflow: hidden;
        }

        #layoutSidenav.collapsed #layoutSidenav_content {
            margin-left: 0;
        }
    </style>
</head>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}

<body>

    @include('layouts.partials.header')

    <div id="layoutSidenav">
        @include('layouts.partials.sidebar')

        <div id="layoutSidenav_content">
            <main>
                @yield('content')
            </main>

            @include('layouts.partials.footer')
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script pour toggle le sidebar -->
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function () {
            document.getElementById('layoutSidenav').classList.toggle('collapsed');
        });
    </script>

</body>
</html>
