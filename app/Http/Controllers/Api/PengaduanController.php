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
        $auth = Auth::user();
        $input = $request->only(['user_nik', 'judul', 'description', 'status', 'alamat']);
        $namaFile = 'GambarPengajuan' . $auth->nik . '-' . $input['judul'] . '.jpg';
        rename(public_path() . '/data_file/GambarPengajuan' . $auth->nik . '.jpg', public_path() . '/data_file/' . $namaFile);
        $input += array('image' => $namaFile);
        Pengaduan::create($input);

        return $this->successResponse('Pengaduan berhasil dimasukkan');
    }

    public function upload_image(Request $request)
    {
        if ($request->has('image')) {
            $auth = Auth::user();
            $file = $request->file('image');

            // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'data_file';
            $namafile = 'GambarPengajuan' . "$auth->nik" . "." . $file->getClientOriginalExtension();
            // upload file
            $file->move($tujuan_upload, $namafile);
            return $this->successResponse($namafile);
        }
    }

    public function index($status)
    {
        $auth = Auth::user();
        // $pengaduan = Pengaduan::where('user_nik', '=', $auth->nik);
        switch ($status) {
            case '1':
                $pengaduan = Pengaduan::where('user_nik', '=', $auth->nik)->where('status', '=', 'Belum Diproses')->get();
                return response()->json($pengaduan);

                break;

            case '2':
                $pengaduan = Pengaduan::where('user_nik', '=', $auth->nik)->where('status', '=', 'Diproses')->get();
                return response()->json($pengaduan);

                break;

            default:
                $pengaduan = Pengaduan::where('user_nik', '=', $auth->nik)->where('status', '=', 'Selesai')->get();
                return response()->json($pengaduan);

                break;
        }
        // return response()->json($pengaduan);
        // return $this->successResponseData('Data',$pengaduan);
    }

    public function delete($id)
    {
        Pengaduan::where('id', '=', $id)->delete();
        return $this->successResponse('Data berhasil dihapus');
    }
}
