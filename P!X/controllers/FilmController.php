<?php
// controllers/FilmController.php
require_once 'config/database.php';
require_once 'models/Film.php';
require_once 'models/Genre.php';
require_once 'models/Aktor.php';

class FilmController {
    private $db;
    private $film;
    private $genre;
    private $aktor;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->film = new Film($this->db);
        $this->genre = new Genre($this->db);
        $this->aktor = new Aktor($this->db);
    }

    // DASHBOARD
    public function dashboard() {
        require_once 'views/dashboard.php';
    }

    // INDEX - List all films
    public function index() {
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $genre_filter = isset($_GET['genre']) ? $_GET['genre'] : '';

        if($search != '') {
            $stmt = $this->film->search($search);
        } else if($genre_filter != '') {
            $stmt = $this->film->readByGenre($genre_filter);
        } else {
            $stmt = $this->film->readAll();
        }

        $films = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $genres = $this->genre->readAll()->fetchAll(PDO::FETCH_ASSOC);
        
        require_once 'views/film/index.php';
    }

    // SHOW - Detail film
    public function show() {
        if(isset($_GET['id'])) {
            $this->film->id_film = $_GET['id'];
            
            // Get film with actors
            $filmData = $this->film->getFilmWithActors($_GET['id']);
            
            if($filmData) {
                require_once 'views/film/show.php';
            } else {
                header("Location: index.php?module=film&error=Film tidak ditemukan");
                exit();
            }
        }
    }

    // CREATE - Show form
    public function create() {
        $genres = $this->genre->readAll()->fetchAll(PDO::FETCH_ASSOC);
        $aktors = $this->aktor->readAll()->fetchAll(PDO::FETCH_ASSOC);
        require_once 'views/film/create.php';
    }

    // STORE - Save new film
    public function store() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->film->judul_film = $_POST['judul_film'];
            $this->film->tahun_rilis = $_POST['tahun_rilis'];
            $this->film->durasi_menit = $_POST['durasi_menit'];
            $this->film->sipnosis = $_POST['sipnosis'];
            $this->film->rating = $_POST['rating'];
            $this->film->poster_url = $_POST['poster_url'];
            $this->film->id_genre = $_POST['id_genre'];

            if($this->film->create()) {
                // Get last inserted ID
                $last_id = $this->db->lastInsertId();
                
                // Add actors if selected
                if(isset($_POST['actors']) && is_array($_POST['actors'])) {
                    foreach($_POST['actors'] as $id_aktor) {
                        $peran = isset($_POST['peran_'.$id_aktor]) ? $_POST['peran_'.$id_aktor] : '';
                        $query = "INSERT INTO Film_Aktor (id_film, id_aktor, peran) VALUES (:id_film, :id_aktor, :peran)";
                        $stmt = $this->db->prepare($query);
                        $stmt->bindParam(':id_film', $last_id);
                        $stmt->bindParam(':id_aktor', $id_aktor);
                        $stmt->bindParam(':peran', $peran);
                        $stmt->execute();
                    }
                }
                
                header("Location: index.php?module=film&message=Film berhasil ditambahkan!");
                exit();
            } else {
                header("Location: index.php?module=film&action=create&error=Gagal menambahkan film");
                exit();
            }
        }
    }

    // EDIT - Show edit form
    public function edit() {
        if(isset($_GET['id'])) {
            $this->film->id_film = $_GET['id'];
            if($this->film->readOne()) {
                $genres = $this->genre->readAll()->fetchAll(PDO::FETCH_ASSOC);
                $aktors = $this->aktor->readAll()->fetchAll(PDO::FETCH_ASSOC);
                
                // Get current actors
                $query = "SELECT id_aktor, peran FROM Film_Aktor WHERE id_film = :id_film";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':id_film', $this->film->id_film);
                $stmt->execute();
                $current_actors = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                require_once 'views/film/edit.php';
            } else {
                header("Location: index.php?module=film&error=Film tidak ditemukan");
                exit();
            }
        }
    }

    // UPDATE - Update film
    public function update() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->film->id_film = $_POST['id_film'];
            $this->film->judul_film = $_POST['judul_film'];
            $this->film->tahun_rilis = $_POST['tahun_rilis'];
            $this->film->durasi_menit = $_POST['durasi_menit'];
            $this->film->sipnosis = $_POST['sipnosis'];
            $this->film->rating = $_POST['rating'];
            $this->film->poster_url = $_POST['poster_url'];
            $this->film->id_genre = $_POST['id_genre'];

            if($this->film->update()) {
                // Update actors - delete old, insert new
                $query = "DELETE FROM Film_Aktor WHERE id_film = :id_film";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':id_film', $this->film->id_film);
                $stmt->execute();
                
                if(isset($_POST['actors']) && is_array($_POST['actors'])) {
                    foreach($_POST['actors'] as $id_aktor) {
                        $peran = isset($_POST['peran_'.$id_aktor]) ? $_POST['peran_'.$id_aktor] : '';
                        $query = "INSERT INTO Film_Aktor (id_film, id_aktor, peran) VALUES (:id_film, :id_aktor, :peran)";
                        $stmt = $this->db->prepare($query);
                        $stmt->bindParam(':id_film', $this->film->id_film);
                        $stmt->bindParam(':id_aktor', $id_aktor);
                        $stmt->bindParam(':peran', $peran);
                        $stmt->execute();
                    }
                }
                
                header("Location: index.php?module=film&message=Film berhasil diupdate!");
                exit();
            } else {
                header("Location: index.php?module=film&action=edit&id=" . $this->film->id_film . "&error=Gagal mengupdate film");
                exit();
            }
        }
    }

    // DELETE - Delete film
    public function delete() {
        if(isset($_GET['id'])) {
            $this->film->id_film = $_GET['id'];
            if($this->film->delete()) {
                header("Location: index.php?module=film&message=Film berhasil dihapus!");
                exit();
            } else {
                header("Location: index.php?module=film&error=Gagal menghapus film");
                exit();
            }
        }
    }
}
?>