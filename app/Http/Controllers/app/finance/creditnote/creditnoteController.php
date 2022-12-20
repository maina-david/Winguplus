<?php

namespace App\Http\Controllers\app\finance\creditnote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\sendCreditnote;
use App\Models\finance\customer\customers;
use App\Models\finance\customer\contact_persons;
use App\Models\finance\creditnote\creditnote;
use App\Models\finance\invoice\invoices;
use App\Models\finance\invoice\invoice_payments;
use App\Models\finance\creditnote\creditnote_products;
use App\Models\finance\creditnote\creditnote_settings as settings;
use App\Models\finance\products\product_information;
use App\Models\wingu\status;
use App\Models\wingu\file_manager as docs;
use App\Models\finance\tax;
use App\Mail\sendLpo;
use App\Models\wingu\Email;
use Session;
use File;
use Helper;
use Finance;
use Wingu;
use Auth;
use PDF;
use Mail;

class creditnoteController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$creditnotes = creditnote::join('wp_business','wp_business.business_code','=','fn_creditnote.business_code')
                              ->join('fn_creditnote_settings','fn_creditnote_settings.business_code','=','wp_business.business_code')
                              ->join('wp_status','wp_status.id','=','fn_creditnote.status')
                              ->join('fn_customers','fn_customers.customer_code','=','fn_creditnote.customer_code')
                              ->where('fn_creditnote.business_code',Auth::user()->business_code)
                              ->select('*','fn_creditnote.number as credit_note_number','wp_status.name as statusName','wp_business.currency as currency','fn_creditnote.prefix as credit_note_prefix')
                              ->orderby('fn_creditnote.id','desc')
                              ->get();

		return view('app.finance.creditnote.index', compact('creditnotes'));
	}

   /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function create()
   {
		$customers = customers::where('business_code',Auth::user()->business_code)->pluck('customer_name','customer_code')->prepend('choose customer','');
		$taxes = tax::where('business_code',Auth::user()->business_code)->OrderBy('id','DESC')->get();
		$status	= status::all();

		$itemProducts = product_information::join('fn_product_inventory','fn_product_inventory.product_code','=','fn_product_information.id')
                                          ->where('fn_product_information.type','product')
                                          ->where('fn_product_information.business_code',Auth::user()->business_code)
                                          ->where('default_inventory','Yes')
                                          ->OrderBy('fn_product_information.id','DESC')
                                          ->select('*','fn_product_information.id as product_code')
                                          ->get();

		$itemService = product_information::join('fn_product_inventory','fn_product_inventory.product_code','=','fn_product_information.id')
				->where('fn_product_information.type','service')
				->where('fn_product_information.business_code',Auth::user()->business_code)
				->where('default_inventory','Yes')
				->OrderBy('fn_product_information.id','DESC')
				->select('*','fn_product_information.id as product_code')
				->get();

		return view('app.finance.creditnote.create', compact('customers','status','taxes','itemProducts','itemService'));
   }

   /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request)
   {
      $this->validate($request, array(
			'customer'	      => 'required',
			'number'	         => 'required',
			'creditnote_date'	=> 'required',
		));

		//check credit products
		$check_product_items = count(collect($request->product_code));
		if($check_product_items < 1){
			Session::flash('error','Please select the credited items for this credit note');

			return redirect()->back();
		}

      $setting = settings::where('business_code',Auth::user()->business_code)->first();

      $code = Helper::generateRandomString(30);

      //store Credit note
      $store					     = new creditnote;
      $store->creditnote_code   = $code;
		$store->created_by		  = Auth::user()->user_code;
		$store->customer_code	  = $request->customer;
      $store->number            = $request->number;
      $store->prefix            = $setting->prefix;
		$store->reference_number  = $request->reference_number;
		$store->title				  = $request->title;
		$store->creditnote_date	  = $request->creditnote_date;
		$store->customer_note	  = $request->customer_note;
		$store->terms				  = $request->terms;
		$store->status			     = 21;
		$store->business_code     = Auth::user()->business_code;
		$store->save();


		//products
		$products				    = $request->product_code;
		foreach ($products as $k => $v){
			$product 					  = new creditnote_products;
			$product->creditnote_code = $code;
			$product->product_code	  = $request->product_code[$k];
			$product->product_name	  = product_information::where('product_code',$request->product_code[$k])
                                          ->where('business_code',Auth::user()->business_code)
                                          ->first()
                                          ->product_name;
         $product->quantity		  = $request->qty[$k];
			$product->price    		  = $request->price[$k];
			$product->save();
		}

      //credit note items
      $items = creditnote_products::where('creditnote_code',$code)->get();
      $store->sub_total	= $items->sum('price');
      $store->total		= $items->sum('price');
		$store->balance	= $items->sum('price');
      $store->save();

		//update creditnote number
		$setting->number = $setting->number + 1;
		$setting->save();

      //recorded activity
      $activity     = 'Credit Note #'.$store->prefix.$store->number.' had been created by '.Auth::user()->name;
      $module       = 'Credit Note';
      $section      = 'Credit Note';
      $action       = 'Create';
      $activityCode = $code;

      Wingu::activity($activity,$module,$section,$action,$activityCode);

		Session::flash('success','creditnote has been successfully created');

		return redirect()->route('finance.creditnote.index');

   }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($code)
   {
		$creditnote = creditnote::where('creditnote_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $creditProducts = creditnote_products::where('creditnote_code',$code)->get();

		$customers = customers::where('business_code',Auth::user()->business_code)->OrderBy('id','DESC')->pluck('customer_name','customer_code');

      $products = product_information::where('fn_product_information.business_code',Auth::user()->business_code)
												->OrderBy('fn_product_information.id','DESC')
												->select('*','fn_product_information.id as product_code')
												->get();

		return view('app.finance.creditnote.edit', compact('customers','creditnote','creditProducts','products'));
   }

   /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $code)
   {
      $this->validate($request, array(
			'customer'	      => 'required',
			'number'	         => 'required',
			'creditnote_date'	=> 'required',
		));

		//check credit products
		$check_product_items = count(collect($request->product_code));
		if($check_product_items < 1){
			Session::flash('error','Please select the credited items for this credit note');

			return redirect()->back();
		}

		$update = creditnote::where('business_code',Auth::user()->business_code)->where('creditnote_code',$code)->first();

      $total = $update->total($request->qty,$request->price);

		//check if credit is linked to any invoice
		$creditLinks = invoice_payments::where('business_code',Auth::user()->business_code)->where('creditnote_code',$code)->count();

		$sum = invoice_payments::where('business_code',Auth::user()->business_code)->where('creditnote_code',$code)->sum('amount');

		if($creditLinks != 0) {
			//check if total is grater that the previous creditations
			if($sum > $total){
				Session::flash('error','Please make sure that the credit notes amount is not lesser than '.$sum.'.00 because many credits have been applied to invoices.');

				return redirect()->back();
			}
		}

		//update balance
		if($update->total != $total){
			$update->balance = $total - $sum;
		}

		$update->customer_code	 	= $request->customer;
		$update->reference_number  = $request->reference_number;
		$update->discount      	   = $request->discount;
		$update->discount_type 	   = $request->discount_type;
		$update->title				   = $request->title;
		$update->total		         = $total;
		$update->sub_total		   = $update->amount($request->qty,$request->price);
		$update->tax				   = $request->tax;
		$update->creditnote_date   = $request->creditnote_date;
		$update->customer_note	   = $request->customer_note;
		$update->terms				   = $request->terms;
		if($creditLinks != 0) {
			if($total > $update->total) {
				$update->status = 21;
			}
		}
		if($update->total > $update->balance){
			$update->status = 21;
		}
		$update->updated_by		= Auth::user()->user_code;
		$update->business_code 	= Auth::user()->business_code;
		$update->save();


		//delete product
		$delete = creditnote_products::where('creditnote_code',$code)->delete();

		//new products
		$products				= $request->product_code;
		foreach ($products as $k => $v)
		{
			$product 					   = new creditnote_products;
			$product->creditnote_code	= $code;
         $product->product_name	   = product_information::where('product_code',$request->product_code[$k])
                                             ->where('business_code',Auth::user()->business_code)
                                             ->first()
                                             ->product_name;
			$product->product_code	   = $request->product_code[$k];
			$product->quantity		   = $request->qty[$k];
			$product->price    		   = $request->price[$k];
			$product->save();
		}

		Session::flash('success','creditnote has been successfully updated');

    	return redirect()->back();
	}

	/**
   * show creditnote
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
	public function show($code){
		$show = creditnote::credit_note_details($code);

		$products = creditnote_products::where('creditnote_code',$code)->get();

		// if($show->payment_code != ""){
		// 	$products = creditnote_products::where('creditnote_code',$show->creditnoteID)->get();
		// }

		//check if user has pending invoice
		$invoices = invoices::where('status','!=',1)
                                 ->where('customer',$show->customer_code)
                                 ->whereNull('credited')
                                 ->where('business_code',Auth::user()->business_code)
                                 ->get();

		$files = docs::where('file_code',$code)->where('business_code',Auth::user()->business_code)->get();

		//all credit notes
		$creditNotes	= creditnote::join('wp_business','wp_business.business_code','=','fn_creditnote.business_code')
								->join('wp_creditnote_settings','wp_creditnote_settings.business_code','=','wp_business.business_code')
								->join('fn_customers','fn_customers.customer_code','=','fn_creditnote.customer_code')
								->join('wp_status','wp_status.id','=','fn_creditnote.status')
								->where('fn_creditnote.business_code',Auth::user()->business_code)
								->select('*','fn_creditnote.id as creditnoteID','wp_status.name as statusName','wp_business.currency as currency')
								->orderby('fn_creditnote.id','desc')
								->get();

		$template = Wingu::template($show->template_code)->template_name;

		return view('app.finance.creditnote.show', compact('show','products','files','invoices','creditNotes','template','code'));
	}


	/**
   * generate creditnote pdf
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
	public function generate($code,$format){

		$details = creditnote::credit_note_details($code);

      $products = creditnote_products::where('creditnote_code',$code)->get();

		$pdf = PDF::loadView('templates/'.Wingu::template($details->template_code)->template_name.'/creditnote/creditnote', compact('products','details'));

      if($format == 'pdf'){
		   return $pdf->download($details->prefix.$details->number.'.pdf');
      }

      if($format == 'print'){
		   return $pdf->stream($details->prefix.$details->number.'.pdf');
      }
	}


	/**
	* attachment creditnote
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function attachment_files(Request $request){

		$creditnote = creditnote::where('creditnote_code',$request->creditnoteID)->where('business_code',Auth::user()->business_code)->first();

		//directory
		$directory = base_path().'/public/businesses/'.Auth::user()->business_code.'/finance/creditnote/';

		//create directory if it doesn't exists
		if (!file_exists($directory)) {
			mkdir($directory, 0777,true);
		}

		//get file name
		$file = $request->file('file');
		$size =  $file->getSize();

      //change file name
      $filename = Helper::generateRandomString(30).$file->getClientOriginalName();

      //move file
		$file->move($directory, $filename);

      //save the upload details into the database
		$upload = new docs;
      $upload->file_code      = $request->creditnoteID;
		$upload->folder 	   = 'Finance';
		$upload->section 	   = 'creditnote';
		$upload->name 		   = Finance::creditnote()->prefix.$creditnote->number;
		$upload->file_name   = $filename;
      $upload->file_size   = $size;
		$upload->attach 	   = 'No';
      $upload->file_mime   = $file->getClientMimeType();
		$upload->created_by    = Auth::user()->user_code;
		$upload->business_code  = Auth::user()->business_code;
      $upload->save();
	}


	/**
	* 	delete file
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function delete_file($id){

		$file = docs::where('id',$id)->where('business_code',Auth::user()->business_code)->first();

		//directory
		$directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/creditnote/';

		$delete = $directory.$file->file_name;
		if (File::exists($delete)) {
			unlink($delete);
		}

		$file->delete();

		Session::flash('success','File Deleted');

		return redirect()->back();
	}


	/**
	* 	show mailing section
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function mail($code){
		$details = creditnote::credit_note_details($code);

		$files = docs::where('file_code',$code)->where('business_code',Auth::user()->business_code)->get();

		$contacts = contact_persons::where('customer_code',$details->customer_code)->get();

		$products = creditnote_products::where('creditnote_code',$code)->get();

		//directory
		$directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/creditnote/';

		//create directory if it doesn't exists
		if (!file_exists($directory)) {
			mkdir($directory, 0777,true);
		}

		$pdf = PDF::loadView('templates/'.Wingu::template($details->template_code)->template_name.'/creditnote/creditnote', compact('products','details'));

		$pdf->save($directory.$details->prefix.$details->number.'.pdf');

		return view('app.finance.creditnote.mail', compact('details','files','contacts','code'));
	}

	/**
	* 	send creditnote via email
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function send(Request $request){
		$this->validate($request,[
			'email_from' => 'required|email',
			'send_to' 	 => 'required',
			'subject'    => 'required',
			'message'	 => 'required',
		]);

		//creditnote information
		$creditnote = creditnote::where('creditnote_code',$request->creditnoteID)->where('business_code',Auth::user()->business_code)->first();

		//client info
		$client = customers::join('fn_customer_address','fn_customer_address.customer_code','=','fn_customers.customer_code')
                        ->where('fn_customers.customer_code',$creditnote->customer_code)
                        ->select('*','fn_customers.customer_code as clientID')
                        ->first();

		$checkatt = count(collect($request->attach_files));
		if($checkatt > 0){
			//change file status to null
			$filechange = docs::where('file_code',$creditnote->creditnote_code)
                           ->where('business_code',Auth::user()->business_code)
                           ->get();
			foreach ($filechange as $fc) {
				$null = docs::where('id',$fc->id)->where('business_code',Auth::user()->business_code)->first();
				$null->attach = "No";
				$null->save();
			}

			for($i=0; $i < count($request->attach_files); $i++ ) {

				$sendfile = docs::where('id',$request->attach_files[$i])->where('business_code',Auth::user()->business_code)->first();
				$sendfile->attach = "Yes";
				$sendfile->save();
			}
		}else{
			$chage = docs::where('file_code',$request->creditnoteID)->where('business_code',Auth::user()->business_code)->get();
			foreach ($chage as $cs) {
				$null = docs::where('id',$cs->id)->where('business_code',Auth::user()->business_code)->first();;
				$null->attach = "No";
				$null->save();
			}
		}

		//check for email CC
		$checkcc = count(collect($request->email_cc));

		//save email
		$emails = new Email;
      $mailCode = Helper::generateRandomString(30);
      $emails->mail_code     = $mailCode;
		$emails->message       = $request->message;
		$emails->client_code   = $client->clientID;
		$emails->subject       = $request->subject;
		$emails->mail_from     = $request->email_from;
		if($checkatt > 0){
			$emails->attachment = json_encode($request->get('files'));
		}
		$emails->category      = 'Credit note Document';
		$emails->status        = 6;
		$emails->ip 		     = Helper::get_client_ip();
		$emails->type          = 'Outgoing';
		$emails->section       = 'Credit note';
		$emails->mail_to       = $request->send_to;
		if($checkcc > 0){
			$emails->cc   	= json_encode($request->get('email_cc'));
		}
		$emails->save();

		//send email
		$subject = $request->subject;
		$content = $request->message.' <img src="'.url('/').'/track/email/'.$mailCode.'" width="1" height="1">';
		$from    = $request->email_from;
		$to      = $request->send_to;
		$mailID  = $mailCode;
		$doctype = 'Credit note';
		$docID   = $creditnote->creditnote_code;

		if($request->attaches == 'Yes'){
			$attachment = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/creditnote/'.Finance::creditnote()->prefix.$creditnote->number.'.pdf';
		}else{
			$attachment = 'No';
		}

		Mail::to($to)->send(new sendCreditnote($content,$subject,$from,$mailID,$docID,$doctype,$attachment));

		//record activity
      $activity     = 'Credit note #'.Finance::creditnote()->prefix.$creditnote->number.' has been sent to the customer by '.Auth::user()->name;
		$module       = 'Credit note';
		$section      = 'Credit note';
      $action       = 'sent';
		$activityCode = $mailCode;

		Wingu::activity($activity,$module,$section,$action,$activityCode);


		Session::flash('success','Credit note Sent to client successfully');

		return redirect()->back();
	}

	/**
	* 	change creditnote status
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function change_status($creditnoteID,$status){
		$creditnote = creditnote::where('id',$creditnoteID)->where('business_code',Auth::user()->business_code)->first();
		$creditnote->status = $status;
		$creditnote->save();

		//recorord activity
		$activities = 'creditnote #'.Finance::creditnote()->prefix.$creditnote->creditnote_number.' status has been updated by '.Auth::user()->name;
		$section = 'creditnote';
		$type = 'update';
		$adminID = Auth::user()->user_code;
		$activityID = $creditnoteID;
		$business_code = Auth::user()->business_code;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$business_code);

		Session::flash('success','creditnote status successfully changed');
		return redirect()->back();
	}


	/**
	* 	apply credit to invoice
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function apply_credit(Request $request){

		$credits = count(collect($request->invoiceID));
		$date = date("Y-m-d");

 		//contact persons
		if($credits > 0){
			if(isset($_POST['invoiceID'])){
				for($i=0; $i < count($request->invoiceID); $i++ ) {
					//credit note
					$creditnote = creditnote::where('business_code',Auth::user()->business_code)->where('creditnote_code',$request->creditnoteID[$i])->first();

					if($creditnote->balance != 0){
						//update invoice
						$invoice = invoices::where('business_code',Auth::user()->business_code)->where('invoice_code',$request->invoiceID[$i])->first();

						//check if credited amount is greater than available amount
						if($request->credit[$i] >= $creditnote->balance){
							$newPayment = $invoice->paid + $creditnote->balance;
							$invoice->balance = $invoice->total - $newPayment;
							$invoice->paid = $newPayment;

                     if($invoice->balance == 0){
                        $invoice->status = 1;
                     }elseif($invoice->balance < $invoice->total){
                        $invoice->status = 3;
                     }elseif($invoice->balance == $invoice->total){
                        $invoice->status = 2;
                     }

							$invoice->credited = 'Yes';
							$invoice->save();
						}elseif($request->credit[$i] < $creditnote->balance){

							$newPayment = $invoice->paid + $request->credit[$i];
							$invoice->balance = $invoice->total - $newPayment;
							$invoice->paid = $newPayment;
							//update status
                     if($invoice->balance == 0){
                        $invoice->status = 1;
                     }elseif($invoice->balance < $invoice->total){
                        $invoice->status = 3;
                     }elseif($invoice->balance == $invoice->total){
                        $invoice->status = 2;
                     }

							$invoice->credited = 'Yes';
							$invoice->save();
						}

						//record payment
						$pay = new invoice_payments;
                  if($request->credit[$i] >= $creditnote->balance){
                     $pay->amount           = $creditnote->balance;
                  }else{
                     $pay->amount           = $request->credit[$i];
                  }

                  $pay->payment_code     = Helper::generateRandomString(30);

						$pay->balance          = $invoice->total - $invoice->paid;

                  $pay->reference_number = 'Credit note';
						$pay->payment_category = 'Credited';
                  $pay->credited         = 'Yes';
                  $pay->payment_date     = $date;
						$pay->creditnote_code  = $request->creditnoteID[$i];
						$pay->invoice_code     = $request->invoiceID[$i];
						$pay->created_by       = Auth::user()->user_code;
						$pay->business_code    = Auth::user()->business_code;
						$pay->customer_code    = $creditnote->customer_code;
						$pay->save();

                  if($request->credit[$i] >= $creditnote->balance){
                     $creditnote->balance = 0;
                     $creditnote->status = 22;
                  }else{
                     $creditnote->balance = $creditnote->balance - $request->credit[$i];
                  }
						$creditnote->save();
					}
				}
			}else{
				return redirect()->back();
			}
		}

		Session::flash('success','Credit note applied');

		return redirect()->back();
	}


	/**
	* 	delete creditnote permanently
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function delete_creditnote($code){
		$creditnote = creditnote::where('creditnote_code',$code)->where('business_code',Auth::user()->business_code)->first();

		$invoiceCredit = invoice_payments::where('creditnote_code',$code)->where('payment_category','Credited')
                                 ->where('business_code',Auth::user()->business_code)
											->count();

      if($creditnote->status != 22 && $invoiceCredit == 0){
			//delete all files linked to the creditnote
			$directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/creditnote/';

			$check_files = docs::where('file_code',$code)->where('business_code',Auth::user()->business_code)->count();

			if($check_files > 0){
				$files = docs::where('file_code',$code)->where('business_code',Auth::user()->business_code)->get();
				foreach($files as $file){
					$doc = docs::where('id',$file->id)->where('business_code',Auth::user()->business_code)->first();

					//create directory if it doesn't exists
					$delete = $directory.$doc->file_name;
					if (File::exists($delete)) {
						unlink($delete);
					}

					$doc->delete();
				}
			}

			//delete creditnote products
			creditnote_products::where('creditnote_code',$code)->delete();

			//delete creditnote plus attachment
			$creditnote = creditnote::where('creditnote_code',$code)->where('business_code',Auth::user()->business_code)->first();
			if($creditnote->attachment != ""){
				$delete = $directory.$creditnote->attachment;
				if (File::exists($delete)) {
					unlink($delete);
				}
			}
			$creditnote->delete();

         //recorded activity
         $activity     = 'Credit Note #'.$creditnote->prefix.$creditnote->number.' had been deleted by '.Auth::user()->name;
         $module       = 'Credit Note';
         $section      = 'Credit Note';
         $action       = 'Delete';
         $activityCode = $code;

         Wingu::activity($activity,$module,$section,$action,$activityCode);

			Session::flash('success','creditnote has been successfully deleted');

			return redirect()->route('finance.creditnote.index');
		}else{
         Session::flash('error','You have recorded transactions for this credit note. Hence, this credit note cannot be deleted.');

			return redirect()->back();
      }
	}
}
