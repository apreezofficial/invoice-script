<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoice';
    
    protected $fillable = [
        'user_id',
        'invoice_nunber',
        'enum',
        'due_date',
        'description',
    ];

}
