<div class="card" id="tendoo-table">
    <div class="card-header p-0 d-flex justify-content-between">
        <h5 class="box-title">{{ @$crud[ 'title' ] ? $crud[ 'title' ] : __( 'Unammed Table' ) }}</h5>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th width="10">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox">
                            </label>
                        </div>
                    </th>
                    @foreach( ( array ) @$columns as $name => $column )
                    <th class="column-{{ $name }}">{{ $column[ 'text' ] }}</th>
                    @endforeach
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if( @$entries )
                    @foreach( $entries as $entry )
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox">
                                </label>
                            </div>
                        </td>

                        @foreach( ( array ) @$columns as $name => $column )
                            @if ( is_callable( @$column[ 'filter' ] ) )
                            <!-- Hopfully PHP 7.x let us acheive this -->
                            <th class="column-{{ $name }}">{{ $column[ 'filter' ]( array_get( $entry, $name ) ) }}</th>
                            @else 
                            <th class="column-{{ $name }}">{{ array_get( $entry, $name ) }}</th>
                            @endif
                        @endforeach
                        
                        <th class="p-2" width="100">
                            <div class="dropdown show">
                                <a class="btn mb-0 btn-raised btn-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ __( 'Options' ) }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right">
                                    @foreach( $actions as $name => $action )
                                    @php
                                        $config    =   $action( $entry );
                                    @endphp
                                    <a href="{{ $config[ 'url' ] }}" class="dropdown-item">{{ $config[ 'text' ] }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </th>
                    </tr>
                    @endforeach
                @else
                <tr>
                    <td colspan="{{ count( @$columns ) + 2 }}" class="text-center">{{ __( 'No entry available' ) }}</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        @if ( @$entries )
            @php
            $pagination     =   $entries->toArray();
            @endphp
        <nav aria-label="...">
            <ul class="pagination mb-0">
                <li class="page-item {{ ! $pagination[ 'prev_page_url' ] ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $pagination[ 'prev_page_url' ] ? $pagination[ 'first_page_url' ] : '#' }}">{{ __( 'First' ) }}</a>
                </li>
                <li class="page-item {{ ! $pagination[ 'prev_page_url' ] ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $pagination[ 'prev_page_url' ] ? $pagination[ 'prev_page_url' ] : '#' }}">{{ __( 'Previous' ) }}</a>
                </li>
                @for ( $i = 1; $i <= round( intval( $pagination[ 'total' ] ) / intval( $pagination[ 'per_page' ] ) ); $i++ ) 
                    @if ( intval( $pagination[ 'current_page' ] ) == $i ) 
                    <li class="page-item active">
                        <span class="page-link">
                            {{ $i }}
                        </span>
                    </li>
                    @elseif ( intval( $pagination[ 'current_page' ] ) - $i <= 5 || $i - intval( $pagination[ 'current_page' ] ) >= 5 )
                    <li class="page-item"><a class="page-link" href="{{ $pagination[ 'path' ] . '?page=' . $i }}">{{ $i }}</a></li>
                    @endif                    
                @endfor
                <li class="page-item {{ ! $pagination[ 'next_page_url' ] ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $pagination[ 'next_page_url' ] ? $pagination[ 'next_page_url' ] : '#' }}">{{ __( 'Next' ) }}</a>
                </li>
                <li class="page-item {{ ! $pagination[ 'next_page_url' ] ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $pagination[ 'next_page_url' ] ? $pagination[ 'last_page_url' ] : '#' }}">{{ __( 'Last' ) }}</a>
                </li>
            </ul>
        </nav>
        @endif
    </div>
</div>