<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrasaranaRequest;
use App\Models\LogAktivitas;
use App\Models\Prasarana;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PrasaranaController extends Controller
{
    public function index(Request $request): View
    {
        $prasarana = Prasarana::query()
            ->withCount('sarana')
            ->when($request->filled('q'), function ($query) use ($request) {
                $kata = $request->q;

                $query->where(function ($w) use ($kata) {
                    $w->where('kode_ruang', 'like', "%{$kata}%")
                        ->orWhere('nama_ruang', 'like', "%{$kata}%")
                        ->orWhere('penanggung_jawab', 'like', "%{$kata}%");
                });
            })
            ->when($request->filled('jenis'), fn ($query) => $query->where('jenis', $request->jenis))
            ->when($request->filled('kondisi'), fn ($query) => $query->where('kondisi', $request->kondisi))
            ->orderBy('kode_ruang')
            ->paginate(10)
            ->withQueryString();

        return view('prasarana.index', [
            'prasarana' => $prasarana,
            'jenisList' => Prasarana::JENIS,
            'kondisiList' => Prasarana::KONDISI,
        ]);
    }

    public function create(): View
    {
        return view('prasarana.create', [
            'prasarana' => new Prasarana([
                'kode_ruang' => Prasarana::kodeBerikutnya(),
                'kondisi' => 'baik',
            ]),
            'jenisList' => Prasarana::JENIS,
            'kondisiList' => Prasarana::KONDISI,
        ]);
    }

    public function store(PrasaranaRequest $request): RedirectResponse
    {
        $data = $request->validated();
        unset($data['hapus_foto']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('prasarana', 'public');
        } else {
            unset($data['foto']);
        }

        $prasarana = Prasarana::create($data);

        LogAktivitas::catat(
            'tambah',
            'prasarana',
            "Menambah prasarana {$prasarana->kode_ruang} - {$prasarana->nama_ruang}."
        );

        return redirect()
            ->route('prasarana.index')
            ->with('success', 'Data prasarana berhasil ditambahkan.');
    }

    public function show(Prasarana $prasarana): View
    {
        $prasarana->load('sarana.kategori');

        return view('prasarana.show', compact('prasarana'));
    }

    public function edit(Prasarana $prasarana): View
    {
        return view('prasarana.edit', [
            'prasarana' => $prasarana,
            'jenisList' => Prasarana::JENIS,
            'kondisiList' => Prasarana::KONDISI,
        ]);
    }

    public function update(PrasaranaRequest $request, Prasarana $prasarana): RedirectResponse
    {
        $data = $request->validated();
        unset($data['hapus_foto']);

        if ($request->hasFile('foto')) {
            if ($prasarana->foto) {
                Storage::disk('public')->delete($prasarana->foto);
            }
            $data['foto'] = $request->file('foto')->store('prasarana', 'public');
        } elseif ($request->boolean('hapus_foto')) {
            if ($prasarana->foto) {
                Storage::disk('public')->delete($prasarana->foto);
            }
            $data['foto'] = null;
        } else {
            unset($data['foto']);
        }

        $prasarana->update($data);

        LogAktivitas::catat(
            'ubah',
            'prasarana',
            "Mengubah prasarana {$prasarana->kode_ruang} - {$prasarana->nama_ruang}."
        );

        return redirect()
            ->route('prasarana.index')
            ->with('success', 'Data prasarana berhasil diperbarui.');
    }

    public function destroy(Prasarana $prasarana): RedirectResponse
    {
        if ($prasarana->sarana()->exists()) {
            return back()->with('error', 'Prasarana tidak dapat dihapus karena masih memiliki data sarana.');
        }

        $label = "{$prasarana->kode_ruang} - {$prasarana->nama_ruang}";
        $foto = $prasarana->foto;

        try {
            $prasarana->delete();
        } catch (QueryException $e) {
            return back()->with('error', 'Prasarana tidak dapat dihapus karena sudah dipakai pada data lain.');
        }

        if ($foto) {
            Storage::disk('public')->delete($foto);
        }

        LogAktivitas::catat('hapus', 'prasarana', "Menghapus prasarana {$label}.");

        return redirect()
            ->route('prasarana.index')
            ->with('success', 'Data prasarana berhasil dihapus.');
    }
}