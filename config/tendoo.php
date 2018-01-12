<?php
return [
    'modules_path'  =>  base_path() . '\modules\\',
    'version'       =>  '5.0',
    'debug'         =>  [
        'errors'    =>  true
    ],
    'redirect'      =>  [
        'authenticated'         =>  'dashboard.index',
        'not-authenticated'     =>  'login.index' 
    ],
    'validations'    => [
        'options'       =>  [],
        'crud'          =>  [],
    ],
    'name'          =>  'Tendoo CMS',
    'pagination'    =>  [
        'users'         =>  2
    ],
];