
@extends('templates.home')
@section('navbar')
@include('include.home.navbar_biru')
@endsection
@section('main')

 <div class="body-divisi">
          <div class="container pt-3">
              <div class="divisi pt-5 pb-5">
                    <div class="row">
                        <div class="col col-sm-6 col-md-6 img-1 text-center">
                            <img class="logo-ekskul" rounded-circle"  src="{{$eskul->image()}}">
                            <h4 class="mt-4">{{$eskul->name}}</h4>
                            <div class="row text-center">
                             <div class="d-flex">
                                  <img src="{{asset('home_page')}}/img/beginner.png" class="ml-auto">
                                  <img src="{{asset('home_page')}}/img/intermediate.png" class="mx-3">
                                  <img src="{{asset('home_page')}}/img/expert.png" class="mr-auto">
                              </div>
                            </div>
                        </div>
    
                        <div class="col col-sm-6 col-md-6">
                            <div class="judul">
                                <h2>EKSKUL {{$eskul->name}}<span><img  src="{{asset('home_page/img/icon_titik.png')}}"></span></h2>
                            </div>
                            <p style="word-wrap: break-word;">
                           {!! $eskul->content !!}
                            </p>
                
                            @foreach($VideoEskul as $video)
                            <div class="materi down">
                                <iframe src="{{$video->url}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                            @endforeach
                        </div>
                    </div>
              </div>
          </div>
      </div>
    

@endsection

@section('footer')
@include('include.home.footer_putih')
@endsection
    

