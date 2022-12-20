@extends('layouts.app')
{{-- page header --}}
@section('title','Property | Units ')
{{-- page styles --}}
@section('breadcrum')

@section('sidebar')
	@include('app.propertywingu.partials._menu')
@endsection
{{-- content section --}}
@section('content')
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      <li class="breadcrumb-item"><a href="{!! route('propertywingu.property.index') !!}">Property</a></li>
      <li class="breadcrumb-item"><a href="{!! route('propertywingu.property.show',$code) !!}">{!! $property->title !!}</a></li>
      <li class="breadcrumb-item active"><a href="javascript:void(0)">Units</a></li>
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-home"></i> {!! $property->title !!} | Units </h1>
   <div class="row">
      @include('app.propertywingu.partials._property_menu')
      <div class="col-md-12">
         @include('partials._messages')
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">All Units</h4>
            </div>
            <div class="panel-body">
               <table id="data-table-default" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th width="1%">#</th>
                        <th>UnitID</th>
                        <th>Unit Type</th>
                        <th>Market Rent (p/Mo)</th>
                        <th>Status</th>
                        <th>Ownership Type</th>
                        <th width="9%">Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($units as $count=>$unit)
                        <tr>
                           <td>{!! $count+1 !!}</td>
                           <td><b>{!! $unit->serial !!}</b></td>
                           <td>
                              @if($unit->property_type != "")
                                 {!! Propertywingu::property_type($unit->property_type)->name !!}
                              @endif
                           </td>
                           <td>{!! number_format($unit->price) !!} ksh</td>
                           <td>
                              @if($unit->tenantID != "")
                                 <span class="badge badge-success">Occupied</span>
                              @else
                                 <span class="badge badge-warning">Vacant</span>
                              @endif
                           </td>
                           <td>{!! $unit->ownwership_type !!}</td>
                           <td>
                              <a href="{!! route('propertywingu.property.units.edit', [$code,$unit->property_code]) !!}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                              <a href="{!! route('propertywingu.property.units.delete', [$code,$unit->property_code]) !!}" class="btn btn-danger btn-sm delete"><i class="far fa-trash"></i></a>
                           </td>
                        </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
