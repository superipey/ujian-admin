<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Config;

class SoalController extends Controller
{
    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET");
    }

    public function index($id)
    {
        $data['ujian'] = \App\Ujian::find($id);
        $data['result'] = \App\Soal::where('id_ujian', $id)->get();
        return view('soal.list', $data);
    }

    public function create($id)
    {
        $data['ujian'] = \App\Ujian::find($id);
        return view('soal.form', $data);
    }

    public function store(Request $request, $id_ujian, $id = "")
    {
        $rules = [
            'pertanyaan' => 'required',
            'jawaban_a' => 'required',
            'jawaban_b' => 'required',
            'jawaban_c' => 'required',
            'jawaban_d' => 'required',
            'kunci_jawaban' => 'required',
        ];

        $this->validate($request, $rules);

        $input = $request->all();

        $input['id_ujian'] = $id_ujian;

        if (empty($id)) {
            $status = \App\Soal::create($input);
        } else {
            $soal = \App\Soal::find($id);
            $status = $soal->update($input);
        }

        if ($status) return redirect('soal/' . $id_ujian)->with('success', 'Data berhasil ' . (empty($id) ? 'ditambahkan' : 'diubah'));
        else return redirect('soal/' . $id_ujian)->with('error', 'Data gagal ' . (empty($id) ? 'ditambahkan' : 'diubah'));
    }

    public function edit($id_ujian, $id)
    {
        $data['ujian'] = \App\Ujian::find($id_ujian);
        $data['result'] = \App\Soal::find($id);
        return view('soal.form', $data);
    }

    public function destroy($ujian_id, $id)
    {
        $status = \App\Soal::destroy($id);
        if ($status) return redirect('soal/' . $ujian_id)->with('success', 'Data berhasil dihapus');
        else return redirect('soal/' . $ujian_id)->with('error', 'Data gagal dihapus');
    }

    public function show($slug)
    {
        $result = \App\Soal::where('slug', 'like', '%' . $slug . '%')->first();
        if ($result) return ['data' => $result];
        else return NULL;
    }

    public function getAll()
    {
        $result = \App\Soal::orderBy('tanggal', 'DESC')->get();
        if ($result) return ['data' => $result];
        else return NULL;
    }
}
