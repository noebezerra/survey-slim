<?php 

	namespace App\Controllers;

	use App\Models\PollQuestions;

	use Slim\Views\Twig as View;


	/**
	* 
	*/
	class PollQuestionsController extends Controller {


		public function __construct($request, $response) {

			$allquestions = PollQuestions::all('question');
			$_context = json_decode($allquestions, true);

			return $this->view->render($response, 'home.twig', $_context);
		}
	}


?>