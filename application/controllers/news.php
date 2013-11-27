<?php
class News extends CI_Controller {

	public function __construct()
	{
	parent::__construct();
	$this->load->model('news_model');
	$this->load->helper(array('form', 'url'));
	$this->load->library('ion_auth');
	}

	//LOAD MAIN NEWS PAGE
	function index() {
	$this->load->library('pagination');			
	$config['base_url'] = ''.base_url().'news/index';
	$config['total_rows'] = $this->db->get('news')->num_rows();
	$config['per_page'] = 5;
	$config['num_links'] = 5;
	$config['full_tag_open'] = '<div id="pagination">';
	$config['full_tag_close'] = '</div>';
	$this->pagination->initialize($config);
	$query = $this->db->get('news', $config['per_page'], $this->uri->segment(3));
	$data["records"] = $query->result_array();
	$data['title'] = 'News';
	$this->load->view('templates/header', $data);
	$this->load->view('templates/nav', $data);
	$this->load->view('templates/sidebar', $data);
	$this->load->view('news/index', $data);
	$this->load->view('templates/footer');
	}

	//LOAD VIEW
	public function view($id)
	{
	$data['news_item'] = $this->news_model->get_news($id);
	if (empty($data['news_item']))
	{
	show_404();
	}
	$data['title'] = $data['news_item']['title'];
	$this->load->view('templates/header', $data);
	$this->load->view('templates/nav', $data);
	$this->load->view('templates/sidebar', $data);
	$this->load->view('news/view', $data);
	$this->load->view('templates/footer');
	}

	//STORY CREATE
	public function create()
	{
	$this->load->helper('form');
	$this->load->library('form_validation');
	$config['upload_path'] = './uploads/';
	$config['allowed_types'] = 'gif|jpg|png';
	$this->load->library('upload', $config);
	$data['title'] = 'Create a news item';
	$this->form_validation->set_rules('title', 'Title', 'required');
	$this->form_validation->set_rules('text', 'text', 'required');
	//ADMIN CHECK
	if ( $this->ion_auth->is_admin() ) {
	//Put User in Class-wide variable
	$this->the_user = $this->ion_auth->user()->row();
	//Store user in $data
	$data['the_user'] = $this->the_user;
	//Load $the_user in all views
	$this->load->vars($data);
	}
	else {
	redirect('/');
	}
	if (! $this->upload->do_upload() && $this->form_validation->run() === FALSE)
	{
	$this->load->view('templates/header', $data);
	$this->load->view('templates/nav', $data);	
	$this->load->view('news/create');
	$this->load->view('templates/footer');
	}
	else
	{
	$this->news_model->set_news();
	$image_data = array('upload_data' => $this->upload->data());
	$this->load->view('templates/header', $data);
	$this->load->view('templates/nav', $data);	
	$this->load->view('news/success', $image_data);
	$this->load->view('templates/footer');
	}	
	}

	//STORY UPDATE
	public function update($id)
	{
	$data['title'] = 'Edit a news item';
	$data['success'] = 0;
	$this->load->helper('form');
	$this->load->library('form_validation');
	$config['upload_path'] = './uploads/';
	$config['allowed_types'] = 'gif|jpg|png';
	$this->load->library('upload', $config);
	$this->form_validation->set_rules('category','category','required');
	//ADMIN CHECK
	if ( $this->ion_auth->is_admin() ) {
	//Put User in Class-wide variable
	$this->the_user = $this->ion_auth->user()->row();
	//Store user in $data
	$data['the_user'] = $this->the_user;
	//Load $the_user in all views
	$this->load->vars($data);
	}
	else {
	redirect('/');
	}
	if($this->form_validation->run())
	{
	$data['success'] = $this->news_model->update_news($id);
	}
	$data['news_item'] = $this->news_model->get_news($id);
	if(empty($data['news_item']))
	{
	show_404();
	}
	$this->load->view('templates/header',$data);
	$this->load->view('templates/nav', $data);
	$this->load->view('news/update',$data);
	$this->load->view('templates/footer');
	}

	//STORY DELETE
	public function delete($id) {
	//ADMIN CHECK
	if ( $this->ion_auth->is_admin() ) {
	//Put User in Class-wide variable
	$this->the_user = $this->ion_auth->user()->row();
	//Store user in $data
	$data['the_user'] = $this->the_user;
	//Load $the_user in all views
	$this->load->vars($data);
	}
	else {
	redirect('/');
	}
	$data['title'] = 'Item deleted!';
	$this->news_model->delete_news($id);
	$this->load->view('templates/header', $data);
	$this->load->view('templates/nav', $data);
	$this->load->view('news/delete', $data);
	$this->load->view('templates/footer');
	}

	//LOAD CATEGORY PAGE
	function category($category) {
	$this->load->library('pagination');
	$this->db->where('category', $category);
	$data['category'] = $category;			
	$config['base_url'] = 'http://ci.infamousgamerz.net/news/category';
	$config['total_rows'] = $this->db->get('news')->num_rows();
	$config['per_page'] = 10;
	$config['num_links'] = 5;
	$config['full_tag_open'] = '<div id="pagination">';
	$config['full_tag_close'] = '</div>';	
	$this->pagination->initialize($config);
	$query = $this->db->get('news', $config['per_page'], $this->uri->segment(3));
	$data["records"] = $query->result_array();
	$data['title'] = 'News';
	$this->load->view('templates/header', $data);
	$this->load->view('templates/nav', $data);
	$this->load->view('templates/sidebar', $data);
	$this->load->view('news/category', $data);
	$this->load->view('templates/footer');
	}

	//ADD CATEGORY
	public function addcategory()
	{
	$this->load->helper('form');
	$this->load->library('form_validation');	
	$data['title'] = 'Add a category';
	$this->form_validation->set_rules('category', 'Category', 'required');
	//ADMIN CHECK
	if ( $this->ion_auth->is_admin() ) {
	//Put User in Class-wide variable
	$this->the_user = $this->ion_auth->user()->row();
	//Store user in $data
	$data['the_user'] = $this->the_user;
	//Load $the_user in all views
	$this->load->vars($data);
	}
	else {
	redirect('/');
	}
	
	if ($this->form_validation->run() === FALSE)
	{
	$this->load->view('templates/header', $data);
	$this->load->view('templates/nav', $data);	
	$this->load->view('news/addcategory');
	$this->load->view('templates/footer');
	}
	else
	{
	$this->news_model->set_cat();
	$this->load->view('templates/header', $data);
	$this->load->view('templates/nav', $data);	
	$this->load->view('news/success_cat');
	$this->load->view('templates/footer');
	}	
	}

	//CATEGORY DELETE
	public function deletecategory($id) {
	//ADMIN CHECK
	if ( $this->ion_auth->is_admin() ) {
	//Put User in Class-wide variable
	$this->the_user = $this->ion_auth->user()->row();
	//Store user in $data
	$data['the_user'] = $this->the_user;
	//Load $the_user in all views
	$this->load->vars($data);
	}
	else {
	redirect('/');
	}
	$data['title'] = 'Item deleted!';
	$this->news_model->delete_category($id);
	$this->load->view('templates/header', $data);
	$this->load->view('templates/nav', $data);
	$this->load->view('news/delete', $data);
	$this->load->view('templates/footer');
	}

	//CATEGORY UPDATE
	public function updatecategory($id)
	{
	$data['title'] = 'Edit a category item';
	$data['success'] = 0;
	$this->load->helper('form');
	$this->load->library('form_validation');
	$this->form_validation->set_rules('category','category','required');
	//ADMIN CHECK
	if ( $this->ion_auth->is_admin() ) {
	//Put User in Class-wide variable
	$this->the_user = $this->ion_auth->user()->row();
	//Store user in $data
	$data['the_user'] = $this->the_user;
	//Load $the_user in all views
	$this->load->vars($data);
	}
	else {
	redirect('/');
	}
	if($this->form_validation->run())
	{
	$data['success'] = $this->news_model->update_cat($id);
	}
	$data['cat_item'] = $this->news_model->get_cats($id);
	if(empty($data['cat_item']))
	{
	show_404();
	}
	$this->load->view('templates/header',$data);
	$this->load->view('templates/nav', $data);
	$this->load->view('news/update_cat',$data);
	$this->load->view('templates/footer');
	}
}
