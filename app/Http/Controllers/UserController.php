<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Muestra el formulario de edición de usuario.
     */
    public function edit()
    {
        $user = Auth::user(); // Obtiene el usuario autenticado
        return view('user.edit', compact('user'));
    }

    /**
     * Actualiza los datos del usuario.
     */
    public function update(Request $request)
    {
        // Valida los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'nullable|min:8|confirmed',
        ]);

        // Obtiene el usuario autenticado
        $user = Auth::user();

        // Actualiza los datos del usuario
        $user->name = $request->name;
        $user->email = $request->email;

        // Solo actualiza la contraseña si se proporcionó una nueva
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Redirecciona con un mensaje de éxito
        return redirect()->route('home')->with('success', 'Datos actualizados correctamente.');
    }
}
