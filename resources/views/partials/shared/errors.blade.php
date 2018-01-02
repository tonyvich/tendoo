@if( @$errors->has( 'status' ) )
    <div class="alert alert-{{ $errors->first( 'status' ) }} {{ @$class }}" role="alert">
        {{ $errors->first( 'message' )}}
    </div>
@endif

@if( session()->has( 'status' ) )
    <div class="alert alert-{{ session()->get( 'status' ) }} {{ @$class }}" role="alert">
        {!! session()->get( 'message' ) !!}
    </div>
@endif