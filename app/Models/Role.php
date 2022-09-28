<?php
/**
 * @author Phan Tường Văn - 11:22 PM / 23/9/2022
 * 
 */


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model{
    use HasFactory;

    protected $fillable = [
        'name', 
        'code'
    ];


    public function users(){
        return $this->hasMany(User::class, 'role_id');
    }
}

?>