<?php
    class UserModel extends CI_Model {

        private $table = 'users';

        public function getAll() {
            return $this->db->select('name,email')->get($this->table)->result_array();
        }

        public function get($id) {
            return $this->db->where('id', $id)->get($this->table)->row();
        }

        public function insert($data) {
            return $this->db->insert($this->table, $data);
        }

        public function update($id, $data) {
            return $this->db->where('id', $id)->update($this->table, $data);
        }

        public function delete($id) {
            return $this->db->where('id', $id)->delete($this->table);
        }
    }