<?php 
	
	namespace App\Middleware;

	/**
	* 
	*/
	class AuthMiddleware extends Middleware {
		
			
		public function __invoke($request, $response, $next) {

			// check if the user is not signed in
			if (!$this->container->auth->check()) {
				// flash
				$this->container->flash->addMessage('error', 'Please sign in before doing that');
				// redirect
				return $response->withRedirect($this->container->router->pathFor('auth.signin'));
			}

			$response = $next($request, $response);
			return $response;
		}
	}


?>