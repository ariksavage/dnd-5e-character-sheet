<?php
require_once('api.php');


Class Job extends API {
  public function __construct(){
    parent::__construct();
    $this->table = 'jobs';
  }
  public function get($id = null) {
    $where = null;
    if ($id){
      if (is_numeric($id)) {
        $where = "id=$id";
      } else {
        $where = "name='$id'";
      }
    }
    $data = $this->db->select($this->table, '*', $where);
    foreach($data as &$job){
       $job->proficiencies = getProficiencies($job->id);
    }
    $this->returnJSON($data);
  }
  public function getJobsByPC($pc_id){
    $where = "pc.id=$pc_id";
    $what = "jobs.*, pc_jobs.level";
    $join = "LEFT JOIN pc_jobs on pc_jobs.job_id = jobs.id";
    $join .=" LEFT JOIN pc on pc.id = pc_jobs.pc_id";
    $order = "jobs.name";
    $jobs = $this->db->select('jobs', $what, $where, $join, $order);
    foreach($jobs as &$job){
      $job->proficiencies = $this->getProficiencies($job->id);
    }
    $this->returnJSON($jobs);
  }
  private function getProficiencies($id) {
    $where = "jobs.id=$id";
    $what = "proficiencies.*";
    $join = "LEFT JOIN job_proficiencies on proficiencies.id = job_proficiencies.proficiency_id";
    $join .=" LEFT JOIN jobs on job_proficiencies.job_id = jobs.id";
    $order = "proficiencies.name";
    $proficiencies = $this->db->select('proficiencies', $what, $where, $join, $order);
    return $proficiencies;
  }
}
?>
