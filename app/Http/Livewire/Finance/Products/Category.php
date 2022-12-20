<?php

namespace App\Http\Livewire\Finance\Products;

use App\Models\finance\products\category as ProductsCategory;
use Livewire\WithPagination;
use Livewire\Component;
use Auth;
use Helper;
use Wingu;

class Category extends Component
{
   use WithPagination;
   protected $paginationTheme = 'bootstrap';

   public $perPage = 10;
   public $name,$parent,$categoryCode;
   public $search;
   public $editMode;

   public function updateSearch()
   {
      $this->reset($this->search);
      $this->goToPage(1);
   }


   public function render()
   {
      $query = ProductsCategory::where('business_code',Auth::user()->business_code);
                        if($this->search){
                           $query->Where('name','like','%'.$this->search.'%');
                        }
      $category = $query->orderBy('id','desc')->simplePaginate($this->perPage);

      return view('livewire.finance.products.category', compact('category'));
   }

   //reset field
   public function restFields(){
      $this->name = "";
      $this->parent = "";
      $this->categoryCode = "";
      $this->editMode = "";
   }

   /**
   * Store category
   */
   public function store(){
      $this->validate([
         'name' => 'required',
      ]);

      $check = ProductsCategory::where('business_code',Auth::user()->business_code)->where('name',$this->name)->count();
      if($check == 0){
         $url = Helper::seoUrl($this->name);
      }else{
         $url = Helper::seoUrl($this->name).Helper::generateRandomString(3);
      }

      $category = new ProductsCategory;
      $category->category_code = Helper::generateRandomString(30);
      $category->name          = $this->name;
      $category->parent        = $this->parent;
      $category->url           = $url;
      $category->business_code = Auth::user()->business_code;
      $category->created_by    = Auth::user()->user_code;
      $category->save();

      //records activity
      $activity     =  Auth::user()->name.' Has Created <b>'.$this->name.'</b> product category';
		$module       = 'Finance';
		$section      = 'Product Category';
      $action       = 'Create';
		$activityCode = $category->category_code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"You have successfully created a new Category."
      ]);

      $this->restFields();
   }

   //edit
   public function edit($code){
      $this->editMode = 'on';
      $category = ProductsCategory::where('category_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $this->name         = $category->name;
      $this->parent       = $category->parent;
      $this->categoryCode = $code;
   }

   //update
   public function update(){
      $this->validate([
         'name' => 'required',
      ]);

      $category = ProductsCategory::where('category_code',$this->categoryCode)->where('business_code',Auth::user()->business_code)->first();
      if($category->name != $this->name){
         $check = ProductsCategory::where('business_code',Auth::user()->business_code)->where('name',$this->name)->count();
         if($check == 0){
            $url = Helper::seoUrl($this->name);
         }else{
            $url = Helper::seoUrl($this->name).Helper::generateRandomString(3);
         }

         $category->url = $url;
      }
      $category->name       = $this->name;
      $category->parent     = $this->parent;
      $category->updated_by = Auth::user()->user_code;
      $category->save();

      //records activity
      $activity     =  Auth::user()->name.' Has updated <b>'.$this->name.'</b> product category';
      $module       = 'Finance';
      $section      = 'Product Category';
      $action       = 'Edit';
      $activityCode = $this->categoryCode;

      Wingu::activity($activity,$module,$section,$action,$activityCode);

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Category successfully updated!"
      ]);

      $this->restFields();
   }

   //remove
   public function remove($code){
      $this->categoryCode = $code;
   }

   //close
   public function close(){
      $this->emit('popModal');

      $this->restFields();
   }

   //delete
   public function delete()
   {
      $delete = ProductsCategory::where('category_code',$this->categoryCode)->where('business_code',Auth::user()->business_code)->first();

      //records activity
      $activity     =  Auth::user()->name.' Has deleted <b>'.$delete->name.'</b> product category';
      $module       = 'Finance';
      $section      = 'Product Category';
      $action       = 'Delete';
      $activityCode = $this->categoryCode;

      Wingu::activity($activity,$module,$section,$action,$activityCode);

      $delete->delete();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"The category was successfully deleted !"
      ]);

      $this->emit('popModal');

      $this->restFields();
   }

}
