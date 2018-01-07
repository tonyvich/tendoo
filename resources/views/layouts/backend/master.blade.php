@section( 'partials.shared.head' )
    <link rel="stylesheet" href="{{ asset( 'css/backend.css' ) }}">
@endsection
@section( 'partials.shared.footer' )
    <script src="{{ asset( 'bower_components/vue/dist/vue.min.js' ) }}"></script>
    <script src="{{ asset( 'bower_components/axios/dist/axios.min.js' ) }}"></script>
    <script src="{{ asset( 'bower_components/jquery/dist/jquery.min.js' ) }}"></script>
    <script src="{{ asset( 'bower_components/popper.js/dist/umd/popper.min.js' ) }}"></script>
    <script src="{{ asset( 'bower_components/bootstrap-material-design/js/bootstrap-material-design.min.js' ) }}"></script>
    <script src="{{ asset( 'js/dashboard/aside.vue.js' ) }}"></script>
    <script src="{{ asset( 'js/dashboard/navbar.vue.js' ) }}"></script>
    <script>$(document).ready(function() { $('body').bootstrapMaterialDesign(); });</script>
@endsection
@include( 'partials.shared.header' )
    @yield( 'layouts.backend.master.body' )
@include( 'partials.shared.footer' )
