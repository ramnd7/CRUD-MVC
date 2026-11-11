<?php

class Gear extends Controller
{
    private $gearModel;

    public function __construct()
    {
        if (empty($_SESSION['login'])) {
            header('Location: ' . BASE_URL . '/login/login.php');
            exit;
        }

        if (empty($_SESSION['gear_csrf_token'])) {
            $_SESSION['gear_csrf_token'] = bin2hex(random_bytes(32));
        }

        $this->gearModel = $this->model('Gear_model');
    }

    public function index()
    {
        $search = trim(isset($_GET['q']) ? (string) $_GET['q'] : '');
        $perPage = 4;
        $total = $this->gearModel->countAll($search);
        $pageCount = max(1, (int) ceil($total / $perPage));
        $page = filter_var(isset($_GET['page']) ? $_GET['page'] : 1, FILTER_VALIDATE_INT);
        $page = max(1, min($page === false ? 1 : $page, $pageCount));

        $this->view('gear/index', [
            'items' => $this->gearModel->getAll($search, $perPage, ($page - 1) * $perPage),
            'search' => $search,
            'page' => $page,
            'pageCount' => $pageCount,
            'csrfToken' => $_SESSION['gear_csrf_token'],
        ]);
    }

    public function add()
    {
        $this->view('gear/form', [
            'title' => 'Tambah Gear',
            'action' => BASEURL . '/index.php?url=gear/store',
            'gear' => $this->emptyGear(),
            'categories' => $this->gearModel->getCategories(),
            'error' => '',
            'csrfToken' => $_SESSION['gear_csrf_token'],
        ]);
    }

    public function store()
    {
        $this->requirePost();
        $this->verifyCsrf();
        $gear = $this->readGearInput();
        $error = $this->validateGear($gear);

        if ($error !== '') {
            $this->showForm('Tambah Gear', $gear, $error);
            return;
        }

        $upload = $this->uploadPhoto(isset($_FILES['foto']) ? $_FILES['foto'] : null, true);
        if (isset($upload['error'])) {
            $this->showForm('Tambah Gear', $gear, $upload['error']);
            return;
        }

        $gear['foto'] = $upload['name'];
        try {
            $this->gearModel->create($gear);
        } catch (Throwable $exception) {
            $this->removePhoto($upload['name']);
            throw $exception;
        }
        $this->redirectToList();
    }

    public function edit($id = null)
    {
        $id = $this->validId($id);
        $gear = $this->gearModel->getById($id);

        if (!$gear) {
            $this->notFound();
        }

        $this->view('gear/form', [
            'title' => 'Edit Gear',
            'action' => BASEURL . '/index.php?url=gear/update/' . $id,
            'gear' => $gear,
            'categories' => $this->gearModel->getCategories(),
            'error' => '',
            'csrfToken' => $_SESSION['gear_csrf_token'],
        ]);
    }

    public function update($id = null)
    {
        $this->requirePost();
        $this->verifyCsrf();
        $id = $this->validId($id);
        $existing = $this->gearModel->getById($id);
        if (!$existing) {
            $this->notFound();
        }

        $gear = $this->readGearInput();
        $gear['foto'] = $existing['foto'];
        $error = $this->validateGear($gear);

        if ($error !== '') {
            $this->showForm('Edit Gear', $gear, $error, $id);
            return;
        }

        $upload = $this->uploadPhoto(isset($_FILES['foto']) ? $_FILES['foto'] : null, false);
        if (isset($upload['error'])) {
            $this->showForm('Edit Gear', $gear, $upload['error'], $id);
            return;
        }
        if (isset($upload['name'])) {
            $gear['foto'] = $upload['name'];
        }

        try {
            $this->gearModel->update($id, $gear);
        } catch (Throwable $exception) {
            if (isset($upload['name'])) {
                $this->removePhoto($upload['name']);
            }
            throw $exception;
        }
        if (isset($upload['name']) && $existing['foto'] !== '') {
            $this->removePhoto($existing['foto']);
        }

        $this->redirectToList();
    }

    public function delete($id = null)
    {
        $this->requirePost();
        $this->verifyCsrf();
        $id = $this->validId($id);
        $gear = $this->gearModel->getById($id);

        if (!$gear) {
            $this->notFound();
        }

        $this->gearModel->delete($id);
        if ($gear['foto'] !== '') {
            $this->removePhoto($gear['foto']);
        }

        $this->redirectToList();
    }

    private function emptyGear()
    {
        return [
            'nama_gear' => '',
            'merek' => '',
            'id_kategori' => '',
            'harga_sewa' => '',
            'stok' => '',
            'status' => 'Tersedia',
            'foto' => '',
            'deskripsi' => '',
        ];
    }

    private function readGearInput()
    {
        return [
            'nama_gear' => trim(isset($_POST['nama_gear']) ? (string) $_POST['nama_gear'] : ''),
            'merek' => trim(isset($_POST['merek']) ? (string) $_POST['merek'] : ''),
            'id_kategori' => isset($_POST['id_kategori']) ? $_POST['id_kategori'] : '',
            'harga_sewa' => isset($_POST['harga_sewa']) ? $_POST['harga_sewa'] : '',
            'stok' => isset($_POST['stok']) ? $_POST['stok'] : '',
            'status' => isset($_POST['status']) ? (string) $_POST['status'] : '',
            'foto' => '',
            'deskripsi' => trim(isset($_POST['deskripsi']) ? (string) $_POST['deskripsi'] : ''),
        ];
    }

    private function validateGear($gear)
    {
        if ($gear['nama_gear'] === '' || $gear['merek'] === '') {
            return 'Nama gear dan merek wajib diisi.';
        }

        $categoryId = filter_var($gear['id_kategori'], FILTER_VALIDATE_INT);
        if ($categoryId === false || $categoryId < 1) {
            return 'Pilih kategori yang valid.';
        }

        foreach (['harga_sewa', 'stok'] as $field) {
            if (filter_var($gear[$field], FILTER_VALIDATE_INT) === false
                || (int) $gear[$field] < 0) {
                return 'Harga dan stok harus berupa angka nol atau lebih.';
            }
        }

        if (!in_array($gear['status'], ['Tersedia', 'Disewa', 'Maintenance'], true)) {
            return 'Pilih status gear yang valid.';
        }

        return '';
    }

    private function uploadPhoto($file, $required)
    {
        if ($file === null || !isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return $required ? ['error' => 'Pilih foto gear terlebih dahulu.'] : [];
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['error' => 'Upload foto gagal. Silakan coba lagi.'];
        }
        if ($file['size'] > 2000000) {
            return ['error' => 'Ukuran foto maksimal 2MB.'];
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
        $allowed = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
        ];
        if (!isset($allowed[$extension]) || $allowed[$extension] !== $mime
            || getimagesize($file['tmp_name']) === false) {
            return ['error' => 'Foto harus berupa gambar JPG, JPEG, atau PNG.'];
        }

        if (!is_dir(GEAR_UPLOAD_DIR)
            && !mkdir(GEAR_UPLOAD_DIR, 0755, true)
            && !is_dir(GEAR_UPLOAD_DIR)) {
            throw new RuntimeException('Could not create the gear upload directory.');
        }

        $name = bin2hex(random_bytes(16)) . '.' . $extension;
        $destination = GEAR_UPLOAD_DIR . DIRECTORY_SEPARATOR . $name;
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            return ['error' => 'Foto gagal disimpan. Silakan coba lagi.'];
        }

        return ['name' => $name];
    }

    private function removePhoto($name)
    {
        $path = GEAR_UPLOAD_DIR . DIRECTORY_SEPARATOR . basename($name);
        if (is_file($path) && !unlink($path)) {
            throw new RuntimeException('Could not remove the old gear photo.');
        }
    }

    private function showForm($title, $gear, $error, $id = null)
    {
        $this->view('gear/form', [
            'title' => $title,
            'action' => $id === null
                ? BASEURL . '/index.php?url=gear/store'
                : BASEURL . '/index.php?url=gear/update/' . $id,
            'gear' => $gear,
            'categories' => $this->gearModel->getCategories(),
            'error' => $error,
            'csrfToken' => $_SESSION['gear_csrf_token'],
        ]);
    }

    private function verifyCsrf()
    {
        $token = isset($_POST['_token']) ? (string) $_POST['_token'] : '';
        if (!hash_equals($_SESSION['gear_csrf_token'], $token)) {
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
        header('Location: ' . BASEURL . '/index.php?url=gear');
        exit;
    }

    private function notFound()
    {
        http_response_code(404);
        exit('Gear not found.');
    }
}
