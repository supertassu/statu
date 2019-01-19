<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title') &mdash;
        {{ config('statu.name') }}
    </title>

    <link rel="preload" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
          as="style" onload="this.rel = 'stylesheet'">

    @if (Request::query('dark') === 'true')
        <link href="{{ asset('css/dark.css') }}" rel="stylesheet">
    @else
        <link href="{{ asset('css/light.css') }}" rel="stylesheet">
    @endif

    <script>
        window.dateFormat = '{{ config('statu.date-format', 'MMM Do, HH:mm') }}';
        window.apiBaseUrl = '{{ config('statu.api-base-url', '/') }}';
        window.refreshTime = parseInt('{{ config('statu.refresh-time', 30) }}');
        window.expandCategoriesByDefault = '{{ config('statu.expand-categories-by-default', true) }}' === '1';
    </script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    @yield('assets')
</head>
<body>

<section class="section" id="app">
    <div class="container">
        <small style="margin-top: 15px;">
            @if (Request::query('dark') === 'true')
                <a href="?dark=false">Use light theme</a>
            @else
                <a href="?dark=true">Use dark theme</a>
            @endif
        </small>

        @yield('content')

        <p style="margin-top: 15px;">
            Powered by <strong><a href="https://github.com/supertassu/statu">Statu</a></strong>
            <a href="https://github.com/supertassu/statu/commit/{{ \App\ApplicationVersion::instance()->getLongHash() }}">{{ \App\ApplicationVersion::instance()->get() }}</a>.
        </p>
    </div>
</section>

</body>
</html>
