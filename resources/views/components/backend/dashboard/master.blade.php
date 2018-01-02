@inject( 'Menus', 'App\Services\Menus' )
@extends( 'layouts.backend.master' )
@section( 'layouts.backend.master.body' )
    <div class="h-100 d-flex align-items-stretch flex-row">
        <aside id="sidebar-menu" class="h-100 bg-light">
            <div class="sidebar-logo align-items-center d-flex justify-content-center">
            Hello World
            </div>
            @include( 'partials.backend.dashboard.aside', [
                'menus'     =>  $Menus->get(),
                'tree'      =>  0
            ])
        </aside>
        <div id="app-body" class="align-items-stretch h-100 flex-column d-flex">
            @include( 'partials.backend.dashboard.navbar' )
                <div class="h-100 app-body-container {{ @$parent_class ? $parent_class : 'p-3' }}">
                @yield( 'components.backend.dashboard.master.body' )
            </div>
        </div>
    </div>
@endsection