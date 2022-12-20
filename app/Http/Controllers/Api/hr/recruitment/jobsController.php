<?php

namespace App\Http\Controllers\Api\hr\recruitment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\hr\recruitment_jobs;
use App\Models\wingu\business;

/**
 * @group Human Resource Recruitment Api's
*/
class jobsController extends Controller
{
   /**
    * All Jobs for specific business
    */
   public function getAllJobs($businessCode) {
      $business = business::where('businessID',$businessCode)->first();

      $jobs = recruitment_jobs::where('businessID',$business->id)->get();

      return \Response::json($jobs, 200);
      //return response()->json();

      //return response($jobs, 200);
   }

   /**
   * Get job details 
   *
   * @return \Illuminate\Http\Response
   */
   public function getJob($businessCode,$code) {
      $business = business::where('businessID',$businessCode)->first();

      $job = recruitment_jobs::where('businessID',$business->id)->where('code',$code)->first();

      return \Response::json($job, 200);
   }

   public function createJob(Request $request) {
      // logic to create a student record goes here
   }



   public function updateJob(Request $request, $id) {
   // logic to update a student record goes here
   }

   public function deleteJob($id) {
   // logic to delete a student record goes here
   }
}
