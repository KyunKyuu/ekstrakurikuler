@extends('templates.home')
@section('navbar')
@include('include.home.navbar_biru')
@endsection
@section('main')

 <section class="body-anggota-11">
            <div class="anggota-11 p-5">
              <div class="container text-center">
                  <h1>Pembimbing<span><img src="{{asset('home_page/img/icon_titik.png')}}" class="mb-1 ml-3"></span></h2>
                  <div class="row mt-3">
                    @foreach($mentors as $mentor)
                      <div class="col-lg-3 col-sm-4 col-6 mt-3 down">
                          <div class="card p-4 text-center gradient-anggota">
                              <div class="card-head">
                                  <h4 class="text-white" style="text-transform: uppercase;">Pembimbing</h4>
                                  <img src="{{$mentor->image()}}"  class="w-100 rounded-circle">
                              </div>
                              <div class="card-body">
                                  <h5 class="mb-0 text-white nama-anggota">{{$mentor->name}}</h5>
                                  <p class="light mb-0 text-white">{{$mentor->eskul->name}}</p>
                              </div>
                          </div>
                      </div>
                        @endforeach
                  
                  </div>
              </div>
          </div>
  
          <nav aria-label="Page navigation example">
             {{$mentors->links()}}
            </nav>
        </section>
@endsection

@section('footer')
@include('include.home.footer_hijau')
@endsection