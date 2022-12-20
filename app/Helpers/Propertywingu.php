<?php
namespace App\Helpers;
use App\Models\property\landlord\landlords;
use App\Models\property\landlord\landlord_group;
use App\Models\property\type;
use App\Models\property\unit_type;
use App\Models\property\property as props;
use App\Models\property\tenants\tenants;
use App\Models\property\invoice\invoices;
use App\Models\property\invoice\invoice_settings;
use App\Models\property\creditnote\creditnote_settings;
use App\Models\property\utilities;
use App\Models\property\lease_utility;
use App\Models\property\expense\expense;
use App\Models\wingu\file_manager;
use App\Models\property\listings;
use App\Models\property\lease;
use Auth;
use Helper;
use Wingu;

class Propertywingu
{
	//======================================= landlord  =========================================
	//=============================================================================================---->

	// check if landlord exists
	public static function check_landlord($id){
		$check = landlords::where('id',$id)->count();
		return $check;
	}

	// landlord information
	public static function landlord($id){
		$landlord = landlords::find($id);
		return $landlord;
	}

	//landlord category
	public static function landlord_category($id){
		$category = landlord_group::join('landlord_groups','landlord_groups.id','=','landlord_group.groupID')
						->where('landlordID',$id)
						->where('landlord_groups.business_code',Auth::user()->business_code)
						->get();
		return $category;
	}

	//landlord category
	public static function landlord_properties($id){
		$count = props::where('landlordID',$id)->where('business_code',Auth::user()->business_code)->count();
		return $count;
	}


	//======================================= property  =========================================
	//=============================================================================================---->
	//===count unit properties
	public static function total_units_per_property($code){
		$count = props::where('parent',$code)->where('business_code',Auth::user()->business_code)->count();
		return $count;
	}

	//property information
	public static function property_info($code){
		$info = props::where('property_code',$code)->where('business_code',Auth::user()->business_code)->first();
		return $info;
	}

	//occupied units in a property
	public static function occupied_units($code){
		$count = props::where('parent',$code)->where('tenant','!=',"")->where('business_code',Auth::user()->business_code)->count();
		return $count;
	}

	//property type info
	public static function property_type($code){
		$info = type::where('code',$code)->first();
		return $info;
	}

	//property Unit check
	public static function check_property_unit($propertyID,$unitID){
		$count = props::where('parent',$propertyID)->where('id',$unitID)->where('business_code',Auth::user()->business_code)->count();
		return $count;
	}

	//property unit info
	public static function property_unit($propertyID,$unitID){
		$unit = props::where('parent',$propertyID)->where('id',$unitID)->where('business_code',Auth::user()->business_code)->first();
		return $unit;
	}

	//check property cover image
	public static function check_cover_property_image($propertyID,$imageID){
		$check = file_manager::where('fileID',$propertyID)
								->where('id',$imageID)
								->where('cover',1)
								->where('business_code',Auth::user()->business_code)
								->where('section','property/images')
								->count();
		return $check;
	}


	//======================================= Tenants  =========================================
	//=============================================================================================---->
	//====check tenant
	public static function check_tenant($id){
		$check = tenants::where('id',$id)->where('business_code',Auth::user()->business_code)->count();
		return $check;
	}

	//====tenant info
	public static function tenant_info($id){
		$info = tenants::where('id',$id)->where('business_code',Auth::user()->business_code)->first();
		return $info;
	}

	//====count tenant leases
	public static function count_lease($code){
		$count = lease::where('tenant',$code)->where('business_code',Auth::user()->business_code)->count();
		return $count;
	}


	//======================================= lease  =========================================
	//=============================================================================================---->
	public static function lease($code){
		$lease = lease::where('lease_code',$code)->where('business_code',Auth::user()->business_code)->first();
		return $lease;
	}

	//======================================= invoice  =========================================
	//=============================================================================================---->
	//invoice settings
	public static function make_invoice_settings($code){
		$new = new invoice_settings;
		$new->property = $code;
		$new->number = 0;
		$new->prefix = 'INV';
		$new->business_code = Auth::user()->business_code;
		$new->created_by = Auth::user()->user_code;
		$new->save();

		return;
	}

	//======================================= credit note  =========================================
	//=============================================================================================---->
	//credit note settings
	public static function make_creditnote_settings($id){
		$new = new creditnote_settings;
		$new->propertyID = $id;
		$new->number = 0;
		$new->prefix = 'CN';
		$new->business_code = Auth::user()->business_code;
		$new->created_by = Auth::user()->user_code;
		$new->save();

		return;
	}

	//======================================= Listing  =========================================
	//=============================================================================================---->
	public static function listing($id){
		$information = listings::where('id',$id)->where('business_code',Auth::user()->business_code)->first();
		return $information;
	}

	//======================================= reports   =========================================
	//=============================================================================================---->
	//check invoice income category within a period
	public static function check_invoice_in_category_by_period($propertyID,$id,$from,$to){
		$check = invoices::where('business_code',Auth::user()->business_code)
								->whereBetween('invoice_date',[$from,$to])
								->where('income_category',$id)
								->where('propertyID',$propertyID)
								->count();
		return $check;
	}

	//get invoices by income category
	public static function invoices_per_income_category($propertyID,$id,$from,$to){
		$invoices = invoices::where('business_code',Auth::user()->business_code)
									->whereBetween('invoice_date',[$from,$to])
									->where('income_category',$id)
									->where('propertyID',$propertyID)
									->groupby('income_category')
									->orderby('id','desc')
									->get();
		return $invoices;
	}

	//get invoices by income category
	public static function invoices_per_income_category_sum($propertyID,$id,$from,$to){
		$sum = invoices::where('business_code',Auth::user()->business_code)
							->whereBetween('invoice_date',[$from,$to])
							->where('propertyID',$propertyID)
							->where('income_category',$id)
							->sum('main_amount');
		return $sum;
	}

	//get expense by category within a period
	public static function check_expense_per_category_by_period($propertyID,$id,$from,$to){
		$check = expense::whereBetween('date',[$from,$to])->where('expense_category',$id)->where('propertyID',$propertyID)->count();
		return $check;
	}

	public static function expense_per_category($propertyID,$id,$from,$to){
		$expenses = expense::where('business_code',Auth::user()->business_code)
									->whereBetween('date',[$from,$to])
									->where('expense_category',$id)
									->where('propertyID',$propertyID)
									->groupby('expense_category')
									->orderby('id','desc')
									->get();
		return $expenses;
	}

	public static function expense_per_category_sum($propertyID,$id,$from,$to){
		$sum = expense::where('business_code',Auth::user()->business_code)
							->whereBetween('date',[$from,$to])
							->where('expense_category',$id)
							->where('propertyID',$propertyID)
							->sum('amount');
		return $sum;
	}

	//======================================= Utility  =========================================
	//=============================================================================================---->
	public static function utility($id){
		$utility = utilities::where('id',$id)->where('business_code',Auth::user()->business_code)->first();
		return $utility;
	}
}
