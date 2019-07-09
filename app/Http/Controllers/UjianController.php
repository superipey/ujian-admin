<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Config;

class UjianController extends Controller
{
    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET");
    }

    public function index()
    {
        $data['result'] = \App\Ujian::all();
        return view('atur_ujian.list', $data);
    }

    public function create()
    {
        return view('atur_ujian.form');
    }

    public function store(Request $request, $id = "")
    {
        $rules = [
            'nama_ujian' => 'required',
            'tanggal_mulai' => 'required|dateFormat:d M Y H:i:s',
            'tanggal_selesai' => 'required|dateFormat:d M Y H:i:s',
            'token' => 'required',
            'password' => 'required',
        ];

        if (!empty($id)) {
            if (@$request->old_nim != @$request->nim) $rules['nim'] = 'required|unique:t_atur_ujian';
        }

        $this->validate($request, $rules);

        $input = $request->all();

        if (empty($id)) {
            $status = \App\Ujian::create($input);
        } else {
            $atur_ujian = \App\Ujian::find($id);
            $status = $atur_ujian->update($input);
        }

        if ($status) return redirect('atur_ujian')->with('success', 'Data berhasil ' . (empty($id) ? 'ditambahkan' : 'diubah'));
        else return redirect('atur_ujian')->with('error', 'Data gagal ' . (empty($id) ? 'ditambahkan' : 'diubah'));
    }

    public function edit($id)
    {
        $data['result'] = \App\Ujian::find($id);
        return view('atur_ujian.form', $data);
    }

    public function destroy($id)
    {
        $status = \App\Ujian::destroy($id);
        if ($status) return redirect('atur_ujian')->with('success', 'Data berhasil dihapus');
        else return redirect('atur_ujian')->with('error', 'Data gagal dihapus');
    }

    public function show($slug)
    {
        $result = \App\Ujian::where('slug', 'like', '%' . $slug . '%')->first();
        if ($result) return ['data' => $result];
        else return NULL;
    }

    public function getAll()
    {
        $result = \App\Ujian::where('status', 1)->orderBy('tanggal_mulai', 'DESC')->get();
        if ($result) return ['data' => $result];
        else return [];
    }

    public function getOne($id)
    {
        $result = \App\Ujian::find($id);
        if ($result) return ['data' => $result];
        else return [];
    }

    public function getSoal(Request $request, $id)
    {
        $token = $request->input('token');

        $soal = [];
        $result = \App\Ujian::where('id', $id)->where('token', $token)->first();
        foreach ($result->soal()->inRandomOrder()->get() as $row) {
            $kunci = "jawaban_" . strtolower($row->kunci_jawaban);
            $kunci_data = $row->$kunci;

            $jawaban = [$row->jawaban_a, $row->jawaban_b, $row->jawaban_c, $row->jawaban_d];
            shuffle($jawaban);

            $kunci_new = "GET-RANDOM-DATA-" . array_search($kunci_data, $jawaban);

            $_soal = [
                'id' => $row->id,
                'id_ujian' => $row->id_ujian,
                'pertanyaan' => $row->pertanyaan,
                'token' => \Hash::make($kunci_new)
            ];

            $h = 'a';
            foreach ($jawaban as $new_jawaban) {
                $k = 'jawaban_' . ($h++);
                $_soal[$k] = $new_jawaban;
            }
            $soal[] = $_soal;
        }
        if ($result) return ['data' => $soal];
        else return [];
    }

    public function submit(Request $request, $id)
    {
        $user = auth()->user();
        $ujian = \App\Ujian::find($id);
        $benar = 0;
        $salah = 0;

        $data = [];

        foreach ($request->answer as $row) {
            $jawaban = @$row['jawaban'];
            $token = @$row['token'];

            if (empty($jawaban) || empty($token)) continue;

            $kunci = '';
            if (\Hash::check('GET-RANDOM-DATA-0', $token)) {
                $kunci = 'a';
                if ($jawaban == 'a') $benar++;
            } else if (\Hash::check('GET-RANDOM-DATA-1', $token)) {
                $kunci = 'b';
                if ($jawaban == 'b') $benar++;
            } else if (\Hash::check('GET-RANDOM-DATA-2', $token)) {
                $kunci = 'c';
                if ($jawaban == 'c') $benar++;
            } else if (\Hash::check('GET-RANDOM-DATA-3', $token)) {
                $kunci = 'd';
                if ($jawaban == 'd') $benar++;
            } else $salah++;

            $data[] = ['id_soal' => @$row['id'], 'kunci' => $kunci, 'jawaban' => $jawaban, 'token' => $token];
        }

        \App\Answer::create([
            'id_mahasiswa' => $user->id,
            'id_ujian' => $id,
            'jumlah_soal' => $ujian->jumlah_soal,
            'benar' => $benar,
            'salah' => $salah,
            'score' => $benar / $ujian->jumlah_soal * 100,
            'answer' => json_encode($data)
        ]);

        return [
            'benar' => $benar,
            'salah' => $salah,
            'score' => number_format(($benar / $ujian->jumlah_soal) * 100, 2)
        ];
    }
}
