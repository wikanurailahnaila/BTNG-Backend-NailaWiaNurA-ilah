<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contoh CRUD — Belajar API itu Seru! 🚗</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', 'Comic Sans MS', system-ui, sans-serif;
            background: linear-gradient(160deg, #1e1b4b 0%, #312e81 50%, #1e3a5f 100%);
            color: #f8fafc; min-height: 100vh; padding: 24px 16px;
        }
        .container { max-width: 1050px; margin: 0 auto; }

        /* ===== HEADER ===== */
        .hero { text-align: center; margin-bottom: 28px; }
        .hero h1 { font-size: 2rem; margin-bottom: 8px; }
        .hero .balloon { display: inline-block; animation: float 3s ease-in-out infinite; }
        @keyframes float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
        .hero p { color: #c7d2fe; font-size: 1rem; max-width: 640px; margin: 0 auto; }
        .hero a { color: #fbbf24; text-decoration: none; font-weight: bold; }

        /* ===== PENJELASAN DASAR ===== */
        .analogi-box {
            background: #fef3c7; color: #78350f; border-radius: 16px; padding: 18px 22px;
            margin-bottom: 24px; border: 3px dashed #f59e0b; font-size: .95rem; line-height: 1.6;
        }
        .analogi-box b { color: #b45309; }
        .analogi-box .emoji-besar { font-size: 2rem; margin-right: 8px; vertical-align: middle; }

        /* ===== KARTU AKSI ===== */
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 14px; margin-bottom: 24px; }
        .kartu {
            background: #ffffff; color: #1e293b; border-radius: 16px; padding: 16px;
            border-bottom: 6px solid transparent; cursor: pointer; transition: all .2s;
            box-shadow: 0 4px 12px rgba(0,0,0,.25);
        }
        .kartu:hover { transform: translateY(-4px) scale(1.02); box-shadow: 0 8px 20px rgba(0,0,0,.35); }
        .kartu:active { transform: scale(.98); }
        .kartu .emoji { font-size: 2.2rem; display: block; margin-bottom: 6px; }
        .kartu .judul { font-weight: 800; font-size: 1rem; }
        .kartu .method {
            display: inline-block; padding: 2px 10px; border-radius: 999px;
            font-size: .72rem; font-weight: 800; color: white; margin: 6px 0;
        }
        .kartu .cerita { font-size: .82rem; color: #475569; line-height: 1.45; }
        .k-lihat { border-color: #22c55e; } .k-lihat .method { background: #16a34a; }
        .k-bikin { border-color: #3b82f6; } .k-bikin .method { background: #2563eb; }
        .k-ubah { border-color: #f59e0b; } .k-ubah .method { background: #d97706; }
        .k-hapus { border-color: #ef4444; } .k-hapus .method { background: #dc2626; }

        /* ===== PANEL INPUT ID ===== */
        .id-panel {
            background: #e0e7ff; color: #312e81; border-radius: 14px; padding: 14px 18px;
            margin-bottom: 24px; display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
            border: 2px solid #818cf8;
        }
        .id-panel input {
            width: 90px; padding: 8px 10px; border-radius: 10px; border: 2px solid #818cf8;
            background: white; color: #1e1b4b; font-size: 1rem; text-align: center; font-weight: bold;
        }

        /* ===== HASIL ===== */
        .hasil { background: #0f172a; border: 3px solid #6366f1; border-radius: 16px; overflow: hidden; }
        .hasil-header {
            display: flex; justify-content: space-between; align-items: center;
            padding: 12px 18px; background: #312e81; flex-wrap: wrap; gap: 8px;
        }
        .hasil-header .status {
            font-weight: 900; font-size: 1rem; padding: 5px 14px; border-radius: 999px;
            animation: pop .3s ease;
        }
        @keyframes pop { 0% { transform: scale(0); } 80% { transform: scale(1.15); } 100% { transform: scale(1); } }
        .st-ok { background: #22c55e; color: white; }
        .st-bikin { background: #3b82f6; color: white; }
        .st-salah { background: #ef4444; color: white; }
        .hasil-header .url { color: #a5b4fc; font-size: .85rem; font-family: Consolas, monospace; }
        .penjelasan-anak {
            padding: 12px 18px; background: #1e293b; color: #fde68a; font-size: .95rem;
            border-bottom: 2px solid #334155;
        }
        pre { padding: 16px; overflow: auto; max-height: 400px; font-size: .8rem; line-height: 1.55; color: #93c5fd; }

        .tips { text-align: center; color: #a5b4fc; font-size: .85rem; margin-top: 18px; }
    </style>
</head>
<body>
    <div class="container">

        <!-- HEADER -->
        <div class="hero">
            <h1><span class="balloon">🚗</span> Contoh CRUD — Belajar API itu Seru!</h1>
            <p>
                API itu seperti <b>pelayan di restoran</b> 🍽️: kita minta sesuatu (data mobil),
                pelayan pergi ke dapur (database), lalu bawa jawabannya kembali dalam bentuk <b>JSON</b>.
                Dokumentasi lengkap: <a href="/docs/api" target="_blank">/docs/api</a>
            </p>
        </div>

        <!-- ANALOGI BESAR -->
        <div class="analogi-box">
            <span class="emoji-besar">📒</span>
            <b>Analogi: Buku Catatan Toko Mobil.</b><br>
            Bayangkan database itu seperti <b>buku catatan besar</b> di toko mobil:
            <b>CRUD</b> adalah 4 hal yang bisa kita lakukan pada buku itu —
            <b>C</b>reate (nulis catatan baru ✏️), <b>R</b>ead (baca catatan 👀),
            <b>U</b>pdate (betulkan catatan lama 🩹), <b>D</b>elete (sobek halus catatan 🗑️).
            Setiap kali kita menekan tombol di bawah, komputer "berbicara" dengan buku catatan itu
            dan membalas dengan surat berisi angka — itu yang disebut <b>status code</b>!
        </div>

        <!-- KARTU AKSI -->
        <div class="grid">
            <div class="kartu k-lihat" onclick="run('GET','/api/mobil','all')">
                <span class="emoji">👀</span>
                <div class="judul">Lihat Semua Mobil</div>
                <span class="method">GET</span>
                <div class="cerita">Seperti <b>membuka seluruh buku catatan</b> dan membacakan semua mobil yang ada di toko.</div>
            </div>

            <div class="kartu k-lihat" onclick="run('GET','/api/mobil?brand=Toyota&status=tersedia','filter')">
                <span class="emoji">🔍</span>
                <div class="judul">Cari Mobil Toyota</div>
                <span class="method">GET + filter</span>
                <div class="cerita">Seperti bilang, <i>"Bu, tolong buka halaman yang cuma berisi Toyota ya!"</i> — itu namanya <b>filter</b>.</div>
            </div>

            <div class="kartu k-lihat" onclick="run('GET','/api/mobil/'+getId(),'detail')">
                <span class="emoji">📖</span>
                <div class="judul">Lihat 1 Mobil Saja</div>
                <span class="method">GET /{id}</span>
                <div class="cerita">Seperti <b>membuka satu halaman</b> di nomor yang kita pilih di bawah. Setiap mobil punya nomor halaman (ID).</div>
            </div>

            <div class="kartu k-bikin" onclick="run('POST','/api/mobil','create',payload())">
                <span class="emoji">✏️</span>
                <div class="judul">Tambah Mobil Baru</div>
                <span class="method">POST</span>
                <div class="cerita">Seperti <b>menulis halaman baru</b> di buku catatan: "Hari ini datang mobil Daihatsu Sigra!" — bukunya jadi lebih tebal.</div>
            </div>

            <div class="kartu k-ubah" onclick="run('PUT','/api/mobil/'+getId(),'update',payload())">
                <span class="emoji">🩹</span>
                <div class="judul">Update Mobil</div>
                <span class="method">PUT /{id}</span>
                <div class="cerita">Seperti <b>menghapus lalu menulis ulang</b> halaman lama — misal harga mobil tadi naik, kita betulkan catatannya.</div>
            </div>

            <div class="kartu k-hapus" onclick="run('DELETE','/api/mobil/'+getId(),'delete')">
                <span class="emoji">🗑️</span>
                <div class="judul">Hapus Mobil</div>
                <span class="method">DELETE /{id}</span>
                <div class="cerita">Seperti <b>sobek halus satu halaman</b> buku catatan karena mobillah sudah terjual dan tidak perlu dicatat lagi.</div>
            </div>

            <div class="kartu k-salah k-bikin" onclick="run('POST','/api/mobil','post_kosong',{})">
                <span class="emoji">🙅</span>
                <div class="judul">Tanpa Data (Coba Salah)</div>
                <span class="method">POST kosong</span>
                <div class="cerita">Seperti <b>menulis halaman kosong</b> — petugas menolak: "Nama & harganya mana?" Komputer bilang <b>422</b>.</div>
            </div>

            <div class="kartu k-salah k-lihat" onclick="run('GET','/api/mobil/99999','404')">
                <span class="emoji">🤷</span>
                <div class="judul">Nomor Halaman Tidak Ada</div>
                <span class="method">GET /99999</span>
                <div class="cerita">Seperti <b>mencari halaman 99999</b> padahal bukunya cuma 100 halaman — jawabannya: "Tidak ditemukan!" alias <b>404</b>.</div>
            </div>
        </div>

        <!-- INPUT ID -->
        <div class="id-panel">
            <span>🔢 Mobil punya "nomor halaman" (ID). Setelah kamu klik <b>Lihat Semua Mobil</b> atau <b>Tambah Mobil Baru</b>, nomor valid akan terisi otomatis di sini:</span>
            <input id="mobilId" type="number" value="1" min="1">
        </div>

        <!-- HASIL -->
        <div class="hasil">
            <div class="hasil-header">
                <span class="status" id="status">🎉 Tekan tombol di atas!</span>
                <span class="url" id="url">request → API → JSON response</span>
            </div>
            <div class="penjelasan-anak" id="penjelasan">
                👆 Klik salah satu kartu, lalu di sini akan muncul penjelasan bahasa manusia + "surat balasan" JSON dari server.
            </div>
            <pre id="output">// Response JSON akan muncul di sini...</pre>
        </div>

        <p class="tips">
            💡 Angka-angka ajaib: <b>200</b> = "oke, ini datanya" · <b>201</b> = "oke, data baru sudah dibuat" ·
            <b>404</b> = "tidak ketemu" · <b>422</b> = "datamu salah/ belum lengkap"
        </p>
    </div>

    <script>
        function getId() {
            return document.getElementById('mobilId').value || 1;
        }

        function payload() {
            const tahun = new Date().getFullYear();
            return {
                nama: 'Sigra 1.2 Deluxe ' + tahun,
                brand: 'Daihatsu',
                harga: 165000000,
                tahun: tahun,
                transmisi: 'Matic',
                bahan_bakar: 'Bensin',
                status: 'tersedia',
                foto: 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=800&q=60',
                warna: 'Kuning Racing',
                kilometer: 0,
                plat_nomor: 'B 9999 XX',
                deskripsi: 'Mobil demo ditambahkan lewat halaman /contohCRUD.'
            };
        }

        const penjelasanAnak = {
            all: '👀 Kami meminta "daftar semua mobil" — server membuka seluruh buku catatan dan mengirimkan isinya. Perhatikan: semuanya dibungkus kata "data" dan ada "message" yang menyapa kita!',
            filter: '🔍 Kali ini kami minta Toyota yang masih tersedia saja — seperti meminta pelayan "yang ikan saja, Pak". Datanya jauh lebih sedikit karena disaring!',
            detail: '📖 Kami meminta satu halaman tertentu. Server mencari nomor halamannya, lalu mengirimkan satu mobil saja lengkap dengan warna, kilometer, dan plat nomornya.',
            create: '✏️ Kami menitipkan data mobil baru ke server. Server menulisnya di buku catatan dan membalas "201 Created" — artinya: "Sudah kutulis, ini salinannya!"',
            update: '🩹 Kami menimpa isi halaman lama dengan data baru. Server membalas "200 OK" plus salinan halaman yang sudah diperbarui.',
            delete: '🗑️ Kami menyuruh server menyobek satu halaman. Balasannya "200 OK" — dan di "data" tertulis null karena halamannya sudah tidak ada.',
            422: '🙅 Kami sengaja mengirim formulir kosong! Server menolak dengan sopan: "422 — isianmu kurang lengkap" lalu menunjukkan kolom mana yang salah. Ini yang bikin data di database tetap rapi!',
            404: '🤷 Kami mencari halaman 99999 yang tidak pernah ada. Server menjawab jujur: "404 — tidak ditemukan" tanpa marah.'
        };

        async function run(method, url, jenis, body) {
            const statusEl = document.getElementById('status');
            const urlEl = document.getElementById('url');
            const output = document.getElementById('output');
            const penjelasan = document.getElementById('penjelasan');

            statusEl.textContent = '⏳ Server sedang mencatat...';
            statusEl.className = 'status';
            penjelasan.textContent = '⏳';

            try {
                const options = { method, headers: { 'Accept': 'application/json' } };
                if (body && method !== 'GET' && method !== 'HEAD') {
                    options.headers['Content-Type'] = 'application/json';
                    options.body = JSON.stringify(body);
                }

                const res = await fetch(url, options);
                const json = await res.json();

                urlEl.textContent = method + ' ' + url;
                statusEl.textContent = res.status + ' ' + (res.status === 200 ? 'OK ✅' : res.status === 201 ? 'CREATED 🎉' : res.status === 404 ? 'NOT FOUND 🤷' : res.status === 422 ? 'UNPROCESSABLE 🙅' : '');
                statusEl.className = 'status ' + (res.status < 300 ? (res.status === 201 ? 'st-bikin' : 'st-ok') : 'st-salah');
                output.textContent = JSON.stringify(json, null, 2);
                penjelasan.textContent = penjelasanAnak[jenis] || 'Coba amati format "message" dan "data" di responsenya!';

                // Auto-isi input ID dengan ID pertama yang valid (biar demo tidak 404 karena ID lama terhapus)
                if (jenis === 'all' && Array.isArray(json.data) && json.data.length > 0) {
                    document.getElementById('mobilId').value = json.data[0].id;
                    document.getElementById('mobilId').max = json.data[json.data.length - 1].id;
                }
                if (jenis === 'create' && json.data && json.data.id) {
                    document.getElementById('mobilId').value = json.data.id;
                    penjelasan.textContent = penjelasanAnak.create + ' (ID barunya: ' + json.data.id + ' — input di bawah sudah otomatis diisi!)';
                }
            } catch (e) {
                statusEl.textContent = 'ERROR ❌';
                statusEl.className = 'status st-salah';
                output.textContent = String(e);
                penjelasan.textContent = 'Hmm, ada gangguan. Coba lagi ya!';
            }
        }
    </script>
</body>
</html>
