<?php
namespace App\Helpers;
use App\Models\crm\leads\leads;
use App\Models\finance\customer\customers;
use App\Models\crm\digital\medium;
use App\Models\crm\deals\pipeline;
use App\Models\crm\deals\stages;
use App\Models\crm\deals\deals;
use App\Models\crm\leads\sources;
use App\Models\crm\leads\status;
use Auth;
class Crm
{
	public static function lead($code){
		$lead = customers::where('business_code',Auth::user()->business_code)->where('customer_code',$code)->first();
		return $lead;
	}

	/*=== lead status ===*/
	public static function check_lead_status($code){
		$check = status::where('business_code',Auth::user()->business_code)->where('status_code',$code)->count();
		return $check;
	}

	public static function lead_status($code){
		$status = status::where('business_code',Auth::user()->business_code)->where('status_code',$code)->first();
		return $status;
	}

	/*=== mediums ===*/
	public static function medium($id){
		$medium = medium::find($id);
		return $medium;
	}

	/*=== pipeline ===*/
	//check pipeline
	public static function check_pipeline($code){
		$check = pipeline::where('pipeline_code',$code)->where('business_code',Auth::user()->business_code)->count();
		return $check;
	}

	//get pipeline
	public static function pipeline($code){
		$pipeline = pipeline::where('pipeline_code',$code)->where('business_code',Auth::user()->business_code)->first();
		return $pipeline;
	}

	/*=== pipeline stage ===*/
	//check pipeline
	public static function check_pipeline_stage($code){
		$check = stages::where('stage_code',$code)->where('business_code',Auth::user()->business_code)->count();
		return $check;
	}

	//get stages
	public static function pipeline_stage($code){
		$pipeline = stages::where('stage_code',$code)->where('business_code',Auth::user()->business_code)->first();
		return $pipeline;
	}

	//get all stages per pipeline
	public static function  all_pipeline_stages($code){
		$stages = stages::where('pipeline_code',$code)->where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();
		return $stages;
	}

	/*=== lead source ===*/
	//check source
	public static function check_sources($code){
		$check = sources::where('source_code',$code)->where('business_code',Auth::user()->business_code)->count();
		return $check;
	}

	//sources
	public static function source($code){
		$source = sources::where('source_code',$code)->where('business_code',Auth::user()->business_code)->first();
		return $source;
	}

   /*=== deals ===*/
   public function stage_deals($code){
      $deals = deals::where('business_code',Auth::user()->business_code)->where('stage',$code)->orderby('id','desc')->get();
      return $deals;
   }

}


