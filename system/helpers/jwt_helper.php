<?php
    require __DIR__ . '/../../vendor/autoload.php';
    use \Firebase\JWT\{JWT,Key};

    if (!function_exists('validate_token')) {
        function validate_token() {
            $CI =& get_instance();
            $headers = $CI->input->request_headers();
            $token = isset($headers['Authorization']) ? $headers['Authorization'] : null;

            if (!$token) {
                return ['error' => 'Token inválido'];
            }

            try {
                $key = "!oOJt#Qq0T|B%P$]8rNeRO_&S}b<ccn-";
                $decoded = JWT::decode($token, new Key($key, 'HS256'));
                return $decoded;
            } catch (Exception $e) {
                return ['error' => 'Token inválido'];
            }
        }
    }
