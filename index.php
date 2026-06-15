<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ojol</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1>Sistem Ojek Online</h1>

    <div class="container-form">
        <form method="post" action="">
            <label>Masukkan Nama</label>
            <input type="text" name="nama"><br/>
            <label>Masukkan NoHP</label>
            <input type="text" name="nohp"><br/>
            <label>Jarak Tempuh/km</label>
            <input type="text" name="jarak"><br/>
            <label>Jenis Layanan</label>
            <select name="jenis">
                <option value="GoRideReguler">GoRide Reguler</option>
                <option value="GoRidePrioritas">GoRide Prioritas</option>
                <option value="GoCar">GoCar</option>
                <option value="GoCarXL">GoCar XL</option>
                <option value="GoFood">GoFood</option>
            </select>
            <label>Kode Voucher (opsional)</label>
            <input type="text" name="voucher" placeholder="Contoh: HEMAT10"><br/>
            <label>Metode Pembayaran</label>
            <select name="pembayaran">
                <option value="EWallet">E-Wallet</option>
                <option value="TransferBank">Transfer Bank</option>
                <option value="Cash">Cash</option>
            </select>
            <input type="submit" name="struk" value="Kirim">
        </form>
    </div>

<?php
class User {
    public $nama;
    public $noHp;

    public function __construct($nama, $noHp) {
        $this->nama = $nama;
        $this->noHp = $noHp;
    }

    public function getNama() {
        return $this->nama;
    }

    public function getStatus() {
        return "User";
    }
}

class Pelanggan extends User {
    public $poin = 0;

    public function getStatus() {
        return "Member";
    }

    public function tambahPoin($totalBayar) {
        $this->poin += floor($totalBayar / 10000);
        return $this->poin;
    }
}

class Layanan {
    private $tarif;
    private $jenisLayanan;

    public function __construct($jenis) {
        $this->jenisLayanan = $jenis;
        if ($jenis == "GoRideReguler") {
            $this->tarif = 2500;
        } elseif ($jenis == "GoRidePrioritas") {
            $this->tarif = 3000;
        } elseif ($jenis == "GoCar") {
            $this->tarif = 4500;
        } elseif ($jenis == "GoCarXL") {
            $this->tarif = 6000;
        } elseif ($jenis == "GoFood") {
            $this->tarif = 2000;
        } else {
            $this->tarif = 0;
        }
    }

    public function getTarif() {
        return $this->tarif;
    }

    public function getJenisLayanan() {
        return $this->jenisLayanan;
    }
}

class Voucher {
    public $kodeVoucher;
    public $diskonPersen;

    public function __construct($kode) {
        $this->kodeVoucher = $kode;
        if ($kode == "HEMAT10") {
            $this->diskonPersen = 10;
        } elseif ($kode == "HEMAT20") {
            $this->diskonPersen = 20;
        } elseif ($kode == "HEMAT30") {
            $this->diskonPersen = 30;
        } else {
            $this->diskonPersen = 0;
        }
    }

    public function hitungDiskon($subtotal) {
        return ($this->diskonPersen / 100) * $subtotal;
    }
}

class Pembayaran {
    public function getMetode() {
        return "Metode pembayaran";
    }

    public function getBiayaAdmin() {
        return 0;
    }
}

class EWallet extends Pembayaran {
    public function getMetode() {
        return "E-Wallet";
    }

    public function getBiayaAdmin() {
        return 1000;
    }
}

class TransferBank extends Pembayaran {
    public function getMetode() {
        return "Transfer Bank";
    }

    public function getBiayaAdmin() {
        return 2500;
    }
}

class Cash extends Pembayaran {
    public function getMetode() {
        return "Cash";
    }

    public function getBiayaAdmin() {
        return 0;
    }
}

class Transaksi {
    public $pelanggan;
    public $layanan;
    public $pembayaran;
    public $voucher;
    public $jarakTempuh;
    private static $totalTransaksi = 0;

    public function __construct($pelanggan, $layanan, $pembayaran, $voucher, $jarak) {
        $this->pelanggan   = $pelanggan;
        $this->layanan     = $layanan;
        $this->pembayaran  = $pembayaran;
        $this->voucher     = $voucher;
        $this->jarakTempuh = $jarak;
        self::$totalTransaksi++;
    }

    public function hitungSubTotal() {
        return $this->jarakTempuh * $this->layanan->getTarif();
    }

    public function hitungDiskon() {
        if ($this->hitungSubTotal() > 50000) {
            return 0.05 * $this->hitungSubTotal();
        } else {
            return 0;
        }
    }

    public function hitungBiayaAdmin() {
        return $this->pembayaran->getBiayaAdmin();
    }

    public function hitungTotal() {
        $subtotal      = $this->hitungSubTotal();
        $diskonMember  = $this->hitungDiskon();
        $diskonVoucher = $this->voucher->hitungDiskon($subtotal);
        $biayaAdmin    = $this->pembayaran->getBiayaAdmin();

        return $subtotal - $diskonMember - $diskonVoucher + $biayaAdmin;
    }

    public static function getTotalTransaksi() {
        return self::$totalTransaksi;
    }
}

//proses form
if (isset($_POST['struk'])) {
    $nama_input    = trim($_POST['nama']);
    $noHp_input    = trim($_POST['nohp']);
    $jarak_input   = trim($_POST['jarak']);
    $layanan_input = $_POST['jenis'];
    $voucher_input = strtoupper(trim($_POST['voucher']));
    $bayar_input   = $_POST['pembayaran'];
    
    //validasi
    $errors = [];

    if (empty($nama_input)) {
        $errors[] = "Nama tidak boleh kosong.";
    }

    if (strlen($noHp_input) < 10 || !is_numeric($noHp_input)) {
        $errors[] = "Nomor HP minimal 10 digit dan harus berupa angka.";
    }

    if (!is_numeric($jarak_input) || (float)$jarak_input <= 0) {
        $errors[] = "Jarak harus lebih dari 0.";
    }

    $validVoucher = ["HEMAT10", "HEMAT20", "HEMAT30", ""];
    if (!in_array($voucher_input, $validVoucher)) {
        $errors[] = "Kode voucher tidak valid. Gunakan HEMAT10, HEMAT20, atau HEMAT30.";
    }

    if (!empty($errors)) {
        echo "<ul>";
        foreach ($errors as $err) {
            echo "<li>$err</li>";
        }
        echo "</ul>";
    } else {
        $pl = new Pelanggan($nama_input, $noHp_input);
        $la = new Layanan($layanan_input);
        $vo = new Voucher($voucher_input);

        if ($bayar_input == "EWallet") {
            $pb = new EWallet();
        } elseif ($bayar_input == "TransferBank") {
            $pb = new TransferBank();
        } else {
            $pb = new Cash();
        }

        //objek
        $tr       = new Transaksi($pl, $la, $pb, $vo, (float)$jarak_input);
        $subtotal = $tr->hitungSubTotal();
        $diskon   = $tr->hitungDiskon();
        $total    = $tr->hitungTotal();
        $poin     = $pl->tambahPoin($total);
?>

    <div class="container-struk">
        <h2>STRUK PEMBAYARAN</h2>
        <label>Nama Pengguna : <?php echo htmlspecialchars($pl->getNama()); ?></label>
        <label>No. HP : <?php echo htmlspecialchars($pl->noHp); ?></label>
        <label>Status : <?php echo $pl->getStatus(); ?></label>
        <label>Hadiah Poin : <?php echo $poin; ?> Poin</label>
        <br>
        <label>Layanan : <?php echo $la->getJenisLayanan(); ?></label>
        <label>Jarak : <?php echo $tr->jarakTempuh; ?> km</label>
        <label>Tarif/Km : Rp <?php echo number_format($la->getTarif(), 0, ',', '.'); ?></label>
        <br>
        <label>Subtotal : Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></label>
        <label>Diskon Member (5%) : Rp <?php echo number_format($diskon, 0, ',', '.'); ?></label>
        <label>Diskon Voucher (<?php echo $vo->diskonPersen; ?>%) : Rp <?php echo number_format($vo->hitungDiskon($subtotal), 0, ',', '.'); ?></label>
        <label>Metode Pembayaran : <?php echo $pb->getMetode(); ?></label>
        <label>Biaya Admin : Rp <?php echo number_format($tr->hitungBiayaAdmin(), 0, ',', '.'); ?></label>
        <br>
        <b><label>Total Bayar : Rp <?php echo number_format($total, 0, ',', '.'); ?></label></b>
        <br>
        <label>Total Transaksi ke- : <?php echo Transaksi::getTotalTransaksi(); ?></label>
    </div>

<?php
    } //akhir proses validasi 
} //akhir isset
?>
</body>
</html>