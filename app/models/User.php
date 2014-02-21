<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

    
        public static $rules = array(
            'username' => 'sometimes|required',
            'email' => 'sometimes|required|email|unique:users',
            'password' => 'sometimes|required|min:6',
            'oldPassword' => 'sometimes|required|min:6',
            'newPassword' => 'sometimes|same:repeatPassword|required|min:6',
            'repeatPassword' => 'sometimes|same:repeatPassword|required|min:6',
            'address'=>'sometimes',
            'phone'=>'sometimes|digits_between:9,9|integer',
            'url'=>'sometimes|url',
            //'nif'=>'sometimes|regex:/^(([A-Z]\d{8})|(\d{8}[A-Z]))$/',
            //'nif'=>array('required','regex:^(([A-Z]\d{8})|(\d{8}[A-Z]))$'),
            'day'=>'sometimes|integer|max:31|required',
            'month'=>'sometimes|integer|max:12|required',
            'year'=>'sometimes|integer|digits_between:4,4|required',
            'date'=>'sometimes',
            'language'=>'sometimes|required'
        );
        
        // MODIFICADO EN CLASE
        protected $fillable = array(
            'username',
            'email',
            'date',
            'url',
            'address',
            'phone',
            'nif',
            'sex',
            'language'
        );
        // HASTA AQUI
        
        /*public static $rulesChangePassword = array(
            'newPassword' => 'required|min:6',
            'repeatPassword' => 'required|min:6'
        );*/
        
        /*public static $rulesChangeEmail = array(
            'email' => 'required|email|unique:users',
        );*/
    
        public function comment(){
        
            return $this->hasMany('Comment','id_user');
        
        }
        // Obtiene la relaccion con los comentarios pero ordenados de forma
        // Descendente
        public function commentDesc(){

            return $this->hasMany('Comment','id_user')
                    ->orderBy('created_at','DESC');

        }
        
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

}