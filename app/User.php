<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Model implements AuthenticatableContract {

	use Authenticatable;
    use Notifiable;
    use HasRoles;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'dnm_seguridad_si.SEG.sys_usuarios';
	protected $connection = 'sqlsrv';
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	//protected $fillable = ['name', 'email', 'password'];
	protected $fillable = [];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password'];
	//protected $hidden = ['password'];

	protected $primaryKey = 'id';
	public $incrementing = false;
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';


	public function getRememberToken()
	 {
	   return null; // not supported
	 }

	 public function setRememberToken($value)
	 {
	   // not supported
	 }

	 public function getRememberTokenName()
	 {
	   return null; // not supported
	 }

	 /**
	  * Overrides the method to ignore the remember token.
	  */
	 public function setAttribute($key, $value)
	 {
	   $isRememberTokenAttribute = $key == $this->getRememberTokenName();
	   if (!$isRememberTokenAttribute)
	   {
	     parent::setAttribute($key, $value);
	   }
	 }
}