<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="application-name" content="{{ config('app.name') }}"/>

<title>{{ config('app.name') }}@yield('title')</title>

<meta property="og:url" content="{{ config('app.url') }}">
<meta property="og:type" content="application">
<meta property="og:title" content="{{ config('app.name') }}">
<meta property="og:description" content="{{ config('app.description') }}">
<meta property="og:image" content="{{ config('app.card_image') }}">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ config('app.name') }}">
<meta name="twitter:description" content="{{ config('app.description') }}">
<meta name="twitter:image" content="{{ config('app.card_image') }}">

<link rel="shortcut icon" href="{{ secure_asset('inspireddeck/favicon.ico') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ secure_asset('inspireddeck/apple-touch-icon.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ secure_asset('inspireddeck/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ secure_asset('inspireddeck/favicon-16x16.png') }}">
<link rel="manifest" href="{{ secure_asset('inspireddeck/site.webmanifest') }}">
<link rel="mask-icon" href="{{ secure_asset('inspireddeck/safari-pinned-tab.svg') }}" color="#5bbad5">
<meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}">
<meta name="application-name" content="{{ config('app.name') }}">

<meta name="msapplication-TileColor" content="#ffffff">
<meta name="theme-color" content="#3D9DFA">
