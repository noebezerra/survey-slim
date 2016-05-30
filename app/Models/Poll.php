<?php 

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

	/**
	* 
	*/
	class Poll extends Model {
		
		protected $table = 'poll_questions';

		protected $fillable = array('question');



		// function __construct(argument)
		// {
		// 	# code...
		// }
	}



?>