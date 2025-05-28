<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    public function usuarios(){

        $usuarios = Usuarios::all();

        return view('admin.usuarios', compact('usuarios'));
    }
    
    public function guardar(Request $request){
        
        //validar datos
        $request->validate([
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'username' => 'required|string|max:50|unique:usuarios,NombreUsuario',
            'password' => 'required|string|min:6',
            'rol' => 'required|in:administrador,observador',
        ],  [
            '',
            '',
            
        ]);

        //mapear roles
        $rolMap = [
            'administrador' => 1,
            'observador' => 2,
        ];

        try {
            
            Usuarios::create([
                'Nombre' => $request->nombre,
                'Apellido' => $request->apellido,
                'NombreUsuario' => $request->username,
                'Password' => Hash::make($request->password),
                'IdRol' => $rolMap[$request->rol]
            ]);
    
            return redirect()->back()->with('success', 'Usuario creado correctamente.');

        } catch (\Exception $e) {
            
            return redirect()->back()->with('error', 'Ocurrió un error al crear el usuario.');
        }
    }

    public function editar(Request $request, $id){
        
        $request->validate([
            'nombre'    => 'required|string|max:255',
            'apellido'  => 'required|string|max:255',
            'username'  => 'required|string|max:255|unique:usuarios,NombreUsuario,' . $id . ',IdUsuario',
            'rol'       => 'required|in:administrador,observador',
            'password'  => 'nullable|string|min:6',
        ]);

        $usuario = Usuarios::findOrFail($id);

        $usuario->Nombre = $request->nombre;
        $usuario->Apellido = $request->apellido;
        $usuario->NombreUsuario = $request->username;
        $usuario->IdRol = $request->rol === 'administrador' ? 1 : 2;

        // Solo actualiza la contraseña si se proporciona una nueva
        if ($request->filled('password')) {
            $usuario->Password = Hash::make($request->password);
        }

        $usuario->save();

        return redirect()->route('admin.usuarios')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($id)
    {
        $usuario = Usuarios::findOrFail($id);
        $usuario->delete();
        return redirect()->route('admin.usuarios')->with('success', 'Usuario eliminado correctamente.');
    }

}
