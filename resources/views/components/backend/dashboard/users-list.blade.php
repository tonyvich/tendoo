@extends( 'components.backend.dashboard.master', [ 'parent_class' => 'app-body-container' ])
@section( 'components.backend.dashboard.master.body' )
@php
$crud           =   [
    'title'         =>  __( 'Users' ),

    'description'   =>  __( 'List all users with their roles' ),

    'columns'       =>  [
        'username'  =>  [
            'text'  =>  __( 'Username' )
        ],
        'email'  =>  [
            'text'  =>  __( 'Email' )
        ],
        'role.name'  =>  [
            'text'  =>  __( 'Role' )
        ],
        'created_at'  =>  [
            'text'  =>  __( 'Member Since' )
        ],
        'active'    =>  [
            'text'  =>  __( 'Active' ),
            'filter'    =>  function( $value ) {
                if ( $value ) {
                    return __( 'Active' );
                }
                return __( 'Unactive' );
            }
        ]
    ],

    'actions'      =>   [
        'edit'      =>  function( $user ) {
            return [
                'text'  =>  __( 'Edit' ),
                'url'   =>  url()->route( 'dashboard.users.edit', [ 'id' => $user->id ] )
            ];
        },
        'delete'    =>  function( $user ) {
            return [
                'type'  =>  'DELETE',
                'url'   =>  url()->route( 'dashboard.users.delete', [ 'id' => $user->id ]),
                'text'  =>  __( 'Delete' )
            ];
        }
    ],

    'links'        =>   [
        [
            'href'  =>  route( 'dashboard.users.create' ),
            'text'  =>  __( 'Add new user' )
        ]
    ]
]
@endphp
@include( 'partials.backend.dashboard.crud-table', $crud )
@endsection