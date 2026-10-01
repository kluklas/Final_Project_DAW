<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    public function index()
    {
        addJavascriptFile('resources/js/pages/users/Users.js');

        return view('pages.users.index');
    }

    public function listado(Request $request)
    {
        $users = User::where('id', '!=', auth()->id());

        return \DataTables::eloquent($users)    
            ->addColumn('role', function ($user) {
                return ucfirst($user->roles->first()->name);
            })
            ->toJson();
    }

    public function modal(?User $user = null)
    {
        try {
            $response = [
                'status' => true,
                'message' => 'Modal cargado correctamente',
                'data' => [
                    'view' => view('pages.users.modals.form', compact( 'user'))->render(),
                    'modal_id' => '#modal_user'
                ]
            ];
        } catch (\Exception $e) {
            $response = [
                'status' => true,
                'message' => 'Error al cargar el modal',
                'error' => $e->getMessage()
            ];
        }
        return response()->json($response);
    }

    public function store(StoreUserRequest $request)
    {
        try {
            $validateData = $request->validated();
            $validateData['password'] = Hash::make($request->password);
            $user = User::create($validateData);
            if ($request->has('is_admin') && $request->is_admin) {
                $user->assignRole('Admin');
            } else {
                $user->assignRole('User');
            }
            return response()->json([
                'status' => true,
                'message' => 'Usuario guardado correctamente',
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error al guardar el Usuario',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function update(User $user, UpdateUserRequest $request)
    {
        try {
            $validateData = $request->validated();
            if ($request->has('password') && !is_null($request->password)) {
                $validateData['password'] = Hash::make($validateData['password']);
                $user->update($validateData);
            } else {
                $user->update($request->except('password'));
            }
            if ($request->has('is_admin') && $request->is_admin) {
                $user->syncRoles(['Admin']);
            } else {
                $user->syncRoles(['User']);
            }
            return response()->json([
                'status' => true,
                'message' => 'Usuario actualizado correctamente',
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error al actualizar el Usuario',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function updateStatus(User $user)
    {
        try {
            $user->update(['status' => !$user->status]);
            return response()->json([
                'status' => true,
                'message' => 'Estado del usuario actualizado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error al cambiar el estado del usuario',
                'error' => $e->getMessage()
            ]);
        }

    }

    public function avatar(User $user)
    {
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
