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

        <div class="flex items-center justify-center grow h-full" >
            <div class="flex flex-col items-center" >
                <div class="mb-16" >
                    <img alt="image" class="dark:hidden max-h-[160px]" src="{{asset('assets/media/illustrations/10.svg')}}">
                    <img alt="image" class="light:hidden max-h-[160px]" src="{{asset('assets/media/illustrations/10-dark.svg')}}">
                </div>
                <span class="badge badge-primary badge-outline mb-3">503 Error</span>
                <h3 class="text-2.5xl font-semibold text-gray-900 text-center mb-2">
                    Servicio no disponible
                </h3>
                <div class="text-md text-center text-gray-700 mb-10" >
                    Lo sentimos, el servicio no está disponible en este momento.
                </div>
            </div>
        </div>
    </div>
@endsection
