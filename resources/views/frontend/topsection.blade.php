<div class="topsection">
            <section class="newsarea">
               <div class="container">
                  <div class="row">
                     <div class="col-md-12 col-sm-12">
                        <div class="newscontent">
                           <div class="newstab">Latest News</div>
                           <div class="newscontent">
                              <marquee class="" behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
                                 <ul id="" class="" >
                                    @foreach($notices as $notice)
                                    <li>
                                       <a href="{{url('notice/'.$notice->id)}}">
                                          <div class="datenews">
                                             {{date('d F Y',strtotime($notice->publish_date))}}                                                              <span>
                                             </span>
                                          </div>
                                          {{$notice->title}}                                                    
                                       </a>
                                    </li>
                                    @endforeach
                                    
                                 </ul>
                              </marquee>
                           </div>
                           <!--./newscontent-->
                        </div>
                        <!--./sidebar-->
                     </div>
                     <!--./col-md-12-->
                  </div>
               </div>
            </section>
            
            <!--./toparea-->
         </div>