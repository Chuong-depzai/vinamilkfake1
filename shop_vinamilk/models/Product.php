<?php
require_once __DIR__ . '/../db.php';

class Product
{
    private $db;

    public function __construct()
    {
        $this->db = getDB();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM products ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $sql = "INSERT INTO products (name, price, image, type, description, ingredients, packaging) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $data['price'],
            $data['image'],
            $data['type'],
            $data['description'],
            $data['ingredients'],
            $data['packaging']
        ]);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE products SET name = ?, price = ?, image = ?, type = ?, 
                description = ?, ingredients = ?, packaging = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $data['price'],
            $data['image'],
            $data['type'],
            $data['description'],
            $data['ingredients'],
            $data['packaging'],
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function search($keyword)
    {
        $sql = "SELECT * FROM products WHERE name LIKE ? OR description LIKE ? ORDER BY id DESC";
        $stmt = $this->db->prepare($sql);
        $searchTerm = "%{$keyword}%";
        $stmt->execute([$searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }
}
