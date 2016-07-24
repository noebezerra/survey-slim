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
				$this->container->flash->addMessage('error', 'Por favor entre com sua conta.');
				// redirect
				return $response->withRedirect($this->container->router->pathFor('auth.signup'));
			} else {
				// verifica  se usuário tem permissão
				$admuser = User::where('id', '=', $_SESSION['user'])->select('id_level_user')->get();
				$admuser = json_decode($admuser, true);
				// se for adm 2 
				if ($admuser[0]['id_level_user'] == 2) {
					$response = $next($request, $response);
					return $response;
				}

				//flash
				$this->container->flash->addMessage('error', 'Você não pode viajar entre as galáxias!');
				// redirect
				return $response->withRedirect($this->container->router->pathFor('home'));

			}
		}
	}


?>