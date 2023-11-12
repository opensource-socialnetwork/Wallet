//<script>
$(document).ready(function(){
		$('#wallet-alter-balance').on('click', function(e) {
			$id = $(this).data('guid');
			Ossn.MessageBox('wallet/alter?guid='+$id);
		});						   
});	