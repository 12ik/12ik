require.config({
    baseUrl: 'js/'
});

define('jquery', 'lib/jquery.js');

define('app', [
    'jquery', 
    'mod/domready'
], function($){
    var app = {
        // do something with jquery
    	
    		abc: function(a){
    			alert($('body').html())
    		}
    };
    return app;
});

require(['app'], function(app){
    // do something with app 
	
	app.abc(456)
});


