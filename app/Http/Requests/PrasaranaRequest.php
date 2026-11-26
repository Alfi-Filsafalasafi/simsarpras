<?php

namespace App\Http\Requests;

use App\Models\Prasarana;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PrasaranaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole(User::ROLE_ADMIN, User::ROLE_PETUGAS) ?? false;
    }

    public function rules(): array
    {
        $id = $this->route('prasarana')?->id;

        return [
            'kode_ruang' => ['required', 'string', 'max:20', Rule::unique('prasarana', 'kode_ruang')->ignore($id)],
            'nama_ruang' => ['required', 'string', 'max:150'],
            'jenis' => ['required', Rule::in(Prasarana::JENIS)],
            'luas' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'kapasitas' => ['nullable', 'integer', 'min:0'],
            'tahun_bangun' => ['nullable', 'integer', 'between:1900,'.date('Y')],
            'kondisi' => ['required', Rule::in(array_keys(Prasarana::KONDISI))],
            'penanggung_jawab' => ['nullable', 'string', 'max:100'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'hapus_foto' => ['nullable', 'boolean'],
            'keterangan' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'unique' => ':attribute sudah digunakan.',
            'in' => ':attribute tidak valid.',
            'numeric' => ':attribute harus berupa angka.',
            'integer' => ':attribute harus berupa bilangan bulat.',
            'min' => ':attribute tidak boleh kurang dari :min.',
            'between' => ':attribute harus antara :min dan :max.',
            'max' => 'Panjang :attribute maksimal :max karakter.',
            'luas.max' => 'Nilai luas terlalu besar.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format foto harus jpg, jpeg, png, atau webp.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
        ];
    }

    public function attributes(): array
    {
        return [
            'kode_ruang' => 'Kode ruang',
            'nama_ruang' => 'Nama ruang',
            'jenis' => 'Jenis',
            'luas' => 'Luas',
            'kapasitas' => 'Kapasitas',
            'tahun_bangun' => 'Tahun bangun',
            'kondisi' => 'Kondisi',
            'penanggung_jawab' => 'Penanggung jawab',
            'foto' => 'Foto',
            'keterangan' => 'Keterangan',
        ];
    }
}