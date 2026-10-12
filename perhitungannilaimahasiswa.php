```php
<?php
// Menyiapkan variabel
$nim = "";
$nama = "";
$nilai_kehadiran = 0;
$nilai_tugas = 0;
$nilai_uts = 0;
$nilai_uas = 0;
$nilai_akhir = 0;
$status = "";
$sudah_dihitung = false;

// Function menghitung nilai akhir
function hitungNilaiAkhir($kehadiran, $tugas, $uts, $uas)
{
    return ($kehadiran + $tugas + $uts + $uas) / 4;
}

// Mengecek form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $_POST["nim"];
    $nama = $_POST["nama"];
    $nilai_kehadiran = (int) $_POST["nilai_kehadiran"];
    $nilai_tugas = (int) $_POST["nilai_tugas"];
    $nilai_uts = (int) $_POST["nilai_uts"];
    $nilai_uas = (int) $_POST["nilai_uas"];

    // Menghitung nilai
    $nilai_akhir = hitungNilaiAkhir(
        $nilai_kehadiran,
        $nilai_tugas,
        $nilai_uts,
        $nilai_uas
    );

    // Menentukan status
    if ($nilai_akhir >= 80) {
        $status = "Sangat Baik";
    } elseif ($nilai_akhir >= 70) {
        $status = "Baik";
    } else {
        $status = "Perlu Perbaikan";
    }

    $sudah_dihitung = true;
}

// Menyimpan nilai dalam array
$daftar_nilai = [
    "Nilai Kehadiran" => $nilai_kehadiran,
    "Nilai Tugas" => $nilai_tugas,
    "Nilai UTS" => $nilai_uts,
    "Nilai UAS" => $nilai_uas
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perhitungan Nilai Mahasiswa</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: url('latar.jpg') center/cover fixed;
            margin: 0;
            padding: 30px 15px;
            color: #333;
        }

        .container {
            max-width: 650px;
            margin: auto;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px #0002;
        }

        h1 {
            margin: 0;
            padding: 25px;
            background: #78558f;
            color: white;
            font-size: 25px;
        }

        form {
            padding: 25px;
        }

        label {
            display: block;
            margin: 14px 0 7px;
            font-size: 14px;
            font-weight: bold;
            color: #5e486c;
        }

        input {
            width: 100%;
            padding: 11px;
            border: 1px solid #ddd;
            border-radius: 7px;
            font-size: 14px;
        }

        input:focus {
            outline: 2px solid #d9c5e5;
        }

        button {
            width: 100%;
            margin-top: 22px;
            padding: 13px;
            background: #78558f;
            color: white;
            border: none;
            border-radius: 7px;
            font-size: 14px;
            cursor: pointer;
        }

        button:hover {
            background: #604174;
        }

        .hasil {
            margin: 0 25px 25px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
        }

        .hasil h2 {
            margin-top: 0;
            font-size: 20px;
            color: #78558f;
        }

        .identitas, .baris-nilai, .nilai-akhir, .status {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }

        .identitas {
            gap: 15px;
            margin: 20px 0;
        }

        .identitas div {
            flex: 1;
            min-width: 0;
            padding: 12px;
            background: #f5f0f8;
            border-radius: 7px;
            overflow-wrap: anywhere;
        }

        small {
            display: block;
            margin-bottom: 7px;
            color: #777;
        }

        .baris-nilai {
            padding: 12px;
            margin: 8px 0;
            background: #f8f8f8;
            border-radius: 6px;
            font-size: 14px;
        }

        .nilai-akhir {
            margin-top: 18px;
            padding: 17px;
            background: #26344a;
            color: white;
            border-radius: 8px;
        }

        .nilai-akhir strong {
            font-size: 25px;
        }

        .status {
            margin-top: 12px;
            padding: 13px;
            background: #edf8f1;
            border-radius: 7px;
        }

        .status strong {
            color: #237547;
        }

        @media (max-width: 450px) {
            h1 {
                font-size: 21px;
            }

            form {
                padding: 20px;
            }

            .hasil {
                margin: 0 20px 20px;
                padding: 15px;
            }

            .identitas {
                flex-direction: column;
            }

            .identitas div {
                width: 100%;
            }
        }
    </style>
</head>

<body>
<div class="container">
    <h1>Perhitungan Nilai Mahasiswa</h1>

    <form method="POST">
        <label>NIM</label>
        <input type="text" name="nim"
            value="<?= htmlspecialchars($nim) ?>" required>

        <label>Nama Mahasiswa</label>
        <input type="text" name="nama"
            value="<?= htmlspecialchars($nama) ?>" required>

        <label>Nilai Kehadiran</label>
        <input type="number" name="nilai_kehadiran"
            min="0" max="100"
            value="<?= $sudah_dihitung ? $nilai_kehadiran : '' ?>" required>

        <label>Nilai Tugas</label>
        <input type="number" name="nilai_tugas"
            min="0" max="100"
            value="<?= $sudah_dihitung ? $nilai_tugas : '' ?>" required>

        <label>Nilai UTS</label>
        <input type="number" name="nilai_uts"
            min="0" max="100"
            value="<?= $sudah_dihitung ? $nilai_uts : '' ?>" required>

        <label>Nilai UAS</label>
        <input type="number" name="nilai_uas"
            min="0" max="100"
            value="<?= $sudah_dihitung ? $nilai_uas : '' ?>" required>

        <button type="submit">Hitung Nilai</button>
    </form>

    <?php if ($sudah_dihitung) { ?>
        <div class="hasil">
            <h2>Hasil Evaluasi Akademik</h2>

            <div class="identitas">
                <div>
                    <small>NIM</small>
                    <strong><?= htmlspecialchars($nim) ?></strong>
                </div>
                <div>
                    <small>Nama Mahasiswa</small>
                    <strong><?= htmlspecialchars($nama) ?></strong>
                </div>
            </div>

            <h3>Rincian Penilaian</h3>

            <?php foreach ($daftar_nilai as $jenis => $nilai) { ?>
                <div class="baris-nilai">
                    <span><?= htmlspecialchars($jenis) ?></span>
                    <strong><?= $nilai ?></strong>
                </div>
            <?php } ?>

            <div class="nilai-akhir">
                <span>Nilai Akhir</span>
                <strong><?= number_format($nilai_akhir, 2, ',', '.') ?></strong>
            </div>

            <div class="status">
                <span>Status Akademik</span>
                <strong><?= htmlspecialchars($status) ?></strong>
            </div>
        </div>
    <?php } ?>
</div>
</body>
</html>
```