<?php $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>

<!-- SHOW TOASTR NOTIFIVATION -->
<?php if ($this->session->flashdata('flash_message') != ""):?>
    <script type="text/javascript">
    toastr.success('<?php echo $this->session->flashdata("flash_message");?>');
</script>
<?php endif;?>

<?php if ($this->session->flashdata('error_message') != ""):?>
    <script type="text/javascript">
    toastr.error('<?php echo $this->session->flashdata("error_message");?>');
</script>
<?php endif;?>

<?php if ($this->session->flashdata('info_message') != ""):?>
    <script type="text/javascript">
    toastr.info('<?php echo $this->session->flashdata("info_message");?>');
</script>
<?php endif;?>


<div class="modal fade" data-bs-backdrop="static" tabindex="-1" id="select_free_or_pay">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="select_free_or_pay_title">Courses</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" onclick="$('#select_free_or_pay').modal('hide');"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
		<div class="form-check">
			<input class="form-check-input" type="radio" name="select_free_or_pay_radio" id="select_free_or_pay_radio_free">
			<label class="form-check-label" for="select_free_or_pay_radio_free">
				<h6><?php echo site_phrase('free_course_no_certificate'); ?></h6>
				<p><?php echo site_phrase('you_do_not_pay_but_you_have_access_to_course'); ?></p>
			</label>
		</div>
		<div class="form-check">
			<input class="form-check-input" type="radio" name="select_free_or_pay_radio" id="select_free_or_pay_radio_paid" checked>
			<label class="form-check-label" for="select_free_or_pay_radio_paid">
				<h6><span id="select_free_or_pay_price"></span> <span><?php echo site_phrase('taking_course_and_getting_certificate'); ?></span></h6>
				<p><?php echo site_phrase('you_are_earning_certificate'); ?>
					<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
						 viewBox="0 0 512 512" xml:space="preserve" style="width:45px;">
						<polygon style="fill:#E6E6E6;" points="14.273,112.52 14.273,234.106 14.273,383.665 381.737,383.665 438.024,383.665 
							497.727,383.665 497.727,234.106 497.727,112.52 "/>
						<polygon style="fill:#F7B239;" points="512,91.382 512,404.803 482.093,374.896 482.093,121.289 "/>
						<g>
							<polygon style="fill:#E09B2D;" points="512,91.382 482.093,121.289 29.907,121.289 0,91.382 	"/>
							<polygon style="fill:#E09B2D;" points="482.093,374.896 373.604,374.896 346.422,374.896 29.907,374.896 0,404.803 
								346.422,404.803 373.604,404.803 512,404.803 	"/>
						</g>
						<path style="fill:#F95428;" d="M404.504,404.803l-4.582-3.326l-4.57,3.326h-0.012l-21.736,15.815v-15.815v-67.047v-22.514
							c0.969,0.263,1.89,0.598,2.727,1.029c5.156,2.632,13.741,15.737,14.654,10.144c9.264-56.773,11.424-4.235,17.071-5.132
							c4.725-0.742,10.515,1.376,15.312,0.467h2.883v16.006v67.047v15.803L404.504,404.803z"/>
						<polygon style="fill:#F7B239;" points="29.907,121.289 29.907,374.896 0,404.803 0,91.382 "/>
						<g>
							<rect x="166.878" y="162.584" style="fill:#666666;" width="178.243" height="17.944"/>
							<rect x="192" y="231.967" style="fill:#666666;" width="128" height="17.944"/>
							<rect x="135.776" y="196.079" style="fill:#666666;" width="240.449" height="17.944"/>
							<rect x="135.776" y="314.485" style="fill:#666666;" width="88.523" height="17.944"/>
						</g>
						<path style="fill:#F7B239;" d="M373.604,352.383c-4.749-1.376-10.647-1.412-14.092-4.869c-4.163-4.163-3.361-11.843-5.898-16.819
							c-2.632-5.156-9.271-9.056-10.156-14.654c-0.885-5.658,4.247-11.424,5.144-17.083c0.873-5.587-2.249-12.668,0.383-17.824
							c2.536-4.976,10.037-6.627,14.2-10.778c4.163-4.163,5.814-11.676,10.79-14.212c5.156-2.62,12.226,0.502,17.824-0.383
							c5.646-0.885,11.412-6.017,17.071-5.132c5.599,0.885,9.498,7.524,14.654,10.156c4.976,2.536,12.668,1.723,16.819,5.886
							c4.163,4.163,3.362,11.855,5.898,16.831c2.632,5.156,9.271,9.056,10.156,14.654c0.885,5.646-4.247,11.424-5.144,17.071
							c-0.873,5.599,2.249,12.668-0.383,17.824c-2.536,4.976-10.037,6.627-14.2,10.79c-4.163,4.163-5.814,11.664-10.778,14.2
							c-0.802,0.407-1.651,0.682-2.524,0.849c-4.797,0.909-10.587-1.208-15.312-0.467c-5.646,0.897-11.412,6.029-17.071,5.132
							c-5.598-0.873-9.498-7.513-14.654-10.144C375.495,352.981,374.573,352.646,373.604,352.383z"/>
						<path style="fill:#F95428;" d="M417.495,289.531c9.702,9.702,9.702,25.433,0,35.122c-9.702,9.702-25.433,9.702-35.134,0
							c-9.702-9.69-9.702-25.421,0-35.122C392.063,279.829,407.794,279.829,417.495,289.531z"/>
					</svg>
				</p>
			</label>
		</div>
		
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="free_or_pay_choosen();"><?php echo site_phrase('continue'); ?>...</button>
      </div>
    </div>
  </div>
</div>

<!-- This scrips are being used in multiple views -->
<script type="text/javascript">
// Responsible for handling Wishlist
function handleWishList(elem) {
    handleEnrolledButton();
    $.ajax({
        url: '<?php echo site_url('home/handleWishList');?>',
        type : 'POST',
        data : {course_id : elem.id},
        success: function(response)
        {
            if (!response) {
                window.location.replace("<?php echo site_url('login'); ?>");
            }else {
                if ($(elem).hasClass('active')) {
                    $('.wishlist-btn-'+elem.id).removeClass('active');
                    $('#tooltiptext-'+elem.id).text('<?php echo site_phrase("add_to_wishlist"); ?>');
                }else {
                    $('.wishlist-btn-'+elem.id).addClass('active');
                    $('#tooltiptext-'+elem.id).text('<?php echo site_phrase("remove_from_wishlist"); ?>');
                }
                $('#wishlist_items').html(response);
            }
        }
    });
}

var current_item = null;

function free_or_pay_choosen()
{
	$('#select_free_or_pay').modal('hide');
	if ( $("#select_free_or_pay_radio_paid").is(":checked") ) {
		handleBuyNow(current_item.id);
		/*$.ajax({
			url: '<?php echo site_url('home/handleCartItems');?>',
			type : 'POST',
			data : {course_id : current_item.id},
			success: function(response)
			{
				window.location.replace("<?php echo site_url('home/shopping_cart'); ?>");
			}
		});*/
	}
	else {
		window.location.replace("<?php echo site_url('home/get_enrolled_to_free_course/'); ?>" + current_item.id);
	}
}

function showFreeOrPay(elem, course_name, price_to_show)
{
	current_item = elem;
	$("#select_free_or_pay_title").html(course_name);
	$("#select_free_or_pay_price").html(price_to_show);
	$('#select_free_or_pay').modal('show');
	return false;
}

// Responsible for handling Cart items
function handleCartItems(elem, paid_course_selected, course_name, price_to_show)
{
	/*if ( typeof elem != "undefined" && !$(elem).hasClass('addedToCart') && typeof paid_course_selected != "undefined" && !paid_course_selected) {
		current_item = elem;
		$("#select_free_or_pay_title").html(course_name);
		$("#select_free_or_pay_price").html(price_to_show);
		$('#select_free_or_pay').modal('show');
		return false;
	}*/
	
	//if (typeof elem == "undefined")
		//elem = current_item;
	
    url1 = '<?php echo site_url('home/handleCartItems');?>';
    url2 = '<?php echo site_url('home/refreshWishList');?>';
    $.ajax({
        url: url1,
        type : 'POST',
        data : {course_id : elem.id},
        success: function(response)
        {
            $('#cart_items').html(response);
            if ($(elem).hasClass('addedToCart')) {
                $('.big-cart-button-'+elem.id).removeClass('addedToCart')
                $('.big-cart-button-'+elem.id).text("<?php echo site_phrase('add_to_cart'); ?>");
            }else {
                $('.big-cart-button-'+elem.id).addClass('addedToCart')
                $('.big-cart-button-'+elem.id).text("<?php echo site_phrase('added_to_cart'); ?>");
            }
            $.ajax({
                url: url2,
                type : 'POST',
                success: function(response)
                {
                    $('#wishlist_items').html(response);
                }
            });
        }
    });
}

// Responsible for enrolling a student to a free course.

function handleEnrolledButton() {
    
    $.ajax({
        url: '<?php echo site_url('home/isLoggedIn?url_history='.base64_encode($actual_link)); ?>',
        success: function(response)
        {
            if (!response) {
                window.location.replace("<?php echo site_url('login'); ?>");
            }
        }
    });
}

// Responsible for removing items from the cart list
function removeFromCartList(elem) {
    url1 = '<?php echo site_url('home/handleCartItems');?>';
    $.ajax({
        url: url1,
        type : 'POST',
        data : {course_id : elem.id},
        success: function(response)
        {
            $('#cart_items').html(response);
        }
    });
}

function handleBuyNow(course_id) {
    url = '<?php echo site_url('home/handleCartItemForBuyNowButton');?>';

    $.ajax({
        url: url,
        type : 'POST',
        data : {course_id : course_id},
        success: function(response)
        {
            window.location.replace("<?php echo site_url('home/shopping_cart'); ?>");
        }
    });
}

function handleCheckOut() {
    $.ajax({
        url: '<?php echo site_url('home/isLoggedIn?url_history='.base64_encode($actual_link)); ?>',
        success: function(response)
        {
            if (!response) {
                window.location.replace("<?php echo site_url('login'); ?>");
            }else if("<?php echo $this->session->userdata('total_price_of_checking_out'); ?>" > 0){
                window.location.replace("<?php echo site_url('home/payment/'); ?>");
            }else{
                toastr.error('<?php echo site_phrase('there_are_no_courses_on_your_cart');?>');
            }
        }
    });
}

function showNewMessageSection() {
    $('.inner-message-section').hide();
    $('.new-message-section').show();
}
function cancelNewMessage() {
    $('.inner-message-section').show();
    $('.new-message-section').hide();
}

function toggleRatingView(course_id) {
    $('#course_info_view_'+course_id).toggle();
    $('#course_rating_view_'+course_id).toggle();
    $('#edit_rating_btn_'+course_id).toggle();
    $('#cancel_rating_btn_'+course_id).toggle();
}

function publishRating(course_id) {
    var review = $('#review_of_a_course_'+course_id).val();
    var starRating = 0;
    starRating = $('#star_rating_of_course_'+course_id).val();
    if (starRating > 0) {
        $.ajax({
            type : 'POST',
            url  : '<?php echo site_url('home/rate_course'); ?>',
            data : {course_id : course_id, review : review, starRating : starRating},
            success : function(response) {
                location.reload();
            }
        });
    }else{

    }
}
</script>
