<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        addJavascriptFile('resources/js/auth/reset-password.js');

        $view = 'pages.auth.forgot-password';
        return view('layouts.auth', compact('view'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::broker('users')->sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'status' => true,
                'message' => 'Correo electrónico enviado exitosamente.',
            ]);
        } else if ($status === Password::INVALID_USER) {
            return response()->json([
                'status' => false,
                'message' => 'No se encontró un usuario con ese correo electrónico.',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Ocurrió un error al enviar el correo electrónico.',
            ]);
        }
    }
}
