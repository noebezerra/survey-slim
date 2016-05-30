<?php 

	namespace App\Controllers;


	 use App\Models\PollAnswers;

	 session_start();


	 /**
	 *
	 */
	 class Poll extends Controller {

         public function poll() {

			$qtdperguntas = $_GET['qtdperguntas'];
			$result = '[';
			for ($i=0; $i < $qtdperguntas; $i++) { 
				if ($i < $qtdperguntas - 1) {
					$result .= '"'.$_GET['valor'][$i].'",';
				} else {
					$result .= '"'.$_GET['valor'][$i].'"';
				}
			}
			$result .= ']';

			$userpoll = PollAnswers::where('id_user', '=', $_SESSION['user']);
			if (!$userpoll) {
				PollAnswers::create([
					'id_user' => $_SESSION['user'],
					'answers' => $result
				]);
				echo "insert";
			} else {
				$userpoll->answers = $result;
				echo "update";
			}

	 	}
	 }


?>