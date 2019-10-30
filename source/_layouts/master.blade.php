<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <link rel="stylesheet" href="{{ mix('css/main.css', 'assets/build') }}">

  <title>The PHP Website</title>

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id={{ $page->get('gaId') }}"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', '{{ $page->get('gaId') }}');
  </script>
</head>
<body class="yue">
@yield('body')
</body>
</html>
