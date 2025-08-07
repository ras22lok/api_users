<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class UserController extends CI_Controller {

        public $user_model;

        public function __construct() {
            parent::__construct();
            $this->load->model('UserModel');
            header('Content-Type: application/json');
        }

        public function index() {
            $users = $this->UserModel->getAll();

            return $this->output
                ->set_status_header(200)
                ->set_output(json_encode($users));
        }

        public function show($id) {
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

        public function store() {
            $data = json_decode(file_get_contents("php://input"), true);

            if (!isset($data['name'], $data['email'], $data['password'])) {
                // http_response_code(400);
                // echo json_encode(['error' => 'Campos obrigatórios ausentes']);
                // return;

                return $this->output
                    ->set_status_header(400)
                    ->set_output(json_encode(['error' => 'Campos obrigatórios ausentes']));
            }

            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

            if ($this->UserModel->insert($data)) {
                return $this->output
                    ->set_status_header(201)
                    ->set_output(json_encode(['message' => 'Usuário criado com sucesso!']));
            }
            return $this->output
                ->set_status_header(500)
                ->set_output(json_encode(['error' => 'Erro ao criar usuário']));
        }

        public function update($id) {
            $data = json_decode(file_get_contents("php://input"), true);

            if (!isset($data['name'], $data['email'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Campos obrigatórios ausentes']);
                return;
            }

            if (!empty($data['password'])) {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
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

        public function delete($id) {
            if ($this->UserModel->delete($id)) {
                return $this->output
                    ->set_status_header(201)
                    ->set_output(json_encode(['message' => 'Usuário removido com sucesso!']));
            }
            http_response_code(500);
            return $this->output
                ->set_status_header(500)
                ->set_output(json_encode(['error' => 'Erro ao remover usuário!']));
        }
    }