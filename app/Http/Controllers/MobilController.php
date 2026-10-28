<?php

namespace App\Http\Controllers;

use App\Http\Resources\MobilResource;
use App\Models\Mobil;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MobilController extends Controller
{
    /**
     * Menampilkan daftar seluruh mobil.
     *
     * Mendukung query parameter pencarian & penyaringan (bonus):
     * ?search=avanza&brand=Toyota&status=tersedia
     */
    public function index(Request $request): JsonResponse
    {
        $mobils = Mobil::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->query('search');

                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                        ->orWhere('brand', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('brand'), fn ($query) => $query->where('brand', $request->query('brand')))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->query('status')))
            ->when($request->filled('transmisi'), fn ($query) => $query->where('transmisi', $request->query('transmisi')))
            ->latest()
            ->get();

        return MobilResource::collection($mobils)
            ->additional(['message' => 'Daftar mobil berhasil diambil'])
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Menambahkan unit mobil baru ke database.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:150'],
            'brand' => ['required', 'string', 'max:100'],
            'harga' => ['required', 'integer', 'min:0'],
            'tahun' => ['required', 'integer', 'digits:4', 'min:1900', 'max:' . (date('Y') + 1)],
            'transmisi' => ['required', 'string', 'in:Manual,Matic,CVT'],
            'bahan_bakar' => ['required', 'string', 'in:Bensin,Diesel,Hybrid,Listrik'],
            'status' => ['required', 'string', 'in:tersedia,sold'],
            'foto' => ['nullable', 'string', 'url', 'max:500'],
            'warna' => ['nullable', 'string', 'max:50'],
            'kilometer' => ['nullable', 'integer', 'min:0'],
            'plat_nomor' => ['nullable', 'string', 'max:12'],
            'deskripsi' => ['nullable', 'string', 'max:2000'],
        ], self::messages());

        $mobil = Mobil::create($validated);

        return (new MobilResource($mobil))
            ->additional(['message' => 'Data mobil berhasil ditambahkan'])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Menampilkan detail satu mobil berdasarkan ID.
     */
    public function show(Mobil $mobil): JsonResponse
    {
        return (new MobilResource($mobil))
            ->additional(['message' => 'Detail mobil berhasil diambil'])
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Memperbarui data mobil yang sudah ada.
     */
    public function update(Request $request, Mobil $mobil): JsonResponse
    {
        $validated = $request->validate([
            'nama' => ['sometimes', 'string', 'max:150'],
            'brand' => ['sometimes', 'string', 'max:100'],
            'harga' => ['sometimes', 'integer', 'min:0'],
            'tahun' => ['sometimes', 'integer', 'digits:4', 'min:1900', 'max:' . (date('Y') + 1)],
            'transmisi' => ['sometimes', 'string', 'in:Manual,Matic,CVT'],
            'bahan_bakar' => ['sometimes', 'string', 'in:Bensin,Diesel,Hybrid,Listrik'],
            'status' => ['sometimes', 'string', 'in:tersedia,sold'],
            'foto' => ['nullable', 'string', 'url', 'max:500'],
            'warna' => ['nullable', 'string', 'max:50'],
            'kilometer' => ['nullable', 'integer', 'min:0'],
            'plat_nomor' => ['nullable', 'string', 'max:12'],
            'deskripsi' => ['nullable', 'string', 'max:2000'],
        ], self::messages());

        $mobil->update($validated);

        return (new MobilResource($mobil->fresh()))
            ->additional(['message' => 'Data mobil berhasil diperbarui'])
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Menghapus unit mobil dari database.
     */
    public function destroy(Mobil $mobil): JsonResponse
    {
        $mobil->delete();

        return response()->json([
            'message' => 'Data mobil berhasil dihapus',
            'data' => null,
        ], 200);
    }

    /**
     * Pesan validasi kustom berbahasa Indonesia.
     *
     * @return array<string, string>
     */
    private static function messages(): array
    {
        return [
            'required' => 'Kolom :attribute wajib diisi.',
            'string' => 'Kolom :attribute harus berupa teks.',
            'integer' => 'Kolom :attribute harus berupa angka.',
            'min' => 'Kolom :attribute minimal :min.',
            'max' => 'Kolom :attribute maksimal :max.',
            'digits' => 'Kolom :attribute harus terdiri dari :digits digit.',
            'in' => 'Nilai :attribute tidak valid. Pilihan: :values.',
            'url' => 'Kolom :attribute harus berupa URL yang valid.',
            'nama.required' => 'Kolom nama mobil wajib diisi.',
            'harga.required' => 'Kolom harga wajib diisi.',
            'harga.integer' => 'Kolom harga harus berupa angka.',
            'tahun.digits' => 'Kolom tahun harus terdiri dari 4 digit.',
        ];
    }
}
