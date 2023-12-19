//<script>
function wallet_card(key) {
	var stripe = Stripe(key);
	var elements = stripe.elements({
		fonts: [{
			cssSrc: 'https://fonts.googleapis.com/css?family=Roboto+Slab:300,700,400',
		}, ],
		locale: '<?php echo ossn_site_settings('langauge');?>'
	});
	$styles = {
		invalid: {
			iconColor: 'red',
			color: 'red',
		},
	};
	var card = elements.create('card', {
		iconStyle: 'solid',
		style: $styles,
	});
	card.mount('#card');
	$(document).ready(function() {
		$("body").on('click', '#payWalletCard', function(event) {
			event.preventDefault();
			$('#payWalletCard').hide();
			$('#wallet-card-details').addClass('d-none');
			$('#wallet-card-processing').removeClass('d-none');
			$('#wallet-card-payment-loading').removeClass('d-none');
			var amount = $('#amount').val();
			if(parseInt(amount) <= 0){
					window.location = Ossn.site_url + 'wallet/charge/failed';
					return false;
			}
			stripe.createPaymentMethod('card', card).then(function(result) {
				$action = Ossn.site_url + 'action/wallet/charge/card?id=' + result.paymentMethod.id + '&amount=' + amount;
				Ossn.PostRequest({
					url: $action,
					callback: function(payment_response) {
						console.log(payment_response);
						if (!payment_response.error && payment_response.requires_action) {
							stripe.handleCardAction(payment_response.payment_intent_client_secret).then(function(intent) {
								if (intent.error) {
									window.location = Ossn.site_url + 'wallet/charge/failed';
								} else {
									Ossn.PostRequest({
										url: Ossn.site_url + 'action/wallet/charge/card/verify?id=' + intent.paymentIntent.id,
										callback: function(final) {
											if (final.success || final.failed) {
												window.location = final.redirect;
											}
										},
									});
								}
							});
						}
						//success or failed
						if(payment_response.redirect){
								window.location = payment_response.redirect;	
						}
					}
				});
			});
		});
	});
}