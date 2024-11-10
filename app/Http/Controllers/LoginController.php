<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){

        $site = Site::first();

        return view('login', compact('site'));
    }

    public function store(Request $request){

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ],[
            'email.required' => 'Esse campo de email é obrigatório!',
            'email.email' => 'Email Inválido!',
            'password.required' => 'Esse campo de senha é obrigatório!',
        ]);

        $credentials = $request->only('email','password');

        $funcionario = Funcionario::where('email', $credentials['email'])->first();

        if(!$funcionario){
            return redirect()->route('login.index')->withErrors(['error' => 'Email inválido!']);
        }

        if($credentials['password'] == $funcionario->Senha){
            Auth::login($funcionario);
            return redirect()->route('dashboard.index');
        }else{
            return redirect()->route('login.index')->withErrors(['error' => 'Senha inválida!']);
        }
    }

    public function destroy(){
        Auth::logout();
        return redirect()->route('home');
    }

}
