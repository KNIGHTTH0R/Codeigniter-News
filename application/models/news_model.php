<?php
class News_model extends CI_Model {

	public function __construct()
	{
	$this->load->database();
	$this->db->order_by("id", "desc"); 
	}

	//LOAD NEWS
	public function get_news($id = FALSE)
	{
	if ($id === FALSE)
	{
	$query = $this->db->get('news');
	return $query->result_array();
	$config['per_page']; $this->uri->segment(3);
	}
	$query = $this->db->get_where('news', array('id' => $id));
	return $query->row_array();
	}

	//CREATE NEWS
	public function set_news()
	{
	$this->load->helper('url');
	$slug = url_title($this->input->post('title'), 'dash', TRUE);
	$image_data = $this->upload->data();
	$data = array(
		'title' => $this->input->post('title'),
		'slug' => $slug,
		'text' => $this->input->post('text'),
		'category'	=>	$this->input->post('category'),
		'userfile' => $image_data['file_name']
	);
	return $this->db->insert('news', $data);
	}
	
	//EDIT NEWS
	public function update_news($id=0)
	{
	$this->load->helper('url');
	$slug = url_title($this->input->post('title'),'dash',TRUE);
	$image_data = $this->upload->data();
	$data = array(
	'title'	=>	$this->input->post('title'),
	'slug'	=>	$slug,
	'text'	=>	$this->input->post('text'),
	'category'	=>	$this->input->post('category'),
	'userfile' => $image_data['file_name']
	);
	$this->db->where('id',$id);
	return $this->db->update('news',$data);
	}
	
	//DELETE NEWS
	public function delete_news($id) {
    $this->db->delete('news', array('id' => $id));
	}
	
	//CREATE CATEGORY
	public function set_cat()
	{
	$this->load->helper('url');
	$data = array(
	'category' => $this->input->post('category')
	);
	return $this->db->insert('news_cat', $data);
	}
	
	// GET CATEGORY
	public function get_cats($id = FALSE)
	{
	if ($id === FALSE)
	{
	$query = $this->db->get('news_cat');
	return $query->result_array();
	}
	$query = $this->db->get_where('news_cat', array('id' => $id));
	return $query->row_array();
	}
	
	//DELETE CATEGORY
	public function delete_category($id) {
    $this->db->delete('news_cat', array('id' => $id));
	}
	
	//UPDATE CATEGORY
	public function update_cat($id=0)
	{
	$this->load->helper('url');
	$data = array(
	'category'	=>	$this->input->post('category')
	);
	$this->db->where('id',$id);
	return $this->db->update('news_cat',$data);
	}
}