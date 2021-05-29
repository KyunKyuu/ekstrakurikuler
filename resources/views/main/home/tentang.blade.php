 @extends('templates.home')
@section('navbar')
@include('include.home.navbar_biru')
@endsection
@section('main')

<div class="container">
          <div class="tentang mt-5 pt-5 mb-5 pb-5">
                <div class="row">
                    <div class="col col-sm-6 col-md-6 img-1">
                        <img src="{{asset('home_page/img/img_tentang_2.png')}}" class="img-tentang">
                    </div>

                    <div class="col col-sm-6">
                        <div class="judul-tentang">
                            <h2>Tentang Kami<span><img  src="{{asset('home_page//img/icon_titik.png')}}" class="mx-3 mb-1 w-2"></span></h2>
                            <h2><b>Kami Ekstrakurikuler SMK 5</b></h2>
                        </div>
                        <p class="deskripsi-tentang">
                            Ekstrakurikuler di SMK Negeri 5 Bandung merupakan program belajar tambahan yang diadakan di sekolah setelah jam belajar selesai. Ekstrakurikuler atau ekskul menjadi wadah yang tepat untuk melihat dan mendalami bakat yang ada di diri siswa. kegiatan ekskul akan sangat bermanfaat buat siswa di kemudian hari. Bisa jadi, kegiatan ekskul yang siswa minati akan menjadi profesi mereka di masa depan dan bermanfaat untuk kehidupan mereka. 
                        </p>

                        <div class="divisi-item">
                            <div class="row text-center divisi-tentang">

                                 @foreach($eskuls as $eskul) 
                                <div class="col col-sm-3 item-1">
                                    <img class="rounded-circle" src="{{$eskul->image()}}">
                                    <h5 class="mt-3 mb-0">{{$eskul->name}}</h5>
                                    <a href="{{route('eskul_detail', $eskul->slug)}}" class="text-black-50">Baca Selengkapnya</a>
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
@include('include.home.footer_putih')
@endsection