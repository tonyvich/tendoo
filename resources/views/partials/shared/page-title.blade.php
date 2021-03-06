<div class="content-header p-4">
    <div class="d-flex flex-row justify-content-between">
        <div class="content-heading mb-2">
            <h3>{{ @$title ? $title : __( 'No title provided' ) }}</h3>
            <small>{{ @$description }}</small>
        </div>
        <div class="d-flex align-items-start justify-content-between">
            @foreach( ( array ) @$links as $link )
            <a href="{{ $link[ 'href' ] }}" class="{{ @$link[ 'class' ] ? $link[ 'class' ] : 'btn btn-raised btn-primary' }}">{{ $link[ 'text' ] }}</a>
            @endforeach
        </div>
    </div>
</div>