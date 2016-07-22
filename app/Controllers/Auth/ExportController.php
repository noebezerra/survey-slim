<?php 

	namespace App\Controllers\Auth;

	use App\Models\Polls;
	use App\Models\PollQuestions;
	use App\Models\PollAnswers;

	use App\Controllers\Controller;

	
	// require_once '../../../public/index.php';
	/**
	* 
	*/
	class ExportController extends Controller {
		

		// poll
		public function postExcel() {
			
			$idenquete = end(explode('excel', $_GET['excel']));
			// $objPHPExcel = new PHPExcel();
			// $objPHPExcel->getActiveSheet()->setCellValue('A1', 'hello world!');
			// $objPHPExcel->getActiveSheet()->setTitle('Chesse1');
			// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			// header('Content-Disposition: attachment;filename="helloworld.xlsx"');
			// header('Cache-Control: max-age=0');
			// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			// $objWriter->save('php://output');

			/* Alternativa enquanto não sei usar PHPExcel */
			// busca dados da enquete
			$poll = Polls::find($idenquete);
			$html = '<table>
						<caption>Impresso no dia: '.date('d-m-Y').'</caption>
						<thead>
							<tr><td></td></tr>
							<tr><th bgcolor="#F9F9A3">Enquete:'.$poll->poll.'</th></tr>
							<tr><th bgcolor="#F9F9A3">Decricao:'.$poll->description.'</th></tr>
							<tr><th bgcolor="#F9F9A3">Dta Inicio:'.$poll->dta_start.'</th></tr>
							<tr><th bgcolor="#F9F9A3">Dta Fim:'.$poll->dta_finish.'</th></tr>
							<tr><td></td></tr>
						</thead>';
			$html .= '<tbody>';
			// busca questoes
			$pollQuestions = PollQuestions::where('id_poll', '=', $idenquete)->get();
			$pollQuestions = json_decode($pollQuestions, true);
			foreach ($pollQuestions as $key => $valuequestion) {
				$html .= '<tr bgcolor="#a5d1fc"><td>'.$valuequestion['question'].'</td></tr>';
				// busca respostas
					
				// quantidade de usuario que repondeu determinada enquete
				$qtduser = PollAnswers::join('poll_questions', 'poll_questions.id', '=', 'poll_answers.id_question')
							->whereRaw('poll_questions.id_poll = ? AND poll_answers.answers != ?', [ $idenquete, 0 ])->distinct('poll_answers.id_user')->count('poll_answers.id_user');
				// quantidade de respostas de estrelas
				// 5 star
				$qtdfivestar = PollAnswers::join('poll_questions', 'poll_questions.id', '=', 'poll_answers.id_question')
							->whereRaw('poll_questions.id_poll = ? AND poll_answers.id_question = ? AND poll_answers.answers = ?', [ $idenquete, $valuequestion['id'], 5 ])
							->count();
				// 4 star
				$qtdfourstar = PollAnswers::join('poll_questions', 'poll_questions.id', '=', 'poll_answers.id_question')
							->whereRaw('poll_questions.id_poll = ? AND poll_answers.id_question = ? AND poll_answers.answers = ?', [ $idenquete, $valuequestion['id'], 4 ])
							->count();
				// 3 star
				$qtdthreestar = PollAnswers::join('poll_questions', 'poll_questions.id', '=', 'poll_answers.id_question')
							->whereRaw('poll_questions.id_poll = ? AND poll_answers.id_question = ? AND poll_answers.answers = ?', [ $idenquete, $valuequestion['id'], 3 ])
							->count(); 
				// 2 star
				$qtdtwostar = PollAnswers::join('poll_questions', 'poll_questions.id', '=', 'poll_answers.id_question')
							->whereRaw('poll_questions.id_poll = ? AND poll_answers.id_question = ? AND poll_answers.answers = ?', [ $idenquete, $valuequestion['id'], 2 ])
							->count();
				// 1 star
				$qtdonestar = PollAnswers::join('poll_questions', 'poll_questions.id', '=', 'poll_answers.id_question')
							->whereRaw('poll_questions.id_poll = ? AND poll_answers.id_question = ? AND poll_answers.answers = ?', [ $idenquete, $valuequestion['id'], 1 ])
							->count();
				// calculation
				$calfivestar  = ($qtdfivestar * 100)  / $qtduser;
				$calfourstar  = ($qtdfourstar * 100)  / $qtduser;
				$calthreestar = ($qtdthreestar * 100) / $qtduser;
				$caltwostar   = ($qtdtwostar * 100)   / $qtduser;
				$calonestar   = ($qtdonestar * 100)   / $qtduser;

				$html .= '<tr>
							<td>'.$calfivestar.'% - 5 Estrelas</td>
							<td>'.$calfourstar.'% - 4 Estrelas</td>
							<td>'.$calthreestar.'% - 3 Estrelas</td>
							<td>'.$caltwostar.'% - 2 Estrelas</td>
							<td>'.$calonestar.'% - 1 Estrelas</td>
						</tr>';
			}
			$html .= '</tbody>';

			// Determina que o arquivo é uma planilha do Excel
			header("Content-type: application/vnd.ms-excel");   
			// Força o download do arquivo
			header("Content-type: application/force-download");  
			// Seta o nome do arquivo
			header("Content-Disposition: attachment; filename=Survey".$idenquete.".xls");
			header("Pragma: no-cache");
			// Imprime o conteúdo da nossa tabela no arquivo que será gerado
			echo $html;
		}
	}


?>