@inject( 'Event', 'Illuminate\Support\Facades\Event' )
@php
    $config   =   $Event::fire( 'before.loading.crud', $namespace );
@endphp

@if ( empty( $config ) )
    @include( 'errors.unhandled-crud' )
@else 
<div class="content-wrapper">
    @php
        extract( $config[0] );
    @endphp
    @include( 'partials.shared.page-title', [
        'title'         =>  @$create_title ? $create_title : __( 'Undefined Page' ),
        'description'   =>  @$create_description ? $create_description : __( 'Undefined Description' ),
        'links'         =>  @$create_links ? $createt_links : []
    ])
    <div class="content-body">
        <div class="container-fluid pt-3 p-4">
            <form class="mb-0" action="{{ route( 'dashboard.crud.post', [ 'namespace' => $crud[ 'namespace' ] ] ) }}" enctype="multipart/form-data" method="post">
                <div class="card">
                    <div class="card-header p-0">
                        <h5 class="box-title">{{ @$create_title ? $create_title : __( 'Undefined Page' ) }}</h5>
                    </div>
                    <div class="card-body p-0">
                    @include( 'partials.shared.errors', compact( 'errors' ) )
                    </div>
                    {{ csrf_field() }}
                    <div class="card-body p-3">
                        @each( 'partials.shared.fields', $fields(), 'field' )
                    </div>
                    <div class="p-2 card-footer">
                        <button type="submit" class="mb-0 btn btn-raised btn-primary">{{ @$create_button ? $create_button : __( 'Create' ) }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endif