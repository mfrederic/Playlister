<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {

	public function index() {
		$this->load->helper('form', 'security', 'directory_helper');

		$this->data['size_unity'] = 'Mo';
		$this->data['current_size']	= get_media_directory_size();
		$this->data['size_limit'] = $this->config->item('size_limit');
		if($this->data['current_size'] < 1000)
			$this->data['size_limit'] = $this->data['size_limit'] * 1000;
		else {
			$this->data['current_size'] = $this->data['current_size'] / 1000;
			$this->data['size_unity'] = 'Go';
		}
		
		$this->render('upload/index', $this->data);
	}

	public function upload_files() {
		$this->load->helper('form', 'security', 'directory_helper');
		$this->output->set_header('Content-type: application/json');
		$this->load->library('Getid3');
		$this->load->library('Fileupload');
		$this->fileupload->init(array(
			'path_to_upload' => get_music_path('')
		));

		if(!empty($_FILES)) {
			$brut_filename = $_FILES['file']['name'];
			$extension = substr($brut_filename, -3);
			$filename = substr($brut_filename, 0, -4);
			$sanitize = strtolower(url_title($filename));

			$all_informations = $this->getid3->analyze($_FILES['file']['tmp_name']);
			$comments = $all_informations['id3v2']['comments'];

			$music_numero = isset($comments['track_number']) ? $comments['track_number'][0] : '';
			$music_title = isset($comments['title']) ? $comments['title'][0] : '';
			$music_band = isset($comments['band']) ? $comments['band'][0] : '';
			$music_year = isset($comments['year']) ? $comments['year'][0] : '';

			$upload_succeed = $this->fileupload->perform_upload(array(
				'new_filename' => "$sanitize.$extension"
			));

			if($upload_succeed === 0) {
				$this->load->model('Music_model');
				$inserted = $this->Music_model->add_music(array(
					'music_numero'	 	=> $music_numero,
					'music_title' 		=> $music_title,
					'music_band' 		=> $music_band,
					'music_year' 		=> $music_year,
					'music_url' 		=> "$sanitize.$extension",
					'music_add' 		=> date('Y-m-d G:i:s'),
					'music_adder_id' 	=> $this->session->userdata('user_id'),
					'music_poster' 		=> get_music_poster($music_band, $music_title)
				));

				if($inserted > 0) {
					$values = $this->Music_model->get($inserted);
					$values->token = $this->security->get_csrf_hash();
					echo json_encode(array(
						'response' => true,
						'content' => $this->partial('music/update_music', $values)
					));
				} else {
					unlink(get_music_path("$sanitize.$extension"));
					echo json_encode(array(
						'response' => false,
						'content' => 'Une erreur est survenue lors de l\'enregistrement du fichier dans la base de données'
					));
				}
			} else {
				echo json_encode(array(
					'response' => false,
					'content' => $this->fileupload->get_verbose_error()
				));
			}
		}
	}

	public function check() {
		if($this->input->get('json') == null)
			return false;

		$brut_filename = $this->input->get('filename');

		if(empty($brut_filename)) {
			$response['response'] = false;
			$response['content'] = 'Le fichier n\'a pas un nom valide !';
		} else {
			$extension = substr($brut_filename, -3);
			$filename = substr($brut_filename, 0, -4);
			$sanitize = strtolower(url_title($filename));

			$this->load->model('Music_model');
			if(!empty($this->Music_model->get_by_url($sanitize.'.'.$extension))) {
				$response['response'] = false;
				$response['content'] = 'Le fichier ' . $sanitize.'.'.$extension . ' existe déjà !';
			} else {
				$response = array(
					'response' => true,
					'content' => $sanitize.'.'.$extension
				);
			}
		}

		$this->output->set_header('Content-type: application/json');
		echo json_encode($response);
	}

}