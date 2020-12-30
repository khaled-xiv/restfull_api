<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable=[
        'name',
        'description',
        'quantity',
        'image',
        'status',
        'seller_id',
    ];
    protected $hidden = [
        'pivot'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
