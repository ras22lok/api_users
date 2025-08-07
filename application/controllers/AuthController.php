<?php
    require __DIR__ . '/../../vendor/autoload.php';
    use \Firebase\JWT\JWT;

    defined('BASEPATH') OR exit('No direct script access allowed');
    

    class AuthController extends CI_Controller {

        private $key = "!oOJt#Qq0T|B%P$]8rNeRO_&S}b<ccn-";

        public function __construct() {
            parent::__construct();
            $this->load->model('UserModel');
            header('Content-Type: application/json');
        }

        public function login() {
            $data = json_decode(file_get_contents("php://input"), true);

            if (!isset($data['email'], $data['password'])) {
                return $this->output
                    ->set_status_header(400)
                    ->set_output(json_encode(['error' => 'E-mail ou password inválida!']));
            }

            $data['password'] = md5($data['password']);
            $user = $this->UserModel->getByEmail($data['email']);
            
            // if ($user && password_verify($data['password'], $user->password)) {
            if ($user && ($data['password'] === $user->password)) {
                $payload = [
                    'id' => $user->id,
                    'email' => $user->email,
                    'iat' => time(),
                    'exp' => time() + (60 * 60) // 1 hora
                ];

                // print_r(__DIR__);die;

                $token = JWT::encode($payload, $this->key, 'HS256');

                return $this->output
                    ->set_status_header(200)
                    ->set_output(json_encode(['token' => $token]));
            }
            return $this->output
                ->set_status_header(401)
                ->set_output(json_encode(['error' => 'E-mail ou password inválida!']));
        }

        public function validateToken() {
            $headers = $this->input->request_headers();
            $token = isset($headers['Authorization']) ? $headers['Authorization'] : '';

            if (!$token) {
                return $this->output
                    ->set_status_header(401)
                    ->set_output(json_encode(['error' => 'Token inválido!']));
            }

            try {
                $decoded = JWT::decode($token, $this->key, ['HS256']);
                echo json_encode(['valid' => true, 'data' => $decoded]);
            } catch (Exception $e) {
                return $this->output
                    ->set_status_header(401)
                    ->set_output(json_encode(['error' => 'Token inválido!']));
            }
        }
    }
