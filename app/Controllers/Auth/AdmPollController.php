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
						->where('poll_questions.id_poll', $idaccordion)->distinct('poll_answers.id_user')->count('poll_answers.id_user');
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

			if ((!empty($_GET['poll'])) && (!empty($_GET['valquestcreate'][0]))) {
				$pollcreate = Polls::create([
					'poll' => $poll,
					'description' => $description,
					'img' => $dirimg,
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
	}


?>