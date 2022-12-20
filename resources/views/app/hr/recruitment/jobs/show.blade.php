@extends('layouts.app')
{{-- page header --}}
@section('title') {!! $job->title !!} | Recruitment | Human Resource @endsection

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.hr.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
      @include('partials._messages')
      <div class="row">
         <div class="col-md-12">
            <div class="row">
               <div class="col-md-8">
                  <h3><i class="fal fa-briefcase"></i> {!! $job->title !!}</h3>
                  <p><i class="fal fa-map-marker-alt"></i> Nairobi, Nairobi County, Kenya<br><i class="fal fa-usd-circle"></i> {!! number_format($job->min_salary) !!} - {!! number_format($job->max_salary) !!}</p>

               </div>
               <div class="col-md-4">
                  <a href="{!! route('hrm.recruitment.jobs.edit',$job->code) !!}" class="btn btn-primary float-right"><i class="fas fa-edit"></i> Edit</a>
               </div>
               <div class="col-md-12">
                  <div class="row">
                     <ul class="nav nav-tabs">
                        <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#"><i class="fal fa-users"></i> Candidate</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fal fa-info-circle"></i> Summary</a>
                        </li>
                        {{-- <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fal fa-users-class"></i> Team</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fal fa-paperclip"></i> Attachments</a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link" href="#"><i class="fal fa-sticky-note"></i> Notes</a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link" href="#"><i class="fal fa-chart-pie-alt"></i> Report</a>
                        </li> --}}
                     </ul>
                     <div class="col-md-12 bg-white">
                        <!-- begin widget-table -->
                        <table class="table table-bordered table-striped mt-3">
                           <thead>
                              <tr>
                                 <th width="1%">#</th>
                                 <th width="10%">Image</th>
                                 <th>Name</th>
                                 <th>Location</th>
                                 <th>Expectation</th>
                                 <th>Experience</th>
                                 <th>Qualification</th>
                                 <th>Phone number</th>
                                 <th>Email</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($applications as $count=>$application)
                                 <tr>
                                    <td>{!! $count+1 !!}</td>
                                    <td>
                                       <img src="../assets/img/product/product-6.png" width="100" />
                                    </td>
                                    <td>
                                       <h5>{!! $application->name !!}</h5>
                                    </td>
                                    <td>{!! $application->location !!}</td>
                                    <td>{!! $application->salary_currency !!}{!! number_format($application->salary_expectation) !!}</td>
                                    <td>{!! $application->experience  !!} years</td>
                                    <td>{!! $application->qualification !!}</td>
                                    <td>{!! $application->phone_number !!}</td>
                                    <td>{!! $application->email !!}</td>
                                    <td><a href="" class="btn btn-sm btn-success"> <i class="fas fa-eye"></i> view </a></td>
                                 </tr>
                              @endforeach
                           </tbody>
                        </table>
                        <!-- end widget-table -->
                        <br>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
