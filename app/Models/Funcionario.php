<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Authenticatable
{
    protected $table = 'funcionarios';
    
    protected $primaryKey = 'ID';

    protected $fillable = ['Nome',
    'Senha',
    'CPF',
    'Email',
    'Sexo',
    'DataNasc',
    'Telefone',
    'Endereco',
    'ID_Cargo'];

    public function cargo()
    {
        return $this->hasOne(Cargo::class, 'ID', "ID_Cargo");
    }

    protected $hidden = ['Senha'];

    public $timestamps = false; 
}
