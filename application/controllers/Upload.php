<?php
    class Upload extends CI_Controller{

        function __construct(){
            parent::__construct();
        }

        public function do_upload()
        {
            $config['upload_path']          = './uploads/';
            $config['allowed_types']        = 'jfif|gif|jpg|png|kmz|jpeg|JPEG|JPG|PNG|GIF';
            $config['max_size']             = 5000;
            $config['encrypt_name']         = TRUE;

            $this->load->library('upload', $config);

            $res = array();

            if ( ! $this->upload->do_upload('file'))
            {
                $error = array('error' => $this->upload->display_errors());
                $res['status'] = false;
                $res['error'] = $error;
            }
            else
            {
                $data = array('upload_data' => $this->upload->data());
                $res['status'] = true;
                $res['link'] = 'uploads/'.$data['upload_data']['file_name'];
            }
            header('Content-type: application/json');
            echo json_encode($res);
        }
    }