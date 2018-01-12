@inject( 'Field', 'App\Services\Field' )
@extends( 'components.backend.dashboard.master', [ 'parent_class' => 'app-body-container' ])
@section( 'components.backend.dashboard.master.body' )
<div class="content-wrapper">
    @include( 'partials.shared.page-title', [
        'title'     =>  __( 'Create a user' ),
        'description'   =>  __( 'Add a new user on the system.' ),
        'links'     =>  [
            [
                'href'  =>  route( 'dashboard.users.list' ),
                'text'  =>  __( 'Return' )
            ]
        ]
    ])
    <div class="content-body">
        <div class="container-fluid pt-3 p-4">
            <form class="mb-0" action="{{ route( 'dashboard.crud.post', [ 'namespace' => $crud[ 'namespace' ] ] ) }}" enctype="multipart/form-data" method="post">
                <div class="card">
                    <div class="card-header p-0">
                        <h5 class="box-title">{{ __( 'Create a new user' ) }}</h5>
                    </div>
                    <div class="card-body p-0">
                    @include( 'partials.shared.errors', compact( 'errors' ) )
                    </div>
                    {{ csrf_field() }}
                    <div class="card-body p-3">
                        @each( 'partials.shared.fields', $Field->createUserFields(), 'field' )
                    </div>
                    <div class="p-2 card-footer">
                        <button type="submit" class="mb-0 btn btn-raised btn-primary">{{ __( 'Create User' ) }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection