<ul class="list-group pt-0 aside-menu {{ @$tree > 0 ? 'sub-menu tree-' . $tree : '' }} pb-0">
	@foreach( $menus as $menu )
	<li class="list-group-item menu-{{ $menu->namespace }}">
		<a href="{{ $menu->href }}" class="d-flex flex-row align-items-center">
			<i class="material-icons mr-2">{{ $menu->icon }}</i>
			{{ $menu->text }}
		</a>
		@if( @$menu->childrens )
			@include( 'partials.backend.dashboard.aside', [ 'menus' => $menu->childrens, 'tree' => intval( @$tree ) + 1 ])
		@endif
	</li>
	@endforeach
</ul>