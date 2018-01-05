@inject( 'Field', 'App\Services\Field' )
@extends( 'components.backend.dashboard.master', [
    'parent_class'  =>  'p-0'
])
@section( 'components.backend.dashboard.master.body' )
    <div class="content-wrapper">
        @include( 'partials.shared.page-title', [
            'title'     =>  __( 'NexoPOS Settings' ),
            'description'   =>  __( 'Group all basic options for the application' )
        ])
        <div class="content-body h-100">
            <div class="container-fluid pt-3 p-4">
                <form action="{{ route( 'dashboard.options.post' ) }}" method="post">
                    {{ csrf_field() }}
                    {{ route_field() }}
                    <div class="card">
                        <div class="card-header p-3">
                            <button type="submit" class="mb-0 btn btn-raised btn-primary">{{ __( 'Save Settings' ) }}</button>
                        </div>
                        @include( 'partials.shared.errors', [
                            'errors'    =>  $errors,
                            'class'     =>  'mb-0'
                        ])
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 col-xs-12 col-sm-12">
                                <h4>{{ __( 'Default Fields' ) }}</h4>
                                @each( 'partials.shared.fields', $Field->get(
                                    'Modules\Foo\Fields\DashboardFields', 
                                    'generalSettings'
                                ), 'field' )
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection