<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
// use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    public $user_id;

    /**
     * The attributes that are mass assignable.
     *
        * @var array
     */
    protected $fillable = [
        'email', 'password', 'role_id', 'active', 'username'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Relation with roles
     * @return void
    **/

    public function role()
    {
        return $this->belongsTo( Role::class );
    }

    /**
     * Get authenticated user pseudo
     * @return string
     */
    public function pseudo()
    {
        $user   =   Auth::user();
        return $user->username;
    }

    /**
     * Assign user to a role
     * @param int user id
     * @param role name
     * @return boolean
     */
    public static function setAs( $id, $roleName )
    {
        $role   =   Role::namespace( $roleName );

        if ( $role ) {
            /**
             * check if model is already provided
             */
            if ( is_object( $id ) ) {
                $user   =   $id;
            } else {
                $user   =   self::find( $id );
            }

            $user->role()->associate( $role );
            $user->save();
        }
        return false;
    }

    /**
     * Set object as a role
     * basically assigning role to user
     * @param object user
     * @return User<Model>
     */
    public static function set( $user ) 
    {
        if ( $user ) {
            return User::define( $user->id );
        }
        return false;
    }

    /**
     * Define user id
     * @param int user
     */
    public static function define( $user_id ) 
    {
        $user   =   new User;
        $user->user_id  =   $user_id;
        return $user;
    }

    /**
     * Assign a role
     * @param string role namespace
     * @return void
     */
    public function as( $role )
    {
        return self::setAs( $this->user_id, $role );
    }
    
    /**
     * mutator
     * mutate active field
     * @param string value
     * @return boolean
     */
    public function getActiveAttribute( $value ) 
    {
        if ( $value == '1' ) {
            return true;
        }
        return false;
    }
}
