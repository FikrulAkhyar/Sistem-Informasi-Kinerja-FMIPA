<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use \Config\Database;
use Hermawan\DataTables\DataTable;

class CapaianFakultas extends BaseController
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

        return view('capaian_fakultas/index', $data);
    }

    public function datatable()
    {
        $tahun = $this->request->getGet('tahun');

        $builder = $this->db->table('capaian c')
            ->join('indikator_kinerja ik', 'ik.ik_id = c.ik_id')
            ->join('satuan s', 's.satuan_id = ik.satuan_fakultas')
            ->select('
                ik.ik_id,
                ik.kode_ik,
                s.nama_satuan,
                c.capaian_id,
                c.triwulan_satu,
                c.triwulan_dua,
                c.triwulan_tiga,
                c.triwulan_empat
            ')
            ->groupBy('ik.kode_ik')
            ->where('ik.tahun', $tahun);

        return DataTable::of($builder)->toJson(TRUE);
    }
}
