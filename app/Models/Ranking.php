<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
    //
     /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'total_points',
        'rank',
    ];

      // Define the relationship with the User model
      public function user()
      {
          return $this->belongsTo(User::class, 'user_id');
      }
}
