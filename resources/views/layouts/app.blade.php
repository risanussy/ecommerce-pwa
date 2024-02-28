<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E-Commerce</title>
  <!-- Add your CSS links here -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="icon"
    href="https://cdn.dribbble.com/users/4553005/screenshots/13436219/media/0f0d109e1888047d02e23b5557f79c96.png?resize=1000x750&vertical=center">

  <link rel="manifest" href="manifest.json">
  <!-- Boostrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

  <!-- font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.2/axios.min.js"
    integrity="sha512-b94Z6431JyXY14iSXwgzeZurHHRNkLt9d6bAHt7BZT38eqV+GyngIi/tVye4jBKPYQ2lBdRs0glww4fmpuLRwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

  <!-- midtrans -->
  <script type="text/javascript" src="https://app.stg.midtrans.com/snap/snap.js"
    data-client-key="SB-Mid-client-FhTCfUJ2L6u8rzbC0"></script>

</head>

<body>
  <div id="app">
    @yield('app')
  </div>
  <!-- <footer class="p-2 text-center">
        <small>&copy; Copyright 2023</small>
    </footer> -->
  <!-- Add your JavaScript scripts here -->
  <script src="{{ asset('js/app.js') }}"></script>

  <!-- JS Bootstrap    -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
  </script>
  <script>
  if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('service-worker.js');
  }
  </script>
</body>

</html>