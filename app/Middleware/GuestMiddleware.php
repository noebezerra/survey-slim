<?php 
	
	namespace App\Middleware;



	/**
	* 
	*/
	class GuestMiddleware extends Middleware {
		
			
		public function __invoke($request, $response, $next) {

			// check if the user is not signed in
			if (!$this->container->auth->check()) {
				// redirect
				return $response->withRedirect($this->container->router->pathFor('auth.signup'));

			}

			$response = $next($request, $response);
			return $response;
		}
	}


?>