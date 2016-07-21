<?php 

	namespace App\Controllers\Auth;

	use App\Controllers\Controller;
	
	use App\Models\Polls;
	use App\Models\PollQuestions;
	use App\Models\PollAnswers;

	use Slim\Views\Twig as View;


	/**
	* 
	*/
	class AdmPollController extends Controller {

		public function Index($request, $response) {
			// lista todas enquetes
			$allpolls = Polls::all();
			$_context = json_decode($allpolls, true);

			return $this->view->render($response, 'auth/admpoll.twig', $_context);
		}

		public function getSurvey() {
			//lista todas enquetes
			$allpolls = Polls::all();

			echo $allpolls;
		}

		public function getQuestAccordion() {
			// recebe o id do accordion clicado
			$idaccordion = $_GET['idaccordion'];
			$idaccordion = explode('accordion', $idaccordion);
			$idaccordion = $idaccordion[1];
			
			// quantidade de questoes
			$qtdquestion = PollQuestions::where('id_poll', $idaccordion)->get();
			$qtdquestion = json_encode($qtdquestion, true);
			
			return $qtdquestion;
		}

		public function getPctAccordion() {

			$idquestion = $_GET['idquestion'];
			// recebe o id do accordion clicado
			$idaccordion = $_GET['idaccordion'];
			$idaccordion = explode('accordion', $idaccordion);
			$idaccordion = $idaccordion[1];

			// quantidade de usuario que repondeu determinada enquete
			$qtduser = PollAnswers::join('poll_questions', 'poll_questions.id', '=', 'poll_answers.id_question')
						->whereRaw('poll_questions.id_poll = ? AND poll_answers.answers != ?', [ $idaccordion, 0 ])->distinct('poll_answers.id_user')->count('poll_answers.id_user');
			// quantidade de respostas de estrelas
			// 5 star
			$qtdfivestar = PollAnswers::join('poll_questions', 'poll_questions.id', '=', 'poll_answers.id_question')
						->whereRaw('poll_questions.id_poll = ? AND poll_answers.id_question = ? AND poll_answers.answers = ?', [ $idaccordion, $idquestion, 5 ])
						->count();
			// 4 star
			$qtdfourstar = PollAnswers::join('poll_questions', 'poll_questions.id', '=', 'poll_answers.id_question')
						->whereRaw('poll_questions.id_poll = ? AND poll_answers.id_question = ? AND poll_answers.answers = ?', [ $idaccordion, $idquestion, 4 ])
						->count();
			// 3 star
			$qtdthreestar = PollAnswers::join('poll_questions', 'poll_questions.id', '=', 'poll_answers.id_question')
						->whereRaw('poll_questions.id_poll = ? AND poll_answers.id_question = ? AND poll_answers.answers = ?', [ $idaccordion, $idquestion, 3 ])
						->count(); 
			// 2 star
			$qtdtwostar = PollAnswers::join('poll_questions', 'poll_questions.id', '=', 'poll_answers.id_question')
						->whereRaw('poll_questions.id_poll = ? AND poll_answers.id_question = ? AND poll_answers.answers = ?', [ $idaccordion, $idquestion, 2 ])
						->count();
			// 1 star
			$qtdonestar = PollAnswers::join('poll_questions', 'poll_questions.id', '=', 'poll_answers.id_question')
						->whereRaw('poll_questions.id_poll = ? AND poll_answers.id_question = ? AND poll_answers.answers = ?', [ $idaccordion, $idquestion, 1 ])
						->count();
			// calculation
			$calfivestar  = ($qtdfivestar * 100)  / $qtduser;
			$calfourstar  = ($qtdfourstar * 100)  / $qtduser;
			$calthreestar = ($qtdthreestar * 100) / $qtduser;
			$caltwostar   = ($qtdtwostar * 100)   / $qtduser;
			$calonestar   = ($qtdonestar * 100)   / $qtduser;
			// group all in array
			$jsoncalculation =  '['.$calonestar.', '.$caltwostar.', '.$calthreestar.', '.$calfourstar.', '.$calfivestar.']';

			return $jsoncalculation;
		}

		public function postNewSurvey() {
			$qtdquestcreate = $_GET['qtdquestcreate'];
			$poll = $_GET['poll'];
			$description = $_GET['description'];
			$questions = $_GET['valquestcreate'];
			$dirimg = $_GET['dirimg'];
			$dta_start = $_GET['dta_start'];
			$dta_finish = $_GET['dta_finish'];

			if ( (!empty($_GET['poll'])) && (!empty($_GET['valquestcreate'][0])) && (!empty($_GET['dta_start'])) && (!empty($_GET['dta_finish'])) ) {
				$pollcreate = Polls::create([
					'poll' => $poll,
					'description' => $description,
					'img' => $dirimg,
					'dta_start' => $dta_start,
					'dta_finish' => $dta_finish,
				]);
				if ($pollcreate) {
					for ($i=0; $i < $qtdquestcreate; $i++) { 
						$pollquestionscreate = PollQuestions::create([
							'id_poll' => $pollcreate->id,
							'question' => $_GET['valquestcreate'][$i],
						]);
					}
				}
			}
		}

		public function getEditSurvey() {
			try {
				$return = false;
				// recupera id da enquete
				$idenquete = $_GET['idenquete'];
				$idenquete = end(explode('edit', $idenquete));
				// recupera todos id das questões desta enquete
				$idQuestions = PollQuestions::where('id_poll', '=', $idenquete)->select('id')->get();
				// verifica se possui respostas dos usuários desta enquete
				foreach ($idQuestions as $key => $value) {
					$editAnswers = PollAnswers::where('id_question', '=', $value['id'])->first();
					if ($editAnswers) {
						$editDados = Polls::select(array('description', 'img', 'dta_finish'))->find($idenquete);
						$return = true;
						break;
					}
					$editDados = Polls::find($idenquete);
					$editDadosQuestions = PollQuestions::where('id_poll', '=', $idenquete)->get();
				}
				$editDados = json_decode($editDados, true);
				$editDadosQuestions = json_decode($editDadosQuestions, true);
				// print_r( $editDadosQuestions );
				$editDados['return'] = $return;
				$editDados['questions'] = $editDadosQuestions;
				$editDados = json_encode($editDados, true);
				return $editDados;
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}

		public function postEditSurvey() {
			try {
				$return = false;
				// recupera id da enquete
				$idenquete = $_GET['idenquete'];
				$idenquete = end(explode('edit', $idenquete));
				// recupera todos id das questões desta enquete
				$idQuestions = PollQuestions::where('id_poll', '=', $idenquete)->select('id')->get();
				// verifica se possui respostas dos usuários desta enquete
				foreach ($idQuestions as $key => $value) {
					$editAnswers = PollAnswers::where('id_question', '=', $value['id'])->first();
					if ($editAnswers) {
						$editDados = Polls::select(array('description', 'img', 'dta_finish'))->find($idenquete);
						$return = true;
						break;
					}
					$editDados = Polls::find($idenquete);
					$editDadosQuestions = PollQuestions::where('id_poll', '=', $idenquete)->get();
				}
				$editDados = json_decode($editDados, true);
				$editDadosQuestions = json_decode($editDadosQuestions, true);
				// print_r( $editDadosQuestions );
				$editDados['return'] = $return;
				$editDados['questions'] = $editDadosQuestions;
				$editDados = json_encode($editDados, true);
				return $editDados;
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}

		public function postDeleteSurvey() {
			try {
				// recupera id da enquete
				$idenquete = $_GET['idenquete'];
				$idenquete = end(explode('delete', $idenquete));
				// recupera todos id das questões desta enquete
				$idQuestions = PollQuestions::where('id_poll', '=', $idenquete)->select('id')->get();
				// deleta respostas dos usuários desta enquete
				foreach ($idQuestions as $key => $value) {
					$delAnswers = PollAnswers::where('id_question', '=', $value['id'])->delete();
				}
				// deleta questoes desta enquete
				$delQuestions = PollQuestions::where('id_poll', '=', $idenquete)->delete();
				// deleta enquete
				$delPoll = Polls::destroy($idenquete);
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}
	}


?>