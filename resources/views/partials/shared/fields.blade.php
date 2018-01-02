@if( $field->type  == 'text' )
<div class="form-group">
    <label for="{{ $field->name }}">{{ $field->label }}</label>
    <input name="{{ $field->name }}" type="text" class="form-control {{ $errors->has( $field->name ) ? 'is-invalid' : '' }}" value="{{ old( $field->name ) ? old( $field->name ) : @$field->default }}" placeholder="{{ @$field->placeholder }}">
    @if( $errors->has( $field->name ) )
    <div class="invalid-feedback d-block">
        {{ $errors->first( $field->name ) }}
    </div>
    @else
    <small class="form-text text-muted">{{ @$field->description }}</small>
    @endif
</div>
@endif

@if( $field->type  == 'password' )
<div class="form-group">
    <label for="{{ $field->name }}">{{ $field->label }}</label>
    <input name="{{ $field->name }}" type="password" class="form-control {{ $errors->has( $field->name ) ? 'is-invalid' : '' }}" value="{{ old( $field->name ) ? old( $field->name ) : @$field->default }}" placeholder="{{ @$field->placeholder }}">
    @if( $errors->has( $field->name ) )
    <div class="invalid-feedback d-block">
        {{ $errors->first( $field->name ) }}
    </div>
    @else
    <small class="form-text text-muted">{{ @$field->description }}</small>
    @endif
</div>
@endif

@if( $field->type  == 'email' )
<div class="form-group">
    <label for="{{ $field->name }}">{{ $field->label }}</label>
    <input name="{{ $field->name }}" type="password" class="form-control {{ $errors->has( $field->name ) ? 'is-invalid' : '' }}" value="{{ old( $field->name ) ? old( $field->name ) : @$field->default }}" placeholder="{{ @$field->placeholder }}">
    @if( $errors->has( $field->name ) )
    <div class="invalid-feedback d-block">
        {{ $errors->first( $field->name ) }}
    </div>
    @else
    <small class="form-text text-muted">{{ @$field->description }}</small>
    @endif
</div>
@endif

@if( $field->type  == 'select' )
<div class="form-group">

    <label for="{{ $field->name }}">{{ $field->label }}</label>
    
    <select class="form-control">
        @foreach( ( array ) @$field->options as $value => $text )
        <option value="{{ $value }}">{{ $text }}</option>
        @endforeach
    </select>

    @if ( $errors->has( $field->name ) )
    <div class="invalid-feedback d-block">
        {{ $errors->first( $field->name ) }}
    </div>
    @else
    <small class="form-text text-muted">{{ @$field->description }}</small>
    @endif

</div>
@endif

@if( $field->type  == 'checkbox' )
<div class="checkbox">
    <label>
        <input type="checkbox" name="{{ $field->name }}" value="{{ @$field->default }}">
        {{ @$field->description }}
    </label>
</div>
@endif