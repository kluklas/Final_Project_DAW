<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProfileController extends Controller
{
    public function index()
    {
        addJavascriptFile('resources/js/pages/profile/Profile.js');
        $user = auth()->user();
        return view('pages.profile.index', compact('user'));

    }
    public function update(UpdateProfileRequest $request)
    {
        try {
            $user = auth()->user();
            $validateData = $request->validated();
            unset($validateData['avatar']);
            // Actualizamos todos los campos del usuario menos la contraseña si es nula
            if ($request->has('password') && !is_null($request->password)) {
                $validateData['password'] = bcrypt($validateData['password']);
                $user->update($validateData);
            } else {
                $user->update($request->except('password', 'avatar'));
            }

            if ($request->has('avatar_remove') && !is_null($request->avatar_remove)) {
                if ($user->avatar && Storage::exists($user->avatar)) {
                    Storage::delete($user->avatar);
                }
                $user->avatar = null;
                $user->save();
            }

            if ($request->hasFile('avatar')) {
                if ($user->avatar && Storage::exists($user->avatar)) {
                    Storage::delete($user->avatar);
                }
                $avatar = $request->file('avatar');
                // Crea una instancia de la imagen usando Intervention/Image
                $manager = new ImageManager(Driver::class);

                $imageName = Str::random(20) . '.jpg';

                $imageResize = $manager->read($avatar);

                // Cambiamos el formato de la imagen a jpg
                $imageResize->toJpeg(90);

                // Redimensiona la imagen a 800px de ancho y 600px de alto
                $imageResize->resize(800, 800);
                // Define la ruta donde se guardará la imagen
                $path = '/usersAvatar/' . $imageName;

                // Verifica si la carpeta de destino existe, si no, la crea
                $destinationPath = storage_path('app/usersAvatar');
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true, true);
                }

                // Guarda la imagen redimensionada y orientada en la ubicación deseada
                $imageResize->save(storage_path('app' . $path));
                $user->avatar = $path;
                $user->save();
            }
            return response()->json([
                'status' => true,
                'message' => 'Perfil actualizado correctamente',
                'data' => $user
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error al actualizar el perfil',
                'data' => $e->getMessage()
            ]);
        }
    }
    public function getAvatar()
    {
        $user = auth()->user();
        if (is_null($user->avatar)) {
            $imagePath = public_path('assets/media/avatars/blank.png');
            return response()->file($imagePath, [
                'Content-Type' => 'image/png',
                'Content-Disposition' => 'inline',
            ]);
        } else {
            return Storage::response($user->avatar, null, [
                'Content-Type' => Storage::mimeType($user->avatar),
                'Content-Disposition' => 'inline'
            ]);
        }
    }
}
