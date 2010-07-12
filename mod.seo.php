<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* SEO Module
*
* @package			SEO
* @version			1.2
* @author			Digital Surgeons
* @link				http://www.digitalsurgeons.com
* @license			http://creativecommons.org/licenses/by-sa/3.0/
*/
 
class Seo {
	
	var $return_data = '';
	var $options = array();
	
	var $defaults = array('append_to_title' => '',
						  'prepend_to_title' => '',
						  'robots' => 'follow,index',
						  'default_title' => '',
						  'default_keywords' => '',
						  'default_description' => '',
						  'use_default_title' => '',
						  'use_default_keywords' => '',
						  'use_default_description' => ''
						  );
	
	function Seo() {
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
	
	function title() {
		$entry_id = $this->EE->TMPL->fetch_param('entry_id');
		if(empty($entry_id)) {return '';}
		$prepend = $this->EE->TMPL->fetch_param('prepend');
		$append = $this->EE->TMPL->fetch_param('append');
		$site_id = $this->EE->config->item('site_id');
		
		$sql = "SELECT `title` FROM `exp_seo_data` WHERE `entry_id` = ".$this->EE->db->escape_str($entry_id)." AND `site_id` = ".$this->EE->db->escape_str($site_id).";";
		
		$res = $this->EE->db->query($sql);
		if($res->num_rows() > 0) {
			if(!empty($prepend)) {
				$final_prepend = $prepend;
			} else {
				$final_prepend = $this->options['prepend_to_title'];
			}
			
			if(!empty($append)) {
				$final_append = $append;
			} else {
				$final_append = $this->options['append_to_title'];
			}
			
			return $this->return_data = $final_prepend.htmlentities($res->row('title')).$final_append;
		}
		
		//Revert to default
		if(isset($this->options['use_default_title']) && $this->options['use_default_title'] == 'yes') {
			return $this->return_data = $this->options['default_title'];
		} else {
			return '';
		}
	}
	
	function description() {
		$entry_id = $this->EE->TMPL->fetch_param('entry_id');
		if(empty($entry_id)) {return '';}
		$site_id = $this->EE->config->item('site_id');
		$sql = "SELECT `description` FROM `exp_seo_data` WHERE `entry_id` = ".$this->EE->db->escape_str($entry_id)." AND `site_id` = ".$this->EE->db->escape_str($site_id).";";
		$res = $this->EE->db->query($sql);
		if($res->num_rows() > 0) {
			return $this->return_data = htmlentities($res->row('description'));
		}
		
		//Revert to default
		if(isset($this->options['use_default_description']) && $this->options['use_default_description'] == 'yes') {
			return $this->return_data = $this->options['default_description'];
		} else {
			return '';
		}
	}
	
	function keywords() {
		$entry_id = $this->EE->TMPL->fetch_param('entry_id');
		if(empty($entry_id)) {return '';}
		$site_id = $this->EE->config->item('site_id');
		$sql = "SELECT `keywords` FROM `exp_seo_data` WHERE `entry_id` = ".$this->EE->db->escape_str($entry_id)." AND `site_id` = ".$this->EE->db->escape_str($site_id).";";
		$res = $this->EE->db->query($sql);
		if($res->num_rows() > 0) {
			return $this->return_data = htmlentities($res->row('keywords'));
		}
		
		//Revert to default
		if(isset($this->options['use_default_keywords']) && $this->options['use_default_keywords'] == 'yes') {
			return $this->return_data = $this->options['default_keywords'];
		} else {
			return '';
		}
	}
	
	function canonical() {
		$url = $this->EE->TMPL->fetch_param('url');
		
		if(empty($url)) {
			$this->return_data = '';
			return '';
		}
		
		return $this->return_data = '<link rel="canonical" href="'.$url.'" />';
	}
	
	function privacy() {
		if(empty($this->options['robots'])) { $this->options['robots'] = $this->defaults['robots']; }
		return $this->return_data = '<meta name="robots" content="'.$this->options['robots'].'" />';
	}
}
// END CLASS

/* End of file mod.seo.php */
/* Location: ./system/expressionengine/third_party/seo/mod.seo.php */