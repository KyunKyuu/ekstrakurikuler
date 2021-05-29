@extends('templates.home')

@section('navbar')
@include('include.home.navbar_eskul')
@endsection
@section('main')
  <!-- Header -->
    <div class="header-materi img-fluid">
        <div class="container">
            <div class="judul-tugas text-center">
                <h1><b>EKSTRAKURIKULER</b></h1>
                <h3>Ekstrakurikuler yang ada di SMKN 5 Bandung</h3>
            </div>
        </div>
    </div>
    <!-- Header -->

     <!-- Tugas -->
    <div class="tugas mt-3 mb-5 pt-5">
        <div class="container">

            <div class="row mb-3">
                  @foreach($eskuls as $eskul)
                <div class="col col-sm-4">
                    <img src="{{$eskul->image()}}" alt="">
                    <h5><a href="{{route('eskul_detail', $eskul->slug)}}">{{$eskul->name}}</a></h5>
                </div>
                @endforeach
            </div>
            <nav aria-label="Page navigation example">
             {{$eskuls->links()}}
            </nav>
        </div>
    </div>
    <!-- Tugas -->

@endsection

@section('footer')
@include('include.home.footer_putih')
@endsection