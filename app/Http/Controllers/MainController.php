<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Validator;
use Session;
use Auth;

class MainController extends Controller
{
    //
    public function getfeed()
    {
    	
    	$events = DB::table('event')
        ->join('events_users', 'event.id', '=', 'events_users.eventid')
        ->where('userid', Session::get('userid'))
        ->select('event.*')
    	->get();
    	$today = getdate();
    	$data = [];
    	foreach($events as $event)
    	{
    		if($event->startdate < $today && $event->expiredate > $today)
    			$data[] = $event;
    	}
    	return $data;
    }

    public function getfeed2()
    {
    	$events = DB::table('event')
    	->join('masters', 'event.createdby', '=', 'masters.userid');
    	->where('state', '0')
    	->where('masters.legionid', Session::get('userid'))
    	->select('masters.*')
    	->get();

    	$data = [];
    	foreach ($events as $value) {
    		$data[] = $value;
    	}
    	return $data;
    }
}
