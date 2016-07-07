<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class FileUpload {
		private $path_to_upload = null;
		private $file_max_size = 15; # Taille en mega-octets
		private $file;
		private $filename;
		private $error_code;

		public function __construct($args=array()) {
			$this->set_args($args);
		}

		public function init($args=array()) {
			$this->set_args($args);
		}

		private function set_args($args) {
			$this->error_code = null;
			$this->file = isset(array_values($_FILES)[0]) ? array_values($_FILES)[0] : array();
			if(isset($args['path_to_upload']))
				$this->path_to_upload = $args['path_to_upload'];
			if(isset($args['file_max_size']))
				$this->file_max_size = $args['file_max_size'];
		}

		public function check_file() {
			if($this->file['error'] !== 0)
				$this->error_code = $this->file['error'];
			elseif($this->file['size'] / (1024 * 1024) > $this->file_max_size)
				$this->error_code = 1;
		}

		public function perform_upload($args=array()) {
			$this->check_file();
			$this->filename = isset($args['new_filename']) ? $args['new_filename'] : $this->file['name'];
			if(is_null($this->path_to_upload))
				$this->error_code = 9;
			if(file_exists($this->path_to_upload.$this->filename))
				$this->error_code = 10;
			if(is_null($this->error_code)) {
				if(move_uploaded_file($this->file['tmp_name'], $this->path_to_upload.$this->filename))
					return 0;
				else
					return 7;
			} else 
				return $this->error_code;
		}

		public function get_verbose_error() {
			switch ($this->error_code) {
				case 0: $error = "Pas d'erreur durant le téléchargement";
					break;
				case 1: $error = "Fichier trop lourd par rapport à la limite du serveur";
					break;
				case 2: $error = "Fichier trop lourd par rapport à la limite du formulaire";
					break;
				case 3: $error = "Le fichier a été partiellement téléchargé";
					break;
				case 4: $error = "Aucun fichier n'a été téléchargé";
					break;
				case 6: $error = "Un dossier temporaire est manquant";
					break;
				case 7: $error = "Echec lors de l'enregistrement du fichier sur le serveur";
					break;
				case 8: $error = "Erreur d'upload dû a une extension corompue du serveur";
					break;
				case 9: $error = "Vous n'avez pas spécifié de chemin d'enregistrement";
					break;
				case 10: $error = "Le fichier '{$this->file['name']}' existe déjà sur le serveur";
					break;
				default: $error = "Erreur inconnue lors du téléchargement";
					break;
			}
			return $error;
		}

		public function datas() {
			return $this->file;
		}

	}

?>