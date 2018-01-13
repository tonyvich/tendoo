@inject( 'Event', 'Illuminate\Support\Facades\Event' )
@php
    $config   =   $Event::fire( 'before.loading.crud', $namespace );
@endphp

@if ( empty( $config ) )
    @include( 'errors.unhandled-crud' )
@else 
    @php
    /**
     * Extracting crud config 
    **/
    extract( $config[0] );
    @endphp
    <div class="content-wrapper">
        @include( 'partials.shared.page-title', [
            'title'         =>  $title,
            'description'   =>  $description,
            'links'         =>  $links
        ])
        
        <div class="content-body h-100">
            <div class="container-fluid pt-3 p-4">
                @include( 'partials.shared.tables-boxed', $config[0] )
            </div>
        </div>
    </div>
@endif