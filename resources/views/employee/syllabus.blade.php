@extends('admin.layouts.layout')
@section('content')
<style>
    .control {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
        position: relative;
        cursor: pointer;
    }
    th.control:before,td.control:before {
        background-color: #696cff;
        border: 2px solid #fff;
        box-shadow: 0 0 3px rgba(67,89,113,.8);
    }
    td.control:before, th.control:before {
        top: 50%;
        left: 50%;
        height: 0.8em;
        width: 0.8em;
        margin-top: -0.5em;
        margin-left: -0.5em;
        display: block;
        position: absolute;
        color: white;
        border: 0.15em solid white;
        border-radius: 1em;
        box-shadow: 0 0 0.2em #444;
        box-sizing: content-box;
        text-align: center;
        text-indent: 0 !important;
        font-family: "Courier New",Courier,monospace;
        line-height: 1em;
        content: "+";
        background-color: #0d6efd;
    }
    .table-dark {
        background-color: #1c4d7c!important;
        color: #fff!important;
        font-weight: bold;
    }
    .table-dark {
        --bs-table-bg: #1c4d7c!important;
        --bs-table-striped-bg: #1c4d7c!important;
        --bs-table-striped-color: #fff!important;
        --bs-table-active-bg: #1c4d7c!important;
        --bs-table-active-color: #fff!important;
        --bs-table-hover-bg: #1c4d7c!important;
        --bs-table-hover-color: #fff!important;
        color: #fff!important;
        border-color: #1c4d7c!important;
    }
    .table:not(.table-dark) th {
        color: #ffffff;
    }
    .p-10{
        padding: 10px!important;
    }
    .m-r-10{
        margin-right: 10px!important;
    }
    .childdata{
      display: none;
      background-color: #98fded;
    }
    .form-label {

        width: 100%;
    }
    .badge{
        float: right;
    }
    .tab-content{
      padding: .5px;
    }
</style>
<style>
   td,th{
      border: 1px solid #eee!important;
   }
   @media (min-width: 576px) {
      .accordion-body .col-sm-3 {
          flex: 0 0 auto;
          width: 26%;
      }
      .accordion-body .col-sm-9 {
          flex: 0 0 auto;
          width: 74%;
      }
  }
  .nav-link .color{
    color: white!important;
    }
    .nav-tabs .nav-item .nav-link {
        color: #ffffff;
        border: 0;
        border-radius: 0;
    }
    .table-class-schedule {
                border-radius: .625rem;
                border: 1px solid #e7e7e7;
                border-top: 0;
                border-bottom: 0;
            }
            .table {
    --bs-table-bg: transparent;
    --bs-table-accent-bg: transparent;
    --bs-table-striped-color: #222;
    --bs-table-striped-bg: rgba(0, 0, 0, 0.05);
    --bs-table-active-color: #222;
    --bs-table-active-bg: rgba(0, 0, 0, 0.1);
    --bs-table-hover-color: #222;
    --bs-table-hover-bg: rgba(0, 0, 0, 0.075);
    width: 100%;
    margin-bottom: 1rem;
    color: #222;
    vertical-align: top;
    border-color: #e7e7e7;
}
.font-size-18 {
    font-size: 1.13rem;
}
.bg-primary {
    background-color: #f0c24b !important;
}

.text-white {
    color: #fff !important;
    font-weight: bold;
}
.text-uppercase {
    text-transform: uppercase !important;
}
.bg-purple {
    background-color: #a597e7 !important;
}
.bg-pink {
    background-color: #ea77ad !important;
}

.text-primary {
    color: #f0c24b !important;
    font-weight: bold;
}

.text-purple {
    color: #a597e7 !important;
    font-weight: bold;
}
.text-pink {
    color: #ea77ad !important;
    font-weight: bold;
}
.text-danger,.text-info,.text-success,.text-danger,.text-secondary,.text-dark{
    font-weight: bold;
}

.subject-title {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 18px;
            line-height: 1.5;
        }

        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .schedule-table th, .schedule-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            vertical-align: top;
        }

        .schedule-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .schedule-table td.left-align {
            text-align: left;
            padding-left: 10px;
        }
        td, th {
                border: 1px solid #eee !important;
                padding: 2px;
            }
</style>
@php
$color=array(
  'primary','secondary','success','danger','warning','info','dark','success'
);

function removeInlineCSS($html) {
    $pattern = '/(<[a-z][a-z0-9]*\b[^>]*?)\s*style\s*=\s*(["\'])(.*?)\2/i';
    $htmlWithoutInlineCSS = preg_replace($pattern, '$1', $html);

    // Remove empty tags (e.g., <div></div>)
    $htmlWithoutEmptyTags = preg_replace('/<([a-z][a-z0-9]*)\b[^>]*>\s*<\/\1>/i', '', $htmlWithoutInlineCSS);

    // Remove &nbsp; entities
    $htmlCleaned = str_replace('&nbsp;', '', $htmlWithoutEmptyTags);
    $htmlCleaned = str_replace('&nbsp;', '', $htmlWithoutEmptyTags);
    $htmlCleaned = str_replace('·', '', $htmlWithoutEmptyTags);

    return $htmlWithoutEmptyTags;
}

@endphp

    <div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
       <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Syllabus</h4>
       <!-- Basic Bootstrap Table -->

          <div class="table-responsive ">

            <div class="card mb-4">
                <div class="card-body">
                  <div class="row">
                    <!-- Custom content with heading -->
                    <div class="col-lg-12 mb-4 mb-xl-0">
                      <small class="text-light fw-medium">Syllabus</small>

                      <div class="nav-align-top nav-tabs-shadow mb-6">
                        <ul class="nav nav-tabs" role="tablist">
                        @foreach($subjects as $key=>$subject)
                          <li class="nav-item " role="presentation">
                            <button type="button" class="nav-link {{($key==0)?'active':''}} color  bg-{{$color[$key%7]}}" role="tab" data-bs-toggle="tab" data-bs-target="#navs{{$subject->subject_id}}" aria-controls="navs{{$subject->subject_id}}" aria-selected="true">{{$subject->subject->subject_name}}</button>
                          </li>
                        @endforeach


                        </ul>
                        <div class="tab-content">
                        @foreach($subjects as $key=>$subject)
                          <div class="tab-pane fade {{($key==0)?'active show':''}}" id="navs{{$subject->subject_id}}" role="tabpanel" >
                          <h4 class="card-title list-group-item-{{$color[$key%7]}}" style="text-align: center;
    padding: 10px;">Subject: {{$subject->subject->subject_name}}</h4>

                                  <div class="card " style="margin-bottom: 10px;">

                                   {!!(isset($subject->syllabus->details))?removeInlineCSS($subject->syllabus->details):''!!}

                                   </div>

                          </div>
                          @endforeach

                        </div>
                      </div>
                    </div>

                    <!--/ Custom content with heading -->
                  </div>
                </div>
              </div>
          </div>


       <!-- Modal -->

    </div>
    <!-- / Content -->

    <div class="content-backdrop fade"></div>
 </div>
 <script>
        $(document).ready(function() {
            $('#headerTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
 <script notice="text/javascript">
$(function(){


   $(document.body).on('click','.control',function(){
      var id=$(this).data('id');
      $('.childdata'+id).toggle();
   });
   $(document.body).on('click','.delete',function(){
            var id=$(this).data('id');
            var url=$(this).data('url');
			Swal.fire({
			  title: 'Do you want to Delete this employee?',
			  showDenyButton: true,
			  confirmButtonText: 'Yes',
			  denyButtonText: 'No',
			  customClass: {
				actions: 'my-actions',
				cancelButton: 'order-1 right-gap',
				confirmButton: 'order-2',
				denyButton: 'order-3',
			  },
			}).then((result) => {
			  if (result.isConfirmed) {
					$.ajax({
						type: "delete",
						headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
						url: url,
						data:{"_token": "{{ csrf_token() }}"},
						success: function(response){
							if(response==1){
								Swal.fire({
									title: "Good job!",
									text: "Deleted successfully",
									icon: "success"
								});
								$('#row'+id).remove();
							}else{
								Swal.fire({
									title: "Error!",
									text: response,
									icon: "warning"
								});
							}

						},
						error: function(data, errorThrown)
						{
							Swal.fire({
								title: "Error",
								text: errorThrown,
								icon: "warning"
							});

						}
					});
			  } else if (result.isDenied) {

			  }
			})

        });
});
</script>

@endsection
