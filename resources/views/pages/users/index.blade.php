@extends('layouts.main')
@section('content')
<div class="grid">
        <div class="card card-grid min-w-full ">
            <div class="card-header py-5 flex-wrap">
                <h3 class="card-title flex flex-row justify-center align-middle items-center gap-2">
                    <i class="ki-outline ki-users text-lg"></i>
                    Usuarios
                </h3>
                <div class="flex flex-row justify-center align-middle items-center gap-2">
                    <input name="search" type="text" class="input input-sm w-[150px]" placeholder="Buscar...">
                    <button id="btnNewUser" class="btn btn-clear btn-primary">
                        <i class="ki-outline ki-plus-squared"></i>
                        Nuevo Usuario
                    </button>
                </div>
            </div>
            <div class="card-body ">
                <div class="card-table scrollable-x-auto">
                    <table id="table" class="table table-auto table-border align-middle text-gray-700 font-medium text-sm"></table>
                </div>
            </div>
        </div>
    </div>
@endsection