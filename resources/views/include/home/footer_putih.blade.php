  <!-- footer -->
      <div class="footer-body-elearning p-md-5 p-2">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6 judul-1">
                    <h5><b>Tentang</b></h5>
                    <a href="{{route('article')}}" class="text-decoration-none d-block my-1 mt-2">Prestasi</a>
                    <a href="{{route('article')}}" class="text-decoration-none d-block my-1">Berita kegiatan</a>
                    <a href="{{route('tentang')}}" class="text-decoration-none d-block my-1">Tentang It Club</a>
                    <a href="{{route('tentang')}}" class="text-decoration-none d-block my-1">Divisi</a>
                </div>
                <div class="col-md-3 col-6 judul-1">
                  <h5><b>Layanan Training</b></h5>
                  <a href="#" class="text-decoration-none d-block my-1 mt-2">Belajar Online</a>
                  <a href="#" class="text-decoration-none d-block my-1">Tatap Muka</a>
                </div>
                <div class="col-md-3 col-6 judul-1">
                  <h5><b>Kontak</b></h5>
                  <p class="my-1 mt-2">Bandung</a>
                  <p class="my-1">Indonesia</a>
                  <p class="my-1">087812845006</a>
                  <p class="my-1">itclubsmk5bdg@gmail.com</p>
                </div>
                <div class="col-md-3 col-6 judul-1">
                  <h5><b>Ikut Kami</b></h5>
                  <div class="d-flex mb-3">
                      <a href="https://m.facebook.com/groups/1947499468732047/" class="mr-3"><img src="{{asset('home_page/img/ic_fb.png')}}"></a>
                      <a href="https://www.instagram.com/itclubsmkn5bdg/" class="mr-3"><img src="{{asset('home_page/img/ic_ig.png')}}"></a>
                      <a href="https://www.youtube.com/channel/UC4k9rPrapnWphcuQYgqJF4w/videos" class="mr-3"><img src="{{asset('home_page/img/ic_yt.png')}}"></a>
                  </div>
                  <img src="{{asset('home_page/img/logo.png')}}" class="w-md-25 w-25 ml-0">
                </div>
            </div>
        </div>
    </div>
    <div class="footer-elearning text-center p-3"><p class="mb-0">2021 Copyright IT CLUB • All rights reserved • Made in Bandung</p></div>

@include('assets.home.js')

</body>

</html>