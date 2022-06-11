<div class="hidden">
	<div class="modal_team_find box_elem_midd"  id="premium">
		<div class="modal_content">
			<button class="mfp-close" id="button-close" type="button" title="Закрыть (Esc)">×</button>
			<?php 
			if ( is_user_logged_in() ) { 
			?>
			<div class="col-md-12 right">
				<div class="massage">
					<p id="error"></p>
					<p id="complete"></p>
				</div>
				<div class="desc_text">
					<h2>Premium</h2>
					<ul>
					    <?php
					    
                        $member_subscriptions = pms_get_member_subscriptions( array( 'user_id' => get_current_user_id() ) );	
					    
					        echo do_shortcode('[pms-subscriptions]');
            
            if($member_subscriptions[0]->status == 'pending'){
                $_REQUEST['pms-action'] = 'retry_payment_subscription';
    
                $_REQUEST['subscription_plan'] = $member_subscriptions[0]->subscription_plan_id;
                $_REQUEST['pmstkn'] = wp_nonce_field( 'pms_retry_payment_subscription', 'pmstkn' );               
            } elseif($member_subscriptions[0]->status == 'active') {
                
                $_GET['pms-action'] = 'abandon_subscription';
                $_GET['subscription_id'] = $member_subscriptions[0]->id;      

            } elseif($member_subscriptions[0]->status == 'canceled'){
                
                $_REQUEST['pms-action'] = 'renew_subscription';
                $_REQUEST['subscription_plan'] = $member_subscriptions[0]->subscription_plan_id;
                $_REQUEST['subscription_id'] = $member_subscriptions[0]->id;


            } 
 

            
            the_content();

					   
					    ?>
			</div>
			<?php
				} else{
					echo '
					<div class="col-md-12 right">
						<div class="massage">
							<p id="error" style="display: block;">Error! Mate has left chat. You may start new search now.</p>
						</div>
					</div>';
				}
			?>
		</div>
	</div>
</div>