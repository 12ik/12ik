define(
		"mod/datasource",
		[ "mod/lang", "mod/network", "mod/template" ],
		function(c, g, b) {
			var e = Math.floor, a = false, f = {
				root : "",
				remote : "",
				post : false,
				data : {},
				filter : function() {
				},
				expire : 0,
				charset : "utf-8",
				mock : false,
				callback : "",
				error : function() {
				}
			};
			var d = function(h) {
				this.cbDict = {};
				this._config = {};
				this._memData = {};
				this.config(h)
			};
			d.prototype = {
				config : function(h) {
					c.config(this._config, h, f)
				},
				get : function(j, k) {
					var r = this, m = this.cbDict, n = this._config, h = b
							.format(n.root + n.remote, j), i = +new Date(), q = n.callback;
					var l = this._memData[h];
					if (l) {
						if (a) {
							delete this._memData[h]
						} else {
							setTimeout(function() {
								p(l)
							}, 0);
							return
						}
					}
					if (n.mock) {
						m[h] = n.mock
					}
					if (q) {
						q = m[h];
						if (q) {
							var o = parseInt(q.split("______")[2], 10);
							if (a || i - o >= n.expire * 3600000) {
								q = false
							}
						}
						if (!q) {
							q = m[h] = [ n.callback, e(Math.random() * 10000),
									i ].join("______")
						}
					}
					if (a) {
						a = false;
						if (k) {
							k()
						}
						return
					}
					var s = "oz_tm=" + encodeURIComponent(q);
					if (n.post) {
						h = h.split(/\?/);
						h[0] += /\?/.test(h[0]) ? "&" + s : "?" + s;
						g.ajax({
							type : "POST",
							url : h[0],
							data : [ h[1], g.params(n.data) ].join("&"),
							dataType : "json",
							success : p
						})
					} else {
						h += /\?/.test(h) ? "&" + s : "?" + s;
						g.getJSON(h, {}, p, {
							charset : n.charset,
							callback : q,
							error : n.error
						})
					}
					function p(t) {
						if (t) {
							var u = r.make(j, t);
							if (k && u) {
								k(u)
							}
						} else {
							n.error(t)
						}
					}
				},
				update : function(i, h) {
					if (i) {
						a = true;
						this.get(i, h)
					} else {
						this.cbDict = {};
						this._memData = {};
						if (h) {
							h()
						}
					}
				},
				put : function(k, j) {
					var h = this._config, i = b.format(h.root + h.remote, k);
					this._memData[i] = j
				},
				make : function(k, i) {
					var j, h = this._config;
					if (h.filter) {
						j = h.filter(k, i)
					}
					return j === false ? false : (j || i)
				}
			};
			return function(h) {
				return new d(h)
			}
		});