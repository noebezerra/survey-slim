<?php 

	namespace App\Controllers;


	use App\Models\User;
	use App\Models\Poll;

	use Slim\Views\Twig as View;


	/**
	* 
	*/
	class HomeController extends Controller {


		public function Index($request, $response) {

			$allpoll = Poll::all('question');
			$_context = json_decode($allpoll, true);

			return $this->view->render($response, 'home.twig', $_context);


			function get_post_action($name){

				$params = func_get_args();

					foreach ($params as $name) {
					if (isset($_GET[$name])) {
					    return $name;
					}
				}
			}

			// verifica qual botao clicou -- ainda nao implementado 
			switch (get_post_action('no', 'save')) {
			    case 'no':
			    	User::find($_SESSION['user']);
			        $user->poll = 1;
			    break;
			    case 'save':
			        // save - update poll respondido and questions save

			    break;
			}

		}

		// public function poll($request, $response) {
		// 	return $this->view->render($response, 'poll.twig');
		// }



	




	}


?>