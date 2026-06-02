<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('reservas', 'roles')->orderBy('name')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load('reservas.horario');
        return view('admin.users.show', compact('user'));
    }

    public function block(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes bloquearte a ti mismo.');
        }

        $user->update(['blocked' => !$user->blocked]);

        $action = $user->blocked ? 'bloqueado' : 'desbloqueado';
        return back()->with('success', "Usuario {$action} correctamente.");
    }

    public function changeRole(User $user, Request $request)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes cambiarte el rol a ti mismo.');
        }

        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $user->syncRoles([$request->role]);

        return back()->with('success', 'Rol cambiado correctamente.');
    }
}
