<div class="modal" data-modal="true" id="modal_user">
    <div class="modal-content modal-center-y max-w-[700px]">
        <div class="modal-header">
            <h3 class="modal-title">{{ $user ? 'Editar' : 'Crear' }} Usuario</h3>
            <button class="btn btn-xs btn-icon btn-light" data-modal-dismiss="true">
                <i class="ki-outline ki-cross"></i>
            </button>
        </div>
        <div class="modal-body">
            <form class="form">
                @if ($user)
                    <input type="hidden" name="id" value="{{ $user->id ?? null }}">
                @endif
                <div class="flex flex-col gap-1 mb-6">
                    <label for="name" class="form-label font-normal text-gray-900 flex item-center align-middle gap-1 max-w-32">
                        Nombre
                        <span class="text-danger">*</span>
                    </label>
                    <input name="name" id="name" class="input" placeholder="Nombre del usuario" type="text" value="{{ $user->name ?? '' }}">
                </div>
                <div class="flex flex-col gap-1 mb-6">
                    <label for="email" class="form-label font-normal texet-gray-900 flex items-center align-middle gap-1 max-w-32">
                        Email
                        <span class="text-danger">*</span>
                    </label>
                    <input name="email" id="email" class="input" placeholder="email@email.es" type="text" value="{{ $user->email ?? '' }}">
                </div>
                <div class="flex flex-col gap-1 mb-6">
                    <label for="password" class="form-label font-normal text-gray-900 flex items-center align-middle gap-1 max-w-32">
                        Contraseña
                        <span class="text-danger">*</span>
                    </label>
                    <input name="password" id="passwrod" class="input" placeholder="********" type="password">
                </div>
                <div class="flex flex-col gap-1 mb-6">
                    <label for="password_repeat" class="form-label font-normal text-gray-900 flex items-center align-middle gap-1 max-w-32">
                        Repetir Contraseña
                        <span class="text-danger">*</span>
                    </label>
                    <input type="password_repeat" id="password_repeat" class="input" placeholder="********" type="password">
                </div>
                <div class="flex gap-12">
                    <label class="form-label flex items-center gap-2.5 text-nowrap">
                        <input class="checkbox" name="is_admin" type="checkbox" {{ $user && $user->hasRole('Admin') ? 'checked=""' : '' }}>
                        Administrador
                    </label>
                </div>
                <div class="border-b border-b-gray-200 my-4"></div>
                <div class="flex justify-end gap-4">
                    <button type="button" class="btn btn-light" data-modal-dismiss="true">Cancelar</button>
                    <button id="btnSaveUser" class="btn btn-primary">{{ $user ? 'Actualizar' : 'Crear' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>