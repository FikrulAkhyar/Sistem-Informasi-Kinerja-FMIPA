<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use \Config\Database;
use Hermawan\DataTables\DataTable;

class CapaianJurusan extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function index()
    {
        $data['tahun'] = $this->db->table('indikator_kinerja')
            ->select('
                tahun
            ')
            ->groupBy('tahun')
            ->get()->getResultArray();

        $data['jurusan'] = $this->db->table('jurusan')->get()->getResultArray();

        return view('capaian_jurusan/index', $data);
    }

    public function modal_edit($id)
    {
        $data['capaian'] = $this->db->table('capaian')
            ->select('
                triwulan_satu,
                triwulan_dua,
                triwulan_tiga,
                triwulan_empat,
            ')
            ->where('capaian_id', $id)
            ->get()->getRowArray();

        $view = \Config\Services::renderer();
        $response['html'] = $view->setVar('id', $id)->setData($data)->render('capaian_jurusan/components/modal_edit');
        return $this->respond($response, 200);
    }

    public function datatable()
    {
        $tahun = $this->request->getGet('tahun');
        $jurusan = $this->request->getGet('jurusan');

        $builder = $this->db->table('capaian c')
            ->join('indikator_kinerja ik', 'ik.ik_id = c.ik_id')
            ->join('satuan s', 's.satuan_id = ik.satuan_jurusan')
            ->select('
                ik.ik_id,
                ik.kode_ik,
                s.nama_satuan,
                c.capaian_id,
                c.triwulan_satu,
                c.triwulan_dua,
                c.triwulan_tiga,
                c.triwulan_empat
            ');

        if ($tahun) {
            $builder->where('ik.tahun', $tahun);
        }
        if ($jurusan) {
            $builder->where('c.jurusan_id', $jurusan);
        }

        return DataTable::of($builder)->toJson(TRUE);
    }
}
