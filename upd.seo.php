<?php if ( ! defined('EXT')) { exit('Invalid file request'); }


class Seo_upd {

	var $version = '1.2';
	
	function Seo_upd()
	{
		// Make a local reference to the ExpressionEngine super object
		$this->EE =& get_instance();
	}


	// --------------------------------------------------------------------

	/**
	 * Module Installer
	 *
	 * @access	public
	 * @return	bool
	 */	
	function install()
	{
		$data = array(
			'module_name' => 'Seo' ,
			'module_version' => $this->version,
			'has_cp_backend' => 'y',
			'has_publish_fields' => 'y'
		);

		$this->EE->db->insert('modules', $data);
		
		$table = "CREATE TABLE IF NOT EXISTS `exp_seo_data` (
				`seo_id` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
				`channel_id` INT( 6 ) NOT NULL ,
				`site_id` INT( 4 ) NOT NULL ,
				`entry_id` INT( 10 ) NOT NULL ,
				`language` VARCHAR( 255 ) NOT NULL DEFAULT  'en',
				`title` TEXT NULL ,
				`keywords` TEXT NULL ,
				`description` TEXT NULL )";
		
		$this->EE->db->query($table);
		
		$options_table = "CREATE TABLE IF NOT EXISTS `exp_seo_options` (
						 `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
						 `key` VARCHAR( 255 ) NOT NULL ,
						 `value` TEXT NOT NULL
						 );";
						 
		$this->EE->db->query($options_table);
		
		//No actions set for this module
		//$sql = "INSERT INTO exp_actions (class, method) VALUES ('seo', 'do_seo_submit')";
		//$this->EE->db->query($sql);
		
		$this->EE->load->library('layout');
		$this->EE->cp->add_layout_tabs($this->tabs(), 'seo');
		
		return TRUE;
	}
	
	
	// --------------------------------------------------------------------

	/**
	 * Module Uninstaller
	 *
	 * @access	public
	 * @return	bool
	 */	
	function uninstall()
	{		
		$query = $this->EE->db->query("SELECT module_id FROM exp_modules WHERE module_name = 'Seo'");
				
		$sql[] = "DELETE FROM exp_module_member_groups WHERE module_id = '".$query->row('module_id') ."'";
		$sql[] = "DELETE FROM exp_modules WHERE module_name = 'Seo'";
		$sql[] = "DELETE FROM exp_actions WHERE class = 'Seo'";
		$sql[] = "DELETE FROM exp_actions WHERE class = 'Seo_mcp'";
		$sql[] = "DROP TABLE IF EXISTS `exp_seo_data`";
		$sql[] = "DROP TABLE IF EXISTS `exp_seo_options`";
		foreach ($sql as $query)
		{
			$this->EE->db->query($query);
		}

		$this->EE->load->library('layout');
		$this->EE->layout->delete_layout_tabs($this->tabs());
		
		return TRUE;
	}
	
	
	// --------------------------------------------------------------------

	/**
	 * Module Updater
	 *
	 * @access	public
	 * @return	bool
	 */	
	
	function update($current='')
	{
		return TRUE;
	}
	
	function tabs()
	{
		$tabs['seo'] = array(
		'title'=> array(
			'visible'	=> 'true',
			'collapse'	=> 'false',
			'htmlbuttons'	=> 'false',
			'width'		=> '100%'
			),
		'keywords'=> array(
			'visible'	=> 'true',
			'collapse'	=> 'false',
			'htmlbuttons'	=> 'false',
			'width'		=> '100%'
			),
		'description'=> array(
			'visible'	=> 'true',
			'collapse'	=> 'false',
			'htmlbuttons'	=> 'true',
			'width'		=> '100%'
			)			
		);	
				
		return $tabs;	
	}

}
// END CLASS

/* End of file upd.seo.php */
/* Location: ./system/expressionengine/third_party/seo/upd.seo.php */