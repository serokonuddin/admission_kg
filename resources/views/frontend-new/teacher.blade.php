  
@extends('frontend-new.layout')
@section('content')

@php 
            $colors=array('bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink');
            $cs=array('primary','danger','success','info','purple','pink','info');
            $icons=array('fas fa-home','far fa-building','fas fa-graduation-cap','fas fa-balance-scale','fas fa-biking','fas fa-certificate','fas fa-comment-dots','fas fa-camera-retro','fas fa-map','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink');
        @endphp
<style>
    .page-link.active, .active > .page-link {
    z-index: 3;
    color: #ff0b0b;
    background-color: var(--bs-pagination-active-bg);
    border-color: #ff001b;
}
p {
    margin-top: 0;
    margin-bottom: .5rem;
}
.fontbold{
    font-weight: bold;
    color: white;
}
.card-product .img-link img {
    max-height: 195px;
}
.btn:hover {
    background-color: #ff0404 !important;
    color: #fcfcfc !important;
}
</style>
        <div class="main-wrapper blog-grid-left-sidebar">
   <!-- ====================================
      ———	BREADCRUMB
      ===================================== -->
      <section class="breadcrumb-bg" style="background-image: url({{asset('public')}}/assets/img/background/page-title-bg.jpg); ">
      <div class="container">
         <div class="breadcrumb-holder">
            <div>
               <h1 class="breadcrumb-title"> {{$pagedata->title}}</h1>
               <ul class="breadcrumb breadcrumb-transparent">
                  <li class="breadcrumb-item">
                     <a class="text-white" href="{{url('/')}}">Home</a>
                  </li>
                  <li class="breadcrumb-item text-white active" aria-current="page">
                  {{$pagedata->title}}
                  </li>
               </ul>
            </div>
         </div>
      </div>
   </section>
   <!-- ====================================
      ———	BLOG GRID LEFT SIDEBAR
      ===================================== -->
      <section class="bg-light py-5 py-md-5">
            <div class="container">
                <div class="row wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                
                    <div class="col-sm-12 col-xs-12">
                        <form  action="{{url('page/'.$slug)}}" method="get">
                        <div class="row" >
                            @if($category_id!=8)
                            <div class="col-sm-2 col-xs-6">
                                <div class="mb-3">
                                    <label for="exampleFormControlSelect1" class="form-label">Subject:<small class="req"> *</small> </label>
                                    <select class="form-select border-success form-control" id="subject_id" name="subject_id">
                                        <option value="">Select</option>
                                        @foreach($subjects as $subject)
                                                        <option value="{{$subject->id}}" {{($subject_id==$subject->id)?'selected="selected"':''}}>{{$subject->subject_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                            </div>
                            @endif
                            <div class="col-sm-2 col-xs-6">
                                <div class="mb-3">
                                    <label class="form-label">Designation:</label><small class="req"> *</small> 
                                    <select id="designation_id" name="designation_id" class="form-control form-select border-info">
                                    <option value="">Select</option>
                                    @foreach($designations as $designation)
                                                    <option value="{{$designation->id}}" {{($designation_id==$designation->id)?'selected="selected"':''}}>{{$designation->designation_name}}</option>
                                    @endforeach
                                    </select>
                                </div>
                                
                            </div>
                            <div class="col-sm-2 col-xs-6">
                                <div class="mb-3">
                                    <label class="form-label">Version:</label><small class="req"> *</small> 
                                    <select id="version_id" name="version_id" class="form-control form-select border-warning">
                                    <option value="">Select</option>
                                    @foreach($versions as $version)
                                                    <option value="{{$version->id}}" {{($version_id==$version->id)?'selected="selected"':''}}>{{$version->version_name}}</option>
                                    @endforeach
                                    </select>
                                </div>
                                
                            </div>
                            <div class="col-sm-2 col-xs-6">
                                <div class="mb-3">
                                    <label class="form-label">Type:</label><small class="req"> *</small> 
                                    <select id="job_type"  name="job_type"class="form-control form-select border-default" data-select2-id="job_type" tabindex="-1" aria-hidden="true">
                                                            <option value="" data-select2-id="6">Select Type</option>
                                                            <option value="1">Permanent</option>
                                                            <option value="2">Temporary</option>
                                                            
                                    </select>
                                </div>
                                
                            </div>
                            <div class="col-sm-2 col-xs-6">
                                <div class="mb-3">
                                    <label class="form-label">Search:</label><small class="req"> *</small> 
                                    <input type="text" class="form-control border-primary" value="" id="admission_no" name="admission_no">
                                </div>
                                
                            </div>
                            <div class="col-sm-2 col-xs-6">
                                <div class="mb-3">
                                    <br/>
                                    <button type="submit" class="btn btn-danger float-right text-uppercase">
                                   Search
                                    </button>
                                </div>
                                
                            </div>
                        </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-5 py-md-5">
            <div class="container">
                <div class="row">
                @foreach($employees as $key=>$employee)
                @php 
                                $file=str_replace("edu.swimtech.org","bafsd.edu.bd",$employee->photo);

                @endphp
                <div class="col-md-6 col-lg-3 col-xs-12">
                    <div class="card card-product border-{{$cs[$key%6]}} card-hover">
                    <a class="img-link" href="javascript:void(0)">
                        <img src="{{$file}}" alt="Card image">
                        {{-- <button class="btn btn-quickview " >
                        <i class="fa fa-eye me-2" aria-hidden="true"></i>
                        {{$employee->employee_name}}
                        </button> --}}
                    </a>
                    <div class="card-body bg-primary px-1 py-1">
                        <h5 class="mb-1">
                        <a href="#">{{$employee->employee_name}}</a>
                        </h5>
                        <div class="course-caption">TID: {{$employee->emp_id}}</div>
                        <p class="authers"><span class="fontbold">Subject:</span> {{$employee->subject->subject_name??''}} </p>
                        <p class="authers"><span class="fontbold">Designation:</span> {{$employee->designation->designation_name??''}} </p>
                        <p class="authers"><span class="fontbold">Version:</span> {{$employee->versionemployee->version_name??''}} </p>
                        <p class="authers"><span class="fontbold">Email:</span> {{$employee->email}}</p>
                        
                       
                    </div>
                    </div>
                </div>
                @endforeach
                
                </div>
            </div>

            <div class="mt-6">
                <!-- ====================================
            ———	PAGINATION
            ===================================== -->
            <section class="py-5">
            <div class="container">
              {{$employees->links('pagination')}}
            </div>
            </section>

            </div>
            </section>

</div>


@endsection