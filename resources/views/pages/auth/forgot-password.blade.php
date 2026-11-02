<form action="{{ route('password.email') }}" class="card-body flex flex-col gap-5 p-10" id="password_reset_form" method="post">
    <div class="text-center">
        <h3 class="text-lg font-medium text-gray-900">
            Restablecer Contraseña
        </h3>
        <span class="text-sm text-gray-700">
            Ingrese su correo electrónico para restablecer su contraseña
        </span>
    </div>
    <div class="flex flex-col gap-1">
        <label for="email" class="form-label font-normal text-gray-900">
            Email
        </label>
        <input name="email" id="email" class="input" placeholder="email@email.com" type="text">
    </div>
    <div class="grid grid-cols-2 gap-2">
        <a class="btn btn-secondary flex justify-center items-center" href="{{ route('login') }}">
            Volver
        </a>
        <button id="password_reset_submit" class="btn btn-primary flex justify-center items-center">
            Continuar
            <i class="ki-filled ki-black-right"></i>
        </button>
    </div>
</form>
