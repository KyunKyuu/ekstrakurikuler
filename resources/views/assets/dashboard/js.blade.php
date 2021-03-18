<!-- General JS Scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="/public_file/node_modules/bootstrap/js/bootstrap.min.js"  crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="/public_file/assets/js/stisla.js"></script>

<!-- JS Libraies -->
<script src="/public_file/node_modules/jquery-sparkline/jquery.sparkline.min.js"></script>
<script src="/public_file/node_modules/chart.js/dist/Chart.min.js"></script>
<script src="/public_file/node_modules/owl.carousel/dist/owl.carousel.min.js"></script>
<script src="/public_file/node_modules/summernote/dist/summernote-bs4.js"></script>
<script src="/public_file/node_modules/chocolat/dist/js/jquery.chocolat.min.js"></script>
<script src="/public_file/node_modules/dataTables/js/jquery.dataTables.js"></script>
{{-- <script src="/public_file/node_modules/sweetalert/dist/sweetalert.js"></script> --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<!-- Template JS File -->
<script src="/public_file/assets/js/scripts.js"></script>
<script src="/public_file/assets/js/custom.js"></script>

<!-- Page Specific JS File -->
<script src="/public_file/assets/js/page/index.js"></script>

<!-- Private File JS File -->
<script src="/private_file/assets/js/function/script.js"></script>
<script src="/private_file/assets/js/variable/script.js"></script>
@if (request()->segment(3))
<script src="/private_file/assets/js/{{request()->segment(1)}}/{{request()->segment(2)}}/{{request()->segment(3)}}.js"></script>
@elseif(request()->segment(2))
<script src="/private_file/assets/js/{{request()->segment(1)}}/{{request()->segment(2)}}/script.js"></script>
@else
<script src="/private_file/assets/js/{{request()->segment(1)}}.js"></script>
@endif
