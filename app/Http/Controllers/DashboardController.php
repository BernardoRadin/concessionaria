<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Funcionario;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        return view('dashboard');
    }
    
    public function funcionarios(){

        $funcionarios = DB::table('funcionarios')->get();

        return view('dashboard_funcionarios', compact('funcionarios'));
    }

}
