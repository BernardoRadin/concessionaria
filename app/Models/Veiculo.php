<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    use HasFactory;

    protected $table = 'veiculos';

    protected $primaryKey = 'ID';

    protected $fillable = ['Nome',
    'Ano',
    'Cambio',
    'Motor',
    'Quilometragem',
    'Combustivel',
    'PrecoCusto',
    'PrecoVenda',
    'Descricao',
    'Em_Estoque',
    'Cor',
    'Portas',
    'ID_Categoria',
    'ID_Marca',
    'ID_AntigoDono',
    'ID_Funcionario'];

    public function categoria()
    {
        return $this->hasOne(Categoria::class, 'ID', "ID_Categoria");
    }

    public function marca()
    {
        return $this->hasOne(Marca::class, 'ID', "ID_Marca");
    }

    public function antigodono()
    {
        return $this->hasOne(Cliente::class, 'ID', "ID_AntigoDono");
    }

    public function funcionario()
    {
        return $this->hasOne(Funcionario::class, 'ID', "ID_Funcionario");
    }

    public function fotoprincipal()
    {
        return $this->hasOne(Fotos::class, 'ID_Veiculo', "ID")->where('Principal', 1);;
    }

    public function fotos()
    {
        return $this->hasMany(Fotos::class, 'ID_Veiculo', "ID");
    }

    public $timestamps = false; 

}
