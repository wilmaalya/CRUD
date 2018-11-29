<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

        function __construct(){
        parent::__construct();
        }

    public function index($error = NULL) {
        $data = array(
            'title' => 'Login Page',
            'action' => site_url('auth/login'),
            'error' => $error
        );
        $this->load->view('login', $data);
    }

    /*public function login() {
        $this->load->model('auth_model');
        $login = $this->auth_model->login($this->input->post('username'), md5($this->input->post('password')));

        if ($login == 1) {
//          ambil detail data
            $row = $this->auth_model->data_login($this->input->post('username'), md5($this->input->post('password')));

//          daftarkan session
            $data = array(
                'logged' => TRUE,
                'username' => $row->username
            );
            $this->session->set_userdata($data);

//            redirect ke halaman sukses
            redirect(site_url('user'));
        } else {
//            tampilkan pesan error
            $error = 'username / password salah';
            $this->index($error);
        }
    }*/

public function index(){

        $this->data['page_title'] = 'User Login';
        
        $this->load->library('form_validation');
        
        if($this->input->post()){
            //here we will verify the inputs    
            $this->form_validation->set_rules('identity','Username','required');
            $this->form_validation->set_rules('password','Password','required');
            //$this->form_validation->set_rules('remember','Remember me','integer');
            
            if($this->form_validation->run()===TRUE){
                //$remember = (bool) $this->input->post('remember');
                $username = $this->input->post('identity');
                $password = md5($this->input->post('password'));
                
                $krit=array('username'=>$username,'password'=>$password);
                if($dt_user=$this->Users_m->get_by($krit,TRUE)){
            
                    $this->load->model('Pengaturan_m');
                    
                    $ta_aktif=$this->Pengaturan_m->get(1);
//session->ta_aktif 
                    $this->session->set_userdata('ta_aktif',$ta_aktif['semester']);
                    
                    //$idgroup=$dt_user['idgroup'];
                    
                    $user_group=$dt_user['idgroup'];
                    $iduser=$dt_user['iduser'];
//session->is_login 
                    $this->session->set_userdata('is_login',TRUE);
//session->user_group
                    $this->session->set_userdata('user_group',$user_group);
                    
                    //check user group
                    if($user_group==1){
                        $this->load->model('Administrator_m');
                        
                        $krit=array('iduser'=>$iduser);
                        $row_user=array();
                        $row_user=$this->Administrator_m->get_by($krit);

                        $nama=array();
                        foreach($row_user as $ru){
                            $nama[]=$ru['nama'];
                        }
                        
                        $this->session->set_userdata('sess_iduser',$iduser);
                        $this->session->set_userdata('sess_nama',$nama[0]);

                        redirect('admin','refresh'); //berhasil => ke dashboard guru
                    
                    }elseif($user_group==3){
                        $this->load->model('Siswa_m');
                        $this->load->model('Kelas_m');
                        
                        $row_user=array();
                        $krit=array('iduser'=>$iduser);                     
                        $row_user=$this->Siswa_m->get_by($krit);
                        
                        
                        $status=$row_user[0]['status'];
                        
                        if($status!=1){
                            $this->session->set_flashdata('message','<p>Akun Tidak Aktif</p>');
                            redirect('login', 'refresh'); //gagal =>refresh halaman ini
                        }
                            
                        $kriter=array('idkelas'=>$row_user[0]['idkelas']);                      
                        $row_user_kelas=array();
                        $row_user_kelas=$this->Kelas_m->get_by($kriter);
                        
                        $idjenjang=array();
                        
                        foreach($row_user_kelas as $r){
                            $idjenjang=$r['idjenjang'];
                        }
                        
                        
                        $nama=array();
                        $idkelas=array();
                        $idsekolah=array();
                        foreach($row_user as $ru){
                            $nama=$ru['nama'];
                            $idkelas=$ru['idkelas'];
                            $idsekolah=$ru['idsekolah'];
                        }                       
                        
                        $this->session->set_userdata('sess_idkelas',$idkelas);
                        $this->session->set_userdata('sess_idjenjang',$idjenjang);
                        $this->session->set_userdata('sess_nama',$nama);
                        $this->session->set_userdata('sess_iduser',$iduser);                            
                        $this->session->set_userdata('sess_idsekolah',$idsekolah);                          
                        
                        //$this->session->set_flashdata('message',"<p>$nama</p><p>$idkelas</p><p>$idjenjang</p>");
                        //$this->session->set_userdata('row_user',$row_user);
                        redirect('siswa/dashboard','refresh'); //berhasil => ke dashboard siswa
                    }elseif($user_group==2){
                        $this->load->model('Guru_m');
                        
                        $krit=array('iduser'=>$iduser);                     
                        $row_user=array();
                        $row_user=$this->Guru_m->get_by($krit);
                        
                        $nama= array();
                        $idsekolah= array();
                        $idmapel= array();
                        foreach($row_user as $ru){
                            $nama=$ru['nama'];
                            $idsekolah=$ru['idsekolah'];
                            $idmapel=$ru['idmapel'];
                        }
                        
                        $this->session->set_userdata('sess_iduser',$iduser);                            
                        $this->session->set_userdata('sess_nama',$nama);                        
                        $this->session->set_userdata('sess_idsekolah',$idsekolah);                      
                        $this->session->set_userdata('sess_idmapel',$idmapel);                      
                        redirect('guru/dashboard','refresh'); 
                    }
                    
                }else{
                    $this->session->set_flashdata('message','<p>Username or Password salah</p>');
                    redirect('login', 'refresh'); //gagal =>refresh halaman ini
                }
            }
        
        }
        //message,
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

        $this->data['identity'] = array(
            'name' => 'identity',
            'id'    => 'identity',
            'type'  => 'text',
            'placeholder'=>'Username',
            'value' => $this->form_validation->set_value('identity'),
            'class' => 'form-control'
        );
        $this->data['password'] = array(
            'name' => 'password',
            'id'   => 'password',
            'type' => 'password',
            'placeholder'=>'Password',
            'class'=> 'form-control'
        );
    
        $this->load->helper('form');
        $this->load->view('login/index_v',$this->data); 
    }
    
    function logout() {
//        destroy session
        $this->session->sess_destroy();
        
//        redirect ke halaman login
        redirect(site_url('auth'));
    }

}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */