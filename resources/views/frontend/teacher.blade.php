@extends('frontend.layout')
@section('content')
<style>
    .product-img img {
        margin: 0 auto;
        object-fit: cover;
        width: 61%;
    }
</style>
<div class="container spaceb50 spacet50">

   <div class="row">
      <div class="col-md-12">
      <h1 style="text-align: center">{{$pagedata->title}}</h1>
        <form id="form1" class="spaceb10 pt20 onlineform" action="{{url('page/'.$slug)}}" method="get" accept-charset="utf-8" enctype="multipart/form-data">
            <div class="row">
                @if($category_id!=8)
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Subject:</label><small class="req"> *</small> 
                        <select id="subject_id" name="subject_id" class="form-control">
                        <option value="">Select</option>
                        @foreach($subjects as $subject)
                                        <option value="{{$subject->id}}" {{($subject_id==$subject->id)?'selected="selected"':''}}>{{$subject->subject_name}}</option>
                        @endforeach
                        </select>
                        <span class="text-danger"></span>
                    </div>
                </div>
                @endif
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Designation:</label><small class="req"> *</small> 
                        <select id="designation_id" name="designation_id" class="form-control">
                        <option value="">Select</option>
                        @foreach($designations as $designation)
                                        <option value="{{$designation->id}}" {{($designation_id==$designation->id)?'selected="selected"':''}}>{{$designation->designation_name}}</option>
                        @endforeach
                        </select>
                        <span class="text-danger"></span>
                    </div>
                </div>
                @if($category_id!=8)
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Version:</label><small class="req"> *</small> 
                        <select id="version_id" name="version_id" class="form-control">
                        <option value="">Select</option>
                        @foreach($versions as $version)
                                        <option value="{{$version->id}}" {{($version_id==$version->id)?'selected="selected"':''}}>{{$version->version_name}}</option>
                        @endforeach
                        </select>
                        <span class="text-danger"></span>
                    </div>
                </div> 
                @endif
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Type:</label><small class="req"> *</small> 
                        <select id="job_type"  name="job_type"class="form-control" data-select2-id="job_type" tabindex="-1" aria-hidden="true">
                                                <option value="" data-select2-id="6">Select Type</option>
                                                <option value="1">Permanent</option>
                                                <option value="2">Temporary</option>
                                                
                        </select>
                    </div>
                </div>
                
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Search:</label><small class="req"> *</small> 
                        <input type="text" class="form-control" value="" id="admission_no" name="admission_no">
                        <span class="text-danger"></span>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <button type="submit" class="onlineformbtn mdbtn mb12 mt-24" name="search" id="search_btn">Search</button>   
                    </div>
                </div>
            </div>
            <!--./row--> 
        </form>
         <!--./course-header-->
      </div>
      <!--./col-md-12-->
      <div class="refine-categ-header">
         
            
         <!--./col-lg-3-->
         <div id="resultdiv">
            <div class="col-lg-12 col-md-12 col-sm-6">
               <div class="row row-flex" id="products">
                  @foreach($employees as $employee)
                  <div class="item col-lg-3 col-md-3 col-sm-12 grid-group-item">
                     <div class="product-item">
                        <div class="girdthumbnail">
                           <div class="product-img">
                              <a href="#">
                                @php 
                                $file=str_replace("edu.swimtech.org","bafsd.edu.bd",$employee->photo);

                                @endphp
                                    <img class="group list-group-image img-responsive" src="{{$file}}">
                                </a>
                           </div>
                           <div class="proinner caption column-height-equal">
                              <a href="#">
                                 <h5>{{$employee->employee_name}}</h5>
                              </a>
                              <div class="course-caption">TID: {{$employee->emp_id}}</div>
                              <p class="authers"><span class="fontbold">Subject:</span> {{$employee->subject->subject_name??''}} </p>
                              <p class="authers"><span class="fontbold">Designation:</span> {{$employee->designation->designation_name??''}} </p>
                              <p class="authers"><span class="fontbold">Version:</span> {{$employee->versionemployee->version_name??''}} </p>
                              <p class="authers"><span class="fontbold">Email:</span> {{$employee->email}}</p>
                              
                           </div>
                           <!--./proinner-->
                           
                        </div>
                        <!--./girdthumbnail-->
                     </div>
                     <!--./product-item-->
                  </div>
                  @endforeach
                  <!--./col-md-4-->
                  
                  <!--./col-md-4-->
               </div>
               <!--./row-->
            </div>
         </div>
         <!--./col-md-9-->
         <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_3_paginate" style="padding: 10px">
            {{$employees->links('pagination')}}
          </div>
      </div>
      <!--./refine-categ-header--> 
   </div>
   <!--./row-->
</div>




@endsection