<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;
    
    protected $table = 'funcionarios';
    protected $fillable = [
        'Nome', 'Senha', 'CPF', 'Email', 'Sexo', 'DataNasc', 'Telefone', 'ID_Cargo'
    ];
    
    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'ID_Cargo', 'ID');
    }
    
    protected $hidden = ['Senha'];
    public $timestamps = false; // Se a tabela não tiver colunas created_at/updated_at
}