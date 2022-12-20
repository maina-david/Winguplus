@extends('layouts.app')
{{-- page header --}}
@section('title','Deals | Customer Relationship Management')

{{-- dashboard menu --}}
@section('sidebar')
	@include('app.crm.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="float-right">
         <a href="{!! route('crm.deals.create') !!}" class="btn btn-pink"><i class="fas fa-plus-circle"></i> New Deal</a>
         <a href="" class="btn btn-success"><i class="far fa-list"></i> List View</a>
         <a href="{!! route('crm.deals.grid') !!}" class="btn btn-warning"><i class="fas fa-columns"></i> Grid view</a>
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">
         <i class="fas fa-bullseye"></i> Deals

      </h1>
      @include('partials._messages')
      <div class="panel panel-default">
         <div class="panel-heading">
            <h4 class="panel-title">Deals List</h4>
         </div>
         <div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered">
               <thead>
                  <tr role="row">
                     <th width="1%">#</th>
                     <th>Title</th>
                     <th>Value</th>
                     <th>Pipeline</th>
                     <th>Stage</th>
                     <th>Owner</th>
                     <th>Customer</th>
                     <th>Closing</th>
                     <th>Status</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($deals as $count=>$deal)
                     <tr>
                        <td>{!! $count+1 !!}</td>
                        <td>{!! $deal->title !!}</td>
                        <td>{!! $deal->currency !!} {!! number_format($deal->value) !!}</td>
                        <td>
                           <span class="badge badge-warning">
                              @if(Crm::check_pipeline($deal->pipeline))
                                 {!! Crm::pipeline($deal->pipeline)->title !!}
                              @endif
                           </span>
                        </td>
                        <td>
                           <span class="badge badge-primary">
                              @if(Crm::check_pipeline_stage($deal->stage))
                                 {!! Crm::pipeline_stage($deal->stage)->title !!}
                              @endif
                           </span>
                        </td>
                        <td>
                           @if(Wingu::check_user($deal->owner) == 1)
                              {!! Wingu::user($deal->owner)->name !!}
                           @endif
                        </td>
                        <td>
                           @if(Finance::check_client($deal->contact) == 1)
                              {!! Finance::client($deal->contact)->customer_name !!}
                           @endif
                        </td>
                        <td>
                           @if($deal->close_date)
                              {!! date('F jS Y', strtotime($deal->close_date)) !!}
                           @endif
                        </td>
                        <td>
                           @if($deal->status)
                              {!! Wingu::status($deal->status)->name !!}
                           @endif
                        </td>
                        <td>
                           <div class="btn-group">
                              <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action</button>
                              <ul class="dropdown-menu">
                                 <li><a href="{!! route('crm.deals.show',$deal->deal_code) !!}"><i class="fal fa-eye" aria-hidden="true"></i> View</a></li>
                                 <li><a href="{!! route('crm.deals.edit',$deal->deal_code) !!}"><i class="fal fa-edit"></i> Edit</a></li>
                                 <li><a href="{!! route('crm.deals.delete',$deal->deal_code) !!}" class="delete"><i class="fal fa-trash-alt"></i> Delete</a></li>
                              </ul>
                           </div>
                        </td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
@endsection
{{-- page scripts --}}
@section('script')

@endsection
