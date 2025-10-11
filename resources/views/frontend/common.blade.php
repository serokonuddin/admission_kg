@extends('frontend.layout')
@section('content')
<style>
   .form-check{
      border-bottom: 1px solid #eee;
      font-size: 15px;
      padding: 5px;
      
   }
   .form-check a{
      color: black!important;
   }
   .form-check a:hover{
      color: #337AB7!important;
      font-weight: bold;
   }
   .sidecourse-title a{
      font-size: 16px;
      font-weight: bold;
   }
</style>
<div class="container spacet20">
   <div class="row">
      <div class="col-md-12 spacet60 pt-0-mobile">
         
         <!--./coursebtnaddModal-->
         <div class="row">
            <div class="container spaceb50">
               <div class="row">
                  
                  <!--./col-md-12-->
                  <div class="refine-categ-header">
                     @if(count($subpages)>0)
                     <div class="col-lg-3 col-md-3 col-sm-6 filterleft">
                        <div class="sidebarlists">
                           <div class="sidebarhide">
                              <div class="filter-list">
                                 <div class="sidecourse-title"><a data-toggle="collapse" data-target="#category">{{$parent->title}}<i class="fa fa-angle-up"></i></a>
                                 </div>
                                 <!-- ./sidecourse-title -->
                                 <div class="catefilterscroll collapse in" id="category">
                                    <div class="catecheck">
                                      
                                       <ul class="rating">
                                          @foreach($subpages as $sub)
                                          <div class="form-check">
                                             @if($sub->slug!='#')
                                             <a href="{{url('page/'.$sub->slug)}}">
                                             @else 
                                             <a href="#">
                                             @endif
                                            
                                           <span class="label-text"> {{$sub->title}} </span></a>
                                          </div>
                                          @endforeach
                                          
                                       </ul>
                                    </div>
                                    <!-- ./catechek -->
                                 </div>
                                 <!-- ./catefilterscroll-->
                              </div>
                              <!--./filter-list -->
                              
                           </div>
                           <!--./sidebarhide-->
                        </div>
                        <!--./sidebarlists-->   
                     </div>
                     @endif
                     <!--./col-lg-3-->
                     <div id="resultdiv">
                        <div class="@if(count($subpages)>0) col-lg-9 col-md-9 col-sm-6 filterright @else col-lg-12 col-md-12 col-sm-12 @endif ">
                           
                           <div class="row row-flex" id="products">
                              <div class="item col-lg-12 col-md-12 col-sm-12 grid-group-item">
                                 
                              {!! $pagedata->details !!}
                              </div>
                             
                           </div>
                           @php
                                       $files=explode(",",$pagedata->images)
                           @endphp
                           @if(count($files)>0 && !empty($files[0]))
                           <div class="row row-flex" >
                              
                              <div class="mediarow spaceb50">
                                 <div class="row">
                                    <div class="gallery">
                                    
                                    @foreach($files as $file)
                                       <div class="col-sm-6 col-md-4 col-lg-4 img_div_modal">
                                          <div class="galleryfancy">
                                             <div class="gallheight">
                                                <a href="{{$file}}" data-toggle="lightbox" data-gallery="mixedgallery" data-title="a">
                                                   <img alt="" src="{{$file}}">
                                                   <div class="content-overlay"></div>
                                                   <div class="overlay-details fadeIn-bottom">
                                                      <i class="fa fa-search-plus"></i>
                                                   </div>
                                                </a>
                                             </div>
                                          </div>
                                       </div>
                                       @endforeach
                                    
                                    </div>
                                 </div>
                              </div>
                           </div>
                           @endif
                           <!--./row-->
                        </div>
                     </div>
                     <!--./col-md-9-->
                    
                  </div>
                  <!--./refine-categ-header--> 
               </div>
               <!--./row-->
            </div>
            <!--./container-->
         </div>
                    
      </div>
   </div>
   <!--./row-->
</div>


@endsection