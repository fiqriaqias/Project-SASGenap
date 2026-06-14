Soal Project OOP
#System Ojek Online Premium 
DESKRIPSI KASUS 
Sebuah aplikasi ojek online menyediakan berbagai layanan transportasi dan pengantaran, pelanggan dapat memesan layanan menggunakan vocher diskon, memiliki metode pembayaran, serta mendapatkan poin reward setelah transaksi berhasil. 

1.Ketentuan Program
buatlah class user sebagai parent class 
Atribut: nama, noHp || Method: getNama(), getStatus() 

2.Class Pelanggan (child class user)
Atribut: tambahan: poin || Method: getStatus(), tambahPoin()

KETENTUAN: Setiap transaksi berhasil mendapatkan 1 poin per Rp10.000 pembayaran.

3.Class Layanan
Jenis layanan:
    Layanan                 Tarif/km
    GoRide Reguler          Rp2.500
    GoRide Prioritas        Rp3.000
    GoCar                   Rp4.500
    GoCar XL                Rp6.000
    GoFood                  Rp2.000
    Method: getTarif(), getJenisLayanan()

4.Class Voucher
Atribut: kodeVoucher; diskonPersen || Method: hitungDiskon()
    Voucher:
        Kode        Diskon
        HEMAT10     10%
        HEMAT20     20%
        HEMAT30     30% 

5.Class Pembayaran
Parent Class Pembayaran
Method: getMetode()

Child Class
-E-Wallet
-TransferBank
-Cash
-Override method

6.Class Transaksi
Atribut: pelanggan, layanan, pembayaran, voucher, jarakTempuh
Method: hitungSubTotal(), hitungDiskon(), hitungBiayaAdmin(), hitungTotal()

7.Aturan Perhitungan
Subtotal: Jarak x Tarif
Diskon Member: Jika subtotal > Rp50.000
Diskon Member = 5%
Diskon Voucher
    Metode          Admin
    E-Wallet        Rp1.000
    Transfer Bank   Rp2.500
    Cash            Rp0
Total = Subtotal - Diskon Member - Diskon Voucher + Biaya Admin
Validasi:
    Nama tidak boleh kosong
    Jarak harus lebih dari 0
    Voucher harus sesuai daftar voucher
    Nomor hp minimal 10 digit   

8.Static Property
Simpan jumlah transaksi: private static $totalTransaksi;
Method: getTotalTransaksi()

            Minimal Interface/UI