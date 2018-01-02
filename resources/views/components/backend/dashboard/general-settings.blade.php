@inject( 'Field', 'App\Services\Field' )
@section( 'partials.shared.head' )
    @parent
    <link rel="stylesheet" href="{{ asset( 'css/backend-module.css' ) }}">
@endsection
@extends( 'components.backend.dashboard.master', [ 'parent_class' => 'p-0' ])
@section( 'components.backend.dashboard.master.body' )
    <div class="content-wrapper">
        @include( 'partials.shared.page-title', [
            'title'     =>  __( 'General Settings' ),
        ])
        <div class="content-body h-100">
            <div class="container-fluid pt-3 p-4">
                <div class="card no-shadow">
                    {{--  <div class="card-header p-0">
                        <h5 class="box-title">Some Title</h5>
                    </div>  --}}
                    <div class="card-header p-0">
                        <ul class="nav nav-tabs">
                            @forelse( ( array ) @$tabs as $tab )
                            <li class="nav-item">
                                <a class="nav-link" href="{{ $tab[ 'href' ] }}">{{ $tab[ 'name' ] }}</a>
                            </li>
                            @empty
                            <li class="nav-item">
                                <a class="nav-link disabled" href="#">{{ __( 'No tabs provided' ) }}</a>
                            </li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="card-body p-0 card-group">
                        <div class="card card-body">Module 1</div>
                        <div class="card card-body">Module 1</div>
                        <div class="card card-body">Module 1</div>
                    </div>
                    <div class="card-body p-0 card-group">
                        <div class="card card-body">Module 1</div>
                        <div class="card card-body">Module 1</div>
                        <div class="card card-body">Module 1</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection