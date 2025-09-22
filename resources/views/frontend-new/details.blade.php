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
    <div class="main-wrapper blog-grid-left-sidebar">
        <!-- ====================================
          ———	BREADCRUMB
          ===================================== -->
        <section class="breadcrumb-bg"
            style="background: url('{{ $article->image }}') no-repeat top center/cover;
           min-height: 350px;
           display: flex;
           align-items: center;">
            <div class="container">
                <div class="breadcrumb-holder">
                    <div>
                        <h1 class="breadcrumb-title">{{ $article->article_title }}</h1>
                        <ul class="breadcrumb breadcrumb-transparent">
                            <li class="breadcrumb-item">
                                <a class="text-white" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item text-white active" aria-current="page">
                                {{ $article->article_title }}
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
            <div class="container ">
                <div class="row">
                    <div class="col-md-8 col-lg-9">
                        <div class="card">
                            <div class="position-relative">
                                <img class="card-img-top" src="{{ $article->image }}" alt="Card image cap">
                                <div class="card-img-overlay">
                                    <span class="badge badge-rounded bg-primary">
                                        {{ date('d M', strtotime($article->publish_date)) }} <br>
                                        {{ date('Y', strtotime($article->publish_date)) }}</span>
                                </div>
                            </div>
                            <div class="card-body border-top-5 px-3 rounded-bottom border-primary detailsarticle">
                                <h3 class="card-title text-primary mb-5">{{ $article->article_title }}</h3>

                                {!! $article->article !!}

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">


                        <div class="mb-4">
                            <h3 class="bg-purple rounded-top font-weight-bold text-white mb-0 py-2 px-4">Related Article
                            </h3>
                            <div class="border border-top-0 rounded">
                                <ul class="list-unstyled mb-0">
                                    @foreach ($articles as $key => $articlea)
                                        <li class="border-bottom p-3">
                                            <div class="media">
                                                <a class="me-2" href="{{ url('details/' . $articlea->id) }}">
                                                    <img class="w-100 rounded" src="{{ $articlea->image }}"
                                                        alt="{{ $articlea->image }}" style="width: 60px!important">
                                                </a>
                                                <div class="media-body">
                                                    <h5 class="mb-1">
                                                        <a class="btn-link font-base text-hover-purple"
                                                            href="{{ url('details/' . $articlea->id) }}">{{ $articlea->article_title }}</a>
                                                    </h5>

                                                </div>
                                            </div>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection
