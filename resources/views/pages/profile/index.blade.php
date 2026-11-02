@extends('layouts.main')
@section('styles')
    <style>
        .hero-bg {
            background-image: url({{asset("assets/media/images/2600x1200/bg-1.png")}});
        }

        .dark .hero-bg {
            background-image: url({{asset("assets/media/images/2600x1200/bg-1-dark.png")}});
        }
    </style>
@endsection
@section('main')
    <form id="update_profile" class="form" enctype="multipart/form-data">
        @csrf
        <div class="bg-center bg-cover bg-no-repeat hero-bg mb-14">
            <div class="w-1/2 md:w-1/4 lg:w-1/6 mx-auto">
                <input id="avatar" type="file" class="filepond" name="avatar" accept="image/png, image/jpeg, image/jpg">
            </div>
        </div>
        <div class="grid grif-cols-1 gap-4">
            <div class="card min-w-full">
                <div class="card-header flex-wrap">
                    <h3 class="card-title">Datos Personales</h3>
                    <button type="button" id="btnSaveProfile" class="btn btn-clear btn-primary">
                        <i class="ki-outline ki-plus-squared"></i>
                        Guardar
                    </button>
                </div>
                <div class="card-table scrollable-x-auto">
                    <table class="table align-middle text-sm text-gray-500">
                        <tbody>
                            <tr>
                                <td class="py-2 text-gray-600 font-normal">Nombre</td>
                                <td class="py-2 text-gray-800 font-normal text-sm">
                                    <input type="text" name="name" class="input input-sm" value="{{ $user->name }}">
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 text-gray-600 font-normal">Email</td>
                                <td class="py-2 text-gray-800 font-normal text-sm">
                                    <input type="text" name="email" class="input input-sm" value="{{ $user->email }}">
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 text-gray-600 font-normal">Contraseña</td>
                                <td class="py-2 text-gray-800 font-normal text-sm">
                                    <input type="text" name="passwrod" class="input input-sm" placeholder="*****">
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 text-gray-600 font-normal">Repetir Contraseña</td>
                                <td class="py-2 text-gray-800 font-normal text-sm">
                                    <input type="text" name="password_repeat" class="input input-sm" placeholder="******">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
@endsection