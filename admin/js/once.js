/**
 * --------------------------------------------------------------------
 * Version: 1.0, 31.05.2012
 * by Adam Wysocki, goldpaid777@gmail.com
 *
 *
 * Copyright (c) 2012 Adam Wysocki
 * --------------------------------------------------------------------
*/
var once={
	// Varible for future use to set active panel
	api: true,
	cms: true,
	admin: true,
	creator: true,
	CSSfiles: [],
	JSfiles: [],
	editors: [],
	path: '',
	// Microtime counter
	microtime: function(get_as_float){
		var now = new Date().getTime() / 1000;
		var sec = parseInt(now, 10);
		return (get_as_float) ? now : (Math.round((now - sec) * 1000) / 1000) + ' ' + sec;
	},
	// Initialize once requests
	init: function(){
		if(once.cms){
			once.path='/admin';
		}
		
		once.microtimer = once.microtime(true);
		once.loadJSfile('js/once.prototype.js');
		
		// Load all required JS files
		$("[data-require!='']").each(function() {
			if($(this).data("require")!=undefined){
				once.loadJSfile($(this).data("require"));
			}
		});
		
		// Append $_GET['csrf_token'] for all post requiest
		var csrf_token = $('meta[name="csrf_token"]').attr('content');
		$.ajaxPrefilter(function(options, originalOptions, jqXHR){
			if (options.type.toLowerCase() === "post") {
				options.url += "&csrf_token=" + csrf_token;
			}
		});
	},
	// Use data 
	usedata: function(type,data){
		eval("this."+type+" = data;");
		eval("console.log(this."+type+");");
	},
	// Load javascript file in <head> by using jquery
	loadJSfile: function(src){
		if($.inArray(src,once.JSfiles)==-1){
			$('script[src="' + src + '"]').remove();
			$('<script>').attr('src', src+"?"+Math.random()).appendTo('head');
			once.JSfiles.push(src);
		}
		
	},
	// Load css file by using jquery, passing attributes to pass it in <head>  
	loadCSSfile: function(src){
		if($.inArray(src,once.CSSfiles)==-1){
			$('link[href="' + src + '"]').remove();
			var style = $('<link>');
			style.attr('href', src+"?"+Math.random());
			style.attr('type', 'text/css');
			style.attr('media', 'screen');
			style.attr('rel', 'stylesheet');
			style.appendTo('head');
			once.CSSfiles.push(src);
		}
	},
}

// Start
$(document).ready(function () {
	once.init();
});