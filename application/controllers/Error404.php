<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Error404 extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        return $this->output
            ->set_status_header(404)
            ->set_output(json_encode(['error' => 'Acesso negado!']));
    }
}