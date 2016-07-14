<?php 

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

	/**
	* 
	*/
	class Polls extends Model {
		
		protected $table = 'polls';

		public $timestamps = false;

		protected $fillable = array('poll', 'description', 'img');
	}
?>