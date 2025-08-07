<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class UserController extends CI_Controller {

        private $message = [];

        public function __construct() {
            parent::__construct();
            $this->load->model('UserModel');
            $this->load->helper('jwt');

            $this->message = (object)validate_token();
            
            header('Content-Type: application/json');
        }

        /**
         * Lista todos os usuários
         */
        public function index() {
            if (isset($this->message->error)) {
                return $this->output
                    ->set_status_header(401)
                    ->set_output(json_encode(['error' => 'Token inválido']));
            }

            $offset = 0;
            $limit = $this->input->get('limit') ?? 10;
            $search = $this->input->get('search');
            $pagina = $this->input->get('pag') ?? 1;

            if ($pagina > 1) {
                $offset = ($pagina - 1) * $limit;
            }

            $users = $this->UserModel->getAll($limit, $offset, $search);
            
            $users['quantidade_total_registros'] = $this->UserModel->getTotalRegistros($search);
            $users['quantidade_por_pagina'] = $limit;
            $users['quantidade_paginas'] = ceil($users['quantidade_total_registros']/$limit);

            return $this->output
                ->set_status_header(200)
                ->set_output(json_encode($users));
        }

        /**
         * Visualiza um usuário
         */
        public function show($id) {
            if (isset($this->message->error)) {
                return $this->output
                    ->set_status_header(401)
                    ->set_output(json_encode(['error' => 'Token inválido']));
            }

            $user = $this->UserModel->get($id);
            if ($user) {
                return $this->output
                    ->set_status_header(200)
                    ->set_output(json_encode($user));
            }
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode(['error' => 'Usuário não encontrado']));
        }

        /**
         * Cria um usuário
         */
        public function store() {
            if (isset($this->message->error)) {
                return $this->output
                    ->set_status_header(401)
                    ->set_output(json_encode(['error' => 'Token inválido']));
            }

            $data = json_decode(file_get_contents("php://input"), true);

            $this->form_validation->set_data($data);
            $this->form_validation->set_rules('name', 'name', 'required|min_length[3]');
            $this->form_validation->set_rules('email', 'email', 'required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('password', 'password', 'required|min_length[8]');

            if ($this->form_validation->run() === FALSE) {
                return $this->output
                    ->set_status_header(400)
                    ->set_output(json_encode(['error' => $this->form_validation->error_array()]));
            }

            if (!isset($data['name'], $data['email'], $data['password'])) {
                return $this->output
                    ->set_status_header(400)
                    ->set_output(json_encode(['error' => 'Campos obrigatórios ausentes']));
            }

            $data['password'] = md5($data['password']);
            
            if ($this->UserModel->insert($data)) {
                return $this->output
                    ->set_status_header(201)
                    ->set_output(json_encode(['message' => 'Usuário criado com sucesso!']));
            }
            return $this->output
                ->set_status_header(500)
                ->set_output(json_encode(['error' => 'Erro ao criar usuário']));
        }

        /**
         * Atualiza um usuário
         */
        public function update($id) {
            if (isset($this->message->error)) {
                return $this->output
                    ->set_status_header(401)
                    ->set_output(json_encode(['error' => 'Token inválido']));
            }

            $data = json_decode(file_get_contents("php://input"), true);

            if (empty($data)) {
                return $this->output
                    ->set_status_header(400)
                    ->set_output(json_encode(['error' => 'É necessário informar ao menos 1 campo.']));
            }

            $this->form_validation->set_data($data);
            if (isset($data['name'])) {
                $this->form_validation->set_rules('name', 'name', 'required|min_length[3]');
            }
            if (isset($data['email'])) {
                $this->form_validation->set_rules('email', 'email', 'required|valid_email|callback_email_check['.$id.']');
            }
            
            if (isset($data['password'])) {
                $this->form_validation->set_rules('password', 'password', 'min_length[8]');
                $data['password'] = md5($data['password']);
            }

            if ($this->form_validation->run() === FALSE) {
                return $this->output
                    ->set_status_header(400)
                    ->set_output(json_encode(['error' => $this->form_validation->error_array()]));
            }

            if ($this->UserModel->update($id, $data)) {
                return $this->output
                    ->set_status_header(201)
                    ->set_output(json_encode(['message' => 'Usuário atualizado com sucesso']));
            }
            return $this->output
                ->set_status_header(500)
                ->set_output(json_encode(['error' => 'Erro ao atualizar usuário']));
        }

        /**
         * Remove um usuário
         */
        public function delete($id) {
            if (isset($this->message->error)) {
                return $this->output
                    ->set_status_header(401)
                    ->set_output(json_encode(['error' => 'Token inválido']));
            }

            if ($this->UserModel->delete($id)) {
                return $this->output
                    ->set_status_header(204)
                    ->set_output(json_encode(['message' => 'Usuário removido com sucesso!']));
            }
            return $this->output
                ->set_status_header(500)
                ->set_output(json_encode(['error' => 'Erro ao remover usuário!']));
        }
    }