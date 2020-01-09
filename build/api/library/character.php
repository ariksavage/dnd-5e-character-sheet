<?php
require_once('api.php');


Class Character extends API {
  public function __construct(){
    parent::__construct();
    $this->table = 'pc';
  }

  public function get($id = null) {
    $where = ($id)? "id=$id" : null;
    $data = $this->db->select($this->table, '*', $where)[0];
    if ($id) {
      $data->skills = $this->getSkills($id);
      $data->inventory = $this->getInventory($id);
      $data->abilities = $this->getAbilities($id);
      $data->feats = $this->getFeats($id);
      $data->background = $this->getBackground($data->background);
      $data->languages = $this->getLanguages($id);
    }
    $this->all = $data;
    $this->returnJSON($data);
  }
  private function getSkills($id){
    $where = NULL;
    $what = "skills.name, skills.stat, pc_skills.proficiency, pc_skills.expertise";
    $join = " LEFT JOIN pc_skills on skills.id = pc_skills.skill_id";
    $join .= " LEFT JOIN pc on pc.id = pc_skills.pc_id";
    $order = "skills.name";
    $skills = $this->db->select('skills', $what, $where, $join, $order);
    return $skills;
  }
  private function getInventory($id) {
    $where = "pc.id=$id";
    $what = "items.*, pc_inventory.equipped, pc_inventory.qty";
    $join = "LEFT JOIN pc_inventory on items.id = pc_inventory.item_id";
    $join .=" LEFT JOIN pc on pc_inventory.pc_id = pc.id";
    $order = "items.name";
    $inventory = $this->db->select('items', $what, $where, $join, $order);
    return $inventory;
  }
  private function getAbilities($id) {
    $where = "pc.id=$id";
    $what = "abilities.*";
    $join = "LEFT JOIN pc_abilities on abilities.id = pc_abilities.ability_id";
    $join .=" LEFT JOIN pc on pc_abilities.pc_id = pc.id";
    $order = "abilities.name";
    $abilities = $this->db->select('abilities', $what, $where, $join, $order);
    return $abilities;
  }
  private function getFeats($id) {
    
    $what = "feats.*";
    $join = "LEFT JOIN pc_feats on feats.id = pc_feats.feat_id";
    $join .=" LEFT JOIN pc on pc_feats.pc_id = pc.id";
    $where = "pc.id=$id";
    $order = "feats.name";
    $feats = $this->db->select('feats', $what, $where, $join, $order);
    return $feats;
  }
  private function getBackground($id){
    $background = $this->db->select('backgrounds', '*', "id=$id")[0];
    $what = "proficiencies.*";
    $join = "LEFT JOIN background_proficiencies on background_proficiencies.proficiency_id = proficiencies.id";
    $where = " background_proficiencies.background_id = $id";
    $order = "proficiencies.name";
    $background->proficiencies = $this->db->select('proficiencies', $what, $where, $join, $order);
    return $background;
  }
  private function getLanguages($id) {
    $what = "languages.name";
    $join = "LEFT JOIN pc_languages on pc_languages.language_id = languages.id";
    $join .=" LEFT JOIN pc on pc.id = pc_languages.pc_id";
    $where = "pc.id=$id";
    $order = "languages.name";
    $languages = $this->db->select('languages', $what, $where, $join, $order);
    return $languages;
  }
}
?>
