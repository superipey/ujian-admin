<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Config;

class SkeletonController extends Controller
{
    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET");
    }

    public function index()
    {
        $data['result'] = \App\Berita::all();
        return view('berita.list', $data);
    }

    public function create()
    {
        return view('berita.form');
    }

    public function store(Request $request, $id="")
    {
        $rules = [
            'judul' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required|date_format:d M Y',
            'gambar' => 'required|url'
        ];
        $this->validate($request, $rules);

        $input = $request->all();

        $input['deskripsi'] = str_replace(url('') . '/uploads', env('CDN_URL'), $input['deskripsi']);
        $input['gambar'] = str_replace(url('') . '/uploads', env('CDN_URL'), $input['gambar']);

        $input['slug'] = \Str::slug($input['judul']);

        if (empty($id)) {
            $status = \App\Berita::create($input);
        } else {
            $berita = \App\Berita::find($id);
            $status = $berita->update($input);
        }

        if ($status) return redirect('berita')->with('success', 'Data berhasil ' . (empty($id) ? 'ditambahkan' : 'diubah'));
        else return redirect('berita')->with('error', 'Data gagal ' . (empty($id) ? 'ditambahkan' : 'diubah'));
    }

    public function edit($id)
    {
        $data['result'] = \App\Berita::find($id);
        return view('berita.form', $data);
    }

    public function destroy($id)
    {
        $status = \App\Berita::destroy($id);
        if ($status) return redirect('berita')->with('success', 'Data berhasil dihapus');
        else return redirect('berita')->with('error', 'Data gagal dihapus');
    }

    public function show($slug)
    {
        $result = \App\Berita::where('slug', 'like', '%' . $slug . '%')->first();
        if ($result) return ['data' => $result];
        else return null;
    }

    public function getAll()
    {
        $result = \App\Berita::orderBy('tanggal', 'DESC')->get();
        if ($result) return ['data' => $result];
        else return null;
    }
}
