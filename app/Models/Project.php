<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = ['title', 'is_published', 'description', 'link','type_id' ];
  
    // RELATIONS

		public function type() 
    {
      return $this->belongsTo(Type::class);
    }

     public function technologies() 
      {
        return $this->belongsToMany(Technology::class); 
      }
    // MUTATORS
     public function getAbstract($max = 40) {
      return substr($this->description, 0 , $max) . '...';
    }

    public function getLinkUri() {
     return $this->link ? asset('storage/' . $this->link) : 'https://scheepvaartwinkel.com/wp-content/uploads/2021/01/placeholder.png';
    } 		
}