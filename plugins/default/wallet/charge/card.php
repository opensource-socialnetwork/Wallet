<script src="https://js.stripe.com/v3/"></script>
<div class="ossn-page-contents">
<?php
echo ossn_view_form('wallet/charge/stripe', array(
		'action' => ossn_site_url() . 'action/wallet/charge/stripe',
		'id' => 'payment-form',
));
?>
</div>