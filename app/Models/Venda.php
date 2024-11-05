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

}
