<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;
	
	// Все колонки $fillable
	protected $guarded = [];
	
	
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


	public function getOtchetstartdateAttribute($value)
    {				
		// Получение даты первого отчета из базы сдаваемых отчетов
		$otchetdate = OtchetPlan::where('formid', $this->attributes['id'])
			->where('category', $this->attributes['category'])
			->where('categorytable', $this->attributes['categorytable'])
			->where('userid', $value)
			->first();

		if ($otchetdate) {
			return array('date' => $otchetdate->firstdate, 'id' => $otchetdate->id);
		} else {
			return null;
		}
    }
	
	
	public function getCategorynameAttribute($value)
    {		
		$category = Category::where('id', $value)->first();

		if ($category) {
			return ($category->categoryname);
		} else {
			return null;
		}
    }
	
	
	public function getCategorydataAttribute($value)
    {		
		$category = Category::where('id', $value)->first();

		if ($category) {
			return $category;
		} else {
			return null;
		}
    }
	
	
	public function getStatusAttribute($value)
    {		
		$statuses = OtchetStatus::where('formid', $this->attributes['id'])
			->where('category', $this->attributes['category'])
			->where('categorytable', $this->attributes['categorytable'])
			->first();

		if ($statuses) {
			return true;
		} else {
			return false;
		}

    }
	
	
	public function getStatuseslistAttribute($value)
    {		
		$statuses = OtchetStatus::where('formid', $this->attributes['id'])
			->where('category', $this->attributes['category'])
			->where('categorytable', $this->attributes['categorytable'])
			->where('userid', $value)
			->get();

		return $statuses;

    }
	
}
