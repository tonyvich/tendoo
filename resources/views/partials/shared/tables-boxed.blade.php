<div class="card">
    <div class="card-header p-0 d-flex justify-content-between">
        <h5 class="box-title">{{ __( 'Users List' ) }}</h5>
    </div>
    @php
    $columns        =   [
        'name'      =>  __( 'User Name' ),
        'email'     =>  __( 'Email' ),
        'role'      =>  __( 'Role' ),
        'registered_on'     =>   __( 'Member Since' ),
        'last_activity'     =>  __( 'Active' ),
    ];
    @endphp
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th width="10">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="">
                            </label>
                        </div>
                    </th>
                    @foreach( ( array ) @$columns as $name => $text )
                    <th class="column-{{ $name }}">{{ $text }}</th>
                    @endforeach
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse( $entries as $entry )
                <tr>
                    <td>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="">
                            </label>
                        </div>
                    </td>
                    @foreach( ( array ) @$columns as $name => $text )
                    <th class="column-{{ $name }}">{{ $entry->$name }}</th>
                    @endforeach
                    <th class="p-2" width="100">
                        <div class="dropdown show">
                            <a class="btn mb-0 btn-raised btn-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ __( 'Options' ) }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </th>
                </tr>
                @empty
                <tr>
                    <td class="text-center" colspan="{{ intval( count( @$columns ) ) + 2 }}">
                    {{ __( 'There is not entries to display' ) }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <nav aria-label="...">
            <ul class="pagination mb-0">
                <li class="page-item disabled">
                <span class="page-link">Previous</span>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item active">
                <span class="page-link">
                    2
                    <span class="sr-only">(current)</span>
                </span>
                </li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</div>