<?php 
	
	use App\Model\PollAnswers;

	// require_once '../bootstrap/app.php';

	session_start();

	$qtdperguntas = $_GET['qtdperguntas'];
	$result = '[';
	for ($i=0; $i < $qtdperguntas; $i++) { 
		if ($i < $qtdperguntas - 1) {
			$result .= '"'.$_GET['valor'][$i].'",';
		} else {
			$result .= '"'.$_GET['valor'][$i].'"';
		}
	}
	$result .= ']';


	echo $qtdperguntas.' '.$result;
	// // $userpoll = PollAnswers::where('id_user', '=', $_SESSION['user']);
	// $userpoll = $db->table('poll_answers')->where('id_user', '=', $_SESSION['user']);
	// if (!$userpoll) {
	// 	PollAnswers::create([
	// 		'id_user' => $_SESSION['user'],
	// 		'answers' => $result
	// 	]);
	// 	echo "insert";
	// } else {
	// 	$userpoll->answers = $result;
	// 	echo "update";
	// }




?>