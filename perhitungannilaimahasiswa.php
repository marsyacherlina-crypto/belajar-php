
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

// Function untuk menghitung nilai akhir
function hitungNilaiAkhir($kehadiran, $tugas, $uts, $uas)
{
    return ($kehadiran + $tugas + $uts + $uas) / 4;
}

// Mengecek apakah form sudah dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nim = $_POST["nim"];
    $nama = $_POST["nama"];
    $nilai_kehadiran = (int) $_POST["nilai_kehadiran"];
    $nilai_tugas = (int) $_POST["nilai_tugas"];
    $nilai_uts = (int) $_POST["nilai_uts"];
    $nilai_uas = (int) $_POST["nilai_uas"];

    // Memanggil function
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

// Mengelompokkan nilai ke dalam array
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
            font-family: Verdana, sans-serif;
            background-image: url('latar.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            margin: 0;
            padding: 40px 20px;
            color: #333;
        }

        .container {
            width: 760px;
            max-width: 100%;
            margin: auto;
            background: #fff;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 12px 40px rgba(88, 54, 105, 0.12);
        }

        h1 {
            text-align: left;
            color: #fff;
            font-size: 27px;
            line-height: 1.4;
            margin: 0;
        }

        .container > h1 {
            background: #78558f;
            padding: 32px 35px 12px;
        }

        .container > h1::after {
            content: "Input data dan hitung hasil nilai akademik";
            display: block;
            font-size: 12px;
            font-weight: normal;
            color: #eee2f5;
            margin-top: 8px;
        }

        form {
            padding: 25px 35px 35px;
        }

        label {
            display: block;
            margin-top: 19px;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #5e486c;
        }

        input {
            display: block;
            width: 100%;
            padding: 13px 15px;
            border: 1px solid #e2d6e9;
            border-radius: 9px;
            background: #fcfaff;
            font-family: inherit;
            font-size: 14px;
            color: #393047;
            outline: none;
        }

        input:focus {
            border-color: #a77ac0;
            box-shadow: 0 0 0 3px #f0e5f7;
        }

        button {
            display: block;
            width: 100%;
            margin-top: 28px;
            padding: 14px;
            background: #78558f;
            color: #fff;
            border: none;
            border-radius: 9px;
            font-family: inherit;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        button:hover {
            background: #604174;
        }

        /* Tampilan hasil */
        .hasil {
            margin: 0 35px 35px;
            padding: 24px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
        }

        .header-hasil {
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header-hasil h2 {
            margin: 0 0 5px;
            color: #26344a;
            font-size: 20px;
        }

        .header-hasil p {
            margin: 0;
            color: #7b8494;
            font-size: 12px;
        }

        .identitas {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 22px;
        }

        .item-identitas {
            padding: 13px;
            background: #f5f7fa;
            border-radius: 9px;
            overflow-wrap: anywhere;
        }

        .item-identitas small {
            display: block;
            color: #7b8494;
            font-size: 11px;
            margin-bottom: 6px;
        }

        .item-identitas strong {
            color: #26344a;
            font-size: 13px;
        }

        .hasil h3 {
            color: #26344a;
            font-size: 14px;
            margin-bottom: 12px;
        }

        .daftar-nilai {
            display: flex;
            flex-direction: column;
            gap: 9px;
        }

        .baris-nilai {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 14px;
            background: #fafbfc;
            border: 1px solid #edf0f4;
            border-radius: 8px;
            font-size: 13px;
        }

        .baris-nilai strong {
            color: #26344a;
        }

        .nilai-akhir {
            margin-top: 20px;
            padding: 22px;
            background: #26344a;
            color: #fff;
            border-radius: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .nilai-akhir span {
            font-size: 13px;
        }

        .nilai-akhir strong {
            font-size: 29px;
        }

        .status {
            margin-top: 15px;
            padding: 13px 15px;
            background: #edf8f1;
            border-radius: 9px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }

        .status span {
            font-size: 13px;
            color: #43534a;
        }

        .status strong {
            color: #237547;
            font-size: 12px;
        }

        @media (max-width: 600px) {
            body {
                padding: 20px 12px;
            }

            .container {
                border-radius: 16px;
            }

            .container > h1 {
                padding: 25px 22px 12px;
                font-size: 22px;
            }

            form {
                padding: 15px 22px 25px;
            }

            .hasil {
                margin: 0 22px 25px;
                padding: 18px;
            }

            .identitas {
                grid-template-columns: 1fr;
            }

            .nilai-akhir strong {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Perhitungan Nilai Mahasiswa</h1>

    <form method="POST">

        <label>NIM</label>
        <input
            type="text"
            name="nim"
            value="<?= htmlspecialchars($nim) ?>"
            required
        >

        <label>Nama Mahasiswa</label>
        <input
            type="text"
            name="nama"
            value="<?= htmlspecialchars($nama) ?>"
            required
        >

        <label>Nilai Kehadiran</label>
        <input
            type="number"
            name="nilai_kehadiran"
            min="0"
            max="100"
            value="<?= $sudah_dihitung ? $nilai_kehadiran : '' ?>"
            required

        <label>Nilai Tugas</label>
        <input
            type="number"
            name="nilai_tugas"
            min="0"
            max="100"
            value="<?= $sudah_dihitung ? $nilai_tugas : '' ?>"
            required
        >

        <label>Nilai UTS</label>
        <input
            type="number"
            name="nilai_uts"
            min="0"
            max="100"
            value="<?= $sudah_dihitung ? $nilai_uts : '' ?>"
            required
        >

        <label>Nilai UAS</label>
        <input
            type="number"
            name="nilai_uas"
            min="0"
            max="100"
            value="<?= $sudah_dihitung ? $nilai_uas : '' ?>"
            required
        >

        <button type="submit">Hitung Nilai</button>

    </form>

    <?php if ($sudah_dihitung) { ?>

        <div class="hasil">

            <div class="header-hasil">
                <h2>Hasil Evaluasi Akademik</h2>
                <p>Ringkasan nilai mahasiswa</p>
            </div>

            <div class="identitas">

                <div class="item-identitas">
                    <small>NOMOR INDUK MAHASISWA</small>
                    <strong><?= htmlspecialchars($nim) ?></strong>
                </div>

                <div class="item-identitas">
                    <small>NAMA MAHASISWA</small>
                    <strong><?= htmlspecialchars($nama) ?></strong>
                </div>

            </div>

            <h3>Rincian Penilaian</h3>

            <div class="daftar-nilai">

                <?php foreach ($daftar_nilai as $jenis => $nilai) { ?>

                    <div class="baris-nilai">
                        <span><?= htmlspecialchars($jenis) ?></span>
                        <strong><?= $nilai ?></strong>
                    </div>

                <?php } ?>

            </div>

            <div class="nilai-akhir">
                <span>Nilai Akhir</span>
                <strong>
                    <?= number_format($nilai_akhir, 2, ',', '.') ?>
                </strong>
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
