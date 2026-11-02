<form action="{{ route('login')}} " class="card-body flex flex-col gap-5 p-10" id="login_form" method="get">
    <div class="text-center mb-2.5">
        <h3 class="text-lg font-medium text-gray-900 leading-none mb-2.5">
            Iniciar Sesión
        </h3>
    </div>
    <div class="flex flex-col gap-1">
        <label for="email" class="form-label font-normal text-gray-900">
            Email
        </label>
        <input name="email" id="email" class="input" placeholder="email@email.com" type="text">
    </div>
    <div class="flex flex-col gap-1">
        <div class="flex items-center justify-between gap-1">
            <label for="password" class="form-label font-normal text-gray-900">
                Contraseña
            </label>
            <a class="text-2sm link shrink-0" href="{{ route('password.request') }}">
                ¿Olvidaste tu contraseña?
            </a>
        </div>
        <div class="relative" data-toggle-password="true">
            <input name="password" id="password" placeholder="Introduce tu contraseña" type="password"
                class="input invalid:border-pink-500 invalid:text-pink-600 focus:invalid:border-pink-500 focus:invalid:ring-pink-500">
            <button class="absolute right-0 top-0 mr-2 btn btn-icon" data-toggle-password-trigger="true" type="button">
                <i class="ki-filled ki-eye text-gray-500 hover:text-gray-700 toggle-password-active:hidden "></i>
                <i class="ki-filled ki-eye-slash text-gray-500 hover:text-gray-700 hidden toggle-password-active:block"></i>
            </button>
        </div>
        <p id="password-error-message" class="mt-2 text-pink-600 text-sm hidden">El campo password es obligatorio.</p>
    </div>
    <button type="button" id="login_submit" class="btn btn-primary flex justify-center grow">
        Iniciar Sesión
    </button>
</form>
