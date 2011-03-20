<?php

class Animal extends Controller {

	function Animal()
	{
		parent::Controller();
		$this->output->enable_profiler(FALSE);	
	}
	
	function index() {
		if(!$this->session->userdata("user")) {
			redirect("accueil/index", "refresh");
		}
		
		$data['titleComplement'] = 'Profil';
		
		$this->load->view('header', $data);
		$this->load->view('user/index', $data);
		$this->load->view('footer');
	}
	
	function offer() {
		if(!$this->session->userdata("user")) {
			redirect("user/login", "refresh");
		}
		
		$this->form_validation->set_message('required', 'Le champs "%s" est n&eacute;cessaire. Veuillez le compl&eacute;ter.');

		$this->form_validation->set_rules('email', 'Adresse Mail', 'trim|required|xss_clean');
		
		$this->form_validation->set_rules('name', 'Nom', 'trim|required|xss_clean');
		$this->form_validation->set_rules('race', 'Race', 'trim|required|xss_clean');
		$this->form_validation->set_rules('bloodgroup', 'Groupe Sanguin', 'trim|required|xss_clean');
		$this->form_validation->set_rules('color', 'Couleur', 'trim|required|xss_clean'); 
		$this->form_validation->set_rules('pedigree', 'Pedigree', 'trim|required|xss_clean');
		
		
		if ($this->form_validation->run() == FALSE) {
			$data['titleComplement'] = 'Ajouter un animal';
		
			$data['species'] = $this->Species->getAll();
	
			$this->load->view('header', $data);
			$this->load->view('animal/offer', $data);
			$this->load->view('footer');		
		} else {
			$validation_date=checkdate($this->input->post('birth_jj'), $this->input->post('birth_mm'), $this->input->post('birth_aaaa'));
			if ($validation_date==false) {
				$data['titleComplement'] = 'Ajouter un animal';
				
				$data['connexion_error'] = "La date de naissance n'est pas une date valide. Veuillez la modifier.";
				
				$data['species'] = $this->Species->getAll();
	
				$this->load->view('header', $data);
				$this->load->view('animal/offer', $data);
				$this->load->view('footer');
			} else {
				if($this->input->post('vaccines') == '') {
					$vaccines = "<i>Aucune indication sur les vaccins.</i>";
				} else {
					$vaccines = $this->input->post('vaccines');
				}
			
				if($this->input->post('appearance') == '') {
					$appearance = "<i>Aucune particularité physique.</i>";
				} else {
					$appearance = $this->input->post('appearance');
				}

				$species = $this->Species->get($this->input->post('species'));
			
				$animalId = $this->Animals->create(
					$this->input->post('name'),
					$species,
					$this->input->post('race'),
					$this->input->post('birth_aaaa').'/'.$this->input->post('birth_mm').'/'.$this->input->post('birth_jj'),
					$this->input->post('sex'),
					$this->input->post('bloodgroup'),
					$vaccines,
					$this->input->post('color'),
					$appearance,
					$this->input->post('pedigree'),
					null,
					null,
				);
				
				$animal = $this->Animals->get($animalId);
				
				array_push($this->session->userdata("user")->animals, $animal);
				
				$this->Users->update($this->session->userdata("user")->animals, $this->session->userdata("user")->id);
				
				$this->load->view('header', $data);
				$this->load->view('animal/addingok');
				$this->load->view('footer');
			}
		}
	}
}

/* End of file user.php */
/* Location: ./system/application/controllers/user.php */