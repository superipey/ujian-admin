<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Config;

class MahasiswaController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        $data['result'] = \App\Mahasiswa::all();
        return view('mahasiswa.list', $data);
    }

    public function create()
    {
        return view('mahasiswa.form');
    }

    public function store(Request $request, $id = "")
    {
        $rules = [
            'nama_lengkap' => 'required',
            'id_kelas' => 'required|exists:t_kelas,id',
            'password' => 'required',
        ];

        if (!empty($id)) {
            if (@$request->old_nim != @$request->nim) $rules['nim'] = 'required|unique:t_mahasiswa';
        }

        $this->validate($request, $rules);

        $input = $request->all();

        if (empty($id)) {
            $status = \App\Mahasiswa::create($input);
        } else {
            $mahasiswa = \App\Mahasiswa::find($id);
            $status = $mahasiswa->update($input);
        }

        if ($status) return redirect('mahasiswa')->with('success', 'Data berhasil ' . (empty($id) ? 'ditambahkan' : 'diubah'));
        else return redirect('mahasiswa')->with('error', 'Data gagal ' . (empty($id) ? 'ditambahkan' : 'diubah'));
    }

    public function edit($id)
    {
        $data['result'] = \App\Mahasiswa::find($id);
        return view('mahasiswa.form', $data);
    }

    public function destroy($id)
    {
        $status = \App\Mahasiswa::destroy($id);
        if ($status) return redirect('mahasiswa')->with('success', 'Data berhasil dihapus');
        else return redirect('mahasiswa')->with('error', 'Data gagal dihapus');
    }

    public function show($slug)
    {
        $result = \App\Mahasiswa::where('slug', 'like', '%' . $slug . '%')->first();
        if ($result) return ['data' => $result];
        else return NULL;
    }

    public function getAll()
    {
        $result = \App\Mahasiswa::orderBy('tanggal', 'DESC')->get();
        if ($result) return ['data' => $result];
        else return NULL;
    }

    public function import(Request $request)
    {
        $file = $request->file('file');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        $data = $spreadsheet->getActiveSheet()->toArray();

        $i = 0;
        $updated = 0;
        $new = 0;
        foreach ($data as $row) {
            $model = [
                'nim' => $row[0],
                'nama_lengkap' => $row[1],
                'id_kelas' => $row[2],
                'password' => \Hash::make($row[0]),
            ];

            if ($i++ == 0) continue;
            $m = \App\Mahasiswa::where('nim', $model['nim'])->first();
            if (!empty($m)) {
                $m->update($model);
                $updated++;
            } else {
                \App\Mahasiswa::create($model);
                $new++;
            }
        }

        return redirect('/mahasiswa')->with('success', "Import data berhasil. Jumlah Data: $i, Data Baru: $new, Data Update: $updated");
    }

    public function reset(Request $request, $id)
    {
        $m = \App\Mahasiswa::find($id);
        if (empty($m)) redirect('/mahasiswa')->with('error', "Data tidak ditemukan");

        $m->password = \Hash::make($m->nim);
        $m->save();

        return redirect('/mahasiswa')->with('success', "Password untuk mahasiswa <strong>" . $m->nim . " - " . $m->nama_lengkap . "</strong> berhasil direset");
    }

    public function login(Request $request)
    {
        $credentials = $request->only('nim', 'password');
        try {
            if (! $token = auth('api')->attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (\JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function detail(Request $request)
    {
        return response()->json(['data' => $request->user() ]);
    }
}
