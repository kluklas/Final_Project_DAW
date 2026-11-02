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
        <div class="flex flex-col items-center justify-center h-[95%]" >
            <div class="mb-10" >
                <img alt="image" class="dark:hidden max-h-[160px]" src="{{asset('assets/media/illustrations/12.svg')}}">
                <img alt="image" class="light:hidden max-h-[160px]" src="{{asset('assets/media/illustrations/12.svg')}}">
            </div>
            <span class="badge badge-primary badge-outline mb-3">403 Error</span>
            <h3 class="text-2.5xl font-semibold text-gray-900 text-center mb-2">
                No tienes permisos para acceder a esta página.
            </h3>
            <div class="text-md text-center text-gray-700 mb-10" >
                <a class="text-primary font-medium hover:text-primary-active" href="{{route('dashboard')}}">Volver al inicio</a>
                .
            </div>
        </div>
    </div>
@endsection