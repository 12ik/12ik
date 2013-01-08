require.config({
	baseUrl : "app/beita/js/",
	loader : "lib/oz.js",
	enableAutoSuffix : false
});

define("lib/jquery.mousewheel", [ "lib/jquery_src" ]);
define("lib/jquery",
		[ "mod/easing", "lib/jquery_src", "lib/jquery.mousewheel" ],
		function(a) {
			var b = jQuery;
			b.easing.jswing = b.easing.swing;
			b.extend(b.easing, a.functions);
			return b
		});
define("gondor:domain", function() {
	return window._main_domain_
});
require([ "lib/jquery", "gondor/app" ], function(b, c) {
	var a = window._setup_opt_;
	a.perfData.push(+new Date());
	a.viewport = b("#viewport");
	c.setup(a).then(function() {
		c.show();
		if (!window._wgt_js_) {
			require("dist/widgets", function() {
			})
		}
	})
});
