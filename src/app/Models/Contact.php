<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'category_id',
        'gender',
        'email',
        'tel',
        'address',
        'building',
        'detail',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeContactSearch($query, $request)
    {
        if (!empty($request->word)) {
            $query->where('first_name', 'like', "%{$request->word}%")->orWhere('last_name', 'like', "%{$request->word}%")->orWhere('email', 'like', "%{$request->word}%");
        }

        if (!empty($request->gender)) {
            $query->where('gender', $request->gender);
        }

        if (!empty($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }

        if (!empty($request->date)) {
            $query->whereDate('created_at', $request->date);
        }
        return $query;
    }

}
