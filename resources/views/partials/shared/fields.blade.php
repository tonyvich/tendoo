@if( $field->type  == 'text' )
<div class="form-group">
    <label for="{{ $field->name }}">{{ $field->label }}</label>
    <input name="{{ $field->name }}" type="text" class="form-control {{ $errors->has( $field->name ) ? 'is-invalid' : '' }}" value="{{ old( $field->name ) ? old( $field->name ) : @$field->value }}" placeholder="{{ @$field->placeholder }}">
    @if( $errors->has( $field->name ) )
    <div class="invalid-feedback d-block">
        {{ $errors->first( $field->name ) }}
    </div>
    @else
    <small class="form-text text-muted">{{ @$field->description }}</small>
    @endif
</div>
@endif

@if( $field->type  == 'textarea' )
<div class="form-group">
    <label for="{{ $field->name }}">{{ $field->label }}</label>
    <textarea 
        name="{{ $field->name }}"
        class="form-control {{ $errors->has( $field->name ) ? 'is-invalid' : '' }}" 
        placeholder="{{ @$field->placeholder }}" 
        id="field-{{ $field->name }}" 
        rows="5">{{ old( $field->name ) ? old( $field->name ) : @$field->value }}</textarea>
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
    <input name="{{ $field->name }}" type="password" class="form-control {{ $errors->has( $field->name ) ? 'is-invalid' : '' }}" value="{{ old( $field->name ) ? old( $field->name ) : @$field->value }}" placeholder="{{ @$field->placeholder }}">
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
    <input name="{{ $field->name }}" type="password" class="form-control {{ $errors->has( $field->name ) ? 'is-invalid' : '' }}" value="{{ old( $field->name ) ? old( $field->name ) : @$field->value }}" placeholder="{{ @$field->placeholder }}">
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
    
    <select name="{{ $field->name }}" class="form-control">
        @foreach( ( array ) @$field->options as $value => $text )
            <option value="{{ $value }}" {{ $value == @$field->value ? 'selected="selected"' : '' }}>{{ $text }}</option>
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
<label for="{{ $field->name }}">{{ @$field->label }}</label>
<div class="checkbox">
    @foreach( $field->options as $value => $text )
    <label>
        <input {{ in_array( $value, ( array ) @$field->value ) ? 'checked="checked"' : null }} type="checkbox"  name="{{ $field->name }}[]" value="{{ $value }}">
        {{ @$text }}
    </label>
    @endforeach

    @if ( $errors->has( $field->name ) )
    <div class="invalid-feedback d-block">
        {{ $errors->first( $field->name ) }}
    </div>
    @else
    <small class="form-text text-muted">{{ @$field->description }}</small>
    @endif
    <br>
</div>
<input name="_checkbox[]" value="{{ $field->name }}" type="hidden"/>
@endif

@if( $field->type  == 'switch' )
<label for="{{ $field->name }}">{{ @$field->label }}</label>
<div class="switch">
    @foreach( $field->options as $value => $text )
    <label>
        <input {{ in_array( $value, ( array ) @$field->value ) ? 'checked="checked"' : null }} type="checkbox"  name="{{ $field->name }}[]" value="{{ $value }}">
        {{ @$text }}
    </label>
    @endforeach

    @if ( $errors->has( $field->name ) )
    <div class="invalid-feedback d-block">
        {{ $errors->first( $field->name ) }}
    </div>
    @else
    <small class="form-text text-muted">{{ @$field->description }}</small>
    @endif
    <br>
</div>
<input name="_checkbox[]" value="{{ $field->name }}" type="hidden"/>
@endif

@if( $field->type == 'radio' ) 
<label for="{{ $field->name }}">{{ @$field->label }}</label>
<div class="radio">
    @foreach( @$field->options as $value => $text )
    <label>
        <input type="radio" name="{{ $field->name }}" id="{{ $field->name }}-field" value="{{ $value }}" {{ @$field->value == $value ? 'checked="checked"' : null }}">
        {{ $text }}
        {{ @$field->value . '-' . $value }}
    </label>
    @endforeach

    @if ( $errors->has( $field->name ) )
    <div class="invalid-feedback d-block">
        {{ $errors->first( $field->name ) }}
    </div>
    @else
    <small class="form-text text-muted">{{ @$field->description }}</small>
    @endif
    <br>
</div>
<input name="_radio[]" value="{{ $field->name }}" type="hidden"/>
@endif