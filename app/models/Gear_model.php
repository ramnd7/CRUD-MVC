<?php

class Gear_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function countAll($search = '')
    {
        $sql = 'SELECT COUNT(*) AS total
                FROM gear
                JOIN kategori ON gear.id_kategori = kategori.id_kategori';
        if ($search !== '') {
            $sql .= ' WHERE gear.nama_gear LIKE :name_search
                      OR gear.merek LIKE :brand_search
                      OR kategori.nama_kategori LIKE :category_search
                      OR gear.status LIKE :status_search';
        }

        $this->db->query($sql);
        if ($search !== '') {
            $this->bindSearch($search);
        }

        $result = $this->db->single();
        return (int) $result['total'];
    }

    public function getAll($search, $limit, $offset)
    {
        $sql = 'SELECT gear.*, kategori.nama_kategori
                FROM gear
                JOIN kategori ON gear.id_kategori = kategori.id_kategori';
        if ($search !== '') {
            $sql .= ' WHERE gear.nama_gear LIKE :name_search
                      OR gear.merek LIKE :brand_search
                      OR kategori.nama_kategori LIKE :category_search
                      OR gear.status LIKE :status_search';
        }
        $sql .= ' ORDER BY gear.id_gear ASC LIMIT :limit OFFSET :offset';

        $this->db->query($sql);
        if ($search !== '') {
            $this->bindSearch($search);
        }
        $this->db->bind(':limit', (int) $limit, PDO::PARAM_INT);
        $this->db->bind(':offset', (int) $offset, PDO::PARAM_INT);

        return $this->db->resultSet();
    }

    public function getById($id)
    {
        $this->db->query('SELECT * FROM gear WHERE id_gear = :id');
        $this->db->bind(':id', (int) $id, PDO::PARAM_INT);
        return $this->db->single();
    }

    public function getCategories()
    {
        $this->db->query('SELECT * FROM kategori ORDER BY nama_kategori ASC');
        return $this->db->resultSet();
    }

    public function create($gear)
    {
        $this->db->query(
            'INSERT INTO gear
             (nama_gear, merek, id_kategori, harga_sewa, stok, status, foto, deskripsi)
             VALUES
             (:nama_gear, :merek, :id_kategori, :harga_sewa, :stok, :status, :foto, :deskripsi)'
        );
        $this->bindGear($gear);
        return $this->db->execute();
    }

    public function update($id, $gear)
    {
        $this->db->query(
            'UPDATE gear SET
             nama_gear = :nama_gear,
             merek = :merek,
             id_kategori = :id_kategori,
             harga_sewa = :harga_sewa,
             stok = :stok,
             status = :status,
             foto = :foto,
             deskripsi = :deskripsi
             WHERE id_gear = :id'
        );
        $this->bindGear($gear);
        $this->db->bind(':id', (int) $id, PDO::PARAM_INT);
        return $this->db->execute();
    }

    public function delete($id)
    {
        $this->db->query('DELETE FROM gear WHERE id_gear = :id');
        $this->db->bind(':id', (int) $id, PDO::PARAM_INT);
        return $this->db->execute();
    }

    private function bindGear($gear)
    {
        $this->db->bind(':nama_gear', $gear['nama_gear']);
        $this->db->bind(':merek', $gear['merek']);
        $this->db->bind(':id_kategori', (int) $gear['id_kategori'], PDO::PARAM_INT);
        $this->db->bind(':harga_sewa', (int) $gear['harga_sewa'], PDO::PARAM_INT);
        $this->db->bind(':stok', (int) $gear['stok'], PDO::PARAM_INT);
        $this->db->bind(':status', $gear['status']);
        $this->db->bind(':foto', $gear['foto']);
        $this->db->bind(':deskripsi', $gear['deskripsi']);
    }

    private function bindSearch($search)
    {
        $term = '%' . $search . '%';
        $this->db->bind(':name_search', $term);
        $this->db->bind(':brand_search', $term);
        $this->db->bind(':category_search', $term);
        $this->db->bind(':status_search', $term);
    }
}
