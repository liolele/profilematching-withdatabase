<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Model_profile extends CI_Model
{

	function ambil_data()
	{
		// $dataMahasiswa = $this->db->query('SELECT * FROM mahasiswa');
		$query = $this->db->get('mahasiswa')->result_array();

		return $query;
	}
	function data_mk($nim)
	{

		$result = $this->db->query("SELECT a.nama, a.nim, b.mkid, b.nama_mk, d.angka FROM mahasiswa as a JOIN mhsmk as e ON e.nim=a.nim JOIN matakuliah as b ON e.mkid = b.mkid JOIN grade as d ON e.idnilai=d.idnilai WHERE a.nim=$nim ORDER BY b.mkid")->result_array();


		return $result;
	}
	function get_nama_from_nim($nim)
	{
		$result = $this->db->query("SELECT nama FROM mahasiswa  WHERE nim=$nim")->row_array();
		// $this->db->select('nama');
		// $this->db->where('nim', $nim);
		// $result = $this->db->get('mahasiswa')->row_array();
		return $result;
	}
	function get_minat_struktur($nim, $idminat)
	{
		$result = $this->db->query(
			"SELECT a.nama, a.nim, b.mkid, b.nama_mk, d.angka, f.core FROM mahasiswa as a JOIN mhsmk as e ON e.nim=a.nim JOIN matakuliah as b ON e.mkid = b.mkid JOIN minat as f ON f.mkid=e.mkid JOIN grade as d ON e.idnilai=d.idnilai WHERE a.nim=$nim AND f.idminat=$idminat "
		);

		return $result->result_array();
	}
}
