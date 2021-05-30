@extends('templates.home')
@section('navbar')
@include('include.home.navbar_biru')
@endsection
@section('main')

<div class="berita-kegiatan p-5">
              <div class="container">
                <form action="{{route('article')}}" method="get">
                 <div class="row pr-0">
                      <div class="col-md-6">
                           <h2 class="mb-3">Berita Kegiatan <span><img src="{{asset('home_page')}}/img/icon_titik.png" class="mb-1"></span> </h2>
                      </div>
   
                      <div class="col-md-6 pr-0">
                        <div class="d-flex">
                          <select name="eskul" class="form-select w-md-25 my-2 ml-auto" aria-label="Default select example">
                              <option value="all"  selected>Semua</option>
                              @foreach($eskuls as $eskul)
                              <option class="py-2" value="{{$eskul->id}}">{{$eskul->name}}</option>
                              @endforeach
                          </select>
                           <button type="submit" class=" h-fit-content btn btn-primary py-2" ><i class="fas fa-search py-2"></i></button>
                      </div>
                       </div>
                  </div>
                     
             @foreach($articlies as $article)
                <div class="row ml-0 border-2 mb-3 slide">
                    <div class="col-md-4 px-0">
                        <img src="{{$article->thumbnail()}}" class="w-100">
                    </div>
                    <div class="col-md-8 my-auto p-4">
                      <div class="d-flex">
                    <h4>{{$article->title}}</h4>
                     <button type="submit" name="eskul" value="{{$article->eskul->id}}" class="badge py-2">{{$article->eskul->name}}</button></h6>

                  </div>
                    <p class="tanggal mb-1">{{$article->created_at}}</p>
                   <p style="word-wrap: break-word;">{!! \Str::limit($article->content, 283, '..') !!}</p>
                    <a href="{{route('article_detail',$article->slug)}}" class="btn btn-shadow">Lihat Selengkapnya</a>
                    </div>
                </div>
                @endforeach
                </form>

               {{$articlies->links()}}

              </div>
          </div>

@endsection

@section('footer')
@include('include.home.footer_putih')
@endsection