<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $table = 'site';
    
    protected $primaryKey = 'ID';

    protected $fillable = ['Email',
    'Telefone',
    'Endereco',
    'Instagram',
    'Facebook',
    'Whatsapp',
    'Logo',
    'Sobre',
    ];

    public $timestamps = false;

}
