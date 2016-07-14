<?php 

	namespace App\Controllers;


	 use App\Models\PollAnswers;
	 use App\Models\PollQuestions;


	 /**
	 *
	 */
	 class PollController extends Controller {

         public function postPollAnswers() {
         	// captura dados passados
         	$idenquete = $_GET['idenquete'];
			$qtdperguntas = $_GET['qtdperguntas'];
			$valor = $_GET['valor'];
         	$idpergunta = $_GET['idpergunta'];
         	// retira p do id passado
         	$idpergunta = explode('p', $idpergunta);
         	// pega valor da posicao 1 do array criado pelo explode
         	$idpergunta = $idpergunta[1];
			/*$valor = '[';
			for ($i=0; $i < $qtdperguntas; $i++) { 
				if ($i < $qtdperguntas - 1) {
					$valor .= '"'.$_GET['valor'][$i].'",';
				} else {
					$valor .= '"'.$_GET['valor'][$i].'"';
				}
			}
			$valor .= ']';
*/
			// verifica se contem dados - se já foi respondido
			$allpollquestions = PollAnswers::whereRaw('id_user = ? AND id_question = ?',[ $_SESSION['user'], $idpergunta])->first();
			$insert = json_decode($allpollquestions, true);
			if (empty($insert)) {
				// se não houver dados - insert
				$insert = PollAnswers::create([
					'id_user' => $_SESSION['user'],
					'id_poll' => $idenquete,
					'id_question' => $idpergunta,
					'answers' => $valor,
				]);
			} else {
				// se houver - update
				$allpollquestions->answers = $valor;
				$allpollquestions->save();
			}

			

			// echo $idenquete.' '.$qtdperguntas.' '.$idpergunta.' '.$valor;
			// echo $valor;
			// echo $qtdperguntas;
			// echo $idpergunta;
			// $userpoll = PollAnswers::where('id_user', '=', $_SESSION['user']);
			// if (!$userpoll) {
				// PollAnswers::create([
					// 'id_user' => $_SESSION['user'],
					// 'answers' => $result
				// ]);
			// 	echo "insert";
			// } else {
			// 	$userpoll->answers = $result;
			// 	echo "update";
			// }

	 	}

	 	public function getPollQuestions() {

	 		$id_poll = $_GET['idenquete'];
	 		// recebe quantidade de  questoes da enquete clicada -- 2 
	 		$qtdquestions = PollQuestions::where('id_poll', '=', $id_poll)->count();
	 		// recebe primeiro id da questao -- {"id": 5}
	 		$firstidquestion = PollQuestions::where('id_poll', '=', $id_poll)->select('id')->first()->toArray();
	 		// maximo de loop
	 		$max = ($qtdquestions + $firstidquestion['id']) - 1;
	 		// insert 
	 		for ($i = $firstidquestion['id']; $i <= $max; $i++) { 
	 			$insert = PollAnswers::whereRaw('id_user = ? and id_question = ?',[ $_SESSION['user'], $i])->first();
	 			$insert = json_decode($insert, true);
	 			if (empty($insert)) {
					// se não houver dados - insert
					$insert = PollAnswers::create([
						'id_user' => $_SESSION['user'],
						'id_question' => $i,
					]);
				}
	 		}
	 		$allpollquestions = PollQuestions::leftJoin('poll_answers', 'poll_questions.id', '=', 'poll_answers.id_question')
	 							->whereRaw('poll_questions.id_poll = ? AND poll_answers.id_user = ?', [$id_poll, $_SESSION['user']])
	 							->select('poll_questions.id', 'poll_questions.question', 'poll_answers.answers')
	 							->groupBy('poll_questions.id')
	 							->get();
			$allpollquestions = json_encode($allpollquestions, true);	

			return $allpollquestions;
	 	}
	 }


?>