<?php 
	
	use App\Middleware\AuthMiddleware;
	use App\Middleware\GuestMiddleware;

	use App\Models\Poll;


	$app->any('/poll/pollanswers', 'PollController:postPollAnswers');
	$app->any('/poll/pollquestions', 'PollController:getPollQuestions');
	
	$app->group('', function() {

		$this->get('/', 'HomeController:index')->setName('home');

	})->add(new GuestMiddleware($container));
	
	$app->get('/auth/signup', 'AuthController:getSignUp')->setName('auth.signup');
	$app->post('/auth/signup', 'AuthController:postSignUp');
	
	$app->get('/auth/signin', 'AuthController:getSignIn')->setName('auth.signin');
	$app->post('/auth/signin', 'AuthController:postSignIn');

	$app->get('/adm', 'AdmPollController:index');	
	$app->any('/adm/pollaccordion', 'AdmPollController:getQuestAccordion');
	$app->any('/adm/pollaccordion/linepct', 'AdmPollController:getPctAccordion');
	$app->any('/adm/newsurvey', 'AdmPollController:postNewSurvey');

	$app->group('', function() {
		
		$this->get('/auth/signout', 'AuthController:getSignOut')->setName('auth.signout');

		$this->get('/auth/password/change', 'PasswordController:getChangePassword')->setName('auth.password.change');
		$this->post('/auth/password/change', 'PasswordController:postChangePassword');

	})->add(new AuthMiddleware($container));


?>