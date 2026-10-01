<?php

use App\Http\Requests\SaveUserPermissionsRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use League\OAuth2\Client\Provider\GenericProvider;
use \Illuminate\Support\Facades\Log;

if (!function_exists('theme')) {
    function theme()
    {
        return app(App\Core\Theme::class);
    }
}

if (!function_exists('getCustomJs')) {
    /**
     * Get custom js files from the settings
     *
     * @return array
     */
    function getCustomJs()
    {
        return theme()->getCustomJs();
    }
}

if (!function_exists('getCustomCss')) {
    /**
     * Get custom css files from the settings
     *
     * @return array
     */
    function getCustomCss()
    {
        return theme()->getCustomCss();
    }
}

if (!function_exists('getCustomJs')) {
    /**
     * Get custom js files from the settings
     *
     * @return array
     */
    function getCustomJs()
    {
        return theme()->getCustomJs();
    }
}

if (!function_exists('getCustomCss')) {
    /**
     * Get custom css files from the settings
     *
     * @return array
     */
    function getCustomCss()
    {
        return theme()->getCustomCss();
    }
}

if (!function_exists('addJavascriptFile')) {
    /**
     * Add custom javascript file to the page
     *
     * @param $file
     *
     * @return void
     */
    function addJavascriptFile($file)
    {
        theme()->addJavascriptFile($file);
    }
}

if (!function_exists('addCssFile')) {
    /**
     * Add custom CSS file to the page
     *
     * @param $file
     *
     * @return void
     */
    function addCssFile($file)
    {
        theme()->addCssFile($file);
    }
}

if (!function_exists('esEnlaceValido')) {
    function esEnlaceValido($valor)
    {
        // Verifica si el valor es una URL válida y comienza con http, https o file
        if (filter_var($valor, FILTER_VALIDATE_URL) !== false) {
            $protocolosPermitidos = ['http', 'https', 'file'];
            $protocolo = parse_url($valor, PHP_URL_SCHEME);

            return in_array($protocolo, $protocolosPermitidos);
        }
        return false;
    }
}

if (!function_exists('normalizeName')) {
    /**
     * Normaliza un nombre reemplazando los espacios por guiones bajos y convirtiendo
     * caracteres especiales a sus equivalentes ASCII.
     *
     * Esta función toma una cadena de texto (nombre) y realiza dos operaciones:
     * 1. Utiliza la función `Str::ascii()` para convertir cualquier carácter especial
     *    (como tildes o caracteres no latinos) a su equivalente en ASCII.
     * 2. Reemplaza los espacios en blanco por guiones bajos ('_') para estandarizar el nombre.
     *
     * @param string $name El nombre o cadena de texto que se desea normalizar.
     * @return string El nombre normalizado con espacios reemplazados por guiones bajos
     *                y caracteres especiales convertidos a ASCII.
     */
    function normalizeName($name)
    {
        // Convierte caracteres especiales a ASCII y reemplaza los espacios por guiones bajos
        return str_replace(' ', '_', Str::ascii($name));
    }
}

if (!function_exists('updatePermissions')) {
    /**
     * Actualiza los permisos de un usuario en base a los datos proporcionados en la solicitud.
     *
     * La función toma los permisos enviados en el request y actualiza los permisos del usuario
     * de acuerdo con las acciones solicitadas (agregar o quitar permisos). Si un permiso ya
     * está asignado, no se vuelve a agregar. Si un permiso no está presente en los datos,
     * se elimina del usuario. Si ocurre un error durante el proceso, se maneja de forma
     * adecuada y se devuelve una respuesta con el error.
     *
     * @param User $user El usuario cuyos permisos se van a actualizar.
     * @param SaveUserPermissionsRequest $request Los datos de la solicitud que contienen
     *                                            los permisos a agregar o quitar.
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el resultado de la operación.
     */
    function updatePermissions(User $user, SaveUserPermissionsRequest $request)
    {
        try {
            // Obtener los permisos enviados en el request, agrupados por tipo de acción
            $permissions = [
                'read' => $request->input('read', []),
                'update' => $request->input('update', []),
                'configuration' => $request->input('configuration', []),
                'filter' => $request->input('filter', [])
            ];

            // Inicializar arrays para permisos a agregar y a quitar
            $permissionsToAdd = [];
            $permissionsToRemove = [];

            // Iterar sobre cada tipo de permiso (read, update, etc.)
            foreach ($permissions as $action => $permissionArray) {

                // Iterar sobre cada permiso de la acción
                foreach ($permissionArray as $permission) {
                    // Ignorar permisos con id inválido (null o no numérico)
                    if (!is_numeric($permission['id']) || $permission['id'] === null) {
                        continue;
                    }

                    // Agregar el permiso a la lista de permisos a agregar o quitar según su valor
                    if ($permission['value'] === 'true' || $permission['value'] === true) {
                        $permissionsToAdd[] = $permission['id'];
                    } else {
                        $permissionsToRemove[] = $permission['id'];
                    }
                }
            }

            // Obtener los permisos actuales del usuario (solo los IDs)
            $currentPermissions = $user->permissions->pluck('id')->toArray();

            // Calcular los permisos a agregar (no presentes actualmente) y a quitar (ya asignados)
            $permissionsToAdd = array_diff($permissionsToAdd, $currentPermissions);
            $permissionsToRemove = array_intersect($currentPermissions, $permissionsToRemove);

            // Agregar los permisos nuevos sin quitar los existentes
            $user->permissions()->syncWithoutDetaching($permissionsToAdd);
            // Quitar los permisos que ya no deben estar asignados
            $user->permissions()->detach($permissionsToRemove);

            // Respuesta de éxito con los permisos actualizados
            $response = [
                'status' => true,
                'message' => 'Permisos guardados correctamente',
                'data' => [
                    'user' => $user,
                    'permissions' => $permissionsToAdd
                ]
            ];
        } catch (\Exception $e) {
            // Manejo de excepciones en caso de error
            return response()->json([
                'status' => false,
                'message' => 'Error al guardar los permisos',
                'error' => $e->getMessage()
            ]);
        }

        // Devolver la respuesta con el estado de la operación
        return response()->json($response);
    }
}
