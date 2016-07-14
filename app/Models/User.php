<?php 

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

	/**
	* 
	*/
	class User extends Model {
		
		protected $table = 'users';

		protected $fillable = array('name', 'email', 'password');

		
		public function setPoll($poll) {
			$this->update([
				'poll' => $poll
			]);
		}

		public function setPassword($password) {
			$this->update([
				'password' => password_hash($password, PASSWORD_DEFAULT)
			]);
		}



		// function __construct(argument)
		// {
		// 	# code...
		// }
	}



?>