@if( @$errors->has( 'status' ) )
    <div class="alert alert-{{ $errors->first( 'status' ) }}" role="alert">
        {{ $errors->first( 'message' )}}
    </div>
@endif