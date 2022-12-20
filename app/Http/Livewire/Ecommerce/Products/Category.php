<?php

namespace App\Http\Livewire\Ecommerce\Products;

use App\Helpers\Helper;
use App\Models\finance\products\category as ProductsCategory;
use Livewire\WithPagination;
use Livewire\Component;
use Auth;

class Category extends Component
{
   use WithPagination;
   public $perPage = 25;
   public $search = '';
   public $name,$parent,$categoryCode,$editMode;

   public function updateSearch()
   {
      $this->reset($this->search);
      $this->goToPage(1);
   }

   public function render()
   {
      $query = ProductsCategory::where('business_code',Auth::user()->business_code)
                        ->where('wingu_store','Yes');
                        if($this->search){
                           $query->where('name','like','%'.$this->search.'%');
                        }
      $categories = $query ->orderBy('id','desc')
                        ->simplePaginate($this->perPage);

      $allCategories =  ProductsCategory::where('business_code',Auth::user()->business_code)->where('wingu_store','Yes')->get();

      return view('livewire.ecommerce.products.category', compact('categories','allCategories'));
   }

   public function restFields(){
      $this->parent       = "";
      $this->name         = "";
      $this->categoryCode = "";
      $this->editMode     = "";
   }

   /**
   * Store a newly created resource in storage.
   */
   public function store()
   {
      $this->validate([
         'name'=>'required',
      ]);

      $check = ProductsCategory::where('business_code',Auth::user()->business_code)->where('name',$this->name)->count();

      if($check == 0){
         $url = Helper::seoUrl($this->name);
      }else{
         $url = Helper::seoUrl($this->name).Helper::generateRandomString(3);
      }

      $category = new ProductsCategory;
      $category->category_code = Helper::generateRandomString(30);
      $category->name = $this->name;
      $category->parent = $this->parent;
      $category->wingu_store = 'Yes';
      $category->url = $url;
      $category->business_code = Auth::user()->business_code;
      $category->created_by = Auth::user()->user_code;
      $category->save();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"You have successfully created a new Category."
      ]);

      $this->restFields();
   }

   /**
   * Update mode
   */
   public function edit($code){
      $edit = ProductsCategory::where('business_code',Auth::user()->business_code)->where('category_code',$code)->first();
      $this->categoryCode = $code;
      $this->name = $edit->name;
      $this->parent = $edit->parent;
      $this->editMode = 'true';
   }

   /**
   * Update the specified resource in storage.
   */
   public function update()
   {
      $this->validate([
         'name'=>'required',
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
      $category->wingu_store = 'Yes';
      $category->updated_by = Auth::user()->user_code;
      $category->save();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Category successfully updated!"
      ]);

      $this->restFields();
   }



   //delete pop modal
   public function confirmDelete($code){
      $this->categoryCode = $code;
   }

   //delete class
   public function delete(){
      $category = ProductsCategory::where('category_code',$this->categoryCode)->where('business_code',Auth::user()->business_code)->first();
      $category->delete();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"The category was successfully deleted !"
      ]);

      $this->emit('popModal');
   }

   //cancel delete
   public function cancel_delete(){
      $this->restFields();
   }
}
