jQuery(document).ready(function(jQuery){
	var jqform_modal = jQuery('.cd-user-modal'),
		jqform_login = jqform_modal.find('#cd-login'),
		jqform_signup = jqform_modal.find('#cd-signup'),
		jqform_modal_tab = jQuery('.cd-switcher'),
		jqtab_login = jqform_modal_tab.children('li').eq(0).children('a'),
		jqtab_signup = jqform_modal_tab.children('li').eq(1).children('a'),
		jqmain_nav = jQuery('.main_nav');

	//open alert
	jqmain_nav.on('click', function(event){

		if( jQuery(event.target).is(jqmain_nav) ) {
			// on mobile open the submenu
			jQuery(this).children('ul').toggleClass('is-visible');
		} else {
			// on mobile close submenu
			jqmain_nav.children('ul').removeClass('is-visible');
			//show modal layer
			jqform_modal.addClass('is-visible');	
			//show the selected form
			( jQuery(event.target).is('.cd-signup') ) ? signup_selected() : login_selected();
		}

	});

	//close
	jQuery('.cd-user-modal').on('click', function(event){
		if( jQuery(event.target).is(jqform_modal) || jQuery(event.target).is('.cd-close-form') ) {
			jqform_modal.removeClass('is-visible');
		}	
	});
	//press esc close
	jQuery(document).keyup(function(event){
    	if(event.which=='27'){
    		jqform_modal.removeClass('is-visible');
	    }
    });

	//switch
	jqform_modal_tab.on('click', function(event) {
		//event.preventDefault();
		//( jQuery(event.target).is( jqtab_login ) ) ? login_selected() : signup_selected();
	});

	function login_selected(){
		// jqform_login.addClass('is-selected');
		// jqform_signup.removeClass('is-selected');
		// //jqform_forgot_password.removeClass('is-selected');
		// jqtab_login.addClass('selected');
		// jqtab_signup.removeClass('selected');
		signup_selected();
	}

	function signup_selected(){
		jqform_login.removeClass('is-selected');
		jqform_signup.addClass('is-selected');
		//jqform_forgot_password.removeClass('is-selected');
		jqtab_login.removeClass('selected');
		jqtab_signup.addClass('selected');
	}

});
