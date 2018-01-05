<div class="card-header p-0">
                        <ul class="nav nav-tabs">
        @forelse( ( array ) @$tabs as $tab )
        <li class="nav-item">
            <a class="nav-link" href="{{ $tab[ 'href' ] }}">{{ $tab[ 'name' ] }}</a>
        </li>
        @empty
        <li class="nav-item">
            <a class="nav-link disabled" href="#">{{ __( 'No tabs provided' ) }}</a>
        </li>
        @endforelse
    </ul>
</div>
<div class="card-body p-0 card-group">
    <div class="card card-body">Module 1</div>
    <div class="card card-body">Module 1</div>
    <div class="card card-body">Module 1</div>
</div>
<div class="card-body p-0 card-group">
    <div class="card card-body">Module 1</div>
    <div class="card card-body">Module 1</div>
    <div class="card card-body">Module 1</div>
</div>