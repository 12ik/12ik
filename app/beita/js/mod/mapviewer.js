define(
		"mod/mapviewer",
		[ "mod/lang", "mod/browsers", "mod/event", "mod/mainloop", "mod/drag" ],
		function(d, b, a, h, c) {
			var f = 1, g = b.msie && b.msie > 8 && b.msie < 10 || b.mozilla
					&& b.mozilla < 5;
			function e(k) {
				this.config = d.mix({
					map : null,
					viewport : null,
					step : false,
					drag : true,
					origin : true,
					event : true
				}, k);
				var j = this, l = this.map = k.map, i = this.viewport = k.viewport;
				this.uuid = ++f;
				this.set()
			}
			e.prototype = {
				set : function(m) {
					if (m) {
						d.mix(this.config, m)
					} else {
						m = this.config
					}
					var l = this, i, k = this.viewport, n = this.map, j = this.config, p = m.origin;
					if (m.event === true) {
						this.event = a()
					} else {
						if (m.event) {
							this.event = m.event
						}
					}
					if (j.edgeWidth) {
						i = j.width - j.edgeWidth;
						n.style.width = j.edgeWidth + (i > 0 ? i : 0) + "px"
					}
					if (j.edgeHeight) {
						i = j.height - j.edgeHeight;
						n.style.height = j.edgeHeight + (i > 0 ? i : 0) + "px"
					}
					if (m.width || m.height) {
						k.style.width = m.width + "px";
						k.style.height = m.height + "px";
						this.event.fire("resize", [ m ])
					}
					if (p === true) {
						p = j.origin = [ (n.offsetWidth - k.offsetWidth) / 2,
								(n.offsetHeight - k.offsetHeight) / 2 ]
					}
					if (p) {
						k.scrollLeft = p[0];
						k.scrollTop = p[1]
					}
					if (m.drag === true) {
						if (!this.dragOpt) {
							this.dragOpt = c({
								handler : n,
								whenDraging : function(t, q) {
									var r = l.viewport, o = r.scrollLeft - q[0]
											+ t[0], s = r.scrollTop - q[1]
											+ t[1];
									l.locate(o, s);
									if (j.whenDraging) {
										j.whenDraging([ o + r.offsetWidth / 2,
												s + r.offsetHeight / 2 ], t, q)
									}
								}
							})
						}
						this.dragOpt.enable()
					} else {
						if (this.dragOpt && m.drag === false) {
							this.dragOpt.disable()
						}
					}
				},
				move : function(i, m, l, k) {
					var j = this.viewport;
					return this.locate(j.scrollLeft + i, j.scrollTop + m, l, k)
				},
				locate : function(i, o, n, m) {
					var k = this, j = this.viewport;
					if (!i) {
						return [ j.scrollLeft + j.offsetWidth / 2,
								j.scrollTop + j.offsetHeight / 2 ]
					}
					if (!n) {
						if (g) {
							j.style.visibility = "hidden"
						}
						j.scrollLeft = i;
						j.scrollTop = o;
						if (g) {
							j.style.visibility = "visible"
						}
						k.event.fire("moveEnd")
					} else {
						var l = "mapViewer-" + this.uuid + ":move";
						h.remove(l).animate(l, j.scrollLeft, i, n, {
							easing : m || "linear",
							step : function(p) {
								j.scrollLeft = p
							}
						}).animate(l, j.scrollTop, o, n, {
							easing : m || "linear",
							step : function(p) {
								j.scrollTop = p
							},
							callback : function(p) {
								h.remove(l);
								k.event.fire("moveEnd")
							}
						})
					}
					return this.event.promise("moveEnd")
				}
			};
			return function(i) {
				return new e(i)
			}
		});