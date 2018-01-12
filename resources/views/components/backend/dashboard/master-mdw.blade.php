@inject( 'Menus', 'App\Services\Menus' )
@extends( 'layouts.backend.master' )
@section( 'layouts.backend.master.body' )
<h2>Contacts</h2>
<ul class="mdc-list">
  <li class="mdc-list-item">
    Janet Perkins
    <a href="#" class="mdc-list-item__meta material-icons"
       aria-label="Remove from favorites" title="Remove from favorites">
      favorite
    </a>
  </li>
  <li class="mdc-list-item">
    Mary Johnson
    <a href="#" class="mdc-list-item__meta material-icons"
       aria-label="Add to favorites" title="Add to favorites">
      favorite_border
    </a>
  </li>
  <li class="mdc-list-item">
    Janet Perkins
    <a href="#" class="mdc-list-item__meta material-icons"
       aria-label="Add to favorites" title="Add to favorites">
      favorite_border
    </a>
  </li>
</ul>
@endsection