@extends('frontend.layout')
@section('content')
<style>
    .staff-content h3 {
    color: #000;
    font-size: 19px;
    font-weight: 700;
    margin-bottom: 5px;
    text-transform: capitalize;
}
</style>
<div class="container spacet60">
<div class="row">
   <div class="col-md-12 spacet60 pt-0-mobile">
      <h2>Club Activities</h2>
      <!-- <h2 class="courses-head text-center">Gallery</h2> -->
      <input type="hidden" name="page_content_type" id="page_content_type" value="gallery">
      <div class="post-list spaceb50" id="postList" style="overflow:hidden;">
         <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3">
                    <a href="{{url('page/art-club')}}">
                                <div class="staffteam">
                                        <div class="staffteamimg">
                                            <img alt="" src="{{asset('public/club/Art Club.jpeg')}}" />
                                            <ul class="social-links">
                                                <li>Facebook</li>
                                                <li>Twitter</li>
                                                <li>Linkedin</li>
                                                <li>Google Plus</li>
                                            </ul>
                                        </div>
                                        <div class="staff-content">
                                            <h3>Art Club</h3>
                                            
                                        </div>
                                        </div>
                            </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                    <a href="{{url('page/bncc')}}">
                                <div class="staffteam">
                                        <div class="staffteamimg">
                                            <img alt="" src="{{asset('frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png')}}" />
                                            <ul class="social-links">
                                                <li>Facebook</li>
                                                <li>Twitter</li>
                                                <li>Linkedin</li>
                                                <li>Google Plus</li>
                                            </ul>
                                        </div>
                                        <div class="staff-content">
                                            <h3>BNCC</h3>
                                            
                                        </div>
                                        </div>
                            </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                    <a href="{{url('page/business-club')}}">
                                <div class="staffteam">
                                        <div class="staffteamimg">
                                            <img alt="" src="{{asset('public/club/business.jpg')}}" />
                                            <ul class="social-links">
                                                <li>Facebook</li>
                                                <li>Twitter</li>
                                                <li>Linkedin</li>
                                                <li>Google Plus</li>
                                            </ul>
                                        </div>
                                        <div class="staff-content">
                                            <h3>Business Club</h3>
                                            
                                        </div>
                                        </div>
                            </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                    <a href="{{url('page/cultural-club')}}">
                                <div class="staffteam">
                                        <div class="staffteamimg">
                                            <img alt="" src="{{asset('public/club/cultural.jpg')}}" />
                                            <ul class="social-links">
                                                <li>Facebook</li>
                                                <li>Twitter</li>
                                                <li>Linkedin</li>
                                                <li>Google Plus</li>
                                            </ul>
                                        </div>
                                        <div class="staff-content">
                                            <h3>Cultural Club</h3>
                                            
                                        </div>
                                        </div>
                            </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                    <a href="{{url('page/debate-club')}}">
                                <div class="staffteam">
                                        <div class="staffteamimg">
                                            <img alt="" src="{{asset('public/club/debate.jpg')}}" />
                                            <ul class="social-links">
                                                <li>Facebook</li>
                                                <li>Twitter</li>
                                                <li>Linkedin</li>
                                                <li>Google Plus</li>
                                            </ul>
                                        </div>
                                        <div class="staff-content">
                                            <h3>Debate club</h3>
                                            
                                        </div>
                                        </div>
                            </a>
            </div>
            
            
            <div class="col-lg-3 col-md-3 col-sm-3">
                    <a href="{{url('page/girls-guide')}}">
                                <div class="staffteam">
                                        <div class="staffteamimg">
                                            <img alt="" src="{{asset('frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png')}}" />
                                            <ul class="social-links">
                                                <li>Facebook</li>
                                                <li>Twitter</li>
                                                <li>Linkedin</li>
                                                <li>Google Plus</li>
                                            </ul>
                                        </div>
                                        <div class="staff-content">
                                            <h3>Girls-Guide</h3>
                                            
                                        </div>
                                        </div>
                            </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                    <a href="{{url('page/green-thumb')}}">
                                <div class="staffteam">
                                        <div class="staffteamimg">
                                            <img alt="" src="{{asset('public/club/greenthumb.png')}}" />
                                            <ul class="social-links">
                                                <li>Facebook</li>
                                                <li>Twitter</li>
                                                <li>Linkedin</li>
                                                <li>Google Plus</li>
                                            </ul>
                                        </div>
                                        <div class="staff-content">
                                            <h3>Green Thumb</h3>
                                            
                                        </div>
                                        </div>
                            </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                    <a href="{{url('page/it-club')}}">
                                <div class="staffteam">
                                        <div class="staffteamimg">
                                            <img alt="" src="{{asset('public/club/IT Club.jpg')}}" />
                                            <ul class="social-links">
                                                <li>Facebook</li>
                                                <li>Twitter</li>
                                                <li>Linkedin</li>
                                                <li>Google Plus</li>
                                            </ul>
                                        </div>
                                        <div class="staff-content">
                                            <h3>IT Club</h3>
                                            
                                        </div>
                                        </div>
                            </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                    <a href="{{url('page/language-club')}}">
                                <div class="staffteam">
                                        <div class="staffteamimg">
                                            <img alt="" src="{{asset('public/club/language.jpg')}}" />
                                            <ul class="social-links">
                                                <li>Facebook</li>
                                                <li>Twitter</li>
                                                <li>Linkedin</li>
                                                <li>Google Plus</li>
                                            </ul>
                                        </div>
                                        <div class="staff-content">
                                            <h3>Language Club</h3>
                                            
                                        </div>
                                        </div>
                            </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                    <a href="{{url('page/mental-health-&-well-being-club')}}">
                                <div class="staffteam">
                                        <div class="staffteamimg">
                                            <img alt="" src="{{asset('public/club/Mental Health.jpg')}}" />
                                            <ul class="social-links">
                                                <li>Facebook</li>
                                                <li>Twitter</li>
                                                <li>Linkedin</li>
                                                <li>Google Plus</li>
                                            </ul>
                                        </div>
                                        <div class="staff-content">
                                            <h3>Mental health & well being</h3>
                                            
                                        </div>
                                        </div>
                            </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                    <a href="{{url('page/photography-club')}}">
                                <div class="staffteam">
                                        <div class="staffteamimg">
                                            <img alt="" src="{{asset('public/club/photography.jpg')}}" />
                                            <ul class="social-links">
                                                <li>Facebook</li>
                                                <li>Twitter</li>
                                                <li>Linkedin</li>
                                                <li>Google Plus</li>
                                            </ul>
                                        </div>
                                        <div class="staff-content">
                                            <h3>Photography Club</h3>
                                            
                                        </div>
                                        </div>
                            </a>
            </div>
            
            
            <div class="col-lg-3 col-md-3 col-sm-3">
                    <a href="{{url('page/ranger')}}">
                                <div class="staffteam">
                                        <div class="staffteamimg">
                                            <img alt="" src="{{asset('frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png')}}" />
                                            <ul class="social-links">
                                                <li>Facebook</li>
                                                <li>Twitter</li>
                                                <li>Linkedin</li>
                                                <li>Google Plus</li>
                                            </ul>
                                        </div>
                                        <div class="staff-content">
                                            <h3>Ranger</h3>
                                            
                                        </div>
                                        </div>
                            </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                    <a href="{{url('page/science-club')}}">
                                <div class="staffteam">
                                        <div class="staffteamimg">
                                            <img alt="" src="{{asset('public/club/science.jpg')}}" />
                                            <ul class="social-links">
                                                <li>Facebook</li>
                                                <li>Twitter</li>
                                                <li>Linkedin</li>
                                                <li>Google Plus</li>
                                            </ul>
                                        </div>
                                        <div class="staff-content">
                                            <h3>Science Club</h3>
                                            
                                        </div>
                                        </div>
                            </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                    <a href="{{url('page/scout')}}">
                                <div class="staffteam">
                                        <div class="staffteamimg">
                                            <img alt="" src="{{asset('frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png')}}" />
                                            <ul class="social-links">
                                                <li>Facebook</li>
                                                <li>Twitter</li>
                                                <li>Linkedin</li>
                                                <li>Google Plus</li>
                                            </ul>
                                        </div>
                                        <div class="staff-content">
                                            <h3>Scout</h3>
                                            
                                        </div>
                                </div>
                            </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                    <a href="{{url('page/sports-club')}}">
                                <div class="staffteam">
                                        <div class="staffteamimg">
                                            <img alt="" src="{{asset('frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png')}}" />
                                            <ul class="social-links">
                                                <li>Facebook</li>
                                                <li>Twitter</li>
                                                <li>Linkedin</li>
                                                <li>Google Plus</li>
                                            </ul>
                                        </div>
                                        <div class="staff-content">
                                            <h3>Sports Club</h3>
                                            
                                        </div>
                                        </div>
                            </a>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-3">
                    <a href="{{url('page/writers-club')}}">
                                <div class="staffteam">
                                        <div class="staffteamimg">
                                            <img alt="" src="{{asset('frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png')}}" />
                                            <ul class="social-links">
                                                <li>Facebook</li>
                                                <li>Twitter</li>
                                                <li>Linkedin</li>
                                                <li>Google Plus</li>
                                            </ul>
                                        </div>
                                        <div class="staff-content">
                                            <h3>Writers Club</h3>
                                            
                                        </div>
                                        </div>
                            </a>
            </div>
            
            
         </div>
         
      </div>
      <script>
            
      </script>                
   </div>
</div>
<!--./row-->
</div><!--./container-->
@endsection