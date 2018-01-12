<div class="content-wrapper">
    @include( 'partials.shared.page-title', [
        'title'         =>  $title,
        'description'   =>  $description,
        'links'         =>  $links
    ])
    
    <div class="content-body h-100">
        <div class="container-fluid pt-3 p-4">
            @include( 'partials.shared.tables-boxed' )
        </div>
    </div>
</div>