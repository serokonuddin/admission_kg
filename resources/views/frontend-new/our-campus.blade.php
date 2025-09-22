@extends('frontend-new.layout')
@section('content')
    @php
        $colors = [
            'bg-primary',
            'bg-danger',
            'bg-success',
            'bg-info',
            'bg-purple',
            ' bg-pink',
            'bg-primary',
            'bg-danger',
            'bg-success',
            'bg-info',
            'bg-purple',
            ' bg-pink',
            'bg-primary',
            'bg-danger',
            'bg-success',
            'bg-info',
            'bg-purple',
            ' bg-pink',
            'bg-primary',
            'bg-danger',
            'bg-success',
            'bg-info',
            'bg-purple',
            ' bg-pink',
            'bg-primary',
            'bg-danger',
            'bg-success',
            'bg-info',
            'bg-purple',
            ' bg-pink',
            'bg-primary',
            'bg-danger',
            'bg-success',
            'bg-info',
            'bg-purple',
            ' bg-pink',
        ];
        $cs = ['primary', 'danger', 'success', 'info', 'purple', 'pink', 'info'];
        $icons = [
            'fas fa-home',
            'far fa-building',
            'fas fa-graduation-cap',
            'fas fa-balance-scale',
            'fas fa-biking',
            'fas fa-certificate',
            'fas fa-comment-dots',
            'fas fa-camera-retro',
            'fas fa-map',
            'bg-info',
            'bg-purple',
            ' bg-pink',
            'bg-primary',
            'bg-danger',
            'bg-success',
            'bg-info',
            'bg-purple',
            ' bg-pink',
            'bg-primary',
            'bg-danger',
            'bg-success',
            'bg-info',
            'bg-purple',
            ' bg-pink',
            'bg-primary',
            'bg-danger',
            'bg-success',
            'bg-info',
            'bg-purple',
            ' bg-pink',
            'bg-primary',
            'bg-danger',
            'bg-success',
            'bg-info',
            'bg-purple',
            ' bg-pink',
        ];
    @endphp
    <style>
        .table-cart thead tr th {
            color: #fff;
            background-color: #ffc107;
            padding: 15px 8px;

        }

        @media (min-width: 700px) {

            img {
                transition: filter 0.3s;
                width: 100% !important;
                height: auto !important;
            }
        }

        @media (max-width: 700px) {
            .card-img-top {}

            img {
                transition: filter 0.3s;
                width: 100% !important;
                height: auto !important;
            }
        }

        p {
            font-size: 1rem;
            color: #666;
            text-align: justify;
        }
    </style>
    @php
        $color = [
            '0' => 'primary',
            '1' => 'success',
            '2' => 'danger',
            '3' => 'info',
            '4' => 'purple',
            '5' => 'pink',
            '6' => 'primary',
            '7' => 'success',
            '8' => 'danger',
            '9' => 'info',
            '10' => 'purple',
            '11' => 'pink',
            '12' => 'primary',
            '13' => 'success',
            '14' => 'danger',
            '15' => 'info',
            '16' => 'purple',
            '17' => 'pink',
            '18' => 'primary',
            '19' => 'success',
            '20' => 'danger',
            '21' => 'info',
            '22' => 'purple',
            '23' => 'pink',
        ];
    @endphp
    <div class="main-wrapper blog-grid-left-sidebar">
        <!-- ====================================
                      ———	BREADCRUMB
                      ===================================== -->
        <section class="breadcrumb-bg"
            style="background-image: url({{ asset('public') }}/assets/img/background/page-title-bg.jpg); ">
            <div class="container">
                <div class="breadcrumb-holder">
                    <div>
                        <h1 class="breadcrumb-title"> From Campus</h1>
                        <ul class="breadcrumb breadcrumb-transparent">
                            <li class="breadcrumb-item">
                                <a class="text-white" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item text-white active" aria-current="page">
                                From Campus
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====================================
                      ———	BLOG GRID LEFT SIDEBAR
                      ===================================== -->

        <section class="py-8 py-md-10">
            <div class="container">
                <div class="row">
                    @foreach ($articles as $key => $article)
                        <div class="col-md-6 col-lg-4">
                            <div class="card">
                                <a href="{{ url('details/' . $article->id) }}">
                                    <div class="position-relative">

                                        <img class="card-img-top" src="{{ $article->image }}" alt="Card image">

                                        <div class="card-img-overlay p-0">
                                            <span class="badge badge-rounded bg-{{ $color[$key] }} m-4">
                                                {{ date('d M', strtotime($article->publish_date)) }} <br>
                                                {{ date('Y', strtotime($article->publish_date)) }}</span>
                                        </div>
                                    </div>
                                </a>
                                <div class="card-body border-top-5 px-3 rounded-bottom border-{{ $color[$key] }}">
                                    <h3 class="card-title">
                                        <a class="text-{{ $color[$key] }} text-capitalize d-block text-truncate"
                                            href="{{ url('details/' . $article->id) }}">{{ $article->article_title }}</a>
                                    </h3>

                                    <p class="mb-2"> {{ substr(strip_tags($article->article), 0, 100) }}</p>
                                    <a class="btn btn-link text-hover-{{ $color[$key] }} ps-0"
                                        href="{{ url('details/' . $article->id) }}">
                                        <i class="fa fa-angle-double-right me-1" aria-hidden="true"></i> Read More
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>

    </div>
@endsection
