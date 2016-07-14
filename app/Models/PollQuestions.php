<?php 

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

	/**
	* 
	*/
	class PollQuestions extends Model {
		
		protected $table = 'poll_questions';

		public $timestamps = false;

		protected $fillable = array('id_poll', 'question');
	}



?>