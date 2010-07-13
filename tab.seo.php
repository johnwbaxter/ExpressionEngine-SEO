<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Seo_tab {
	
	function Seo_tab()
	{
		$this->EE =& get_instance();
	}
	
	function publish_tabs($channel_id, $entry_id = '')
	{
		$settings = array();
		
		$seo_title = '';
		$seo_keywords = '';
		$seo_description = '';
		
		if(!empty($entry_id)) {
			$sql = "SELECT * FROM `exp_seo_data` WHERE `site_id` = 1  AND `channel_id` = ".$this->EE->db->escape_str($channel_id)." AND `entry_id` = ".$this->EE->db->escape_str($entry_id).";";
			
			$res = $this->EE->db->query($sql);
			
			if($res->num_rows() > 0) {
				$seo_title = ($res->row('title'));				//removed htmlentities()
				$seo_keywords = ($res->row('keywords'));		//removed htmlentities()
				$seo_description = ($res->row('description'));	//removed htmlentities()
			}
		}
		
		$settings[] = array(
			'field_id'             => 'seo_title',
			'field_label'          => "Title",
			'field_required'       => 'n',
			'field_data'           => $seo_title,
			'field_list_items'     => '',
			'field_fmt'            => '',
			'field_instructions'   => 'Data for the title field',
			'field_show_fmt'       => 'n',
			'field_pre_populate'   => 'n',
			'field_text_direction' => 'ltr',
			'field_type'           => 'text',
			'field_maxl'		   => 1024,
			'field_channel_id'     => $channel_id
		);
		
		$settings[] = array(
			'field_id'             => 'seo_keywords',
			'field_label'          => "Keywords",
			'field_required'       => 'n',
			'field_data'           => $seo_keywords,
			'field_list_items'     => '',
			'field_fmt'            => '',
			'field_instructions'   => 'Data for the keywords meta field',
			'field_show_fmt'       => 'n',
			'field_pre_populate'   => 'n',
			'field_text_direction' => 'ltr',
			'field_type'           => 'text',
			'field_maxl'		   => 1024,
			'field_channel_id'     => $channel_id
		);
		
		$settings[] = array(
			'field_id'             => 'seo_description',
			'field_label'          => "Description",
			'field_required'       => 'n',
			'field_data'           => $seo_description,
			'field_list_items'     => '',
			'field_fmt'            => '',
			'field_instructions'   => 'Data for the description meta field',
			'field_show_fmt'       => 'n',
			'field_pre_populate'   => 'n',
			'field_text_direction' => 'ltr',
			'field_type'           => 'textarea',
			'field_ta_rows'		   => 5,
			'field_channel_id'     => $channel_id
		);
		//$this->EE->cp->add_to_head('<!-- im totally adding this to head. just watch me. look. its awesome. -->');
		return $settings;
	}
	
	function validate_publish($params)
	{
		//Of course I trust you!!!
		return true;
	}
	
	function publish_data_db($params)
	{
		//Do database stuff here - but only if there's data to add
		if(empty($params['mod_data']['seo_title']) && empty($params['mod_data']['seo_keywords']) && empty($params['mod_data']['seo_description'])) {
			return;
		}
		
		//This already exist?
		$sql = "SELECT * FROM `exp_seo_data` 
				WHERE `site_id` = ".$this->EE->db->escape_str($params['meta']["site_id"])." 
				AND `channel_id` = ".$this->EE->db->escape_str($params['meta']["channel_id"])." 
				AND `entry_id` = ".$this->EE->db->escape_str($params["entry_id"]).";";
		
		$res = $this->EE->db->query($sql);
		
		if($res->num_rows() > 0) {
			//updating
			$data = array(
				'title' => trim($params['mod_data']['seo_title']),
				'keywords' => trim($params['mod_data']['seo_keywords']),
				'description' => trim($params['mod_data']['seo_description'])
			);
			
			$sql = $this->EE->db->update_string('exp_seo_data', $data, "seo_id = ".$res->row('seo_id'));
			$this->EE->db->query($sql);
			
		} else {
			//new entry
			$data = array(
				'channel_id' => $params['meta']["channel_id"],
				'site_id' => $params['meta']["site_id"],
				'entry_id' => $params["entry_id"],
				/* 'language' => 'en', */
				'title' => trim($params['mod_data']['seo_title']),
				'keywords' => trim($params['mod_data']['seo_keywords']),
				'description' => trim($params['mod_data']['seo_description'])
			);
			
			$sql = $this->EE->db->insert_string('exp_seo_data', $data);
			$this->EE->db->query($sql);
		}		
	}
	
	function publish_data_delete_db($params)
	{
		//delete data when entry deleted
		//This should check for site id?
		foreach($params["entry_ids"] as $k => $id) {
			$sql = "DELETE FROM `exp_seo_data` WHERE `entry_id` = ".$this->EE->db->escape_str($id).";";
			$this->EE->db->query($sql);
		}
	}
}
// END CLASS

/* End of file tab.seo.php */
/* Location: ./system/expressionengine/third_party/seo/tab.seo.php */