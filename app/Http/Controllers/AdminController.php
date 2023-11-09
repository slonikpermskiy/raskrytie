<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\UserCategory;
use App\Models\Form;
use App\Models\UserForm;
use App\Models\OtchetPlan;
use App\Models\OtchetStatus;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use DB;

class AdminController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminmainpage(){
		/*$usersList = User::select('id', 'name', 'email')
            ->orderBy('id', 'desc')
            ->get();
		
        return view('admin.adminmainpage', ['users' => $usersList]);*/
    }
	
	
	public function usersList(){
        $usersList = User::select('id', 'name', 'created_at', 'email', 'email_verified_at', 'premium_to_date', 'blocked', 'getemails')
            ->orderBy('id', 'asc')
            ->get();
        return $usersList;
    }
	
	
	public function changeUser(Request $request){
 
		// Валидация на ошибки в полях
		$validator = Validator::make($request->all(), [			
			'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($request->get('id'), 'id')],		
        ]);
		
		// Запись в БД
        if ($validator->passes()) {	
		
			if ($request->get('id') !== null & $request->get('id') !== '0') {
			
				User::where('id', $request->get('id'))->update(['name' => $request->get('name'),
				'email' => $request->get('email'),'email_verified_at' => $request->get('email_verified_at'),'premium_to_date' => $request->get('premium_to_date'),
				'blocked' => $request->get('blocked'), 'getemails' => $request->get('getemails'),]);
				
				return response()->json(['success'=>'Данные изменены']);
					
			} else {
				$err = array();
				array_push($err, "Ошибка сохранения данных, перезагрузите страницу.");
				return response()->json(['errors'=> ['error'=> $err]],444);
			
			}

        } 
		
		return response()->json(['errors'=> $validator->errors()], 444);
						
	}
		
		
		
		
	public function changeUserPassword(Request $request){
 
		// Валидация на ошибки в полях
		$validator = Validator::make($request->all(), [			
			'password' => ['required', 'string', 'min:8', 'confirmed'],		
        ]);

		// Запись в БД
        if ($validator->passes()) {	
		
			if ($request->get('id') !== null & $request->get('id') !== '0') {
			
				User::where('id', $request->get('id'))->update(['password' => Hash::make($request->get('password')),]);
				
				return response()->json(['success'=>'Данные изменены']);
					
			} else {
				$err = array();
				array_push($err, "Ошибка сохранения данных, перезагрузите страницу.");
				return response()->json(['errors'=> ['error'=> $err]],444);
			
			}

        } 

		return response()->json(['errors'=> $validator->errors()], 444);
						
	}
		
		
		
	public function deleteUser(Request $request){
		
		if ($request->get('id') !== null & $request->get('id') !== '0') {
			
			User::destroy($request->get('id'));
			
			// Удаляем все связанные с пользователем данные
			UserCategory::where('organisation', $request->get('id'))->delete();					
			UserForm::where('organisation', $request->get('id'))->delete();
			OtchetPlan::where('userid', $request->get('id'))->delete();
			OtchetStatus::where('userid', $request->get('id'))->delete();
									
			return response()->json(['success'=>'Данные удалены']);
				
		} else {
			$err = array();
			array_push($err, "Ошибка удаления, перезагрузите страницу.");
			return response()->json(['errors'=> ['error'=> $err]],444);
		
		}
						
	}	
	
	
	public function newCategory(Request $request){
		
		
		if ($request->get('organisation') == 'admin') {
			
			// Валидация на ошибки в полях
			$validator = Validator::make($request->all(), [	
				'categoryname' => ['required', 'string', 'max:255', Rule::unique('categories')->where(fn ($query) => $query->where('organisation', $request->get('organisation')))->ignore($request->get('id'), 'id')],			
				'goverment' => ['nullable', 'string', 'max:255'],
				'law' => ['nullable', 'string', 'max:255'],
				'lawlink' => ['nullable', 'string', 'max:255'],
				'place' => ['nullable', 'string', 'max:255'],
				'comment' => ['nullable', 'string', 'max:255'],		
			]);
						
			// Запись в БД
			if ($validator->passes()) {	

				$id = Category::updateOrCreate(['id' => $request->get('id')], ['categoryname'  => $request->get('categoryname'),'goverment' => $request->get('goverment'),'law' => $request->get('law'),'lawlink' => $request->get('lawlink'),
				'place' => $request->get('place'),'comment' => $request->get('comment'),'organisation' => $request->get('organisation'),'staff' => $request->get('staff'),]);

				return response()->json(['success'=>'Данные сохранены', 'newid'=>$id->id]);
	
			} 

			return response()->json(['errors'=> $validator->errors()], 444);
			
		} else {
			
			// Валидация на ошибки в полях
			$validator = Validator::make($request->all(), [	
				'categoryname' => ['required', 'string', 'max:255', Rule::unique('user_categories')->where(fn ($query) => $query->where('organisation', $request->get('organisation')))->ignore($request->get('id'), 'id')],			
				'goverment' => ['nullable', 'string', 'max:255'],
				'law' => ['nullable', 'string', 'max:255'],
				'lawlink' => ['nullable', 'string', 'max:255'],
				'place' => ['nullable', 'string', 'max:255'],
				'comment' => ['nullable', 'string', 'max:255'],		
			]);
			
			
			// Запись в БД
			if ($validator->passes()) {	
	
				$id = UserCategory::updateOrCreate(['id' => $request->get('id')], ['categoryname'  => $request->get('categoryname'),'goverment' => $request->get('goverment'),'law' => $request->get('law'),'lawlink' => $request->get('lawlink'),
				'place' => $request->get('place'),'comment' => $request->get('comment'),'organisation' => $request->get('organisation'),'staff' => $request->get('staff'),]);

				return response()->json(['success'=>'Данные сохранены', 'newid'=>$id->id]);

			} 

			return response()->json(['errors'=> $validator->errors()], 444);
						
		}
					
	}	
	
	
	public function categoriesList(Request $request){
				
		if ($request->get('organisation') == 'admin') {
        
			$categoriesList = Category::select('id', 'categoryname', 'goverment', 'law', 'lawlink', 'place', 'comment', 'organisation', 'created_at', DB::raw('organisation as organisationname'), DB::raw("'admin' as 'table'"))
				->orderBy('id', 'asc')
				->get();
			
		} else {
			
			$categoriesList = UserCategory::select('id', 'categoryname', 'goverment', 'law', 'lawlink', 'place', 'comment', 'organisation', 'created_at', DB::raw('organisation as organisationname'), DB::raw("'user' as 'table'"))
            ->where('organisation', $request->get('organisation'))
			->orderBy('id', 'asc')
            ->get();
			
		}
		
        return $categoriesList;

    }
	
	
	public function deleteCategory(Request $request){
		
		if ($request->get('id') !== null & $request->get('id') !== '0') {
			
			$result = null;
			
			if ($request->get('table') == 'admin') {		
				
				$result = Category::destroy($request->get('id'));
				
				Form::where('categorytable', 'admin')->where('category', $request->get('id'))->delete();
				
				UserForm::where('categorytable', 'admin')->where('category', $request->get('id'))->delete();
				
				OtchetPlan::where('categorytable', 'admin')->where('category', $request->get('id'))->delete();
				
				OtchetStatus::where('categorytable', 'admin')->where('category', $request->get('id'))->delete();
				
			} else if ($request->get('table') == 'user') {
				
				$result = UserCategory::destroy($request->get('id'));
				
				UserForm::where('categorytable', 'user')->where('category', $request->get('id'))->delete();
				
				OtchetPlan::where('categorytable', 'user')->where('category', $request->get('id'))->delete();
				
				OtchetStatus::where('categorytable', 'user')->where('category', $request->get('id'))->delete();
				
			}
			
			
			if ($result != null) {
				return response()->json(['success'=>'Данные удалены']);
			} else {				
				$err = array();
				array_push($err, "Ошибка удаления, перезагрузите страницу.");
				return response()->json(['errors'=> ['error'=> $err]],444);
			}
				
		} else {
			$err = array();
			array_push($err, "Ошибка удаления, перезагрузите страницу.");
			return response()->json(['errors'=> ['error'=> $err]],444);
		
		}
						
	}
	
	
	
	public function newOtchet(Request $request){
	
		if ($request->get('organisation') == 'admin') {
		
			// Валидация на ошибки в полях
			$validator = Validator::make($request->all(), [	
				'otchetname' => ['required', 'string', 'max:255', Rule::unique('forms')->where(fn ($query) => $query->where('organisation', $request->get('organisation'))->where('category', $request->get('category'))->where('categorytable', $request->get('categorytable')))->ignore($request->get('id'), 'id')],			
				'razdelname' => ['nullable', 'string', 'max:255'],
				'firstdate' => ['required'],
				'reportdays' => ['required'],			
				'otchetlink' => ['nullable', 'string', 'max:255'],
				'comment' => ['nullable', 'string', 'max:255'],		
			]);
			
			// Запись в БД
			if ($validator->passes()) {
				
				Form::updateOrCreate(['id' => $request->get('id')], ['category'  => $request->get('category'), 'categorytable'  => $request->get('categorytable'), 
				'otchetname'  => $request->get('otchetname'),'razdelname' => $request->get('razdelname'),'firstdate' => $request->get('firstdate'),'reportdays' => json_encode($request->get('reportdays')),'otchetlink' => $request->get('otchetlink'),
				'whosend' => json_encode($request->get('whosend')),'comment' => $request->get('comment'),'organisation' => $request->get('organisation'),'staff' => $request->get('staff'),]);
				
				return response()->json(['success'=>'Данные сохранены']);
				
			} 

			return response()->json(['errors'=> $validator->errors()], 444);
			
		} else {
			
			// Валидация на ошибки в полях
			$validator = Validator::make($request->all(), [	
				'otchetname' => ['required', 'string', 'max:255', Rule::unique('user_forms')->where(fn ($query) => $query->where('organisation', $request->get('organisation'))->where('category', $request->get('category'))->where('categorytable', $request->get('categorytable')))->ignore($request->get('id'), 'id')],			
				'razdelname' => ['nullable', 'string', 'max:255'],
				'reportdays' => ['required'],			
				'otchetlink' => ['nullable', 'string', 'max:255'],
				'comment' => ['nullable', 'string', 'max:255'],		
			]);
			
			// Запись в БД
			if ($validator->passes()) {
				
				$id = UserForm::updateOrCreate(['id' => $request->get('id')], ['category'  => $request->get('category'), 'categorytable'  => $request->get('categorytable'), 
				'otchetname'  => $request->get('otchetname'),'razdelname' => $request->get('razdelname'),'reportdays' => json_encode($request->get('reportdays')),'otchetlink' => $request->get('otchetlink'),
				'whosend' => json_encode($request->get('whosend')),'comment' => $request->get('comment'),'organisation' => $request->get('organisation'),'staff' => $request->get('staff'),]);
						
				if ($request->get('neworedit') == 0) {
				
					OtchetPlan::create(['userid'  => $request->get('organisation'), 'category'  => $request->get('category'), 'categorytable'  => $request->get('categorytable'), 
					'formid'  => $id->id, 'firstdate' => Carbon::now()->format('Y-m-d'),]);
					
				}
						
			
				return response()->json(['success'=>'Данные сохранены']);
			
			} 

			return response()->json(['errors'=> $validator->errors()], 444);
			
		}
		
	}
		
		
	public function otchetsList(Request $request){
				
		
		$adminotchetsList = Form::select('id', 'category', 'categorytable', 'razdelname', 'otchetname', 'firstdate', 'reportdays', 'whosend', 'otchetlink', 'comment', 'organisation', 'created_at', DB::raw('organisation as organisationname'), DB::raw('organisation as status'))
			->where('category', $request->get('category'))
			->where('categorytable', $request->get('categorytable'))
			->orderBy('id', 'asc')
			->get();

		$userotchetsList = UserForm::select('id', 'category', 'categorytable', 'razdelname', 'otchetname', 'reportdays', 'whosend', 'otchetlink', 'comment', 'organisation', 'created_at', DB::raw('organisation as organisationname'), DB::raw('organisation as status'))
			->where('category', $request->get('category'))
			->where('categorytable', $request->get('categorytable'))
			->orderBy('id', 'asc')
			->get();
		
		$otchetsList = collect();

		foreach ($adminotchetsList as $adminotchet)
			$otchetsList->push($adminotchet);
		foreach ($userotchetsList as $userotchet)
			$otchetsList->push($userotchet);
			
		// Пример поиска в JSON для MySQL выше 5.7
		// ->whereJsonContains('address', ['address' => $query])
		// ->whereJsonContains('address->address', $query)		
		// Form::whereRaw("JSON_CONTAINS(JSON_EXTRACT(reportdays, '$.freq'), '"2"')")
		
		// Пример поиска по значению в JSON, т.к. MySQL ниже 5.7 не поддерживает работу с JSON
		//if (Str::contains(Str::lower(json_decode($row->address)->address), Str::lower($query))) {}
		
		// https://stackoverflow.com/questions/46055223/select-where-json-array-contains
		// https://laravel.su/docs/8.x/queries#json-where-clauses
		// https://stackguides.com/questions/51602291/laravel-fetching-json-column-mariadb-syntax-error
		
        return $otchetsList;

	}
	
	
	public function deleteOtchet(Request $request){
		
		if ($request->get('id') !== null & $request->get('id') !== '0') {
			
			$result = null;
			
			if ($request->get('categorytable') == 'admin') {		
				$result = Form::destroy($request->get('id'));				
				OtchetPlan::where('categorytable', 'admin')->where('formid', $request->get('id'))->delete();
				OtchetStatus::where('categorytable', 'admin')->where('formid', $request->get('id'))->delete();
			} else if ($request->get('categorytable') == 'user') {
				$result = UserForm::destroy($request->get('id'));
				OtchetPlan::where('categorytable', 'user')->where('formid', $request->get('id'))->delete();
				OtchetStatus::where('categorytable', 'user')->where('formid', $request->get('id'))->delete();
			}

			
			if ($result != null) {
				return response()->json(['success'=>'Данные удалены']);
			} else {				
				$err = array();
				array_push($err, "Ошибка удаления, перезагрузите страницу.");
				return response()->json(['errors'=> ['error'=> $err]],444);
			}
				
		} else {
			$err = array();
			array_push($err, "Ошибка удаления, перезагрузите страницу.");
			return response()->json(['errors'=> ['error'=> $err]],444);
		
		}
						
	}
	
	
	public function adminDeleteOtchetStatistic(Request $request){

		if ($request->get('id') !== null & $request->get('id') !== '0') {
					
			$check = null;
			
			if ($request->get('organisation') == 'admin') { 
			
				OtchetStatus::where('categorytable', $request->get('categorytable'))->where('category', $request->get('category'))->where('formid', $request->get('id'))->delete();

				$check = OtchetStatus::where('formid', $request->get('id'))
					->where('category', $request->get('category'))
					->where('categorytable', $request->get('categorytable'))
					->first();
			
			} else {
				
				OtchetStatus::where('categorytable', $request->get('categorytable'))->where('category', $request->get('category'))->where('formid', $request->get('id'))->where('userid', $request->get('organisation'))->delete();

				$check = OtchetStatus::where('formid', $request->get('id'))
					->where('category', $request->get('category'))
					->where('categorytable', $request->get('categorytable'))
					->where('userid', $request->get('organisation'))
					->first();
	
			}
			

			if (!$check) {
				return response()->json(['success'=>'Данные удалены']);
			} else {
				$err = array();
				array_push($err, "Ошибка удаления, перезагрузите страницу.");
				return response()->json(['errors'=> ['error'=> $err]],444);
			}
	
		} else {
			$err = array();
			array_push($err, "Ошибка удаления, перезагрузите страницу.");
			return response()->json(['errors'=> ['error'=> $err]],444);
		
		}
						
	}
		
}