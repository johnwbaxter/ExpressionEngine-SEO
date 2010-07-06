<?php
if ( ! defined('EXT')) { exit('Invalid file request'); }

/**
  *  Constructor
  */
class Seo_mcp {
	
	var $options = array();
	
	var $defaults = array('append_to_title' => '',
						  'prepend_to_title' => '',
						  'robots' => 'follow,index',
						  'default_title' => '',
						  'default_keywords' => '',
						  'default_description' => ''
						  );
	
	function Seo_mcp()
	{
		// Make a local reference to the ExpressionEngine super object
		$this->EE =& get_instance();
		
		//Get Options (configuration) on class load
		$sql = "SELECT * FROM `exp_seo_options`;";
		$res = $this->EE->db->query($sql);
		if($res->num_rows() > 0) {
			foreach($res->result_array() as $row) {
				$this->options[$row['key']] = $row['value'];
			}
		} else {
			//Revert to defaults if no results found
			$this->options = $this->defaults;
		}
	}
	
	function index() {
		$this->EE->cp->set_variable('cp_page_title', $this->EE->lang->line('seo_module_name'));
		
		return $this->EE->load->view('index', $this->options, TRUE);
	}
	
	function update() {
		$this->EE->cp->set_variable('cp_page_title', $this->EE->lang->line('seo_module_name'));
		
		foreach($_POST as $k => $v) {
			if($k == 'submit') continue;
			
			if(isset($this->options[$k])) {
				//UPDATE, if changed
				if($this->options[$k] != $v) {
					$data = array('value' => $v);
					$add_option = $this->EE->db->update_string('exp_seo_options', $data, "`key` = '".$this->EE->db->escape_str($k)."'");
					$this->EE->db->query($add_option);
				}
			} else {
				//INSERT if not added
				$data = array('key' => $k, 'value' => $v);
				$add_option = $this->EE->db->insert_string('exp_seo_options', $data);
				$this->EE->db->query($add_option);
			}
		}
		
		$this->EE->session->set_flashdata('message_success', $this->EE->lang->line('options_updated')); //not working?
		$this->EE->functions->redirect(BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=seo');
	}
}
// END CLASS

/* End of file mcp.seo.php */
/* Location: ./system/expressionengine/thirdparty/seo/mcp.seo.php */