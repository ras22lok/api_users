<?php
    class UserModel extends CI_Model {

        private $table = 'users';

        public function getAll($limit, $offset, $search = null) {
            if ($search) {
                $this->db->like('name', $search);
                $this->db->or_like('email', $search);
            }

            return $this->db->select('id, name, email')
                            ->limit($limit)
                            ->offset($offset)
                            ->get($this->table)
                            ->result_array();
        }

        public function getTotalRegistros($search = null) {
            if ($search) {
                $this->db->like('name', $search);
                $this->db->or_like('email', $search);
            }
            return $this->db->select('id')->count_all($this->table);
        }

        public function get($id) {
            return $this->db->where('id', $id)->get($this->table)->row();
        }

        public function getByEmail($email) {
            return $this->db->select('id, email, password')->where('email', $email)->get($this->table)->row();
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