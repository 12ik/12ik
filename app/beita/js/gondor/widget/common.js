define(
		"gondor/widget/common",
		[ "lib/jquery", "mod/lang", "gondor/toolkit", "mod/scrollbar",
				"mod/event", "mod/template", "gondor/view",
				"gondor/view/dialog", "gondor/view/uievent", "gondor/observer" ],
		function(d, l, k, n, m, b, j, h, i, g) {
			var f = {
				".wgt-digg.disabled" : function() {
					g.fire("citizen:submit-disabled", [ d(this).attr(
							"data-reason") ])
				},
				".wgt-digg" : function() {
					var s = this;
					if (s.nodeName === "A") {
						var w = ".icon-heart", t = '<b class="icon-heart"></b>', q = "你已经标记过红心了。", v = d(
								s).data("pos"), p = d("b", s), o = p.length ? p
								: d(s), r = o.text(), u = s.href;
						k.post(u, function(z) {
							if (!z.r) {
								d("body").append(t);
								var y = d(s).offset(), x = d(w);
								x.css({
									top : y.top,
									left : y.left
								}).animate({
									top : "-=30",
									opacity : 0
								}, 300, function() {
									x.remove()
								});
								o.text(~~r + 1)
							} else {
								if (v === "dialog") {
									h.confirm(q)
								} else {
									j.alert(q)
								}
							}
						}, "json")
					}
				}
			};
			var c = {};
			var e = {
				evt : m(),
				init : function() {
					this.event = i.clickProxy.bind(f)
				},
				render : function(p, r) {
					if (!p.wrapper[0]) {
						return
					}
					var q;
					if (p.kind) {
						if (c[p.kind] === undefined) {
							c[p.kind] = 0
						} else {
							r && e.evt.unbind(r);
							c[p.kind]++
						}
						q = c[p.kind]
					}
					if (!p.url) {
						o(typeof p.data === "string" ? d.parseJSON(p.data)
								: (p.data === undefined ? {} : p.data))
					} else {
						k.getJSON(p.url, p.args, function(t) {
							if (p.kind === undefined || q === c[p.kind]) {
								var s;
								if (!d.isEmptyObject(t)) {
									if (p.data) {
										t = l.mix(t, p.data)
									}
									o(t);
									if (t.comments) {
										s = {
											got : t.comments.length,
											n_comment : t.n_comment
										}
									}
								}
								p.cb && p.cb(t);
								if (r) {
									e.evt.fire(r, s && [ s ] || [])
								}
							}
						})
					}
					function o(t) {
						p.wrapper[p.method](b.convertTpl(p.tplname, t))
					}
				},
				resize : function(q, o, p) {
					p = p || 0;
					o.css("height", parseInt(d("#widget-" + q).parents(
							".widget-box").css("height"), 10)
							- p)
				},
				scrollLoad : function(r, p) {
					var q = function q() {
						p.action()
					}, o = a();
					r.scroll(function() {
						if (r[0].scrollTop + r.height() >= r[0].scrollHeight) {
							o(q, 30)
						}
					})
				},
				switchBnDisabled : function(p, o) {
					p.prop("disabled", o ? "" : "disabled")
				},
				cursorMethod : {
					getCursorPosition : function(q) {
						if (document.selection) {
							q.focus();
							var r = document.selection, o = r.createRange(), p = o
									.duplicate();
							p.moveToElementText(q);
							p.setEndPoint("EndToEnd", o);
							q.selectionStart = p.text.length - o.text.length;
							q.selectionEnd = q.selectionStart + o.text.length;
							return q.selectionStart
						} else {
							return q.selectionStart
						}
					},
					setCursorPosition : function(o, q) {
						this.selectRangeText(o, q, q)
					},
					selectRangeText : function(p, q, r) {
						if (document.selection) {
							var o = p.createTextRange();
							o.moveEnd("character", -p.value.length);
							o.moveEnd("character", r);
							o.moveStart("character", q);
							o.select()
						} else {
							p.setSelectionRange(q, r);
							p.focus()
						}
					},
					deleteRangeText : function(o, v) {
						var r = this.getCursorPosition(o), q = o.scrollTop, u = o.value;
						o.value = v > 0 ? u.slice(0, r - v) + u.slice(r) : u
								.slice(0, r)
								+ u.slice(r - v);
						this.setCursorPosition(o, r - (v < 0 ? 0 : v));
						d.browser.mozilla && setTimeout(function() {
							if (o.scrollTop !== q) {
								o.scrollTop = q
							}
						}, 10)
					},
					insertAfterCursor : function(q, o) {
						var v = q.value, p = this;
						if (document.selection) {
							q.focus();
							document.selection.createRange().text = o
						} else {
							var u = q.selectionStart, w = q.value.length, r = q.scrollTop;
							q.value = q.value.slice(0, u) + o
									+ q.value.slice(u, w);
							this.setCursorPosition(q, u + o.length);
							d.browser.mozilla && setTimeout(function() {
								if (q.scrollTop !== r) {
									q.scrollTop = r
								}
							}, 0)
						}
					}
				},
				commentEvt : function(v) {
					var t = v.base, u = v.wrap, q = v.url, s = v.id, C = v.commentDetail, B = v.callback, x = v.tmplExtra;
					var y = d(".comment-form", t), w = d(".comment-input", t), p = d(
							".comment-submit", t), z = ".comments", o = ".more-comments", A = "确定要删除此条评论？";
					y.unbind("submit");
					w.unbind("keyup");
					e.switchBnDisabled(p, 0);
					y.bind("submit", function(D) {
						D.preventDefault();
						e.switchBnDisabled(p, 0);
						k.post(q + s + "/add_comment", {
							text : w.val()
						}, function(E) {
							e.render({
								data : l.mix(E, x),
								wrapper : d(z, t),
								method : "append",
								tplname : "tplComment"
							});
							if (E.task_info) {
								j.alert(E.task_info.comment, undefined, {
									title : E.task_info.name
								})
							}
							w.val("");
							e.switchBnDisabled(p, 0);
							B && B();
							n.init(u[0], {
								hasShadow : true
							})
						}, "json")
					});
					w.bind("keyup", function(D) {
						e.switchBnDisabled(p, D.target.value)
					});
					t.delegate(z, "click", function(G) {
						G.preventDefault();
						var D = G.target, F = function() {
							k.post(q + s + "/delete_comment", {
								cid : E
							}, function(H) {
								if (!H.r) {
									d(D).parents("li").fadeOut(300, function() {
										d(this).remove();
										n.init(u[0], {
											hasShadow : true
										})
									})
								}
							})
						};
						if (D.className === "cmt-del") {
							var E = D.id.split("-")[1];
							if (t.hasClass("dui-dialog")) {
								h.confirm(A, F)
							} else {
								j.alert(A, F)
							}
						}
					});
					t.delegate(o, "click", function(E) {
						E.preventDefault();
						var D = this;
						r(t, D)
					});
					function r(E, F) {
						var D = d(F);
						d.ajax({
							url : q + s + "/get_comments",
							type : "get",
							data : {
								start : C.got,
								limit : 20
							},
							dataType : "json",
							beforeSend : function() {
								D.attr("class", "loading-more-comments").text(
										"加载中...")
							},
							success : function(G) {
								if (d.isEmptyObject(G)) {
									return
								}
								if (G.comments.length < 20) {
									D.remove();
									E.undelegate(o, "click")
								}
								e.render({
									data : l.mix(G, x),
									wrapper : d(z, E),
									method : "append",
									tplname : "tplComments"
								});
								C.got += G.comments.length;
								n.init(u[0], {
									hasShadow : true
								})
							},
							complete : function() {
								D.attr("class", "more-comments").text("加载更多")
							}
						})
					}
				},
				nextDate : function(q) {
					var t = new Date(), p = t.getTime(), o = new Date(p + q
							* 1000), r = function(s) {
						return s < 10 ? "0" + s : s
					};
					return o.getFullYear() + "-" + r(o.getMonth() + 1) + "-"
							+ r(o.getDate())
				}
			};
			function a() {
				var o = null;
				return function(q, r) {
					var p = Array.prototype.slice.call(arguments, 2);
					if (o !== null) {
						clearTimeout(o);
						o = null
					}
					o = setTimeout(function() {
						q.apply(null, p)
					}, r)
				}
			}
			return e
		});