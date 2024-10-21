<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;
    
    protected $table = 'Cargos';
    protected $fillable = ['Nome'];
    
    public function funcionarios()
    {
        return $this->hasMany(Funcionario::class, 'ID_Cargo', 'ID');
    }
}