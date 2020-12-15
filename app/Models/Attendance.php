<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
    	'store_id',
	    'import_time',
	    'staff_id',
	    'name',
	    'department',
	    'base_working_time',
		'actual_working_time',
		'skip',
	    'skip_grade',
	    'live_earl',
	    'live_earl_grade',
	    'base_exploited_times',
	    'special_exploited_times',
	    'base_actual_days',
	    'travel_days',
	    'skip_work_days',
	    'leave_days',
	    'work_rate',
	    'salary_remark',
	    'exploited_salary',
	    'add_salary',
	    'late_reduce',
	    'leave_reduce',
	    'reduce_salary',
	    'actual_salary',
	    'remark'
    ];
}
