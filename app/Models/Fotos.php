<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fotos extends Model
{
    use HasFactory;

    protected $table = 'fotos';
    
    protected $primaryKey = 'ID';

    protected $fillable = ['Foto',
    'Principal',
    'ID_Veiculo',
    ];

    public $timestamps = false;
    
    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class, 'ID_Veiculo');
    }

}
