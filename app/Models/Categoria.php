<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    protected $primaryKey = 'ID';

    protected $fillable = ['Nome'];

    public function veiculos()
    {
        return $this->belongsTo(Veiculo::class, 'ID_Categoria');
    }

    public $timestamps = false; 

}
