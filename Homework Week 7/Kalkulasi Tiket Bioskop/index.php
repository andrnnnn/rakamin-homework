<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Tiket Bioskop Online</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- style CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center text-light">Pemesanan Tiket Bioskop Sederhana</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="index.php">
                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-film icon"></i>Pilih Film</label>
                                <div class="movie-selection">
                                    <div class="movie-card" onclick="selectMovie(this, 'The Lord of the Rings: The War of the Rohirrim')">
                                        <img src="img/lord_of_the_rings_the_war_of_the_rohirrim_ver2.jpg" alt="Film A" class="movie-poster">
                                        <p class="movie-title">The Lord of the Rings: The War of the Rohirrim</p>
                                    </div>
                                    <div class="movie-card" onclick="selectMovie(this, 'Deadpool & Wolverine')">
                                        <img src="img/deadpool_and_wolverine_ver6.jpg" alt="Film B" class="movie-poster">
                                        <p class="movie-title">Deadpool & Wolverine</p>
                                    </div>
                                    <div class="movie-card" onclick="selectMovie(this, 'Elevation')">
                                        <img src="img/elevation.jpg" alt="Film C" class="movie-poster">
                                        <p class="movie-title">Elevation</p>
                                    </div>
                                    <div class="movie-card" onclick="selectMovie(this, 'Godzilla: Minus One')">
                                        <img src="img/godzilla_minus_one_ver12.jpg" alt="Film D" class="movie-poster">
                                        <p class="movie-title">Godzilla: Minus One</p>
                                    </div>
                                    <div class="movie-card" onclick="selectMovie(this, 'The Substance')">
                                        <img src="img/substance.jpg" alt="Film E" class="movie-poster">
                                        <p class="movie-title">The Substance</p>
                                    </div>
                                    <div class="movie-card" onclick="selectMovie(this, 'Joker: Folie à Deux')">
                                        <img src="img/joker_folie_a_deux_ver2.jpg" alt="Film F" class="movie-poster">
                                        <p class="movie-title">Joker: Folie à Deux</p>
                                    </div>
                                </div>
                                <input type="hidden" id="film" name="film" required>
                            </div>

                            <div class="mb-3">
                                <label for="jumlahDewasa" class="form-label"><i class="fas fa-user icon"></i>Jumlah Tiket Dewasa</label>
                                <input type="number" class="form-control" id="jumlahDewasa" name="jumlahDewasa" min="0" value="0">
                                <div class="keterangan">Harga: Rp50.000 per tiket</div>
                            </div>

                            <div class="mb-3">
                                <label for="jumlahAnak" class="form-label"><i class="fas fa-child icon"></i>Jumlah Tiket Anak</label>
                                <input type="number" class="form-control" id="jumlahAnak" name="jumlahAnak" min="0" value="0">
                                <div class="keterangan">Harga: Rp30.000 per tiket</div>
                            </div>

                            <div class="mb-3">
                                <label for="hariPemesanan" class="form-label"><i class="fas fa-calendar-alt icon"></i>Hari Pemesanan</label>
                                <select class="form-select" id="hariPemesanan" name="hariPemesanan" required>
                                    <option value="senin">Senin</option>
                                    <option value="selasa">Selasa</option>
                                    <option value="rabu">Rabu</option>
                                    <option value="kamis">Kamis</option>
                                    <option value="jumat">Jumat</option>
                                    <option value="sabtu">Sabtu</option>
                                    <option value="minggu">Minggu</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-calculator"></i> Hitung Total Harga</button>
                        </form>

                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            function hitungTotalHarga($jumlahDewasa, $jumlahAnak, $hariPemesanan) {
                                $hargaDewasa = 50000;
                                $hargaAnak = 30000;
                                $tambahanAkhirPekan = 10000;
                                $totalHarga = 0;

                                // Hitungan harga total
                                $totalDewasa = $hargaDewasa * $jumlahDewasa;
                                $totalAnak = $hargaAnak * $jumlahAnak;
                                $totalHarga = $totalDewasa + $totalAnak;

                                // akhir pekan
                                if ($hariPemesanan === "sabtu" || $hariPemesanan === "minggu") {
                                    $totalHarga += $tambahanAkhirPekan * ($jumlahDewasa + $jumlahAnak);
                                }

                                // diskon
                                $diskon = 0;
                                if ($totalHarga > 150000) {
                                    $diskon = 0.1 * $totalHarga;
                                    $totalHarga -= $diskon;
                                }

                                return [
                                    'totalHarga' => $totalHarga,
                                    'diskon' => $diskon,
                                    'totalDewasa' => $totalDewasa,
                                    'totalAnak' => $totalAnak,
                                    'tambahanAkhirPekan' => ($hariPemesanan === "sabtu" || $hariPemesanan === "minggu") ? $tambahanAkhirPekan * ($jumlahDewasa + $jumlahAnak) : 0
                                ];
                            }

                            $film = $_POST['film'];
                            $jumlahDewasa = $_POST['jumlahDewasa'];
                            $jumlahAnak = $_POST['jumlahAnak'];
                            $hariPemesanan = $_POST['hariPemesanan'];

                            $result = hitungTotalHarga($jumlahDewasa, $jumlahAnak, strtolower($hariPemesanan));

                            echo '<div class="total-title">Rincian Pemesanan</div>';
                            echo '<div class="h4">'. $film .'</div>';
                            echo '<div class="alert alert-info mt-3" role="alert">';
                            echo '<table class="table table-bordered">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th>Deskripsi</th>';
                            echo '<th>Jumlah</th>';
                            echo '<th>Harga</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';
                            echo '<tr>';
                            echo '<td>Tiket Dewasa</td>';
                            echo '<td>' . $jumlahDewasa . '</td>';
                            echo '<td>Rp' . number_format($result['totalDewasa'], 0, ',', '.') . '</td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<td>Tiket Anak</td>';
                            echo '<td>' . $jumlahAnak . '</td>';
                            echo '<td>Rp' . number_format($result['totalAnak'], 0, ',', '.') . '</td>';
                            echo '</tr>';

                            if ($result['tambahanAkhirPekan'] > 0) {
                                echo '<tr>';
                                echo '<td>Biaya Tambahan (Akhir Pekan)</td>';
                                echo '<td>' . ($jumlahDewasa + $jumlahAnak) . '</td>';
                                echo '<td>Rp' . number_format($result['tambahanAkhirPekan'], 0, ',', '.') . '</td>';
                                echo '</tr>';
                            }

                            if ($result['diskon'] > 0) {
                                echo '<tr>';
                                echo '<td>Total Harga Sebelum Diskon</td>';
                                echo '<td></td>';
                                echo '<td>Rp' . number_format($result['totalDewasa'] + $result['totalAnak'] + $result['tambahanAkhirPekan'], 0, ',', '.') . '</td>';
                                echo '</tr>';
                                echo '<tr class="discount-info">';
                                echo '<td>Diskon 10%</td>';
                                echo '<td></td>';
                                echo '<td>- Rp' . number_format($result['diskon'], 0, ',', '.') . '</td>';
                                echo '</tr>';
                            }

                            echo '<tr class="table-success">';
                            if ($result['diskon'] > 0) {
                                echo '<td class="discount-info">Total Harga Setelah Diskon</td>';
                            } else {
                                echo '<td>Total Harga</td>';
                            }
                            echo '<td></td>';
                            echo '<td class="total-price">Rp' . number_format($result['totalHarga'], 0, ',', '.') . '</td>';
                            echo '</tr>';
                            echo '</tbody>';
                            echo '</table>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function selectMovie(element, movieName) {
            // Remove selected class from all movie cards
            document.querySelectorAll('.movie-card').forEach(card => {
                card.classList.remove('selected');
            });
            
            // Add selected class to clicked card
            element.classList.add('selected');
            
            // Update hidden input value
            document.getElementById('film').value = movieName;
        }

        // Initialize the first movie as selected
        document.addEventListener('DOMContentLoaded', function() {
            const firstMovie = document.querySelector('.movie-card');
            if (firstMovie) {
                selectMovie(firstMovie, firstMovie.querySelector('.movie-title').textContent);
            }
        });
    </script>
</body>
</html>
