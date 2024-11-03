<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    
    protected $primaryKey = 'ID';

    protected $fillable = ['Nome',
    'Email',
    'DataNasc',
    'Sexo',
    'CPF',
    'Telefone',
    'Endereco',
    'Descricao'];

    public $timestamps = false;
    
    public function antigodono()
    {
        return $this->belongsTo(Cliente::class, 'ID_AntigoDono');
    }

}
