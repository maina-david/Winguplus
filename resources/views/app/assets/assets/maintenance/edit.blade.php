<div class="row">
   <div class="col-md-8">
      {!! Form::model($edit, ['route' => ['assets.maintenances.update',[$code,$edit->maintenance_code]], 'method'=>'post','enctype' => 'multipart/form-data']) !!}
         @csrf
         <div class="row">
            @livewire('assets.assets.suppliers')
            <div class="col-md-6">
               <div class="form-group form-group-default">
                  <label for="">Asset Maintenance Type</label>
                  {!! Form::select('maintenance_type',['' => 'Select an asset maintenance type','Maintenance' => 'Maintenance','Repair' => 'Repair','Upgrade' => 'Upgrade','PAT test' => 'PAT test','Calibration' => 'Calibration','Software Support' => 'Software Support','Hardware Support' => 'Hardware Support'],null,['class'=>'form-control select2']) !!}
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group form-group-default required">
                  <label for="">Title</label>
                  {!! Form::text('title',null,['class'=>'form-control','placeholder' => 'Enter title', 'required' => '']) !!}
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group form-group-default required">
                  <label for="">Start Date</label>
                  {!! Form::date('start_date',null,['class'=>'form-control' ,'placeholder' => 'Enter date', 'required' => '']) !!}
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group form-group-default">
                  <label for="">Completion Date</label>
                  {!! Form::date('completion_date',null,['class'=>'form-control','placeholder' => 'Enter date', 'required' => '']) !!}
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group form-group-default">
                  <label for="">Warranty Improvement</label>
                  {!! Form::select('warranty_improvement',['' => 'Choose', 'No' => 'No', 'Yes' => 'Yes'],null,['class'=>'form-control select2']) !!}
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group form-group-default">
                  <label for="">Cost</label>
                  {!! Form::number('cost',null,['class'=>'form-control','placeholder' => 'Enter cost']) !!}
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group form-group-default required">
                  <label for="">Next inspection date</label>
                  <input type="date" name="next_inspection_date" value="{!! $details->next_inspection_date !!}" class="form-control">
               </div>
            </div>
            <div class="col-md-12">
               <div class="form-group">
                  <label for="">Maintenance Notes</label>
                  {!! Form::textarea('note',null,['class'=>'form-control tinymcy']) !!}
               </div>
            </div>
            <div class="col-md-12">
               <div class="form-group">
                  <center>
                     <button class="btn btn-pink submit" type="submit"><i class="fas fa-save"></i> Update information</button>
                     <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
                  </center>
               </div>
            </div>
         </div>
      {!! Form::close() !!}
   </div>
</div>
