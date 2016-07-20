<?php 

	namespace App\Controllers\Auth;

	use App\Models\User;
	use App\Models\PollQuestions;
	use App\Models\PollAnswers;

	use App\Controllers\Controller;

	use Respect\Validation\Validator as v;

	/**
	* 
	*/
	class AuthController extends Controller {
		

		// poll
		public function getPoll($request, $response) {
			
			// verifica id do usuário
			$poll = User::find($_SESSION['user']);
			// armazena flag poll
			$poll = $poll->poll;
			// if flag poll 0
			if ($poll == 0) {
				
				$allpoll = PollQuestions::all('question');
				$data = json_decode($allpoll, true);

				// var_dump($poll);
				
				$this->flash->addMessage('poll', $poll);
			}
		}

		public function getSignOut($request, $response) {
			
			// sign out
			$this->auth->logout();
			// redirect
			return $response->withRedirect($this->router->pathFor('home'));
		}		

		public function getSignIn($request, $response) {
			
			return $this->view->render($response, 'auth/signin.twig');
		}

		public function postSignIn($request, $response) {
			
			$auth = $this->auth->attempt(
				$request->getParam('email'),
				$request->getParam('password')
			);

			if (!$auth) {

				// message to error sign in
				$this->flash->addMessage('error', 'Could not sign you in with those details');

				return $response->withRedirect($this->router->pathFor('auth.signup'));
			}


			// chama func poll
			$this->getPoll();

			return $response->withRedirect($this->router->pathFor('home'));
		}
	
		public function getSignUp($request, $response) {


			return $this->view->render($response, 'auth/signup.twig');
		}

		public function postSignUp($request, $response) {

			$validation = $this->validator->validate($request, [
				'name' => v::notEmpty()->alpha(),
				'email' => v::noWhitespace()->notEmpty()->email()->EmailAvailable(),
				'password' => v::noWhitespace()->notEmpty(),
			]);

			if ($validation->failed()) {
				return $response->withRedirect($this->router->pathFor('auth.signup'));
			}

			$user = User::create([
				'name' => $request->getParam('name'),
				'email' => $request->getParam('email'),
				'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT),
	
			]);

			// message to welcome
			$this->flash->addMessage('info', 'You have been signed up!');

			$this->auth->attempt($user->email, $request->getParam('password'));

			// chama func poll
			$this->getPoll();

			return $response->withRedirect($this->router->pathFor('home'));
		}


	}


?>