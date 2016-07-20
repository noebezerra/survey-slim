<?php 
	
	namespace App\Middleware;

	use App\Models\User;
	
	/**
	* 
	*/
	class AdmMiddleware extends Middleware {
		
			
		public function __invoke($request, $response, $next) {

			// check if the user is not signed in
			if (!$this->container->auth->check()) {
				// flash
				$this->container->flash->addMessage('error', 'Please sign in before doing that');
				// redirect
				return $response->withRedirect($this->container->router->pathFor('auth.signup'));
			} else {
				// verifica  se usuário tem permissão
				$admuser = User::find($_SESSION['user'])->where('id_level_user', '=', 2);
				// se true
				if ($admuser) {
					$response = $next($request, $response);
					return $response;
				}

				// flash
				$this->container->flash->addMessage('error', 'Please sign in before doing that');
				// redirect
				return $response->withRedirect($this->container->router->pathFor('auth.signup'));

			}
		}
	}


?>