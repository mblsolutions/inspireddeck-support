
<!doctype html>
<html lang="en">
<head>
    @include('inspireddeck.helpers.head-meta')

    <script>
        window.INSPIREDDECK = {!! deck_js_object() !!}
    </script>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('inspireddeck/css/vue-datetime.css') }}">
</head>
<body class="font-sans subpixel-antialiased bg-gray-200">
<div id="app">

    <nav class="fixed top-0 left-0 right-0 z-20 shadow">
        <div class="flex w-full h-14 px-4 text-white bg-brand-gray-1000 items-center">
            <svg class="text-brand-blue-500 fill-current h-10 w-10 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="-17.5 482.5 36 36">
                <path d="M-.531 500.016h-.631a2.218 2.218 0 0 1-2.23-2.229v-4.292a1.13 1.13 0 0 0-1.135-1.137h-9.55a2.218 2.218 0 0 0-2.23 2.23v7.488a2.217 2.217 0 0 0 2.23 2.229h1.094c.631 0 1.136-.505 1.136-1.136a2.216 2.216 0 0 1 2.229-2.229h9.087a.487.487 0 0 0 .505-.506c0-.207-.211-.418-.505-.418z"/>
                <path d="M11.164 488.025h-12.79c-.967 0-1.767.799-1.767 1.768v1.514c0 .589.505 1.095 1.094 1.095h.505c.968 0 1.767.799 1.767 1.767v5.386c0 .294.21.504.504.504h.084c.295 0 .505-.21.505-.504v-1.095c0-.968.8-1.767 1.767-1.767h9.003c.589 0 1.094-.505 1.094-1.094v-5.806c-.041-.969-.798-1.768-1.766-1.768z"/>
                <path d="M3.339 508.641c-1.262 0-2.272-1.01-2.272-2.23v-4.922a.485.485 0 0 0-.505-.504H.478a.485.485 0 0 0-.504.504v.631a2.217 2.217 0 0 1-2.23 2.229h-8.499c-.63 0-1.135.506-1.135 1.137v5.258a2.217 2.217 0 0 0 2.23 2.23H2.161a2.217 2.217 0 0 0 2.229-2.23v-1.009c.043-.589-.462-1.094-1.051-1.094z"/>
                <path d="M15.119 496.692h-1.094c-.631 0-1.094.505-1.094 1.095 0 1.219-1.01 2.229-2.271 2.229H1.53a.512.512 0 0 0-.505.505c0 .252.21.505.505.505h.631a2.262 2.262 0 0 1 2.271 2.271v4.292c0 .631.505 1.094 1.094 1.094h9.55c1.22 0 2.229-1.01 2.229-2.23v-7.53c.044-1.264-.966-2.231-2.186-2.231z"/>
            </svg>
            <a class="text-lg ml-2 text-white whitespace-no-wrap" href="{{ route('dashboard') }}">
                Inspired Deck
            </a>

            @include('navigation.head')
        </div>

        <div class="flex w-full h-12 text-gray-600 bg-white text-sm items-center">
            @yield('sub-navigation')
        </div>
    </nav>

    <div class="container mt-32 mx-auto">
        <main role="main" class="mx-4">
            @yield('content')

            @yield('transaction-content')

            @yield('report-content')


        </main>

        <main role="main" class="mx-4">
            @yield('report-render')
        </main>

        <div class="text-center mt-4 mb-4 text-brand-blue-500 text-xs">
            <a href="{{ route('privacy') }}" class="inline-block mr-5">Privacy Policy</a>
            <a href="{{ route('terms') }}" class="inline-block ml-5">Terms of Service</a>
            <p class="text-gray-500 mt-3">
                Copyright &copy; {{ date('Y') }} <a href="https://www.mblsolutions.co.uk">MBL Solutions Ltd.</a>
            </p>
        </div>

    </div>

</div>
<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>

@yield('extended-scripts')

</body>
</html>
