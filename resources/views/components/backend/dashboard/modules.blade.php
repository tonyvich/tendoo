@inject( 'Modules', 'App\Services\Modules' )
@extends( 'components.backend.dashboard.master' )
@section( 'components.backend.dashboard.master.body' )
    <div class="row">
    @foreach( $Modules->get() as $module ) 
        <div class="col-md-4">
            <div class="card {{ ! $module[ 'enabled' ] ? 'disabled-module' : '' }}">
                <div class="card-body">
                <h4>{{ @$module[ 'name' ] }} <small>( {{ @$module[ 'version' ] }} )</small></h4>
                <p>{{ @$module[ 'description' ] }}</p>
                <small>{{ @$module[ 'author' ] }}</small>
                </div>
                <div class="card-footer p-2 d-flex justify-content-between">
                    <div>
                        @if( ! $module[ 'enabled' ] )
                            <a href="{{ route( 'dashboard.modules.enable', [ 'namespace' => $module[ 'namespace' ] ] ) }}" class="mb-0 btn btn-success btn-raised">{{ __( 'Enable' ) }}</a>
                        @else 
                            <a href="{{ route( 'dashboard.modules.disable', [ 'namespace' => $module[ 'namespace' ] ] ) }}" class="mb-0 btn btn-secondary btn-raised">{{ __( 'Disable' ) }}</a>
                        @endif
                    </div>
                    <div>
                        <a href="{{ route( 'dashboard.modules.delete', [ 'namespace' => $module[ 'namespace' ] ] ) }}" class="mb-0 btn-icon btn btn-danger btn-raised">
                            <i class="material-icons">delete_forever</i>
                        </a>
                        <a href="{{ route( 'dashboard.modules.extract', [ 'namespace' => $module[ 'namespace' ] ] ) }}" class="mb-0 btn-icon btn btn-primary btn-raised">
                            <i class="material-icons">file_download</i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    </div>
@endsection