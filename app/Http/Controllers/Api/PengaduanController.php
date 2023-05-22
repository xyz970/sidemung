<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    use ApiResponse;

    public function insert(Request $request)
    {
        $input = $request->only(['user_nik','name','user_id','description','image','status']);
        $file = $request->file('image');

        // isi dengan nama folder tempat kemana file diupload
        $tujuan_upload = 'data_file';
        // upload file
        $file->move($tujuan_upload, $file->getClientOriginalName());
        
        Pengaduan::create($input);

        return $this->successResponse('Pengaduan berhasil ditambahkan');
        
    }
}
