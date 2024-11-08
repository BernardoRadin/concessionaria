<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;

    protected $table = 'vendas';

    protected $primaryKey = 'ID';

    protected $fillable = ['ID_Veiculo','ID_Cliente','ID_Funcionario','Data','PrecoVenda','Descricao'];

    public $timestamps = false; 

    public function veiculo()
    {
        return $this->hasOne(Veiculo::class, 'ID', "ID_Veiculo");
    }

    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'ID', "ID_Cliente");
    }

    public function funcionario()
    {
        return $this->hasOne(Funcionario::class, 'ID', "ID_Funcionario");
    }


}
