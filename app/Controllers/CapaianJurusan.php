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
            ->orderBy('tahun', 'desc')
            ->get()->getResultArray();

        $data['jurusan'] = $this->db->table('jurusan')->get()->getResultArray();
        $data['triwulan'] = $this->db->table('triwulan')->get()->getResultArray();

        for ($i = 0; $i < count($data['triwulan']); $i++) {
            $data['triwulan'][$i]['bulan'] = explode(',', $data['triwulan'][$i]['keterangan']);
        }

        return view('capaian_jurusan/index', $data);
    }

    public function modal_edit($id)
    {
        $data['capaian'] = $this->db->table('capaian_jurusan c')
            ->join('indikator_kinerja ik', 'ik.indikator_kinerja_id = c.indikator_kinerja_id')
            ->join('satuan s', 's.satuan_id = ik.satuan_jurusan')
            ->select('
                c.triwulan_satu,
                c.triwulan_dua,
                c.triwulan_tiga,
                c.triwulan_empat,
                s.nama_satuan
            ')
            ->where('capaian_jurusan_id', $id)
            ->get()->getRowArray();

        $view = \Config\Services::renderer();
        $response['html'] = $view->setVar('id', $id)->setData($data)->render('capaian_jurusan/components/modal_edit');
        return $this->respond($response, 200);
    }

    public function isi_capaian($id)
    {
        $data = [
            'triwulan_satu' => $this->request->getPost('tw1'),
            'triwulan_dua' => $this->request->getPost('tw2'),
            'triwulan_tiga' => $this->request->getPost('tw3'),
            'triwulan_empat' => $this->request->getPost('tw4'),
        ];

        if ($this->db->table('capaian_jurusan')->where('capaian_jurusan_id', $id)->update($data) === FALSE) {
            $response = [
                'message' => 'Gagal mengisi capaian'
            ];
            return $this->respond($response, 422);
        }

        $response = [
            'message' => 'Berhasil mengisi capaian'
        ];

        return $this->respond($response);
    }

    public function datatable()
    {
        $tahun = $this->request->getGet('tahun');
        $jurusan = $this->request->getGet('jurusan');
        $triwulan = $this->request->getGet('triwulan');

        $builder = $this->db->table('indikator_kinerja ik')
            ->join('capaian_jurusan c', 'c.indikator_kinerja_id = ik.indikator_kinerja_id')
            ->join('target_jurusan t', 't.indikator_kinerja_id = ik.indikator_kinerja_id')
            ->join('satuan s', 's.satuan_id = ik.satuan_id');

        if ($triwulan == 1) {
            $builder = $builder->select('
                c.capaian_jurusan_id,
                ik.indikator_kinerja_id,
                ik.kode_indikator_kinerja,
                s.nama_satuan,
                t.triwulan_satu as target,
                SUM(c.hasil) as capaian,
                c.file
            ');
        } else if ($triwulan == 2) {
            $builder = $builder->select('
                c.capaian_jurusan_id,
                ik.indikator_kinerja_id,
                ik.kode_indikator_kinerja,
                s.nama_satuan,
                t.triwulan_dua as target,
                SUM(c.hasil) as capaian,
                c.file
            ');
        } else if ($triwulan == 3) {
            $builder = $builder->select('
                c.capaian_jurusan_id,
                ik.indikator_kinerja_id,
                ik.kode_indikator_kinerja,
                s.nama_satuan,
                t.triwulan_tiga as target,
                SUM(c.hasil) as capaian,
                c.file
            ');
        } else if ($triwulan == 4) {
            $builder = $builder->select('
                c.capaian_jurusan_id,
                ik.indikator_kinerja_id,
                ik.kode_indikator_kinerja,
                s.nama_satuan,
                t.triwulan_empat as target,
                SUM(c.hasil) as capaian,
                c.file
            ');
        }

        $builder = $builder->groupBy('ik.kode_indikator_kinerja')
            ->where([
                'ik.tahun' => $tahun,
                'c.triwulan_id' => $triwulan,
                'c.jurusan_id' => $jurusan,
                't.jurusan_id' => $jurusan,
            ]);

        return DataTable::of($builder)->toJson(TRUE);
    }
}
