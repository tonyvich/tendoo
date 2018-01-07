@section( 'partials.shared.footer' )
    @parent
    <script src="{{ asset( 'js/dashboard/table.vue.js' ) }}"></script>
@endsection

<script>
let table       =   {
    columns     :   @json( ( array ) @$columns ),
    actions     :   @json( ( array ) @$actions ),
    url         :   '{{ url()->route( 'api.all', [ 'resource' => @$resource ] ) }}'
};

</script>

<div class="card" id="tendoo-table">
    <div class="card-header p-0 d-flex justify-content-between">
        <h5 class="box-title">{{ __( 'Users List' ) }}</h5>
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
                    <th v-for="column in columns" class="column-@{{ column.name }}">@{{ column.text }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="entry in entries">
                    <td>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" :checked="entry.checked" :value="entry.id">
                            </label>
                        </div>
                    </td>

                    <th v-for="column in columns" class="column-@{{ column.name }}">@{{ entry[ column.name ] }}</th>
                    
                    <th class="p-2" width="100">
                        <div class="dropdown show">
                            <a class="btn mb-0 btn-raised btn-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ __( 'Options' ) }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="" class="dropdown-item"></a>
                            </div>
                        </div>
                    </th>
                </tr>
                    <tr v-if="entries.length == 0">
                    <td class="text-center" :colspan="columns.length + 2">{{ __( 'No entry available' ) }}</td>
                </tr>
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