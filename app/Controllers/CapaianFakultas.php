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
            ->orderBy('tahun', 'desc')
            ->get()->getResultArray();

        $data['triwulan'] = $this->db->table('triwulan')->get()->getResultArray();

        for ($i = 0; $i < count($data['triwulan']); $i++) {
            $data['triwulan'][$i]['bulan'] = explode(',', $data['triwulan'][$i]['keterangan']);
        }

        return view('capaian_fakultas/index', $data);
    }

    public function datatable()
    {
        $tahun = $this->request->getGet('tahun');
        $triwulan = $this->request->getGet('triwulan');

        $builder = $this->db->table('indikator_kinerja ik')
            ->join('capaian_fakultas c', 'c.indikator_kinerja_id = ik.indikator_kinerja_id')
            ->join('target_fakultas t', 't.indikator_kinerja_id = ik.indikator_kinerja_id')
            ->join('satuan s', 's.satuan_id = ik.satuan_id');

        if ($triwulan == 1) {
            $builder = $builder->select('
                c.capaian_fakultas_id,
                ik.indikator_kinerja_id,
                ik.kode_indikator_kinerja,
                s.nama_satuan,
                t.triwulan_satu as target,
                SUM(c.hasil) as capaian,
                c.file
            ');
        } else if ($triwulan == 2) {
            $builder = $builder->select('
                c.capaian_fakultas_id,
                ik.indikator_kinerja_id,
                ik.kode_indikator_kinerja,
                s.nama_satuan,
                t.triwulan_dua as target,
                SUM(c.hasil) as capaian,
                c.file
            ');
        } else if ($triwulan == 3) {
            $builder = $builder->select('
                c.capaian_fakultas_id,
                ik.indikator_kinerja_id,
                ik.kode_indikator_kinerja,
                s.nama_satuan,
                t.triwulan_tiga as target,
                SUM(c.hasil) as capaian,
                c.file
            ');
        } else if ($triwulan == 4) {
            $builder = $builder->select('
                c.capaian_fakultas_id,
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
                'c.triwulan_id' => $triwulan
            ]);

        return DataTable::of($builder)->toJson(TRUE);
    }

    public function modal_detail($id)
    {
        $capaian = $this->db->table('capaian_fakultas')->where('capaian_fakultas_id', $id)->get()->getRowArray();

        $data['capaian'] = $this->db->table('capaian_fakultas c')
            ->join('indikator_kinerja ik', 'ik.indikator_kinerja_id = c.indikator_kinerja_id')
            ->select('
                ik.kode_indikator_kinerja,
                c.indikator_kinerja_id,
                c.uraian,
                c.capaian,
                c.pembagi,
                c.hasil,
            ')
            ->where([
                'c.indikator_kinerja_id' => $capaian['indikator_kinerja_id'],
                'c.triwulan_id' => $capaian['triwulan_id']
            ])
            ->get()->getResultArray();

        $data['kode'] = $data['capaian'][0]['kode_indikator_kinerja'];
        $data['jumlah'] = 0;
        for ($i = 0; $i < count($data['capaian']); $i++) {
            $data['jumlah'] += $data['capaian'][$i]['hasil'];
        }

        $view = \Config\Services::renderer();
        $response['html'] = $view->setData($data)->render('capaian_fakultas/components/modal_detail');
        return $this->respond($response, 200);
    }

    public function isi_capaian($id)
    {
        $capaian = $this->db->table('capaian_fakultas')->where('capaian_fakultas_id', $id)->get()->getRowArray();

        $data['ik'] = $this->db->table('indikator_kinerja ik')
            ->join('target_fakultas t', 't.indikator_kinerja_id = ik.indikator_kinerja_id')
            ->join('capaian_fakultas c', 'c.indikator_kinerja_id = ik.indikator_kinerja_id')
            ->join('triwulan tr', 'tr.triwulan_id = c.triwulan_id')
            ->join('sasaran s', 's.sasaran_id = ik.sasaran_id');

        if ($capaian['triwulan_id'] == 1) {
            $data['ik'] = $data['ik']->select('
                ik.indikator_kinerja_id,
                ik.kode_indikator_kinerja,
                ik.keterangan,
                s.keterangan as sasaran,
                tr.nama_triwulan,
                t.triwulan_satu as target
            ');
        } else if ($capaian['triwulan_id'] == 2) {
            $data['ik'] = $data['ik']->select('
                ik.indikator_kinerja_id,
                ik.kode_indikator_kinerja,
                ik.keterangan,
                s.keterangan as sasaran,
                tr.nama_triwulan,
                t.triwulan_dua as target
            ');
        }
        if ($capaian['triwulan_id'] == 3) {
            $data['ik'] = $data['ik']->select('
                ik.indikator_kinerja_id,
                ik.kode_indikator_kinerja,
                ik.keterangan,
                s.keterangan as sasaran,
                tr.nama_triwulan,
                t.triwulan_tiga as target
            ');
        }
        if ($capaian['triwulan_id'] == 4) {
            $data['ik'] = $data['ik']->select('
                ik.indikator_kinerja_id,
                ik.kode_indikator_kinerja,
                ik.keterangan,
                s.keterangan as sasaran,
                tr.nama_triwulan,
                t.triwulan_empat as target
            ');
        }

        $data['ik'] = $data['ik']->where([
            'ik.indikator_kinerja_id' => $capaian['indikator_kinerja_id'],
            'c.triwulan_id' => $capaian['triwulan_id']
        ])
            ->get()->getRowArray();


        $data['capaian'] = $this->db->table('indikator_kinerja ik')
            ->join('capaian_fakultas c', 'c.indikator_kinerja_id = ik.indikator_kinerja_id')
            ->select('
                c.uraian,
                c.capaian,
                c.pembagi,
                c.hasil
            ')
            ->where([
                'c.indikator_kinerja_id' => $capaian['indikator_kinerja_id'],
                'c.triwulan_id' => $capaian['triwulan_id']
            ])
            ->get()->getResultArray();

        // dd($data);
        return view('capaian_fakultas/isi_capaian', $data);
    }
}
