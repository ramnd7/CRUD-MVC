<?php

class Kategori extends Controller{
    private $kategoriModel;

    public function __construct(){
        if (empty($_SESSION['login'])) {
            header('Location: ' . BASE_URL . '/login/login.php');
            exit;
        }

        if (empty($_SESSION['kategori_csrf_token'])) {
            $_SESSION['kategori_csrf_token'] = bin2hex(random_bytes(32));
        }

        $this->kategoriModel = $this->model('Kategori_model');
    }

    public function index(){
        $this->view('kategori/index', [
            'items' => $this->kategoriModel->getAll(),
            'csrfToken' => $_SESSION['kategori_csrf_token'],
        ]);
    }

    public function add(){
        $this->view('kategori/form', [
            'title' => 'Tambah Kategori',
            'action' => BASEURL . '/index.php?url=kategori/store',
            'kategori' => ['nama_kategori' => ''],
            'error' => '',
            'csrfToken' => $_SESSION['kategori_csrf_token'],
        ]);
    }

    public function store(){
        $this->requirePost();
        $this->verifyCsrf();
        $kategori = $this->readKategoriInput();
        $error = $this->validateKategori($kategori);

        if ($error !== '') {
            $this->showForm('Tambah Kategori', $kategori, $error);
            return;
        }

        if ($this->kategoriModel->create($kategori['nama_kategori'])) {
            header('Location: ' . BASEURL . '/index.php?url=kategori');
            exit;
        } else {
            $this->showForm('Tambah Kategori', $kategori, 'Gagal menyimpan kategori.');
        }
    }

    public function edit($id = null){
        $id = $this->validId($id);
        $kategori = $this->kategoriModel->getById($id);
        if (!$kategori) {
            $this->notFound();
        }

        $this->showForm('Edit Kategori', $kategori, '', $id);
    }

    public function update($id = null){
        $this->requirePost();
        $this->verifyCsrf();
        $id = $this->validId($id);
        if (!$this->kategoriModel->getById($id)) {
            $this->notFound();
        }

        $kategori = $this->readKategoriInput();
        $error = $this->validateKategori($kategori);

        if ($error !== '') {
            $this->showForm('Edit Kategori', $kategori, $error, $id);
            return;
        }

        if ($this->kategoriModel->update($id, $kategori['nama_kategori'])) {
            $this->redirectToList();
        } else {
            $this->showForm('Edit Kategori', $kategori, 'Gagal memperbarui kategori.', $id);
        }
    }

    public function delete($id = null){
        $this->requirePost();
        $this->verifyCsrf();
        $id = $this->validId($id);
        if (!$this->kategoriModel->getById($id)) {
            $this->notFound();
        }

        if ($this->kategoriModel->delete($id)) {
            $this->redirectToList();
        } else {
            throw new RuntimeException('Gagal menghapus kategori.');
        }
    }

    private function readKategoriInput()
    {
        return [
            'nama_kategori' => trim(isset($_POST['nama_kategori'])
                ? (string) $_POST['nama_kategori']
                : ''),
        ];
    }

    private function validateKategori($kategori)
    {
        if ($kategori['nama_kategori'] === '') {
            return 'Nama kategori wajib diisi.';
        }

        if (strlen($kategori['nama_kategori']) > 100) {
            return 'Nama kategori maksimal 100 karakter.';
        }

        return '';
    }

    private function showForm($title, $kategori, $error, $id = null)
    {
        $this->view('kategori/form', [
            'title' => $title,
            'action' => $id === null
                ? BASEURL . '/index.php?url=kategori/store'
                : BASEURL . '/index.php?url=kategori/update/' . $id,
            'kategori' => $kategori,
            'error' => $error,
            'csrfToken' => $_SESSION['kategori_csrf_token'],
        ]);
    }

    private function verifyCsrf()
    {
        $token = isset($_POST['_token']) ? (string) $_POST['_token'] : '';
        if (!hash_equals($_SESSION['kategori_csrf_token'], $token)) {
            http_response_code(403);
            exit('Invalid form token. Please reload the form and try again.');
        }
    }

    private function requirePost()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Method not allowed.');
        }
    }

    private function validId($id)
    {
        $validId = filter_var($id, FILTER_VALIDATE_INT);
        if ($validId === false || $validId < 1) {
            $this->notFound();
        }

        return $validId;
    }

    private function redirectToList()
    {
        header('Location: ' . BASEURL . '/index.php?url=kategori');
        exit;
    }

    private function notFound()
    {
        http_response_code(404);
        exit('Kategori not found.');
    }
}