<?php

namespace Database\Seeders;

use App\Models\Mobil;
use Illuminate\Database\Seeder;

class MobilSeeder extends Seeder
{
    /**
     * Katalog model mobil populer di Indonesia beserta
     * harga dasar, transmisi, bahan bakar, dan foto.
     */
    private array $katalog = [
        ['Avanza 1.5 G', 'Toyota', 275000000, 'CVT', 'Bensin', 'photo-1549399542-7e3f8b79c341'],
        ['Innova Zenix Q', 'Toyota', 455000000, 'CVT', 'Hybrid', 'photo-1494976388531-d1058494cdd8'],
        ['Fortuner 2.4 VRZ', 'Toyota', 742000000, 'Matic', 'Diesel', 'photo-1519245659620-e9afe9423d42'],
        ['Hilux 2.4 G Double Cabin', 'Toyota', 465300000, 'Manual', 'Diesel', 'photo-1568605117036-5fe5e7bab0b7'],
        ['Rush GR Sport', 'Toyota', 302500000, 'Matic', 'Bensin', 'photo-1533473359331-0135ef1b58bf'],
        ['Civic RS Turbo', 'Honda', 615000000, 'CVT', 'Bensin', 'photo-1605559484846-fed08e1c41c6'],
        ['CR-V Turbo Prestige', 'Honda', 687500000, 'CVT', 'Hybrid', 'photo-1568844293986-8d0400bd4749'],
        ['Brio Satya E', 'Honda', 178500000, 'CVT', 'Bensin', 'photo-1552519507-da3b142c6e3d'],
        ['HR-V RS Turbo', 'Honda', 378900000, 'CVT', 'Bensin', 'photo-1511919884226-fd3cad34687c'],
        ['Pajero Sport Dakar', 'Mitsubishi', 830500000, 'Matic', 'Diesel', 'photo-1533473359331-0135ef1b58bf'],
        ['Xpander Ultimate', 'Mitsubishi', 310000000, 'Matic', 'Bensin', 'photo-1511919884226-fd3cad34687c'],
        ['Xforce Ultimate', 'Mitsubishi', 399100000, 'Matic', 'Listrik', 'photo-1560958089-b8a1929cea89'],
        ['Xpander Cross HEV', 'Mitsubishi', 427000000, 'CVT', 'Hybrid', 'photo-1493238792000-8113da705763'],
        ['Ioniq 5 Signature', 'Hyundai', 764900000, 'Matic', 'Listrik', 'photo-1560958089-b8a1929cea89'],
        ['Stargazer Prime', 'Hyundai', 344000000, 'CVT', 'Bensin', 'photo-1541899481282-d53bffe3c35d'],
        ['Palisade Prime', 'Hyundai', 782000000, 'Matic', 'Bensin', 'photo-1563720223185-11003d516935'],
        ['Kicks e-Power Urban', 'Nissan', 458900000, 'CVT', 'Hybrid', 'photo-1502877338535-766e1452684a'],
        ['X-Trail e-Power', 'Nissan', 585000000, 'CVT', 'Hybrid', 'photo-1517672651691-24622a91b550'],
        ['Terra VL Turbo', 'Nissan', 648000000, 'Matic', 'Diesel', 'photo-1568605117036-5fe5e7bab0b7'],
        ['Cortez Connect 1.5', 'Wuling', 289000000, 'CVT', 'Bensin', 'photo-1570733577524-3a047079e80d'],
    ];

    /** Warna dengan kode CSS untuk deskripsi. */
    private array $warna = ['Putih Polar', 'Hitam Metalik', 'Silver Titanium', 'Abu-abu Meteor', 'Merah Bordeaux', 'Biru Tropis', 'Cokelat Bronzit', 'Hijau Olive'];

    /** Wilayah plat nomor Indonesia. */
    private array $wilayahPlat = ['B', 'D', 'F', 'H', 'L', 'N', 'AB', 'AD', 'DK', 'KB'];

    public function run(): void
    {
        $target = 100;
        $nomorPlat = 1000;

        for ($i = 0; $i < $target; $i++) {
            [$nama, $brand, $hargaDasar, $transmisi, $bahanBakar, $foto] = $this->katalog[$i % count($this->katalog)];

            // Variasi tahun 2021-2025 berulang, harga naik untuk tahun muda
            $tahun = 2021 + ($i % 5);
            $selisihTahun = 2025 - $tahun;
            $harga = $hargaDasar - ($selisihTahun * 15000000) - ($i % 4) * 5000000;

            // Kilometer naik seiring umur mobil
            $kilometer = $selisihTahun * random_int(8000, 25000);

            $warna = $this->warna[$i % count($this->warna)];
            $kodePlat = $this->wilayahPlat[$i % count($this->wilayahPlat)];
            $platNomor = sprintf('%s %d %s', $kodePlat, $nomorPlat + $i, chr(65 + ($i % 26)) . chr(65 + (($i + 3) % 26)));

            // 85% tersedia, 15% sold
            $status = ($i % 7 === 0) ? 'sold' : 'tersedia';

            Mobil::create([
                'nama' => sprintf('%s %s %d', $nama, substr($warna, 0, strpos($warna . ' ', ' ')), $tahun),
                'brand' => $brand,
                'harga' => $harga,
                'tahun' => $tahun,
                'transmisi' => $transmisi,
                'bahan_bakar' => $bahanBakar,
                'status' => $status,
                'foto' => "https://images.unsplash.com/{$foto}?auto=format&fit=crop&w=800&q=60",
                'warna' => $warna,
                'kilometer' => $kilometer,
                'plat_nomor' => $platNomor,
                'deskripsi' => "{$brand} {$nama} tahun {$tahun} warna " . strtolower($warna) . ", transmisi {$transmisi}, bahan bakar {$bahanBakar}, terpakai " . number_format($kilometer, 0, ',', '.') . " km. Kondisi terawat, siap pakai, lengkap dokumen.",
            ]);
        }
    }
}
