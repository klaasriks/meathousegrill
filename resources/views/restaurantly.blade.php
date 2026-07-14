<!DOCTYPE html>
<html lang="en">
    <head>

        <!-- Meta Tags -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title inertia></title>
        <meta name="description" content="">
        <meta name="keywords" content="">

        <!-- Favicons -->
        <link href="{{ asset('themes/restaurantly/assets/img/favicon.png') }}" rel="icon">
        <link href="{{ asset('themes/restaurantly/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com" rel="preconnect">
        <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

        <!-- CSS CSS Files -->
        <link href="{{ asset('themes/restaurantly/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('themes/restaurantly/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
        <link href="{{ asset('themes/restaurantly/assets/vendor/aos/aos.css" rel="stylesheet') }}">
        <link href="{{ asset('themes/restaurantly/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
        <link href="{{ asset('themes/restaurantly/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

        <!-- Main CSS File -->
        <link href="{{ asset('themes/restaurantly/assets/css/main.css') }}" rel="stylesheet">
        <link href="{{ asset('themes/restaurantly/assets/css/restaurantly-white-menu-picture-colours-only.css') }}" rel="stylesheet">

        <!-- =======================================================
        * Template Name: Restaurantly
        * Template URL: https://bootstrapmade.com/restaurantly-restaurant-template/
        * Updated: Aug 07 2024 with Bootstrap v5.3.3
        * Author: BootstrapMade.com
        * License: https://bootstrapmade.com/license/
        ======================================================== -->

        <!-- Scripts -->
        @vite([
            'resources/css/app.css',
            'resources/js/app.ts'
        ])
        @inertiaHead
    </head>
    <body class="index-page">
        @inertia
    </body>
</html>
