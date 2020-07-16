<?php
defined('BASEPATH') or exit('No direct script access allowed');
require(APPPATH . 'libraries/REST_Controller.php');
class RestGetController extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('BusModel', 'bm');
		$this->load->model('ChauffeurModel', 'cm');
		$this->load->model('ItineraireModel', 'im');
		$this->load->model('RamassageModel', 'rm');
	}
	
	function ramassages_get()
	{
		
		$bus = $this->rm->getRamassage();

		if ($bus) {
		 echo json_encode($this->response($bus, 200));
		} else {
			$this->response(NULL, 404);
		}
	}

	function bus_get()
	{
		
		$bus = $this->bm->getBus();

		if ($bus) {
		 echo json_encode($this->response($bus, 200));
		} else {
			$this->response(NULL, 404);
		}
	}
	function getTraceurPosition_get()
	{
		
		$bus = $this->bm->getTraceurPosition();

		if ($bus) {
		 echo json_encode($this->response($bus, 200));
		} else {
			$this->response(NULL, 404);
		}
	}


	function chauffeurs_get()
	{
		
		$bus = $this->cm->getChauffeur();

		if ($bus) {
		 echo json_encode($this->response($bus, 200));
		} else {
			$this->response(NULL, 404);
		}
	}
	function itineraires_get()
	{
		
		$bus = $this->im->getItineraire();

		if ($bus) {
		 echo json_encode($this->response($bus, 200));
		} else {
			$this->response(NULL, 404);
		}
	}
	function itineramassages_get()
	{
		
		$bus = $this->im->getItineRamassages();

		if ($bus) {
		 echo json_encode($this->response($bus, 200));
		} else {
			$this->response(NULL, 404);
		}
	}


	function historiques_get($numero)
	{
		
		$this->load->model('HistoriqueModel', 'hm');
		$bus = $this->hm->getHistorique($numero);

		if ($bus) {
		 echo json_encode($this->response($bus, 200));
		} else {
			$this->response(NULL, 404);
		}
	}
}
