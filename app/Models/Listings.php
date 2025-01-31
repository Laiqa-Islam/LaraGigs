<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listings extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','title','company','description','tags','email','website','location', 'logo'];

    public static function scopeFilter($query, array $filters){
        //tag filter
        if($filters['tag'] ?? false){
            $query->where('tags', 'like','%'.request('tag').'%');
        }

        //search filter
        if($filters['search'] ?? false){
            $query->where('tags', 'like','%'.request('search').'%')->orwhere('title','like','%'.request('search').'%')->orwhere('description','like','%'.request('search').'%')->orwhere('location','like','%'.request('search').'%');
        }
    }

    //Relationship With User

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
