<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuarios;

class LoginController extends Controller
{
    public function showLogin(){

        //si no se encuentra ningun rol en la variable de sesion que redireccione al login (ejemplo para las demas paginas)
        /*
        if (session()->has('rol')) {
            if (session('rol') == 1) return redirect()->route('admin.dashboard');
            if (session('rol') == 2) return redirect()->route('observador.dashboard');
        }
        return view('login');
        */

        return view('login');
    }

    function loginPost(Request $request){

        $request->validate([
            'usuario' => 'required',
            'password' => 'required'
        ]);

        // Busca el usuario por nombre de usuario
        $usuario = Usuarios::where('NombreUsuario', $request->usuario)->first();

        if ($usuario && $usuario->Password === $request->password) {
            // Guardar en sesión
            session([
                'idusuario' => $usuario->IdUsuario,
                'nombre' => $usuario->Nombre,
                'rol' => $usuario->IdRol
            ]);

            // Redirección según rol (ajusta los ID según tu base)
            if ($usuario->IdRol == 1) {
                return redirect()->route('admin.dashboard');
            } elseif ($usuario->IdRol == 2) {
                return redirect()->route('observador.inicio');
            } else {
                return redirect()->route('login')->with('error', 'Rol no reconocido.');
            }
        }

        return back()->with('error', 'Credenciales incorrectas.');
    }
    
    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
    
}
