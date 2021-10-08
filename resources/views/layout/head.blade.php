<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Content management system</title>
<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
<!-- Styles -->
<link type="text/css" href="/assets/css/bootstrap.min.css" rel="stylesheet">
<link type="text/css" href="/assets/css/toastr.min.css" rel="stylesheet">
<link type="text/css" href="/assets/css/select2.min.css" rel="stylesheet">

<meta name="csrf-token" content="{{ csrf_token() }}">

@if (!empty(session('error')))
  <meta name="error" message="{{ session('error')["message"] ? session('error')["message"] : ""}}"
    message_title="{{ session('error')["message_title"] ? session('error')["message_title"] : ""}}">
@endif
@if (!empty(session('success')))
  <meta name="success" message="{{ session('success')["message"] ? session('success')["message"] : ""}}">
@endif
