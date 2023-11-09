<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
use App\Notifications\PayBill;
use App\Notifications\SendPlan;
use Illuminate\Support\Facades\Config;



class UserController extends Controller
{
    
	public function standartCategoriesList(Request $request){
				
		$categoriesList = Category::select('id', 'categoryname', 'goverment', 'law', 'lawlink', 'place', 'comment', 'organisation', 'created_at', DB::raw('organisation as organisationname'), DB::raw("'admin' as 'table'"))
			->orderBy('id', 'asc')
			->get();
		
        return $categoriesList;		

    }
	
	
	public function standartOtchetsList(Request $request){
		
		$otchetsList = Form::select('id', 'category', 'categorytable', 'razdelname', 'otchetname', 'reportdays', 'whosend', 'otchetlink', 'comment', 'organisation', 'created_at', DB::raw('organisation as organisationname'), DB::raw( $request->get('userid').' as otchetstartdate'))
			->where('category', $request->get('category'))
			->where('categorytable', $request->get('categorytable'))
			->orderBy('id', 'asc')
			->get();
		
        return $otchetsList;

	}
	
	public function userCategoriesList(Request $request){
				
		$categoriesList = UserCategory::select('id', 'categoryname', 'goverment', 'law', 'lawlink', 'place', 'comment', 'organisation', 'created_at', DB::raw("'user' as 'table'"))
			->where('organisation', $request->get('organisation'))
			->orderBy('id', 'asc')
			->get();
		
        return $categoriesList;		

    }
	
	
	public function userOtchetsList(Request $request){
		
		$otchetsList = UserForm::select('id', 'category', 'categorytable', 'razdelname', 'otchetname', 'reportdays', 'comment', 'organisation', DB::raw( $request->get('userid').' as otchetstartdate'), DB::raw( $request->get('userid').' as status'))
			->where('organisation', $request->get('userid'))
			->where('category', $request->get('category'))
			->where('categorytable', $request->get('categorytable'))
			->orderBy('id', 'asc')
			->get();
		
        return $otchetsList;

	}


	public function allCategoriesList(Request $request){

		$categoriesList = array();
		
		$admin_categoriesList = Category::select('id', 'categoryname', 'goverment', 'law', 'lawlink', 'place', 'comment', 'organisation', 'created_at', DB::raw('organisation as organisationname'), DB::raw("'admin' as 'table'"))
			->orderBy('id', 'asc')
			->get();

		foreach ($admin_categoriesList as $admin_category)
			array_push($categoriesList, $admin_category);
			
		if ($request->get('premium') == 1) {

			$user_categoriesList = UserCategory::select('id', 'categoryname', 'goverment', 'law', 'lawlink', 'place', 'comment', 'organisation', 'created_at', DB::raw("'user' as 'table'"))
				->where('organisation', $request->get('organisation'))
				->orderBy('id', 'asc')
				->get();

			foreach ($user_categoriesList as $user_category)
				array_push($categoriesList, $user_category);

		}
		
        return $categoriesList;		

    }

	
	public function setToOtchetPlan(Request $request){
		
        // Валидация на ошибки в полях
		$validator = Validator::make($request->all(), [	
			'formid' => [Rule::unique('otchet_plans')->where(function ($query) use ($request) {return $query->where('userid', $request->get('userid'))->where('category', $request->get('category'))->where('categorytable', $request->get('categorytable'));}),],
		]);
		
		// Запись в БД
		if ($validator->passes()) {

			OtchetPlan::where('formid', $request->get('formid'))
				->where('category', $request->get('category'))
				->where('categorytable',$request->get('categorytable'))
				->where('userid', $request->get('userid'))
				->delete();
			
			OtchetPlan::create(['userid'  => $request->get('userid'), 'category'  => $request->get('category'), 'categorytable'  => $request->get('categorytable'), 
			'formid'  => $request->get('formid'), 'firstdate' => $request->get('firstdate'),]);
					
			return response()->json(['success'=>'Данные сохранены']);
		
		} else {
			$err = array();
			array_push($err, "Ошибка сохранения, значение уже существует.");
			return response()->json(['errors'=> ['error'=> $err]],444);
		
		}

	}
	
	
	public function deleteToOtchetPlan(Request $request){

		if ($request->get('todelid') !== null & $request->get('todelid') !== '0') {
			
			//OtchetPlan::destroy($request->get('todelid'));

			OtchetPlan::where('id', $request->get('todelid'))
				->where('userid', $request->get('userid'))
				->delete();
						
			return response()->json(['success'=>'Данные удалены']);
				
		} else {
			$err = array();
			array_push($err, "Ошибка удаления, перезагрузите страницу.");
			return response()->json(['errors'=> ['error'=> $err]],444);
		
		}
						
	}


	public function getFreePremium(Request $request){
		
		if ($request->get('userid') !== null & $request->get('userid') !== '0') {
			
			$user = User::where('id', $request->get('userid'))->first();
			
			if ($user) {
				
				if ($user->premium_to_date === null) {
					User::where('id', $request->get('userid'))->update(['premium_to_date' => Carbon::now()->addMonth(3)->format('Y-m-d'),]);
				} else {
					$err = array();
					array_push($err, "Ошибка получения статуса, перезагрузите страницу.");
					return response()->json(['errors'=> ['error'=> $err]],444);
				}
				
				return response()->json(['success'=>'Статус Премиум получен']);
				
				/*if ($user->premium_to_date !== null && Carbon::parse($user->premium_to_date)->gt(Carbon::now())) {
					User::where('id', $request->get('userid'))->update(['premium_to_date' => Carbon::parse($user->premium_to_date)->addMonth(3)->format('Y-m-d'),]);
				} else {
					User::where('id', $request->get('userid'))->update(['premium_to_date' => Carbon::now()->addMonth(3)->format('Y-m-d'),]);
				}*/
				
			} else {
				$err = array();
				array_push($err, "Ошибка получения статуса, перезагрузите страницу.");
				return response()->json(['errors'=> ['error'=> $err]],444);
			}
	
		} else {
			$err = array();
			array_push($err, "Ошибка получения статуса, перезагрузите страницу.");
			return response()->json(['errors'=> ['error'=> $err]],444);
		
		}
						
	}
	
	
	public function oneUserData(Request $request){
		      
		if ($request->get('id') !== null & $request->get('id') !== '0') {
			
			$user = User::where('id', $request->get('id'))->first();
			
			return $user;
				
		} else {
			$err = array();
			array_push($err, "Ошибка получения данных, перезагрузите страницу.");
			return response()->json(['errors'=> ['error'=> $err]],444);
		
		}		
		
    }
	
	
	public function changeUserData(Request $request){
 
		// Валидация на ошибки в полях
		$validator = Validator::make($request->all(), [			
			'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($request->get('id'), 'id')],		
        ]);
		
		// Запись в БД
        if ($validator->passes()) {	
		
			if ($request->get('id') !== null & $request->get('id') !== '0') {
			
				$user = User::where('id', $request->get('id'))->first();
							
				if ($user->email !== $request->get('email')) {
					User::where('id', $request->get('id'))->update(['name' => $request->get('name'), 'email' => $request->get('email'), 'getemails' => $request->get('getemails'), 'email_verified_at' => null,]);
					return response()->json(['success'=>'Данные изменены', 'reload'=>1]);
				} else {				
					User::where('id', $request->get('id'))->update(['name' => $request->get('name'), 'email' => $request->get('email'), 'getemails' => $request->get('getemails'),]);
					return response()->json(['success'=>'Данные изменены', 'reload'=>0]);
				}				
					
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
			'oldpassword' => ['required', 'string'],		
			'password' => ['required', 'string', 'min:8', 'confirmed', 'different:oldpassword'],		
        ]);

		// Запись в БД
        if ($validator->passes()) {	
		
			if ($request->get('id') !== null & $request->get('id') !== '0') {
			
				$user = User::where('id', $request->get('id'))->first();
				
				if ($user) {					
					if (Hash::check($request->get('oldpassword'), $user->password)) {						
						User::where('id', $request->get('id'))->update(['password' => Hash::make($request->get('password')),]);			
						return response()->json(['success'=>'Данные изменены']);						
					} else {						
						$err = array();
						array_push($err, "Неверный действующий пароль.");
						return response()->json(['errors'=> ['error'=> $err]],444);
					}										
				} else {				
					$err = array();
					array_push($err, "Ошибка сохранения данных, перезагрузите страницу.");
					return response()->json(['errors'=> ['error'=> $err]],444);
				}				
			} else {
				$err = array();
				array_push($err, "Ошибка сохранения данных, перезагрузите страницу.");
				return response()->json(['errors'=> ['error'=> $err]],444);
			}

        } 

		return response()->json(['errors'=> $validator->errors()], 444);
				
	}
	
	
	public function getUser(){
		      
		$user = Auth::user();

		if ($user) {			
			return $user;				
		} else {
			$err = array();
			array_push($err, "Ошибка получения данных, перезагрузите страницу.");
			return response()->json(['errors'=> ['error'=> $err]],444);
		
		}	
		
    }
	
	
	public function sendBill(Request $request){
		      
		$user = Auth::user();
		
		if ($user) {
			
			$params = array('userid'=>$user->id, 'time'=>$request->get('sendbill_time'), 'summ'=>$request->get('sendbill_summ'));
			
			$user->notify(new PayBill($params));
			
			return response()->json(['success'=>'Отправлено']);
			
		} else {
			$err = array();
			array_push($err, "Ошибка отправки, перезагрузите страницу.");
			return response()->json(['errors'=> ['error'=> $err]],444);
		
		}
		
    }


	public function sendPlan(Request $request){
		      
		$user = Auth::user();
		
		if ($user) {
			
			$params = array('userid'=>$user->id, 'html'=>$request->get('html'), 'month'=>$request->get('month'));
			
			$user->notify(new SendPlan($params));
			
			return response()->json(['success'=>'Отправлено']);
			
		} else {
			$err = array();
			array_push($err, "Ошибка отправки, перезагрузите страницу.");
			return response()->json(['errors'=> ['error'=> $err]],444);
		
		}
		
    }
	
	
	public function newUserCategory(Request $request){
		
		// Валидация на ошибки в полях
		$validator = Validator::make($request->all(), [	
			'categoryname' => ['required', 'string', 'max:255', Rule::unique('user_categories')->where(function ($query) use ($request) {return $query->where('organisation', $request->get('organisation'));})->ignore($request->get('id'), 'id'),],			
			'goverment' => ['nullable', 'string', 'max:255'],
			'law' => ['nullable', 'string', 'max:255'],
			'place' => ['nullable', 'string', 'max:255'],
			'comment' => ['nullable', 'string', 'max:255'],		
		]);
		
		
		// Запись в БД
		if ($validator->passes()) {	

			$id = UserCategory::updateOrCreate(['id' => $request->get('id')], ['categoryname'  => $request->get('categoryname'),'goverment' => $request->get('goverment'),'law' => $request->get('law'),
			'place' => $request->get('place'),'comment' => $request->get('comment'),'organisation' => $request->get('organisation'),'staff' => $request->get('staff'),]);

			return response()->json(['success'=>'Данные сохранены', 'newid'=>$id->id]);

		} 

		return response()->json(['errors'=> $validator->errors()], 444);
			
	}
	
	
	public function deleteUserCategory(Request $request){
		
		if ($request->get('id') !== null & $request->get('id') !== '0') {
			
			$result = null;
				
			$result = UserCategory::destroy($request->get('id'));
				
			UserForm::where('categorytable', 'user')->where('category', $request->get('id'))->delete();
						
			OtchetPlan::where('categorytable', 'user')->where('category', $request->get('id'))->delete();
			
			OtchetStatus::where('categorytable', 'user')->where('category', $request->get('id'))->delete();
			
						
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
	
	
	public function newUserOtchet(Request $request){
		

		// Валидация на ошибки в полях
		$validator = Validator::make($request->all(), [	
			'otchetname' => ['required', 'string', 'max:255', Rule::unique('user_forms')->where(function ($query) use ($request) {return $query->where('organisation', $request->get('organisation'))->where('category', $request->get('category'))->where('categorytable', $request->get('categorytable'));})->ignore($request->get('id'), 'id'),],			
			'razdelname' => ['nullable', 'string', 'max:255'],
			'reportdays' => ['required'],			
			'comment' => ['nullable', 'string', 'max:255'],		
		]);
		
		// Запись в БД
		if ($validator->passes()) {
			
			$id = UserForm::updateOrCreate(['id' => $request->get('id')], ['category'  => $request->get('category'), 'categorytable'  => $request->get('categorytable'), 
			'otchetname'  => $request->get('otchetname'),'razdelname' => $request->get('razdelname'),'reportdays' => json_encode($request->get('reportdays')),
			'comment' => $request->get('comment'),'organisation' => $request->get('organisation'),'staff' => $request->get('staff'),]);
			
			if ($request->get('neworedit') == 0) {

				OtchetPlan::where('formid', $request->get('formid'))
					->where('category', $request->get('category'))
					->where('categorytable',$request->get('categorytable'))
					->where('userid', $request->get('organisation'))
					->delete();
				
				OtchetPlan::create(['userid'  => $request->get('organisation'), 'category'  => $request->get('category'), 'categorytable'  => $request->get('categorytable'), 
				'formid'  => $id->id, 'firstdate' => Carbon::now()->format('Y-m-d'),]);
				
			}
					
			return response()->json(['success'=>'Данные сохранены']);
		
		} 

		return response()->json(['errors'=> $validator->errors()], 444);

	}
	
	
	public function deleteUserOtchet(Request $request){
		
		if ($request->get('id') !== null & $request->get('id') !== '0') {
			
			$result = null;
			
			$result = UserForm::destroy($request->get('id'));
			
			OtchetPlan::where('categorytable', 'user')->where('formid', $request->get('id'))->delete();
			
			OtchetStatus::where('categorytable', 'user')->where('formid', $request->get('id'))->delete();

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
	
	
	public function getCalendarOtchets(Request $request){
		
		
		$otchetsList = array();
		
		$admin_otchetsList = Form::select('id', 'category', 'categorytable', 'razdelname', 'otchetname', 'reportdays', 'whosend', 'otchetlink', 'comment', DB::raw('category as categorydata'), DB::raw( $request->get('userid').' as otchetstartdate'), DB::raw("'not' as 'myornot'"))
		->where('categorytable', 'admin')
		->where('organisation', 'admin')
		->get();
		
		foreach ($admin_otchetsList as $admin_otchet)
			array_push($otchetsList, $admin_otchet);
		
		
		if ($request->get('premium') == 1) {
			
			$user_otchetsList = UserForm::select('id', 'category', 'categorytable', 'razdelname', 'otchetname', 'reportdays', 'whosend', 'otchetlink', 'organisation', 'comment', DB::raw('category as categorydata'), DB::raw( $request->get('userid').' as otchetstartdate'), DB::raw("'my' as 'myornot'"))
			->where('organisation', $request->get('userid'))
			->get();
			
			foreach ($user_otchetsList as $user_otchet)
				array_push($otchetsList, $user_otchet);
			
		}

		$otchets_tocalendar = [];
		
		if(count($otchetsList) > 0){
			
			foreach($otchetsList as $row){
														
				if ($row->otchetstartdate) {

					foreach(json_decode($row->reportdays) as $reportday){
									
						// Однократно: дата или событие
						if ($reportday->freq == 1) {

							$date = '';
							
							// Если есть дата
							if ($reportday->onetimeday) {							
								$date = Carbon::parse($reportday->onetimeday);								
							// Если нет даты, то последний день месяца
							} else {								
								$date = Carbon::parse('last day of '.date("F",mktime(0,0,0,$request->month,1,$request->year)).' '.$request->year);
							}
							
							if ($row->otchetstartdate && $date && Carbon::parse($row->otchetstartdate['date'])->lte($date) && Carbon::parse($date)->month == $request->month) {													
								
								$status = OtchetStatus::where('formid', $row->id)
										->where('category', $row->category)
										->where('categorytable', $row->categorytable)
										->where('userid', $request->get('userid'))
										->where('plandate', (clone $date)->format('Y-m-d'))
										->first();
							
								$otchets_tocalendar[] = ['otchetdata' => $row, 'start' => (clone $date)->format('Y-m-d'), 'end' => (clone $date)->format('Y-m-d'), 'name' => $row->otchetname, 'status' => $status, 'reportday' => $reportday];
							}
						
						// Дневная периодичность
						} else if ($reportday->freq == 2) {
							
							$date = '';
							
							// Первый день месяца
							$firstdayofmonth = Carbon::parse('first day of '.date("F",mktime(0,0,0,$request->month,1,$request->year)).' '.$request->year);
							// Последний день месяца
							$lastdayofmonth = Carbon::parse('last day of '.date("F",mktime(0,0,0,$request->month,1,$request->year)).' '.$request->year);
							
							// Если дата начала отчета меньше первого дня месяца
							if (Carbon::parse($row->otchetstartdate['date'])->lt($firstdayofmonth)) {							
															
								// Разница в днях
								$diff = Carbon::parse($row->otchetstartdate['date'])->diffInDays($firstdayofmonth);	
								
								// Находим ближайший к началу месяца день. Целое количество интервалов * периодичность.
								$date = Carbon::parse($row->otchetstartdate['date'])->addDay(intval($diff/$reportday->intervday)*$reportday->intervday);
							
							// Если дата начала отчета больше первого дня месяца, то первый день - дата начала отчета
							} else {								
								$date = Carbon::parse($row->otchetstartdate['date']);
							}
							
							// Пока дни попадают в месяц, складываем в выборку. В итерации добавляем количество дней равное периодичности. 
							for (;;) {
								
								if ($date->gt($lastdayofmonth)) {
									break;
								}

								if ($row->otchetstartdate && $date && Carbon::parse($row->otchetstartdate['date'])->lte($date) && Carbon::parse($date)->month == $request->month) {									
									
									$status = OtchetStatus::where('formid', $row->id)
										->where('category', $row->category)
										->where('categorytable', $row->categorytable)
										->where('userid', $request->get('userid'))
										->where('plandate', (clone $date)->format('Y-m-d'))
										->first();
									
									if (Carbon::parse($date)->between($firstdayofmonth, $lastdayofmonth)) {
									
										$otchets_tocalendar[] = ['otchetdata' => $row, 'start' => (clone $date)->format('Y-m-d'), 'end' => (clone $date)->format('Y-m-d'), 'name' => $row->otchetname, 'status' => $status, 'reportday' => $reportday];									
								
									}
								
								}
																
								$date = Carbon::parse($date)->addDay($reportday->intervday);
								
							}							

						} else if ($reportday->freq == 3) {
							
							$daysOfWeek = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday", ];
							
							$date = '';
							
							// Первый нужный день недели в выбранном месяце
							$firstweekdayofmonth = Carbon::parse('first '.$daysOfWeek[$reportday->weekdays-1].' of '.date("F",mktime(0,0,0,$request->month,1,$request->year)).' '.$request->year);
														
							// Первый нужный день недели следующий после даты начала отчета
							$firstweekdayofmonthafterstart = '';
 
							if (Carbon::parse($row->otchetstartdate['date'])->is($daysOfWeek[$reportday->weekdays-1])) {								
								$firstweekdayofmonthafterstart = Carbon::parse($row->otchetstartdate['date']);								
							} else {
								
								$firstweekdayofmonthafterstart = Carbon::parse($row->otchetstartdate['date'])->next($daysOfWeek[$reportday->weekdays-1]);
								
								if ($reportday->intervweek != 1) {
									// Если дата начала отчета после первого нужного дня текущей недели, то прибавляем полный интервал
									$firstweekdayofmonthafterstart = Carbon::parse($firstweekdayofmonthafterstart)->addWeek($reportday->intervweek-1);
								}	
							}

							// Если первый после даты начала отчета день недели меньше первого дня недели в выбранном месяце
							if (Carbon::parse($firstweekdayofmonthafterstart)->lt($firstweekdayofmonth)) {							
								
								// Разница в неделях
								$diff = Carbon::parse($row->otchetstartdate['date'])->diffInWeeks($firstweekdayofmonth);								

								// Проверка деления без остатка на периодичность
								if ($diff % $reportday->intervweek == 0 ) {									
									// Если делится без остатка, то добавляем разницу в неделях к дате 
									$date = Carbon::parse($firstweekdayofmonthafterstart)->addWeek($diff);							
								} else {
									// Если делится с остатком, то добавляем разницу в неделях плюс остаток к дате
									$date = Carbon::parse($firstweekdayofmonthafterstart)->addWeek($diff+$diff % $reportday->intervweek);
								}
								
							} else {								
								
								$date = Carbon::parse($firstweekdayofmonthafterstart);
							}
							
							// Первый день месяца
							$firstdayofmonth = Carbon::parse('first day of '.date("F",mktime(0,0,0,$request->month,1,$request->year)).' '.$request->year);
							// Последний день месяца
							$lastdayofmonth = Carbon::parse('last day of '.date("F",mktime(0,0,0,$request->month,1,$request->year)).' '.$request->year);

							// Пока дни попадают в месяц, складываем в выборку. В итерации добавляем количество дней равное периодичности (в неделях).
							for (;;) {

								if ($date->gt($lastdayofmonth)) {
									break;
								}
								
								if ($row->otchetstartdate && $date && Carbon::parse($row->otchetstartdate['date'])->lte($date) && Carbon::parse($date)->month == $request->month) {									
								
									$status = OtchetStatus::where('formid', $row->id)
										->where('category', $row->category)
										->where('categorytable', $row->categorytable)
										->where('userid', $request->get('userid'))
										->where('plandate', (clone $date)->format('Y-m-d'))
										->first();
									
									if (Carbon::parse($date)->between($firstdayofmonth, $lastdayofmonth)) {									
										$otchets_tocalendar[] = ['otchetdata' => $row, 'start' => (clone $date)->format('Y-m-d'), 'end' => (clone $date)->format('Y-m-d'), 'name' => $row->otchetname, 'status' => $status, 'reportday' => $reportday];
									}
								}
																
								$date = Carbon::parse($date)->addDay(7*$reportday->intervweek);

							}		

						} else if ($reportday->freq == 4) {
							
							$date = '';

							// Первый день месяца даты начала
							$start_month = Carbon::parse($row->otchetstartdate['date'])->startOfMonth();
							
							// Первый день текущего месяца
							$start_month_now = Carbon::createFromDate($request->year, $request->month, 1, Config::get('app.timezone'));

							// Разница в месяцах
							$diff = Carbon::parse($start_month)->diffInMonths($start_month_now);

							// Проверка деления без остатка на периодичность
							if ($diff % $reportday->intervmonth == 0 ) {

								// Если выбран метод по дню месяца
								if ($reportday->monthmethod == 1) {
									
									// Последний день нужного месяца
									$last_day = Carbon::parse('last day of '.date("F",mktime(0,0,0,$start_month_now->month,1,$start_month_now->year)).' '.$start_month_now->year);
								
									// Если день отчета больше последнего дня месяца 
									if ($reportday->monthdays >= $last_day->day | $reportday->monthdays == 'last') {								
										$date = $last_day;
									} else {
										$date = Carbon::createFromDate(Carbon::parse($last_day)->year, Carbon::parse($last_day)->month, $reportday->monthdays, Config::get('app.timezone'));
									}
								// Если выбран метод по неделе и дню недели
								} else if ($reportday->monthmethod == 2) {
									
									$daysOfWeek = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday", ];								
									$weeks = ["first", "second", "third", "fourth", "last", ];

									$date = Carbon::parse($weeks[$reportday->monthweek-1].' '.$daysOfWeek[$reportday->monthweekdays-1].' of '.date("F",mktime(0,0,0,$start_month_now->month,1,$start_month_now->year)).' '.$start_month_now->year);

								}
																				
							}

							if ($row->otchetstartdate && $date && Carbon::parse($row->otchetstartdate['date'])->lte($date) && Carbon::parse($date)->month == $request->month) {									
							
								$status = OtchetStatus::where('formid', $row->id)
										->where('category', $row->category)
										->where('categorytable', $row->categorytable)
										->where('userid', $request->get('userid'))
										->where('plandate', (clone $date)->format('Y-m-d'))
										->first();
							
								$otchets_tocalendar[] = ['otchetdata' => $row, 'start' => (clone $date)->format('Y-m-d'), 'end' => (clone $date)->format('Y-m-d'), 'name' => $row->otchetname, 'status' => $status, 'reportday' => $reportday];
							}

						} else if ($reportday->freq == 5) { 
						
							$date = '';
						
							// Первый день квартала даты начала
							$start_quarter = Carbon::parse($row->otchetstartdate['date'])->startOfQuarter();
							
							// Первый день текущего квартала
							$start_quarter_now = Carbon::createFromDate($request->year, $request->month, 1, Config::get('app.timezone'))->startOfQuarter();

							// Разница в кварталах
							$diff = Carbon::parse($start_quarter)->diffInQuarters($start_quarter_now);

							// Проверка деления без остатка на периодичность
							if ($diff % $reportday->intervquarter == 0 ) {	
								
								if ($reportday->quarterdays != 'last') {								
									$date = Carbon::parse($start_quarter_now)->addDay($reportday->quarterdays-1);
								} else {
									$date = Carbon::parse($start_quarter_now)->lastOfQuarter();
								}
												
							} 

							if ($row->otchetstartdate && $date && Carbon::parse($row->otchetstartdate['date'])->lte($date) && Carbon::parse($date)->month == $request->month) {									
							
								$status = OtchetStatus::where('formid', $row->id)
										->where('category', $row->category)
										->where('categorytable', $row->categorytable)
										->where('userid', $request->get('userid'))
										->where('plandate', (clone $date)->format('Y-m-d'))
										->first();
							
								$otchets_tocalendar[] = ['otchetdata' => $row, 'start' => (clone $date)->format('Y-m-d'), 'end' => (clone $date)->format('Y-m-d'), 'name' => $row->otchetname, 'status' => $status, 'reportday' => $reportday];
							}						
						
						} else if ($reportday->freq == 6) { 
						
							
							$date = '';
						
							// Первый день года даты начала
							$start_year = Carbon::parse($row->otchetstartdate['date'])->startOfYear();
							
							// Первый день текущего года
							$start_year_now = Carbon::createFromDate($request->year, 1, 1, Config::get('app.timezone'))->startOfQuarter();

							// Разница в годах
							$diff = Carbon::parse($start_year)->diffInYears($start_year_now);

							// Проверка деления без остатка на периодичность
							if ($diff % $reportday->intervyear == 0 ) {

								// Если выбран метод по дню месяца
								if ($reportday->yearmethod == 1) {
									
									$date = Carbon::createFromDate($request->year, $reportday->yearmonth, $reportday->yearmonthdays, Config::get('app.timezone'));

									
								// Если выбран метод по неделе и дню недели
								} else if ($reportday->yearmethod == 2) {
									
									$daysOfWeek = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday", ];								
									$weeks = ["first", "second", "third", "fourth", "last", ];

									$date = Carbon::parse($weeks[$reportday->yearmonthweek-1].' '.$daysOfWeek[$reportday->yearmonthweekdays-1].' of '.date("F",mktime(0,0,0,$reportday->yearmonth,1,$request->year)).' '.$request->year);

								}
												
							}

							if ($row->otchetstartdate && $date && Carbon::parse($row->otchetstartdate['date'])->lte($date) && Carbon::parse($date)->month == $request->month) {									
							
								$status = OtchetStatus::where('formid', $row->id)
										->where('category', $row->category)
										->where('categorytable', $row->categorytable)
										->where('userid', $request->get('userid'))
										->where('plandate', (clone $date)->format('Y-m-d'))
										->first();
							
								$otchets_tocalendar[] = ['otchetdata' => $row, 'start' => (clone $date)->format('Y-m-d'), 'end' => (clone $date)->format('Y-m-d'), 'name' => $row->otchetname, 'status' => $status, 'reportday' => $reportday];
							}
						
						}

					}
					
				}	
			
			}
	
		} 
		
		return $otchets_tocalendar;
		
	}
	
	
	public function getCalendarOtchetsCount(Request $request){
	
		$result = 1;
	
		$otchetcount = OtchetPlan::where('userid', $request->get('userid'))->get();
		
		if($otchetcount->count() > 0){ 		
			$result = 2;
		}
		
		return $result;
	
	}
	
	
	
	public function setOtchetStatus(Request $request){
	
		if ($request->get('status') == 0 && $request->get('id') != '') {	
				
			$result = OtchetStatus::where('id', $request->get('id'))->where('userid', $request->get('userid'))->where('plandate', $request->get('plandate'))->delete();
			
			if ($result) {
				return response()->json(['success'=>'Удачно удалено']);
			} else {				
				$err = array();
				array_push($err, "Ошибка удаления.");
				return response()->json(['errors'=> ['error'=> $err]],444);
			}
			

		} else {

			// Валидация на ошибки в полях
			$validator = Validator::make($request->all(), [	
				'plandate' => [Rule::unique('otchet_statuses')->where(function ($query) use ($request) {return $query->where('userid', $request->get('userid'))->where('formid', $request->get('formid'))->where('category', $request->get('category'))->where('categorytable', $request->get('categorytable'));})->ignore($request->get('id'), 'id'),],				
			]);
			
			// Запись в БД
			if ($validator->passes()) {
				
				$status = OtchetStatus::updateOrCreate(['id' => $request->get('id')], ['userid'  => $request->get('userid'), 'formid'  => $request->get('formid'), 'category'  => $request->get('category'), 'categorytable'  => $request->get('categorytable'), 
				'status'  => $request->get('status'), 'plandate' => $request->get('plandate'), 'realdate' => $request->get('realdate'),]);

				return response()->json(['success'=>'Данные сохранены', 'status'=>$status]);
			
			} else {
				$err = array();
				array_push($err, "Ошибка сохранения, значение уже существует.");
				return response()->json(['errors'=> ['error'=> $err]],444);
			
			}
		
		}

	}
	
	
	public function deleteOtchetStatistic(Request $request){

		if ($request->get('id') !== null & $request->get('id') !== '0') {
				
			OtchetStatus::where('categorytable', $request->get('categorytable'))->where('category', $request->get('category'))->where('formid', $request->get('id'))->where('userid', $request->get('organisation'))->delete();
				
			$check = OtchetStatus::where('formid', $request->get('id'))
				->where('category', $request->get('category'))
				->where('categorytable', $request->get('categorytable'))
				->where('userid', $request->get('organisation'))
				->first();

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
	
	
	public function planedStandartCategoriesList(Request $request){

		$userid = $request->get('organisation');
			
		$categoriesList = Category::select('categories.id', 'categories.categoryname', 'categories.goverment', 'categories.law', 'categories.lawlink', 'categories.place', 'categories.comment', 'categories.organisation', 'categories.created_at', DB::raw('organisation as organisationname'), DB::raw("'admin' as 'table'"))			
			->join('otchet_plans', function ($join) use ($userid) {
				$join->on('categories.id', '=', 'otchet_plans.category');
				$join->on(DB::raw("'admin'"), '=', 'otchet_plans.categorytable');
				$join->on(DB::raw("'".$userid."'"), '=', 'otchet_plans.userid');
				$join->on(DB::raw("'NULL'"), '!=', 'otchet_plans.firstdate');	
			})			
			->orderBy('id', 'asc')
			->get();

        return $categoriesList;		

    }
	
	
	public function planedUserCategoriesList(Request $request){
		
		$userid = $request->get('organisation');
				
		$categoriesList = UserCategory::select('user_categories.id', 'user_categories.categoryname', 'user_categories.goverment', 'user_categories.law', 'user_categories.lawlink', 'user_categories.place', 'user_categories.comment', 'user_categories.organisation', 'user_categories.created_at', DB::raw("'user' as 'table'"))
			->where('organisation', $request->get('organisation'))
			->join('otchet_plans', function ($join) use ($userid) {
				$join->on('user_categories.id', '=', 'otchet_plans.category');
				$join->on(DB::raw("'user'"), '=', 'otchet_plans.categorytable');
				$join->on(DB::raw("'".$userid."'"), '=', 'otchet_plans.userid');
				$join->on(DB::raw("'NULL'"), '!=', 'otchet_plans.firstdate');	
			})		
			->orderBy('id', 'asc')
			->get();
		
        return $categoriesList;		

    }
	
	public function planedStandartOtchetsList(Request $request){
		
		$userid = $request->get('userid');
		
		$otchetsList = Form::select('forms.id', 'forms.category', 'forms.categorytable', 'forms.razdelname', 'forms.otchetname', 'forms.reportdays', 'forms.whosend', 'forms.otchetlink', 'forms.comment', 'forms.organisation', 'forms.created_at', DB::raw('organisation as organisationname'), DB::raw( $request->get('userid').' as otchetstartdate'))
			->where('forms.category', $request->get('category'))			
			->where('forms.categorytable', $request->get('categorytable'))			
			->join('otchet_plans', function ($join) use ($userid) {
				$join->on('forms.id', '=', 'otchet_plans.formid');
				$join->on(DB::raw("'admin'"), '=', 'otchet_plans.categorytable');
				$join->on(DB::raw("'".$userid."'"), '=', 'otchet_plans.userid');
				$join->on(DB::raw("'NULL'"), '!=', 'otchet_plans.firstdate');	
			})
			->orderBy('id', 'asc')
			->get();
				
        return $otchetsList;

	}
	
	
	public function planedUserOtchetsList(Request $request){
		
		$userid = $request->get('userid');
		
		$otchetsList = UserForm::select('user_forms.id', 'user_forms.category', 'user_forms.categorytable', 'user_forms.razdelname', 'user_forms.otchetname', 'user_forms.reportdays', 'user_forms.comment', 'user_forms.organisation', DB::raw( $request->get('userid').' as otchetstartdate'), DB::raw( $request->get('userid').' as status'))
			->where('user_forms.organisation', $request->get('userid'))
			->where('user_forms.category', $request->get('category'))
			->where('user_forms.categorytable', $request->get('categorytable'))
			->join('otchet_plans', function ($join) use ($userid) {
				$join->on('user_forms.id', '=', 'otchet_plans.formid');
				$join->on(DB::raw("'user'"), '=', 'otchet_plans.categorytable');
				$join->on(DB::raw("'".$userid."'"), '=', 'otchet_plans.userid');
				$join->on(DB::raw("'NULL'"), '!=', 'otchet_plans.firstdate');	
			})
			->orderBy('id', 'asc')
			->get();
		
        return $otchetsList;

	}
	
	
	
	public function getPlanFactDates(Request $request){
		
		$otchet = json_decode($request->get('otchet'));

		$otchets_tocalendar = [];
																		
		foreach(json_decode($otchet->reportdays) as $reportday){
						
			// Однократно: дата или событие
			if ($reportday->freq == 1) {

				$date = '';
				
				// Если есть дата
				if ($reportday->onetimeday) {							
					$date = Carbon::parse($reportday->onetimeday);								
				// Если нет даты, то последний день месяца
				} else {								
					$date = Carbon::parse('last day of '.date("F",mktime(0,0,0,$request->month,1,$request->year)).' '.$request->year);
				}
				
				if ($otchet->otchetstartdate && $date && Carbon::parse($otchet->otchetstartdate->date)->lte($date) && Carbon::parse($date)->month == $request->month) {													
					
					$status = OtchetStatus::where('formid', $otchet->id)
							->where('category', $otchet->category)
							->where('categorytable', $otchet->categorytable)
							->where('userid', $request->get('userid'))
							->where('plandate', (clone $date)->format('Y-m-d'))
							->first();
							
					
					$otchets_tocalendar[] = ['otchetdata' => $otchet, 'start' => (clone $date)->format('Y-m-d'), 'end' => (clone $date)->format('Y-m-d'), 'name' => $otchet->otchetname, 'reportday' => $reportday, 'status' => $status];

				}
			
			// Дневная периодичность
			} else if ($reportday->freq == 2) {
					
				$date = '';
				
				// Первый день месяца
				$firstdayofmonth = Carbon::parse('first day of '.date("F",mktime(0,0,0,$request->month,1,$request->year)).' '.$request->year);
				// Последний день месяца
				$lastdayofmonth = Carbon::parse('last day of '.date("F",mktime(0,0,0,$request->month,1,$request->year)).' '.$request->year);
				
				// Если дата начала отчета меньше первого дня месяца
				if (Carbon::parse($otchet->otchetstartdate->date)->lt($firstdayofmonth)) {							
					// Разница в днях
					$diff = Carbon::parse($otchet->otchetstartdate->date)->diffInDays($firstdayofmonth);	
					// Находим ближайший к началу месяца день. Целое количество интервалов * периодичность.
					$date = Carbon::parse($otchet->otchetstartdate->date)->addDay(intval($diff/$reportday->intervday)*$reportday->intervday);							
				
				// Если дата начала отчета больше первого дня месяца, то первый день - дата начала отчета
				} else {								
					$date = Carbon::parse($otchet->otchetstartdate->date);
				}
				
				// Пока дни попадают в месяц, складываем в выборку. В итерации добавляем количество дней равное периодичности.
				for (;;) {
								
					if ($date->gt($lastdayofmonth)) {
						break;
					}

					if ($otchet->otchetstartdate && $date && Carbon::parse($otchet->otchetstartdate->date)->lte($date) && Carbon::parse($date)->month == $request->month) {									
						
						$status = OtchetStatus::where('formid', $otchet->id)
							->where('category', $otchet->category)
							->where('categorytable', $otchet->categorytable)
							->where('userid', $request->get('userid'))
							->where('plandate', (clone $date)->format('Y-m-d'))
							->first();
						
						if (Carbon::parse($date)->between($firstdayofmonth, $lastdayofmonth)) {
						
							$otchets_tocalendar[] = ['otchetdata' => $otchet, 'start' => (clone $date)->format('Y-m-d'), 'end' => (clone $date)->format('Y-m-d'), 'name' => $otchet->otchetname, 'reportday' => $reportday, 'status' => $status];
					
						}
					
					}
													
					$date = Carbon::parse($date)->addDay($reportday->intervday);
					
				}							

			} else if ($reportday->freq == 3) {
				
				$daysOfWeek = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday", ];
				
				$date = '';
				
				// Первый нужный день недели в выбранном месяце
				$firstweekdayofmonth = Carbon::parse('first '.$daysOfWeek[$reportday->weekdays-1].' of '.date("F",mktime(0,0,0,$request->month,1,$request->year)).' '.$request->year);
											
				// Первый нужный день недели следующий после даты начала отчета
				$firstweekdayofmonthafterstart = '';

				if (Carbon::parse($otchet->otchetstartdate->date)->is($daysOfWeek[$reportday->weekdays-1])) {								
					$firstweekdayofmonthafterstart = Carbon::parse($otchet->otchetstartdate->date);								
				} else {
					
					$firstweekdayofmonthafterstart = Carbon::parse($otchet->otchetstartdate->date)->next($daysOfWeek[$reportday->weekdays-1]);
					
					if ($reportday->intervweek != 1) {
						// Если дата начала отчета после первого нужного дня текущей недели, то прибавляем полный интервал
						$firstweekdayofmonthafterstart = Carbon::parse($firstweekdayofmonthafterstart)->addWeek($reportday->intervweek-1);
					}	
				}

				// Если первый после даты начала отчета день недели меньше первого дня недели в выбранном месяце
				if (Carbon::parse($firstweekdayofmonthafterstart)->lt($firstweekdayofmonth)) {							
					
					// Разница в неделях
					$diff = Carbon::parse($otchet->otchetstartdate->date)->diffInWeeks($firstweekdayofmonth);								

					// Проверка деления без остатка на периодичность
					if ($diff % $reportday->intervweek == 0 ) {									
						// Если делится без остатка, то добавляем разницу в неделях к дате 
						$date = Carbon::parse($firstweekdayofmonthafterstart)->addWeek($diff);							
					} else {
						// Если делится с остатком, то добавляем разницу в неделях плюс остаток к дате
						$date = Carbon::parse($firstweekdayofmonthafterstart)->addWeek($diff+$diff % $reportday->intervweek);
					}
					
				} else {								
					
					$date = Carbon::parse($firstweekdayofmonthafterstart);
				}
				
				// Первый день месяца
				$firstdayofmonth = Carbon::parse('first day of '.date("F",mktime(0,0,0,$request->month,1,$request->year)).' '.$request->year);
				// Последний день месяца
				$lastdayofmonth = Carbon::parse('last day of '.date("F",mktime(0,0,0,$request->month,1,$request->year)).' '.$request->year);

				// Пока дни попадают в месяц, складываем в выборку. В итерации добавляем количество дней равное периодичности (в неделях).
				
				
				// Пока дни попадают в месяц, складываем в выборку. В итерации добавляем количество дней равное периодичности (в неделях).
				for (;;) {
					
					if ($date->gt($lastdayofmonth)) {
						break;
					}

					if ($otchet->otchetstartdate && $date && Carbon::parse($otchet->otchetstartdate->date)->lte($date) && Carbon::parse($date)->month == $request->month) {									
					
						$status = OtchetStatus::where('formid', $otchet->id)
							->where('category', $otchet->category)
							->where('categorytable', $otchet->categorytable)
							->where('userid', $request->get('userid'))
							->where('plandate', (clone $date)->format('Y-m-d'))
							->first();
							
							if (Carbon::parse($date)->between($firstdayofmonth, $lastdayofmonth)) {							
								$otchets_tocalendar[] = ['otchetdata' => $otchet, 'start' => (clone $date)->format('Y-m-d'), 'end' => (clone $date)->format('Y-m-d'), 'name' => $otchet->otchetname, 'reportday' => $reportday, 'status' => $status];							
							}

					}
													
					$date = Carbon::parse($date)->addDay(7*$reportday->intervweek);

				}					

			} else if ($reportday->freq == 4) {
				
				$date = '';

				// Первый день месяца даты начала
				$start_month = Carbon::parse($otchet->otchetstartdate->date)->startOfMonth();
				
				// Первый день текущего месяца
				$start_month_now = Carbon::createFromDate($request->year, $request->month, 1, Config::get('app.timezone'));

				// Разница в месяцах
				$diff = Carbon::parse($start_month)->diffInMonths($start_month_now);

				// Проверка деления без остатка на периодичность
				if ($diff % $reportday->intervmonth == 0 ) {

					// Если выбран метод по дню месяца
					if ($reportday->monthmethod == 1) {
						
						// Последний день нужного месяца
						$last_day = Carbon::parse('last day of '.date("F",mktime(0,0,0,$start_month_now->month,1,$start_month_now->year)).' '.$start_month_now->year);
					
						// Если день отчета больше последнего дня месяца 
						if ($reportday->monthdays >= $last_day->day | $reportday->monthdays == 'last') {								
							$date = $last_day;
						} else {
							$date = Carbon::createFromDate(Carbon::parse($last_day)->year, Carbon::parse($last_day)->month, $reportday->monthdays, Config::get('app.timezone'));
						}
					// Если выбран метод по неделе и дню недели
					} else if ($reportday->monthmethod == 2) {
						
						$daysOfWeek = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday", ];								
						$weeks = ["first", "second", "third", "fourth", "last", ];

						$date = Carbon::parse($weeks[$reportday->monthweek-1].' '.$daysOfWeek[$reportday->monthweekdays-1].' of '.date("F",mktime(0,0,0,$start_month_now->month,1,$start_month_now->year)).' '.$start_month_now->year);

					}
																	
				}

				if ($otchet->otchetstartdate && $date && Carbon::parse($otchet->otchetstartdate->date)->lte($date) && Carbon::parse($date)->month == $request->month) {									
				
					$status = OtchetStatus::where('formid', $otchet->id)
							->where('category', $otchet->category)
							->where('categorytable', $otchet->categorytable)
							->where('userid', $request->get('userid'))
							->where('plandate', (clone $date)->format('Y-m-d'))
							->first();
				
					$otchets_tocalendar[] = ['otchetdata' => $otchet, 'start' => (clone $date)->format('Y-m-d'), 'end' => (clone $date)->format('Y-m-d'), 'name' => $otchet->otchetname, 'reportday' => $reportday, 'status' => $status];
				}

			} else if ($reportday->freq == 5) { 
			
				$date = '';
			
				// Первый день квартала даты начала
				$start_quarter = Carbon::parse($otchet->otchetstartdate->date)->startOfQuarter();
				
				// Первый день текущего квартала
				$start_quarter_now = Carbon::createFromDate($request->year, $request->month, 1, Config::get('app.timezone'))->startOfQuarter();

				// Разница в кварталах
				$diff = Carbon::parse($start_quarter)->diffInQuarters($start_quarter_now);

				// Проверка деления без остатка на периодичность
				if ($diff % $reportday->intervquarter == 0 ) {	
					
					if ($reportday->quarterdays != 'last') {								
						$date = Carbon::parse($start_quarter_now)->addDay($reportday->quarterdays-1);
					} else {
						$date = Carbon::parse($start_quarter_now)->lastOfQuarter();
					}
									
				} 

				if ($otchet->otchetstartdate && $date && Carbon::parse($otchet->otchetstartdate->date)->lte($date) && Carbon::parse($date)->month == $request->month) {									
				
					$status = OtchetStatus::where('formid', $otchet->id)
							->where('category', $otchet->category)
							->where('categorytable', $otchet->categorytable)
							->where('userid', $request->get('userid'))
							->where('plandate', (clone $date)->format('Y-m-d'))
							->first();
				
					$otchets_tocalendar[] = ['otchetdata' => $otchet, 'start' => (clone $date)->format('Y-m-d'), 'end' => (clone $date)->format('Y-m-d'), 'name' => $otchet->otchetname, 'reportday' => $reportday, 'status' => $status];
				}						
			
			} else if ($reportday->freq == 6) { 
			
				
				$date = '';
			
				// Первый день года даты начала
				$start_year = Carbon::parse($otchet->otchetstartdate->date)->startOfYear();
				
				// Первый день текущего года
				$start_year_now = Carbon::createFromDate($request->year, 1, 1, Config::get('app.timezone'))->startOfQuarter();

				// Разница в годах
				$diff = Carbon::parse($start_year)->diffInYears($start_year_now);

				// Проверка деления без остатка на периодичность
				if ($diff % $reportday->intervyear == 0 ) {

					// Если выбран метод по дню месяца
					if ($reportday->yearmethod == 1) {
						
						$date = Carbon::createFromDate($request->year, $reportday->yearmonth, $reportday->yearmonthdays, Config::get('app.timezone'));

						
					// Если выбран метод по неделе и дню недели
					} else if ($reportday->yearmethod == 2) {
						
						$daysOfWeek = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday", ];								
						$weeks = ["first", "second", "third", "fourth", "last", ];

						$date = Carbon::parse($weeks[$reportday->yearmonthweek-1].' '.$daysOfWeek[$reportday->yearmonthweekdays-1].' of '.date("F",mktime(0,0,0,$reportday->yearmonth,1,$request->year)).' '.$request->year);

					}
									
				}

				if ($otchet->otchetstartdate && $date && Carbon::parse($otchet->otchetstartdate->date)->lte($date) && Carbon::parse($date)->month == $request->month) {									
				
					$status = OtchetStatus::where('formid', $otchet->id)
							->where('category', $otchet->category)
							->where('categorytable', $otchet->categorytable)
							->where('userid', $request->get('userid'))
							->where('plandate', (clone $date)->format('Y-m-d'))
							->first();
				
					$otchets_tocalendar[] = ['otchetdata' => $otchet, 'start' => (clone $date)->format('Y-m-d'), 'end' => (clone $date)->format('Y-m-d'), 'name' => $otchet->otchetname, 'reportday' => $reportday, 'status' => $status];
				}
			
			}

		}

		return $otchets_tocalendar;
		
	}
		
}
