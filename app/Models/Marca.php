<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

    protected $table = 'marcas';

    protected $primaryKey = 'ID';

    protected $fillable = ['Nome','Logo'];

    public $timestamps = false; 

    public function veiculos()
    {
        return $this->belongsTo(Funcionario::class, 'ID_Marca');
    }

}
