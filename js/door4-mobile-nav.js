jQuery(document).ready(function(){
	jQuery('.door4-mobile-nav-toggle').click(function(e){
		e.preventDefault();
		$this = jQuery(this);
		$body_inner = jQuery('.door4-mobile-nav-push-inner');
		$overlay = $body_inner.siblings('.door4-mobile-nav-overlay');
		$menu = jQuery('.door4-mobile-nav');
		$slideby = $menu.outerWidth();

		if($menu.hasClass('activated')) {		
			$menu.removeClass('activated');
			$this.removeClass('activated');
			$body_inner.removeClass('pushed-aside');
			$overlay.removeClass('overlaid');
			jQuery('.rolled_out').each(function(){
				jQuery(this).removeClass('rolled_out');
			});
			jQuery('.obscured').each(function(){
				jQuery(this).removeClass('obscured');
			});
		} else {
			$menu.addClass('activated');
			$this.addClass('activated');
			$body_inner.addClass('pushed-aside');
			$overlay.addClass('overlaid');
		};

	});

	jQuery('.door4-mobile-nav-overlay').click(function(e){
		$menu = jQuery('.door4-mobile-nav');
		$overlay = jQuery(this);
		$link = jQuery('.door4-mobile-nav-toggle');
		$body_inner = $overlay.siblings('.door4-mobile-nav-push-inner');
		
		$overlay.removeClass('overlaid');
		$body_inner.removeClass('pushed-aside');
		$menu.removeClass('activated');
		$link.removeClass('activated');
		jQuery('.rolled_out').each(function(){
			jQuery(this).removeClass('rolled_out');
		});
		jQuery('.obscured').each(function(){
			jQuery(this).removeClass('obscured');
		});
	});

	$navlist = jQuery('.mobile-nav-list');
	if(jQuery('.door4-mobile-nav').length>0) {
		jQuery('li.mobile-back-item').each(function(){
			$this = jQuery(this);
			$this.children('a').on('click', function(e){
				e.preventDefault();
				$clicked = jQuery(this);
				$onelevel = $clicked.closest('ul');
				$twolevels = $onelevel.parent().closest('ul');
				$onelevel.removeClass('rolled_out');
				$twolevels.removeClass('obscured');
			});
		});
		jQuery('li.mobile-nav-item').each(function(){
			$this = jQuery(this);
			if($this.children('ul').length>0) {
				$this.children('a').on('click', function(e){
					e.preventDefault();
					$clicked = jQuery(this);
					$clicked.siblings('ul').addClass('rolled_out');
					$clicked.closest('ul').addClass('obscured');
				});
			};
		});
	};
});
