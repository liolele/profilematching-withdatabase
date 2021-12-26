<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('model_profile');
    $this->load->helper('url', 'array');
    if (!$this->session->userdata('username')) {
      redirect('login/index');
    }
  }

  public function index()
  {
    $data['title'] = "dashboard";
    $data['info'] = $this->model_profile->ambil_data();


    // $columns = array_column($data['info'], 'total');
    // array_multisort($columns, SORT_DESC, $data['info']);
    $this->load->view('dashboard', $data);
  }

  public function analisis()
  {
    $data['nim'] = $this->input->get('nim');
    $data['nama'] = $this->model_profile->get_nama_from_nim($data['nim']);

    $data['info'] = $this->model_profile->data_mk($data['nim']);

    $data['peminatan'] = $this->peminatan($data['nim']);
    arsort($data['peminatan']);
    // echo "<pre>";
    // print_r($data['peminatan']);

    // exit;

    $this->load->view('personaldata', $data);
  }

  function peminatan($nim)
  {
    $datastruktur = $this->model_profile->get_minat_struktur($nim, '1');
    $hasil['Struktur'] = $this->hitung($nim, $datastruktur);
    $datageoteknik = $this->model_profile->get_minat_struktur($nim, '2');
    $hasil['Geoteknik'] = $this->hitung($nim, $datageoteknik);
    $datatrans = $this->model_profile->get_minat_struktur($nim, '3');
    $hasil['Transoprtasi'] = $this->hitung($nim, $datatrans);
    $datasumberair = $this->model_profile->get_minat_struktur($nim, '4');
    $hasil['Air'] = $this->hitung($nim, $datasumberair);
    $datamanagement = $this->model_profile->get_minat_struktur($nim, '5');
    $hasil['Management'] = $this->hitung($nim, $datamanagement);


    return $hasil;
  }

  function hitung($nim, $data)
  {
    $daftarbobotcore = array();
    $daftarbobotscnd = array();
    $target = 4;

    /*  print_r(count($datastruktur));
    exit(); */
    for ($x = 0; $x < count($data); $x++) {
      if ($data[$x]['core'] == "1" or $data[$x]['core'] == "2") {
        $selisih = $data[$x]['angka'] - $target;
        if ($selisih == -4) {
          // $bobot = 1;
          $data[$x]['bobot'] = 1;
          if ($data[$x]['core'] == "1") {
            array_push($daftarbobotcore, $data[$x]['bobot']);
          } else {
            array_push($daftarbobotscnd, $data[$x]['bobot']);
          }
        }
        if ($selisih == -3) {
          // $bobot = 2;
          $data[$x]['bobot'] = 2;
          if ($data[$x]['core'] == "1") {
            array_push($daftarbobotcore, $data[$x]['bobot']);
          } else {
            array_push($daftarbobotscnd, $data[$x]['bobot']);
          }
        }
        if ($selisih == -2) {
          // $bobot = 3;
          $data[$x]['bobot'] = 3;
          if ($data[$x]['core'] == "1") {
            array_push($daftarbobotcore, $data[$x]['bobot']);
          } else {
            array_push($daftarbobotscnd, $data[$x]['bobot']);
          }
        }
        if ($selisih == -1) {
          // $bobot = 4;
          $data[$x]['bobot'] = 4;
          if ($data[$x]['core'] == "1") {
            array_push($daftarbobotcore, $data[$x]['bobot']);
          } else {
            array_push($daftarbobotscnd, $data[$x]['bobot']);
          }
        }
        if ($selisih == 0) {
          // $bobot = 5;
          $data[$x]['bobot'] = 5;
          if ($data[$x]['core'] == "1") {
            array_push($daftarbobotcore, $data[$x]['bobot']);
          } else {
            array_push($daftarbobotscnd, $data[$x]['bobot']);
          }
        }
      }
    }


    if (!empty($daftarbobotcore)) {
      if (!empty($daftarbobotscnd)) {
        $perhitungan = ((array_sum($daftarbobotcore) / count($daftarbobotcore)) + (array_sum($daftarbobotscnd) / count($daftarbobotscnd))) / 2;
      } else {
        $perhitungan = (array_sum($daftarbobotcore) / count($daftarbobotcore) + 0) / 2;
      }
    }

    return number_format($perhitungan, 2);
  }
}
