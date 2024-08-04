var $doc = jQuery(document);

$doc.ready(function($){
	$doc.on('click', '#logoutModal .modal-footer a.btn', function (e) {
		e.preventDefault();
		var $this = $(this).closest('#logoutModal');
		$this.find('form').trigger('submit');
	});
});