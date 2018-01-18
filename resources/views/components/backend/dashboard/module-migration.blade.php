@extends( 'components.backend.dashboard.master', [ 'parent_class' => 'app-body-container' ])
@push( 'partials.shared.footer' )
    <script>
        "use strict";
        tendoo.migration  =   @json( compact( 'module', 'versions' ) );
    </script>
    <script src="{{ asset( 'js/dashboard/modules-migration.vue.js' ) }}"></script>
@endpush
@section( 'components.backend.dashboard.master.body' )
    <div class="content-wrapper">
        @include( 'partials.shared.page-title', [
            'title'     =>  __( 'Modules &mdash; Migration' ),
            'description'   =>  sprintf( __( 'Migratin the module %s.' ), $module[ 'name' ] )
        ])
        <div class="content-body h-100">
            <div class="container-fluid pt-3 p-4">
                <div class="card">
                    <div class="card-header p-0">
                        <h5 class="box-title">{{ __( 'Migration Process' ) }}</h5>
                    </div>
                    <div class="card-body" id="module-migration">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection