<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Voucher Application</title>
<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
<!-- Styles -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

<link type="text/css" href="/assets/css/toastr.min.css" rel="stylesheet">

<meta name="csrf-token" content="{{ csrf_token() }}">

@if (isset($error))
  <meta name="error" message="{{ isset($error)&&isset($error['message']) ? $error['message'] : ""}}"
    message_title="{{ isset($error)&&isset($error['message_title']) ? $error['message_title'] : ""}}">
@endif
@if (isset($success))
  <meta name="success" notify="{{ isset($success)&&isset($success['notify']) ? $success['notify'] : ""}}">
@endif