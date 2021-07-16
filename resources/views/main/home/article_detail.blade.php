@extends('templates.home')
@section('navbar')
@include('include.home.navbar_biru')
@endsection
@section('main')

<div class="body-berita-kegiatan">
            <div class="container pt-5">
                <p class="breadcumb-berita-kegiatan"><a href="{{route('article')}}" class="text-decoration-none">Berita Kegiatan</a><span class="mx-3">    /     </span><b>Details</b></p>
                <div class="row">
                    <div class="col-lg-8 pl-lg-0">
                        <div class="card card-berita mb-5 px-3 py-3">
    
                                <h1 class="judul-berita">{{$article->title}}<span><img src="{{asset('home_page')}}/img/icon_titik.png" class="icon-titik-berita-kegiatan"></span></h1>
                                <p class="mt-0 text-black-50 tanggal-berita">{{$article->created_at}}</p>
                                <img src="{{$article->thumbnail()}}" class="img-webinar">
    
                                <p class="description mt-4" style="word-wrap: break-word;">
                                {!!$article->content!!}
                                </p>
                            
                        </div>
                    </div>
    
                    <div class="col-lg-4 col-sm-3">
                        <div class="card card-berita card-right p-2 pr-0 mb-5">
                            <h5 class="text-center mb-3 judul-kegiatan-terbaru">Berita Kegiatan Terbaru</h5>
                            <div class="row col-sm-12">
                               @foreach($articlies as $data)  
                                <div class="col d-flex kegiatan pb-2">
                                    <img src="{{$data->thumbnail()}}" alt="">
                                    <div class="ml-2">
                                        <h6 class="sub-judul-kegiatan-terbaru"><a href="{{route('article_detail',$data->slug)}}" class="text-decoration-none">{{$data->title}}</a></h6>
                                        <p class="kegiatan-item text-black-50">{{$data->created_at}}</p>
                                        <p class="kegiatan-item-2 style="word-wrap: break-word;">{!! \Str::limit($data->content, 45, '..') !!}</p>
                                    </div>
                                </div>
                              @endforeach
                            
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div>

@endsection

@section('footer')
@include('include.home.footer_hijau')
@endsection

