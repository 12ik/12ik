define(
		"mod/mention",
		[ "lib/jquery", "mod/lang", "mod/event", "mod/key" ],
		function(e, k, l, n) {
			var j = {
				selectRangeText : function(q, r, o) {
					if (q.createTextRange) {
						var p = q.createTextRange();
						p.moveEnd("character", -q.value.length);
						p.moveEnd("character", o);
						p.moveStart("character", r);
						p.select()
					} else {
						q.setSelectionRange(r, o)
					}
				},
				setCaretPosition : function(p, o) {
					j.selectRangeText(p, o, o)
				},
				getCaretPosition : function(s) {
					if (s.createTextRange) {
						s.focus();
						var t = s.value, o = document.selection.createRange(), q = s
								.createTextRange(), r = q.duplicate();
						r.moveToBookmark(o.getBookmark());
						q.setEndPoint("EndToStart", r);
						if (o == null || q == null) {
							return t.length
						}
						var p = o.text.replace(/[\r\n]/g, "."), u = t.replace(
								/[\r\n]/g, ".");
						return u.indexOf(p, q.text.length)
					} else {
						return s.selectionStart
					}
				}
			}, b, h = [ "@", "#" ], c = {
				"#" : "＃"
			}, f = {};
			var i = {
				keydownHandler : function(q) {
					var p = q.target;
					if (p.className.indexOf("mention") !== -1) {
						var o = d(p);
						var r = o.slices();
						a = true;
						if (r.tag !== null) {
							switch (n.KEYS_CODE[q.keyCode]) {
							case "space":
							case "esc":
								o.event.fire("quit");
								a = false;
								break;
							case "return":
							case "tab":
								q.preventDefault();
								o.event.fire("pick", [ o ]);
								a = false;
								break;
							case "up":
								q.preventDefault();
								o.event.fire("move", [ -1 ]);
								a = false;
								break;
							case "down":
								q.preventDefault();
								o.event.fire("move", [ 1 ]);
								a = false;
								break;
							default:
								break
							}
						}
					}
				},
				keyupHandler : function(q) {
					var p = q.target;
					if (p.className.indexOf("mention") !== -1) {
						var o = d(p);
						var r = o.slices();
						if (!a) {
							return
						}
						if (r.tag !== null) {
							o.event.fire("show", [ o.slices.accord, r.tag,
									o.cursorPos(r.beforeCaret), o ])
						} else {
							o.event.fire("quit")
						}
					}
				},
				plugin : function(o) {
					this._plugedSuggester = o
				}
			};
			var a = true;
			i.lib = {
				insertAtCaret : function(o, s) {
					if (document.selection) {
						o.focus();
						var r = document.selection.createRange();
						r.text = s;
						o.focus()
					} else {
						if (o.selectionStart || o.selectionStart == "0") {
							var q = o.selectionStart, p = o.selectionEnd, t = o.scrollTop;
							o.value = o.value.substring(0, q) + s
									+ o.value.substring(p, o.value.length);
							o.focus();
							o.selectionStart = q + s.length;
							o.selectionEnd = q + s.length;
							o.scrollTop = t
						} else {
							o.value += s;
							o.focus()
						}
					}
				}
			};
			function d(p) {
				var s, r = i._plugedSuggester;
				if (p.id.indexOf("mention") === -1) {
					s = q();
					p.id = "mention-" + s;
					f[s] = m(p);
					f[s].event.bind("quit", r.clear.bind(r));
					f[s].event.bind("pick", r.pick.bind(r));
					f[s].event.bind("move", r.move.bind(r));
					f[s].event.bind("show", r.show.bind(r));
					for ( var t in f) {
						if (!o(f[t].getDOM())) {
							f[t].destroy();
							delete f[t]
						}
					}
				} else {
					s = p.id.match(/\d{6}/)
				}
				return f[s];
				function q() {
					var u = "" + Math.floor(Math.random() * 1000000);
					if (u.length < 6) {
						u = "000000".slice(0, 6 - u.length) + u
					}
					if (u in Object.keys(f)) {
						return q()
					}
					return u
				}
				function o(u) {
					while (u.parentNode) {
						u = u.parentNode
					}
					return !!(u.body)
				}
			}
			function m(o) {
				var q = l(), u = e(o).data("leaders") || h, p = e(o).data(
						"context"), t = e(o), s = {
					width : t.width(),
					fontFamily : t.css("font-family"),
					fontSize : t.css("font-size"),
					lineHeight : t.css("line-height")
				};
				return {
					context : p,
					event : q,
					destroy : function() {
						q.unbind()
					},
					getDOM : function() {
						return o
					},
					powerInsert : function(v) {
						var x = r();
						if (x.tag !== null) {
							o.value = x.beforeLeader + r.accord + v + " "
									+ x.afterCaret
						}
						var w = x.offset - x.tag.length + v.length + 1;
						j.setCaretPosition(o, w)
					},
					slices : r,
					cursorPos : function(A) {
						var x = t.offset(), w = t.css("paddingTop"), z = t
								.css("paddingLeft"), v = e("<em>&nbsp</em>"), y;
						if (!b) {
							g()
						}
						b.css({
							width : s.width,
							"font-family" : s.fontFamily,
							"font-size" : s.fontSize,
							"line-height" : s.lineHeight
						}).text(A).append(v);
						y = v.position();
						y.top -= o.scrollTop;
						y.left -= o.scrollLeft;
						return {
							top : x.top + y.top,
							left : x.left + y.left,
							marginTop : w,
							marginLeft : z
						}
					}
				};
				function r() {
					var A = o.value, B = j.getCaretPosition(o), z = A.slice(0,
							B), w = A.slice(B), v = null, y = null;
					u.forEach(function x(F, D, I, H) {
						var C = 0, G = [];
						if (v === null) {
							var E = z.lastIndexOf(F);
							if (H) {
								o.value = o.value.replace(F, H);
								F = H
							}
							if (E !== -1) {
								y = z.slice(0, E);
								v = z.slice(E + 1);
								if (v.indexOf(" ") !== -1) {
									v = null;
									if (c[F] !== undefined && !H) {
										x(c[F], C, G, F)
									}
								} else {
									r.accord = F
								}
							} else {
								if (c[F] !== undefined && !H) {
									x(c[F], C, G, F)
								}
							}
						}
					});
					return {
						value : A,
						beforeLeader : y,
						beforeCaret : z,
						tag : v,
						afterCaret : w,
						offset : B
					}
				}
			}
			function g() {
				b = e("<pre></pre>").css({
					position : "absolute",
					left : -9999,
					border : "1px",
					"word-wrap" : "break-word"
				}).appendTo("body")
			}
			return i
		});