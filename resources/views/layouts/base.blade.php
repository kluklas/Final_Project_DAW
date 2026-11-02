<!doctype html>
<html class="h-full" data-theme="true" data-theme-mode="light" lang="{{config('app.locale')}}">

<head>
    <meta charset="utf-8">
    <title>{{config('app.name')}}</title>
    <base href="/">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="{{asset('assets/media/app/favicon.ico')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/media/app/favicon.ico')}}">
    <link rel="apple-touch-icon" href="{{asset('assets/media/app/favicon.ico')}}">
    <link rel="manifest" href="/manifest.json">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
	<meta property="og:type" content="website" />
	<meta property="og:title" content="Reservas LMV" />
    <meta name="description" content="Aplicación de reservas" />
	<meta property="og:description" content="Aplicación de reservas"/>
	<meta property="og:image" content="{{asset('assets/media/app/og.jpg')}}" />
	<meta property="og:locale" content="es_ES" />
	<meta property="og:site_name" content="Reservas LMV" />
    @vite('resources/css/app.scss')
    @vite(getCustomCss())
    @yield('styles')
    @routes
</head>
<body class="flex h-full demo1 sidebar-fixed header-fixed bg-[#fefefe] dark:bg-coal-500 {{isset($_COOKIE["sidebar_minimize_state"]) && $_COOKIE["sidebar_minimize_state"] === "on" ? 'sidebar-collapse' : ''}}">
<!--begin::Theme mode setup on page load-->
@vite('resources/js/config/global.js')
@vite('resources/js/config/dataTables.tailwindcss.js')
@vite(getCustomJs())
<script>
    const defaultThemeMode = 'light'; // light|dark|system
    let themeMode;
    if (document.documentElement) {
        if (localStorage.getItem('theme')) {
            themeMode = localStorage.getItem('theme');
        } else if (document.documentElement.hasAttribute('data-theme-mode')) {
            themeMode = document.documentElement.getAttribute('data-theme-mode');
        } else {
            themeMode = defaultThemeMode;
        }
        if (themeMode === 'system') {
            themeMode = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        }
        document.documentElement.classList.add(themeMode);
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

<!--end::Theme mode setup on page load-->
@yield('main')
@vite('resources/js/app.js')
</body>
</html>
