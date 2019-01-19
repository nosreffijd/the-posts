<?php
    class User {
        private $db;

        public function __construct () {
            $this->db = new Database;
        }
        
        public function register ($data) {
            $this->db->query('INSERT INTO user (name, email, password) VALUES (:name, :email, :password)');
            // Bind values parameter defined in
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':password', $data['password']);
            //Save Data
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function findUserByEmail ($email) {
            $this->db->query('SELECT * FROM user WHERE email = :email');
            $this->db->bind(':email', $email);
            
            $row = $this->db->single();
            // Check row
            if ($this->db->rowCount() > 0) {
                return true; 
            } else {
                return false;
            }
        }
    }