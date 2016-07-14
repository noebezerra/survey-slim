<?php 

	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Model;

	/**
	* 
	*/
	class PollAnswers extends Model {
		
		protected $table = 'poll_answers';

		public $timestamps = false;

		protected $fillable = array('id_user', 'id_question', 'answers');

	}


?>