<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use \Config\Database;
use Hermawan\DataTables\DataTable;

class IndikatorKinerja extends BaseController
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

        return view('indikator_kinerja/index', $data);
    }

    public function create()
    {
        $data['sasaran'] = $this->db->table('sasaran')->get()->getResultArray();
        $data['satuan'] = $this->db->table('satuan')->get()->getResultArray();
        $data['cascading'] = $this->db->table('cascading')->get()->getResultArray();

        return view('indikator_kinerja/create', $data);
    }

    public function edit($id)
    {
        $data['ik'] = $this->db->table('indikator_kinerja')
            ->where('ik_id', $id)
            ->get()->getRowArray();

        $data['ik']['cascading_fakultas'] = explode(',', $data['ik']['cascading_fakultas']);
        $data['ik']['cascading_jurusan'] = explode(',', $data['ik']['cascading_jurusan']);

        $data['sasaran'] = $this->db->table('sasaran')->get()->getResultArray();
        $data['satuan'] = $this->db->table('satuan')->get()->getResultArray();
        $data['cascading'] = $this->db->table('cascading')->get()->getResultArray();

        return view('indikator_kinerja/edit', $data);
    }

    public function datatable()
    {
        $tahun = $this->request->getGet('tahun');

        $builder = $this->db->table('indikator_kinerja')
            ->select('
                ik_id,
                kode_ik,
                target
            ');

        if ($tahun) {
            $builder->where('tahun', $tahun);
        }

        return DataTable::of($builder)->toJson(TRUE);
    }

    public function modal_delete($id)
    {
        $view = \Config\Services::renderer();
        $response['html'] = $view->setVar('id', $id)->render('indikator_kinerja/components/modal_delete');
        return $this->respond($response, 200);
    }
}
