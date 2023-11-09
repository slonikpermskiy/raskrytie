<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Form;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class MainpageController extends Controller
{
    
	public function getStandartCategoriesList(Request $request){
				
		$categoriesList = Category::select('id', 'categoryname', 'goverment', 'law', 'lawlink', 'place', 'comment', 'organisation', 'created_at', DB::raw('organisation as organisationname'), DB::raw("'admin' as 'table'"))
			->orderBy('id', 'asc')
			->get();
		
        return $categoriesList;		

    }


	public function getStandartOtchetsList(Request $request){
		
		$otchetsList = Form::select('id', 'category', 'categorytable', 'razdelname', 'otchetname', 'reportdays', 'whosend', 'otchetlink', 'comment', 'organisation', 'created_at', DB::raw('organisation as organisationname'))
			->where('category', $request->get('category'))
			->where('categorytable', $request->get('categorytable'))
			->orderBy('id', 'asc')
			->get();
		
        return $otchetsList;

	}


    public function getMainCalendarOtchets(Request $request){	
			
		$otchetsList = Form::select('id', 'category', 'categorytable', 'razdelname', 'otchetname', 'firstdate', 'reportdays', 'whosend', 'otchetlink', 'comment', DB::raw('category as categorydata'))
		->where('categorytable', 'admin')
		->where('organisation', 'admin')
		->get();
		

		$otchets_tocalendar = [];
		
		if(count($otchetsList) > 0){
			
			foreach($otchetsList as $row){
														
				if ($row->firstdate) {

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
							
							if ($row->firstdate && $date && Carbon::parse($row->firstdate)->lte($date) && Carbon::parse($date)->month == $request->month) {													
							
								$otchets_tocalendar[] = ['otchetdata' => $row, 'start' => (clone $date)->format('Y-m-d'), 'end' => (clone $date)->format('Y-m-d'), 'name' => $row->otchetname, 'reportday' => $reportday];
							}
						
						// Дневная периодичность
						} else if ($reportday->freq == 2) {
							
							$date = '';
							
							// Первый день месяца
							$firstdayofmonth = Carbon::parse('first day of '.date("F",mktime(0,0,0,$request->month,1,$request->year)).' '.$request->year);
							// Последний день месяца
							$lastdayofmonth = Carbon::parse('last day of '.date("F",mktime(0,0,0,$request->month,1,$request->year)).' '.$request->year);
							
							// Если дата начала отчета меньше первого дня месяца
							if (Carbon::parse($row->firstdate)->lt($firstdayofmonth)) {							
															
								// Разница в днях
								$diff = Carbon::parse($row->firstdate)->diffInDays($firstdayofmonth);	
								
								// Находим ближайший к началу месяца день. Целое количество интервалов * периодичность.
								$date = Carbon::parse($row->firstdate)->addDay(intval($diff/$reportday->intervday)*$reportday->intervday);
							
							// Если дата начала отчета больше первого дня месяца, то первый день - дата начала отчета
							} else {								
								$date = Carbon::parse($row->firstdate);
							}
							
							// Пока дни попадают в месяц, складываем в выборку. В итерации добавляем количество дней равное периодичности. 
							for (;;) {
								
								if ($date->gt($lastdayofmonth)) {
									break;
								}

								if ($row->firstdate && $date && Carbon::parse($row->firstdate)->lte($date) && Carbon::parse($date)->month == $request->month) {									
									
									if (Carbon::parse($date)->between($firstdayofmonth, $lastdayofmonth)) {
									
										$otchets_tocalendar[] = ['otchetdata' => $row, 'start' => (clone $date)->format('Y-m-d'), 'end' => (clone $date)->format('Y-m-d'), 'name' => $row->otchetname, 'reportday' => $reportday];									
								
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
 
							if (Carbon::parse($row->firstdate)->is($daysOfWeek[$reportday->weekdays-1])) {								
								$firstweekdayofmonthafterstart = Carbon::parse($row->firstdate);								
							} else {
								
								$firstweekdayofmonthafterstart = Carbon::parse($row->firstdate)->next($daysOfWeek[$reportday->weekdays-1]);
								
								if ($reportday->intervweek != 1) {
									// Если дата начала отчета после первого нужного дня текущей недели, то прибавляем полный интервал
									$firstweekdayofmonthafterstart = Carbon::parse($firstweekdayofmonthafterstart)->addWeek($reportday->intervweek-1);
								}	
							}

							// Если первый после даты начала отчета день недели меньше первого дня недели в выбранном месяце
							if (Carbon::parse($firstweekdayofmonthafterstart)->lt($firstweekdayofmonth)) {							
								
								// Разница в неделях
								$diff = Carbon::parse($row->firstdate)->diffInWeeks($firstweekdayofmonth);								

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
								
								if ($row->firstdate && $date && Carbon::parse($row->firstdate)->lte($date) && Carbon::parse($date)->month == $request->month) {									
									
									if (Carbon::parse($date)->between($firstdayofmonth, $lastdayofmonth)) {									
										$otchets_tocalendar[] = ['otchetdata' => $row, 'start' => (clone $date)->format('Y-m-d'), 'end' => (clone $date)->format('Y-m-d'), 'name' => $row->otchetname, 'reportday' => $reportday];
									}
								}
																
								$date = Carbon::parse($date)->addDay(7*$reportday->intervweek);

							}		

						} else if ($reportday->freq == 4) {
							
							$date = '';

							// Первый день месяца даты начала
							$start_month = Carbon::parse($row->firstdate)->startOfMonth();
							
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

							if ($row->firstdate && $date && Carbon::parse($row->firstdate)->lte($date) && Carbon::parse($date)->month == $request->month) {									
							
								$otchets_tocalendar[] = ['otchetdata' => $row, 'start' => (clone $date)->format('Y-m-d'), 'end' => (clone $date)->format('Y-m-d'), 'name' => $row->otchetname, 'reportday' => $reportday];
							}

						} else if ($reportday->freq == 5) { 
						
							$date = '';
						
							// Первый день квартала даты начала
							$start_quarter = Carbon::parse($row->firstdate)->startOfQuarter();
							
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

							if ($row->firstdate && $date && Carbon::parse($row->firstdate)->lte($date) && Carbon::parse($date)->month == $request->month) {									
							
								$otchets_tocalendar[] = ['otchetdata' => $row, 'start' => (clone $date)->format('Y-m-d'), 'end' => (clone $date)->format('Y-m-d'), 'name' => $row->otchetname, 'reportday' => $reportday];
							}						
						
						} else if ($reportday->freq == 6) { 
						
							
							$date = '';
						
							// Первый день года даты начала
							$start_year = Carbon::parse($row->firstdate)->startOfYear();
							
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

							if ($row->firstdate && $date && Carbon::parse($row->firstdate)->lte($date) && Carbon::parse($date)->month == $request->month) {									
							
								$otchets_tocalendar[] = ['otchetdata' => $row, 'start' => (clone $date)->format('Y-m-d'), 'end' => (clone $date)->format('Y-m-d'), 'name' => $row->otchetname, 'reportday' => $reportday];
							}
						
						}

					}
					
				}	
			
			}
	
		} 
		
		return $otchets_tocalendar;
		
	}

}
