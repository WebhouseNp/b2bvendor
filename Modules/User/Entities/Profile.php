<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Profile extends Model
{

  protected $guarded = ['id','created_at','updated_at'];

  public function imageUrl($size = null)
  {
    if(!$this->image) {
        $queryString = [
            'name' => $this->full_name,
            'background' => 'b8daff',
            'color' => '0D8ABC',
        ];

        return 'https://ui-avatars.com/api/?' . http_build_query($queryString);
    }

    if ($size == 'thumbnail') {
        return asset('images/thumbnail/' . $this->image);
    }

    return asset('images/listing/' . $this->image);
  }
    public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }
    
}
