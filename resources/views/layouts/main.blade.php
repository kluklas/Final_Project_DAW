@extends('layouts.base')
@section('main')
    <div class="flex grow">
        @include('layouts.sidebar')
        <div class="wrapper flex grow flex-col">
            @include('layouts.header')
            <main class="grow content pt-5" id="content" role="content">
                <div class="container-fluid" id="content_container"></div>
                <div class="container-fluid">
                    @yield('content')
                </div>
            </main>
            @include('layouts.footer')
        </div>
    </div>
@endsection