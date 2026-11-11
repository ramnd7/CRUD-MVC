<?php

class Kategori_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAll()
    {
        $this->db->query('SELECT * FROM kategori ORDER BY id_kategori ASC');
        return $this->db->resultSet();
    }

    public function getById($id)
    {
        $this->db->query('SELECT * FROM kategori WHERE id_kategori = :id');
        $this->db->bind(':id', (int) $id, PDO::PARAM_INT);
        return $this->db->single();
    }

    public function create($name)
    {
        $this->db->query('INSERT INTO kategori (nama_kategori) VALUES (:name)');
        $this->db->bind(':name', $name);
        return $this->db->execute();
    }

    public function update($id, $name)
    {
        $this->db->query('UPDATE kategori SET nama_kategori = :name WHERE id_kategori = :id');
        $this->db->bind(':name', $name);
        $this->db->bind(':id', (int) $id, PDO::PARAM_INT);
        return $this->db->execute();
    }

    public function delete($id)
    {
        $this->db->query('DELETE FROM kategori WHERE id_kategori = :id');
        $this->db->bind(':id', (int) $id, PDO::PARAM_INT);
        return $this->db->execute();
    }

}