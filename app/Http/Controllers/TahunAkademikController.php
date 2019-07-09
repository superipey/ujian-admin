<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Config;

class TahunAkademikController extends Controller
{
    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET");
    }

    public function index()
    {
        $data['result'] = \App\TahunAkademik::all();
        return view('tahun_akademik.list', $data);
    }

    public function create()
    {
        return view('tahun_akademik.form');
    }

    public function store(Request $request, $id="")
    {
        $rules = [
            'tahun_akademik' => 'required',
        ];
        $this->validate($request, $rules);

        $input = $request->all();

        if (empty($id)) {
            $status = \App\TahunAkademik::create($input);
        } else {
            $tahun_akademik = \App\TahunAkademik::find($id);
            $status = $tahun_akademik->update($input);
        }

        if ($status) return redirect('tahun_akademik')->with('success', 'Data berhasil ' . (empty($id) ? 'ditambahkan' : 'diubah'));
        else return redirect('tahun_akademik')->with('error', 'Data gagal ' . (empty($id) ? 'ditambahkan' : 'diubah'));
    }

    public function edit($id)
    {
        $data['result'] = \App\TahunAkademik::find($id);
        return view('tahun_akademik.form', $data);
    }

    public function destroy($id)
    {
        $status = \App\TahunAkademik::destroy($id);
        if ($status) return redirect('tahun_akademik')->with('success', 'Data berhasil dihapus');
        else return redirect('tahun_akademik')->with('error', 'Data gagal dihapus');
    }

    public function show($slug)
    {
        $result = \App\TahunAkademik::where('slug', 'like', '%' . $slug . '%')->first();
        if ($result) return ['data' => $result];
        else return null;
    }

    public function getAll()
    {
        $result = \App\TahunAkademik::orderBy('tanggal', 'DESC')->get();
        if ($result) return ['data' => $result];
        else return null;
    }
}
