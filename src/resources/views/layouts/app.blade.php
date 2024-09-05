<!--
=========================================================
* Soft UI Dashboard - v1.0.3
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard
* Copyright 2021 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>

<html lang="en" >

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">


  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/tackle-logo/tackle_128px.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/img/tackle-logo/tackle_64px.png') }}">
  <title>
    Tackle @ FH Aachen
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('assets/css/soft-ui-dashboard.css?v=1.0.3') }}" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styling')


</head>

<body class="g-sidenav-show vh-100 bg-gray-100">

  @auth
    @yield('auth')
  @endauth
  @guest
    @yield('guest')
  @endguest

  @stack('rtl')
  @stack('dashboard')

  <script>
      function docReady(fn) {
          // see if DOM is already available
          if (document.readyState === "complete" || document.readyState === "interactive") {
              // call on next available tick
              setTimeout(fn, 1);
          } else {
              document.addEventListener("DOMContentLoaded", fn);
          }
      }

      function loadScript(url) {
          var tag = document.createElement("script");
          tag.src = url;
          document.getElementsByTagName("head")[0].appendChild(tag);
      }
  </script>

  @stack('js')

  <script>
      docReady(function () {
          @if(session()->has('success'))
          Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: '{{ session()->get('success') }}',
              showConfirmButton: false,
              timer: 1500
          })
          @endif
          @if(session()->has('error'))
          Swal.fire({
              position: 'top-end',
              icon: 'error',
              title: '{{ session()->get('error') }}',
              showConfirmButton: false,
              timer: 1500
          })
          @endif

          // Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc
          loadScript("{{ asset('assets/js/soft-ui-dashboard.min.js?v=1.0.3') }}")


      });
  </script>

</body>

</html>
