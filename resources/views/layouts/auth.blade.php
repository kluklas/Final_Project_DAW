@extends('layouts.base')
@section('styles')
    <style>
        .page-bg {
            background-image: url({{asset("assets/media/images/2600x1200/bg-6.png")}});
            width: 100vw;
            height: 100vh;
        }

        .dark .page-bg {
            background-image: url({{asset("assets/media/images/2600x1200/bg-14-dark.png")}});
            width: 100vw;
            height: 100vh;
        }
    </style>
@endsection
@section('main')
    <div class="flex items-center flex-col justify-center grow bg-center bg-cover bg-no-repeat page-bg">
        <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white" style="max-width: 400px">
            <img class="w-full h-full hidden dark:block" src="{{asset('assets/media/reservas/logo_descriptor.png')}}" alt="logo">
            <img class="w-full block dark:hidden" src="{{asset('assets/media/reservas/logo_descriptor.png')}}" alt="logo">
        </a>
        <div class="card max-w-[370px] w-full">
            @include($view)
        </div>
    </div>
@endsection
