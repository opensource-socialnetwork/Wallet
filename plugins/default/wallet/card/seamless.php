<script src="https://js.stripe.com/v3/"></script>
<div class="ossn-page-contents">
<?php
echo ossn_view_form('wallet/card/seamless', array(
		'action' => 'javascript:void(0);',
		'id' => 'seamless-payment-form',
));
?>
</div>