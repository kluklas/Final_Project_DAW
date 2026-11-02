<form action="{{ route('password.update') }}" class="card-body flex flex-col gap-5 p-10" id="new_password_form" method="post" data-redirect-url="{{ route('login') }}">
    <input type="hidden" name="token" value="{{ $request->token }}">
    <input type="hidden" name="email" value="{{ old('email', $request->email) }}">
    <div class="text-center" >
        <h3 class="text-lg font-medium text-gray-900">
            Cambiar Contraseña
        </h3>
        <span class="text-2sm text-gray-700">Introduce tu nueva contraseña</span>
    </div>
    <div class="flex flex-col gap-1">
        <div class="flex items-center justify-between gap-1">
            <label for="password" class="form-label font-normal text-gray-900">
                Nueva Contraseña
            </label>
        </div>
        <div class="relative" data-toggle-password="true">
            <input name="password" id="password" placeholder="Introduce una nueva contraseña" type="password" class="input invalid:border-pink-500 invalid:text-pink-600 focus:invalid:border-pink-500 focus:invalid:ring-pink-500">
            <button class="absolute right-0 top-0 mr-2 btn btn-icon" data-toggle-password-trigger="true" type="button">
                <i class="ki-filled ki-eye text-gray-500 hover:text-gray-700 toggle-password-active:hidden "></i>
                <i class="ki-filled ki-eye-slash text-gray-500 hover:text-gray-700 hidden toggle-password-active:block"></i>
            </button>
        </div>
    </div>
    <div class="flex flex-col gap-1">
        <div class="flex items-center justify-between gap-1">
            <label for="password_confirmation" class="form-label font-normal text-gray-900">
                Confirmar Nueva Contraseña
            </label>
        </div>
        <div class="relative" data-toggle-password="true">
            <input name="password_confirmation" id="password_confirmation" placeholder="Vuelve a introducir la contraseña" type="password" class="input invalid:border-pink-500 invalid:text-pink-600 focus:invalid:border-pink-500 focus:invalid:ring-pink-500">
            <button class="absolute right-0 top-0 mr-2 btn btn-icon" data-toggle-password-trigger="true" type="button">
                <i class="ki-filled ki-eye text-gray-500 hover:text-gray-700 toggle-password-active:hidden "></i>
                <i class="ki-filled ki-eye-slash text-gray-500 hover:text-gray-700 hidden toggle-password-active:block"></i>
            </button>
        </div>
    </div>
    <button id="new_password_submit" class="btn btn-primary flex justify-center grow">
        Confirmar
    </button>
</form>
