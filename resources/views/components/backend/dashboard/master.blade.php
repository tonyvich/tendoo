@inject( 'Menus', 'App\Services\Menus' )
@extends( 'layouts.backend.master' )
@section( 'layouts.backend.master.body' )
    @include( 'partials.backend.dashboard.navbar' )
    <div class="app-body h-100 d-flex align-items-stretch flex-row">
        <aside id="sidebar-menu" class="h-100 bg-light">
            @include( 'partials.backend.dashboard.aside', [
                'menus'     =>  $Menus->get(),
                'tree'      =>  0
            ])
        </aside>
        <div id="app-body">
            <div class="app-body-container p-3">
                @yield( 'components.backend.dashboard.master.body' )
            </div>
        </div>
    </div>
@endsection