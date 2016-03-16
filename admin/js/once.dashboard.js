/**
 * Version: 1.0, 29.07.2015
 * by Adam Wysocki, support@oncebuilder.com
 *
 * Copyright (c) 2015 Adam Wysocki
 *
 *	This is OnceBuilder Dashboard plugin (once.dashboard)
 *
*/

once.dashboard = {
	loaded: false,
	initialized: function(){
		this.loaded=true;
	},
	
}

$(document).ready(function () {

	// Initialize / sandbox
	once.dashboard.initialized();
});