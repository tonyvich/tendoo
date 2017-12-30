<?php
return [
    'modules_path'  =>  base_path() . '\modules',
    'version'       =>  '5.0',
    'redirect'      =>  [
        'authenticated'         =>  'dashboard.index',
        'not-authenticated'     =>  'login.index' 
    ]
];