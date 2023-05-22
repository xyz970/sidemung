<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengaduanController extends Controller
{
    use ApiResponse;

    public function insert(Request $request)
    {
        $input = $request->only(['user_nik','judul','user_id','description','status','alamat']);
        $file = $request->file('image');

        // isi dengan nama folder tempat kemana file diupload
        $tujuan_upload = 'data_file';
        $namafile = 'GambarPengajuan'.$input['user_nik']."-".$input['judul'].".".$file->getClientOriginalExtension();
        // upload file
        $file->move($tujuan_upload, $namafile);
        $input += array('image'=>$namafile);
        Pengaduan::create($input);

        return $this->successResponse('Pengaduan berhasil ditambahkan');
        
    }

    public function index()
    {
        $auth = Auth::user();
        $pengaduan = Pengaduan::where('user_nik','=',$auth->nik)->get();
        return $this->responseCollection('Data Pengaduan',$pengaduan);
        // return $this->successResponseData('Data',$pengaduan);
    }

    public function delete($id)
    {
        Pengaduan::where('id','=',$id)->delete();
        return $this->successResponse('Data berhasil dihapus');
    }
}
