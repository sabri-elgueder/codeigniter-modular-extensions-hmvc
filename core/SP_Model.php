<?php defined('BASEPATH') OR exit('No direct script access allowed');

class SP_Model extends CI_Model {
	protected $primary;
	protected $table;
	protected $all;
	function __construct(){
		parent::__construct();
	}


	function save($data){
		if(isset($data[$this->primary])){
			$save = $data;
			unset($save[$this->primary]);
			$this->db->where($this->primary, $data[$this->primary])->update($this->table, $save);
			return $this->findOne($data[$this->primary]);
		}else{
			$defaults = $this->defaults();
			foreach ($defaults as $key=>$val){
				if(!isset($data[$key])){
					$data[$key] = $val;
				}
			}
			$this->db->insert($this->table, $data);
			$id = $this->db->insert_id();
			return $this->findOne($id);
		}
	}

	function haveColumn($c){
		return $this->db->select('COUNT(COLUMN_NAME) as CNT')
			->from("INFORMATION_SCHEMA.COLUMNS")
			->where("TABLE_NAME", $this->table)
			->where("COLUMN_NAME", $c)
			->get()->row()->CNT > 0;
	}

	function findOne($id, $array = FALSE){
		$return = $this->db->select('*')->from($this->table)->where($this->primary, $id)->get();
		if($array){
			return $return->row_array();
		}else{
			return $return->row();
		}
	}

	function defaults(){
		return [];
	}
}
