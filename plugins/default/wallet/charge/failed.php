<div class="ossn-widget">
	<div class="widget-heading"><?php echo ossn_print('wallet:charge:failed');?></div>
	<div class="widget-contents">
		<div class="wallet-charge-failed">
        		<div class="alert alert-danger">
                <?php
				 	if(isset($_SESSION['wallet_last_error'])){
							$error = $_SESSION['wallet_last_error'];
    $type = $error['type'] ?? '';
    $code = $error['code'] ?? '';
    $decline = $error['decline_code'] ?? '';
    $message = $error['message'] ?? '';

    // Default fallback
    $userMessage = ossn_print('wallet:card:exceptions:general_error');

    if ($type === 'card_error') {
        switch ($decline) {
            case 'insufficient_funds':
                $userMessage = ossn_print('wallet:card:exceptions:insufficient_funds');
                break;

            case 'lost_card':
                $userMessage = ossn_print('wallet:card:exceptions:lost_card');
                break;

            case 'stolen_card':
                $userMessage = ossn_print('wallet:card:exceptions:stolen_card');
                break;

            case 'generic_decline':
                $userMessage = ossn_print('wallet:card:exceptions:generic_decline');
                break;

            case 'card_velocity_exceeded':
                $userMessage = ossn_print('wallet:card:exceptions:card_velocity_exceeded');
                break;

            default:
                // Handle errors with no decline_code but with code instead
                switch ($code) {
                    case 'expired_card':
                        $userMessage = ossn_print('wallet:card:exceptions:expired_card');
                        break;

                    case 'incorrect_cvc':
                        $userMessage = ossn_print('wallet:card:exceptions:incorrect_cvc');
                        break;

                    case 'processing_error':
                        $userMessage = ossn_print('wallet:card:exceptions:processing_error');
                        break;

                    case 'incorrect_number':
                        $userMessage = ossn_print('wallet:card:exceptions:incorrect_number');
                        break;

                    case 'authentication_required':
                        $userMessage = ossn_print('wallet:card:exceptions:authentication_required');
                        break;

                    default:
                        $userMessage = ossn_print('wallet:card:exceptions:generic_decline');
                        break;
                }
                break;
        }

    } else {
        // Non-card Stripe error types
        switch ($type) {
            case 'rate_limit':
                $userMessage = ossn_print('wallet:card:exceptions:rate_limit');
                break;

            case 'invalid_request':
                $userMessage = ossn_print('wallet:card:exceptions:invalid_request');
                break;

            case 'auth_error':
                $userMessage = ossn_print('wallet:card:exceptions:authentication_required');
                break;

            case 'api_connection':
                $userMessage = ossn_print('wallet:card:exceptions:api_connection');
                break;

            case 'api_error':
                $userMessage = ossn_print('wallet:card:exceptions:api_error');
                break;

            case 'general_error':
            default:
                $userMessage = ossn_print('wallet:card:exceptions:general_error');
                break;
        }
    }
					
					echo "<strong>".$userMessage."</strong>";
					}
				?>                
				<?php echo ossn_print('wallet:charge:failed:note');?>
               	</div>
		</div>
    </div>
</div>