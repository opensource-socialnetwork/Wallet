//<script>
function wallet_card(key) {
	var stripe = Stripe(key);
	var elements = stripe.elements({
		fonts: [{
			cssSrc: 'https://fonts.googleapis.com/css?family=Roboto+Slab:300,700,400',
		}, ],
		locale: '<?php echo ossn_site_settings('
		language ');?>',
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
	$(document).ready(function () {
		$("body").on('click', '#payWalletCard', function (event) {
			event.preventDefault();
			$('#payWalletCard').hide();
			$('#wallet-card-details').addClass('d-none');
			$('#wallet-card-processing').removeClass('d-none');
			$('#wallet-card-payment-loading').removeClass('d-none');
			var amount = $('#amount').val();
			if (parseInt(amount) <= 0) {
				window.location = Ossn.site_url + 'wallet/charge/failed';
				return false;
			}
			stripe.createPaymentMethod('card', card).then(function (result) {
				if (result.error) {
					var err_msg = result.error.message;
					$('#wallet-form-errors .alert').removeClass('d-none').html(err_msg);

					setTimeout(function () {
						location.reload();
					}, 3000);
					return false;
				}
				$action = Ossn.site_url + 'action/wallet/charge/card?id=' + result.paymentMethod.id + '&amount=' + amount;
				Ossn.PostRequest({
					url: $action,
					callback: function (payment_response) {
						if (payment_response.error) {
							window.location = Ossn.site_url + 'wallet/charge/failed';
						}
						if (!payment_response.error && payment_response.requires_action) {
							stripe.handleCardAction(payment_response.payment_intent_client_secret).then(function (intent) {
								if (intent.error) {
									window.location = Ossn.site_url + 'wallet/charge/failed';
								} else {
									Ossn.PostRequest({
										url: Ossn.site_url + 'action/wallet/charge/card/verify?id=' + intent.paymentIntent.id,
										callback: function (final) {
											if (final.success || final.failed) {
												window.location = final.redirect;
											}
										},
									});
								}
							});
						}
						//success or failed
						if (payment_response.redirect) {
							window.location = payment_response.redirect;
						}
					}
				});
			});
		});
	});
}

function wallet_seamless(key, tier_guid) {
	var stripe = Stripe(key);
	var elements = stripe.elements({
		fonts: [{
			cssSrc: 'https://fonts.googleapis.com/css?family=Roboto+Slab:300,700,400',
		}, ],
		locale: '<?php echo ossn_site_settings('
		language ');?>'
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
	$(document).ready(function () {
		$("body").on('click', '#payWalletCard', function (event) {
			event.preventDefault();

			$('#payWalletCard').hide();
			$('#wallet-card-details').addClass('d-none');
			$('#wallet-card-processing').removeClass('d-none');
			$('#wallet-card-payment-loading').removeClass('d-none');

			$action = Ossn.site_url + 'action/wallet/charge/card/future';
			Ossn.PostRequest({
				url: $action,
				callback: function (payment_response) {
					stripe.confirmCardSetup(payment_response.payment_intent_client_secret, {
						payment_method: {
							card: card,
						}
					}).then(function (result) {
						if (result.error) {
							var err_msg = result.error.message;
							$('#wallet-form-errors .alert').removeClass('d-none').html(err_msg);
							$('#wallet-card-processing').addClass('d-none');
							setTimeout(function () {
								location.reload();
							}, 3000);
							return false;
						}
						if (result.setupIntent.status != 'succeeded') {
							$('#wallet-form-errors .alert').removeClass('d-none').html(Ossn.Print('wallet:card:exceptions:processing_error'));
							$('#wallet-card-processing').addClass('d-none');

							setTimeout(function () {
								location.reload();
							}, 3000);


							return false;
						}
						if (result.setupIntent.status == 'succeeded') {
							var paymentMethodId = result.setupIntent.payment_method;
							Ossn.PostRequest({
								url: Ossn.site_url + 'action/wallet/charge/card/future/save?payment_id=' + paymentMethodId + '&tier_guid=' + tier_guid,
								callback: function (response) {
									if (response.success == true && response.redirect == false) {
										window.location = Ossn.site_url + "wallet/overview";
									} else if (response.success == true && response.redirect != false) {
										window.location = Ossn.site_url + response.redirect;
									} else {
										window.location = response.redirect;
									}
								}
							});
						}
					});
				}
			});
		});
	});
}