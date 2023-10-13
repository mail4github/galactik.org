<style>
  .purchase-history-course-img img{
    width: 60px;
    height: 60px;
    border-radius: 100%;
    float: left;
  }
  .purchase-history-list-header{
    padding-top: 15px;
    padding-bottom: 15px;
  }
  .purchase-history-items{
    padding-bottom: 15px;
    border-bottom: 1px solid #efefef;
  }
  .ofline-payment-pending{
    color: #ffc107;
  }
  .purchase-history-course-title{
    line-height: 50px;
    margin-left: 10px;
  }
</style>
<?php
$show_success_alert = '';
$certs_folder = getcwd().'/application/views/payment-global/paymtech/';
$order_file_path = '';

if (!empty(@$_GET['status']) && $_GET['status'] == 'charged') {
	$order_file_path = $certs_folder.'order_'.$_GET['order_id'].'.txt';
}
if (empty($order_file_path)) {
	// process not processed purchases
	$files = glob($certs_folder.'order_*.txt');
	foreach ( $files as $file_name ) {
		if ( !is_dir($file_name) ) {
			$order_file_path = $file_name;
			break;
		}
	}
}
if ( !empty($order_file_path) ) {
	try {
		$s = file_get_contents($order_file_path);
		if ($s && !empty($s)) {
			$order_arr = json_decode($s, true);
			// merchant_order_id holds information about user_id and IDs of purchased curses. First two nine-digit system numbers separated by '9' are user_id and IDs of purchased curses.
			$code_arr = explode("9", $order_arr['orders'][0]['merchant_order_id']);
			$user_id = intval($code_arr[0], 9);
			
			// The curses, which are purchased, are packed in one octet number where each course_id separated from each other by '8'
			$courses_str = strval(intval($code_arr[1], 9));
			$courses_arr = explode("8", $courses_str);
	
			$amount = floatval(@$order_arr['orders'][0]['amount_charged']);
			
			$delimeterLeft = 'order_';
			$posLeft = strpos($order_file_path, $delimeterLeft) + strlen($delimeterLeft);
			$order_id = substr($order_file_path, $posLeft, strpos($order_file_path, '.txt', $posLeft) - $posLeft); 
			
			// Check out if this order has been processed already
			$this->db->where('transaction_id', $order_id);
			$processed_transaction = $this->db->get('payment', 1, 0);
			
			if (!$processed_transaction || $processed_transaction->num_rows() <= 0) {

				$this->db->trans_start();
				
				foreach ($courses_arr as $course_id) {
					
					// convert octet number of course id to decimal
					$course_id = intval($course_id, 8);
					
					// subscribe purchaser to the curse
					$this->db->insert('enrol', ['user_id' => $user_id, 'course_id' => $course_id, 'date_added' => strtotime(date('D, d M Y')), 'last_modified' => strtotime(date('D, d M Y'))]);
				}
				
				// save purchase
				$this->db->insert('payment', ['user_id' => $user_id, 'payment_type' => 'paymtech', 'course_id' => $course_id, 'amount' => $amount, 'date_added' => strtotime(date('D, d M Y')), 'last_modified' => strtotime(date('D, d M Y')), 'transaction_id' => $order_id, 'session_id' => $order_arr['orders'][0]['merchant_order_id']]);
				
				
				$this->db->trans_complete();
				
				if ($this->db->trans_status() !== FALSE) {
					unlink($order_file_path);
					$show_success_alert = 'success';
				}
			}
			else {
				if ( $processed_transaction && $processed_transaction->num_rows() > 0) {
					unlink($order_file_path);
				}
			}
		}
	}
	catch (Exception $e) {

	}
}
$this->db->where('user_id', $this->session->userdata('user_id'));
$purchase_history = $this->db->get('payment',$per_page, $this->uri->segment(3));
$banners = themeConfiguration(get_frontend_settings('theme'), 'banners');
$purchase_history_banner = $banners['purchase_history_banner'];
?>
<section id="hero_in" class="general">
  <div class="banner-img" style="background: url(<?php echo base_url($purchase_history_banner); ?>) center center no-repeat;"></div>
  <div class="wrapper">
    <div class="container">
      <h1 class="fadeInUp"><span></span><?php echo site_phrase('purchase_history'); ?></h1>
    </div>
  </div>
</section>

<div class="bg_color_1">
  <div class="container margin_60_35">
	<?php 
	if (!empty($show_success_alert)) {
		echo '
		<div class="alert alert-success" role="alert">
			<h4 class="alert-heading">'.get_phrase('your_payment_has_been_successful').'</h4>
		</div>';
	}
	?>
    <div class="row">
      <div class="col-lg-12">
        <div class="box_cart">
          <table class="table table-striped cart-list">
            <thead>
              <tr>
                <th>
                  <?php echo site_phrase('course'); ?>
                </th>
                <th>
                  <?php echo site_phrase('amount_paid'); ?>
                </th>
                <th>
                  <?php echo site_phrase('purchase_date'); ?>
                </th>
                <th>
                  <?php echo site_phrase('actions'); ?>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php if ($purchase_history->num_rows() > 0):
                foreach($purchase_history->result_array() as $each_purchase):
                  $course_details = $this->crud_model->get_course_by_id($each_purchase['course_id'])->row_array();?>
                  <tr>
                    <td>
                      <div class="thumb_cart">
                        <img src="<?php echo $this->crud_model->get_course_thumbnail_url($each_purchase['course_id']);?>" alt="Image">
                      </div>
                      <span class="item_cart">
                        <a href="<?php echo site_url('home/course/'.slugify($course_details['title']).'/'.$course_details['id']); ?>" style="color: unset;"> <?php echo ellipsis($course_details['title']); ?> </a>
                      </span>
                    </td>
                    <td>
                      <strong><?php echo currency($each_purchase['amount']); ?></strong>
                    </td>
                    <td>
                      <strong><?php echo date('D, d-M-Y', $each_purchase['date_added']); ?></strong>
                    </td>
                    <td class="options" style="width:5%; text-align:center;">
                      <a href="<?php echo site_url('home/invoice/'.$each_purchase['id']); ?>" class="btn_1 rounded" target="_blank"><i class="icon-print-1"></i></a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
          <!-- /cart-options -->
        </div>
      </div>
      <!-- /col -->
    </div>
    <!-- /row -->
  </div>
  <!-- /container -->
</div>
<!-- /bg_color_1 -->
<?php
  if(addon_status('offline_payment') == 1):
    include APPPATH.'/views/frontend/default/pending_purchase_course_history.php';
  endif;
?>
<div class="row justify-content-center">
  <nav aria-label="...">
    <?php
    echo $this->pagination->create_links();
    ?>
  </nav>
</div>
