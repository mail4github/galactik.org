<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ai_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    function chat_gpt(){
      $open_ai = get_settings('open_ai', true);

      if($_POST['service_type'] == 'Course thumbnail'){
        $number_of_image_creation = (int)$open_ai['number_of_image_creation'];
        $prompt = $_POST['keyword'];
        $curlopt_post = ['prompt' => $prompt, 'size' => '512x512', 'n' => $number_of_image_creation];
        $curlopt_post_url = 'https://api.openai.com/v1/images/generations';
      }else{
        $prompt = "write me a ";
        $prompt .= $_POST['service_type'];
        $prompt .= " on ";
        $prompt .= $_POST['keyword'];
        $prompt .= " in ";
        $prompt .= $_POST['language'];
        $prompt .= " language";

        $max_tokens = (int)$open_ai['max_tokens'];
        
        if($_POST['service_type'] == 'Course certificate text'){
            $max_tokens = 50;
        }
        
        $curlopt_post = ['model' => $open_ai['model'], 'prompt' => $prompt, 'temperature' => 0, 'max_tokens' => $max_tokens];
        $curlopt_post_url = 'https://api.openai.com/v1/completions';
      }


      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $curlopt_post_url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
      curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer '.$open_ai['ai_secret_key'],
      ]);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($curlopt_post));

      $response = curl_exec($ch);

      curl_close($ch);

      $response_arr = json_decode($response,true);
      if(array_key_exists('choices', $response_arr)){
        return $response_arr['choices'][0]['text'];
      }else{
        $this->session->set_userdata('ai_image', $response_arr['data']);
        return json_encode($response_arr['data']);
      }
    }

    function ai_img_download(){
      if(isset($_GET['index']) && !empty($_GET['index'])){
        $all_images = $this->session->userdata('ai_image');
        $exi = $_GET['index'] - 1;
        $image_url = $all_images[$exi]['url'];
      }else{
        $this->session->set_flashdata('error_message', get_phrase('image_url_not_found'));
        redirect(site_url(), 'refresh');
      }
      $this->load->helper('download');


      $data = file_get_contents($image_url);
      $name = random(5).'.png';
      force_download($name, $data);
    }

    function update_open_ai_settings($param1 = ""){
      if(get_settings('open_ai')){
          $this->db->where('key', 'open_ai')->update('settings', ['value' => json_encode($_POST)]);
      }else{
          $this->db->insert('settings', ['value' => json_encode($_POST)]);
      }

      $this->session->set_flashdata('flash_message', get_phrase('ai_settings_updated_successfully'));
      redirect(site_url('admin/open_ai_settings'), 'refresh');
    }







}