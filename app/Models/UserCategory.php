<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCategory extends Model
{
    use HasFactory;
	
	// Все колонки $fillable
	protected $guarded = [];
	
	 /*protected $fillable = ['categoryname','goverment','law','lawlink','place','comment','organisation','staff',];*/
	 
	 // Мутация значения в столбце organisation
	 public function getOrganisationnameAttribute($value)
    {		
		if ($value == 'admin') {		
			return ('Администратор');
		} else {
			$user = User::where('id', $value)->first();
			return ($user->name);
		}
    }
}
