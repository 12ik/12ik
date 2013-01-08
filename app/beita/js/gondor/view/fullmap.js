define(
		"gondor/view/fullmap",
		[ "lib/jquery", "mod/lang", "mod/template", "mod/mapviewer",
				"mod/domcanvas", "mod/mainloop", "gondor/observer",
				"gondor/view/dashboard", "gondor/view/sidebar", "mod/domready" ],
		function(g, I, h, b, f, l, B, x, s) {
			var u = 160, v = 640, i = 20, p = 14, w = 34, D = [ "N", "S", "W",
					"E" ], o = {
				N : "S",
				S : "N",
				W : "E",
				E : "W"
			}, C = {
				N : [ 0, -u ],
				S : [ 0, u ],
				W : [ -u, 0 ],
				E : [ u, 0 ]
			}, e = [ {
				x : 331,
				y : 573
			}, {
				x : 187,
				y : 271
			}, {
				x : 120,
				y : 338
			}, {
				x : 124,
				y : 481
			}, {
				x : 328,
				y : 122
			}, {
				x : 39,
				y : 406
			}, {
				x : 396,
				y : 620
			}, {
				x : 268,
				y : 195
			}, {
				x : 192,
				y : 415
			}, {
				x : 252,
				y : 491
			}, {
				x : 254,
				y : 339
			}, {
				x : 257,
				y : 623
			}, {
				x : 116,
				y : 195
			}, {
				x : 50,
				y : 268
			}, {
				x : 269,
				y : 61
			}, {
				x : 388,
				y : 54
			}, {
				x : 316,
				y : 416
			}, {
				x : 320,
				y : 268
			} ], a = '<a href="/area/{{id}}/" id="fmap_area_{{id}}" class="sprite-area" style="top:{{y}}px;left:{{x}}px;">{{name}}</a>', k = '<a class="overlap refer-activity cate-{{cate}}" href="#/place/{{pid}}/widget/{{wid}}/activity/{{aid}}/poster" title="正在举办活动：{{name}}" style="top:{{top}}px;left:{{left}}px;" tksub="activity:mapmaker"></a>', j = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABUAAAAVCAMAAACeyVWkAAAAA3NCSVQICAjb4U/gAAAASFBMVEWFs8vN19bn8PWVvM3r5tuhwc/H3eiwzt7///+gxdfX3NixydK/2OT3+vyKtszX5+7b3ticv87v9fiyytLP4uu40+Giws+YwNRfGrRJAAAAGHRSTlP/////AP////////////////////////84vapSAAAACXBIWXMAAAsSAAALEgHS3X78AAAAHHRFWHRTb2Z0d2FyZQBBZG9iZSBGaXJld29ya3MgQ1M1cbXjNgAAAKJJREFUGJV10VESgyAMBNBVsAQERKX2/jdtJMapbd2PML5hIBLYljCajGzGIJ/YS9mg2Ypqh890oldsDFvwncI680ocAyy8eGC2CDjUwZAo2yqaqMJxbbrCiE6UMHFtapBFY6JXoqdolltZK1VavCjOvY5vql73HufGvQHn9dyjh4ieKHvtIag+qIfXftu/XTPfvsP/N7t5X57FcNpwzuJ3bm8LcAd9LLyXAwAAAABJRU5ErkJggg==", d = g(window), y, n, H, m, c = [], E = {}, F = {}, t = {}, A = 0, q;
			var r = {
				init : function(K) {
					if (K.size) {
						u = K.size[0];
						i = K.size[1];
						p = K.size[2];
						C = {
							N : [ 0, -u ],
							S : [ 0, u ],
							W : [ -u, 0 ],
							E : [ u, 0 ]
						}
					}
					var M = K.detailLayer
							&& K.detailLayer.find(".minicanvas")[0], N = K.overviewLayer
							&& K.overviewLayer.find(".minicanvas")[0], J = d
							.width()
							- s.width, L = d.height() - x.height;
					if (M) {
						this.detailLayer = b({
							viewport : K.detailLayer[0],
							map : M,
							width : J,
							height : L,
							whenDraging : G
						})
					}
					if (N) {
						this.overviewLayer = b({
							viewport : K.overviewLayer[0],
							map : N,
							width : J,
							height : L,
							edgeWidth : 678,
							edgeHeight : 878
						})
					}
					this.loadingLayer = K.loadingLayer;
					this.ctx = f(M);
					this.lib = K.data.lib;
					this.arealib = K.data.arealib;
					this.userInfo = K.userInfo;
					this.isHideMe = K.isHideMe;
					this.markedLib = {};
					this.depth = K.depth || 0;
					this.visited = K.visited;
					z(K.detailLayer)
				},
				updateSize : function() {
					if (!y) {
						return
					}
					var J = d.width() - s.width, K = d.height() - x.height;
					this.detailLayer.set({
						width : J,
						height : K
					});
					this.overviewLayer.set({
						width : J,
						height : K
					})
				},
				drawOverview : function() {
					var K = this.overviewLayer.config, J = K.origin[0]
							+ K.width / 2, M = K.origin[1] + K.height / 2;
					var L = Object.keys(this.arealib).map(function(O) {
						var N = this[O], P = e[O - 1];
						N.x = P.x;
						N.y = P.y;
						return h.format(a, N)
					}, this.arealib).join("");
					this.sketchbox = g(
							'<div class="town-sketch">' + L + "</div>")
							.appendTo(this.overviewLayer.map);
					n = true;
					this.updateOverview()
				},
				drawMap : function(Q) {
					var N = this, M = this.ctx, L = this.detailLayer.config, O = [
							Q, this.lib[Q].kind ], J = L.origin[0] + L.width
							/ 2, P = L.origin[1] + L.height / 2;
					M.font = "12px sans-serif";
					M.globalCompositeOperation = "destination-over";
					M.translate(J, P);
					this.metroIcon = new Image();
					this.metroIcon.src = j;
					if (this.visited) {
						N.hiddenMode = true;
						M._otherClass = "minimap-hidden";
						this.drawNode(O);
						M.render();
						N.hiddenMode = false
					} else {
						N.depth = 0;
						N.hiddenMode = false;
						this.drawNode(O);
						M.render()
					}
					if (this.visited) {
						this.visited.forEach(function(R) {
							if (R) {
								this.explore(R)
							}
						}, N)
					}
					c = Object
							.keys(this.arealib)
							.map(
									function(T) {
										var V = N.getPos(this[T].center_cross), S = v * 0.4, R = V[0], U = V[1];
										return {
											id : T,
											vertex : [ [ R - S, U ],
													[ R, U + S ], [ R + S, U ],
													[ R, U - S ] ]
										}
									}, this.arealib);
					var K = "";
					y = true;
					this.updateMap();
					B.resolve("fullmap:ready")
				},
				drawNode : function(Z, ab) {
					var R = this, T = this.ctx, O = this.lib, L = Z[1], P = this.markedLib[Z[0]], S = !P ? O[Z[0]]
							: null;
					ab = ab || 0;
					if (L > 6) {
						return
					} else {
						if (L < 4) {
							if (S && !ab) {
								for ( var X = 0, U = D.length; X < U; X++) {
									if (S.neighbors[D[X]]) {
										return this.drawNode(S.neighbors[D[X]],
												ab)
									}
								}
							}
							return
						}
					}
					if (S) {
						this.markedLib[S.id] = 1;
						S.canvasData = {};
						T.bindData = {
							id : "fmap_node_" + S.id
						};
						var N = S.name || "路口";
						var J = L == 6 ? "#fff" : "#fffe84";
						if (R.hiddenMode) {
							E[S.id] = {
								title : N
							}
						} else {
							T.bindData.title = N
						}
						T.fillStyle = J;
						var aa = g("#" + T.bindData.id);
						if (aa[0]) {
							aa.remove()
						}
						var Q = L == 6 ? p : i;
						T._href = "/" + S.kind_name + "/" + S.id;
						T.fillRect(-Q / 2, -Q / 2, Q, Q);
						T.bindData = null;
						T._href = null;
						this.drawMetro(S, T);
						ab++;
						if (R.depth && ab > R.depth) {
							return
						}
						if (S.kind == 4 || S.kind == 5) {
							var Y, M, K, W = S.neighbors;
							for ( var V = 0; V < 4; V++) {
								Y = D[V];
								M = W[Y];
								if (M && M[1] > 1) {
									K = W[o[Y]];
									if (!K || K[1] < 2
											|| O[M[0]].name !== O[K[0]].name) {
										O[M[0]].is_not_av_halfway = true
									}
								}
							}
						}
						D.forEach(function(ae) {
							if (this[ae]) {
								var ad = this[ae][0];
								var af = R.markedLib[ad];
								var ac = O[ad].neighbors[ae];
								if (!af) {
									R.markedLib[ad] = 1;
									R.drawRoad(ae, O[ad], L, ac[1], ab)
								}
								T.translate.apply(T, C[ae]);
								R.drawNode(ac, ab);
								T.translate.apply(T, C[o[ae]])
							}
						}, S.neighbors)
					}
				},
				drawRoad : function(V, S, R, N, aa) {
					var J, P, O, L, Q = this, T = this.ctx;
					aa = aa || 0;
					P = S.kind < 2 ? p : i;
					if (R == 6) {
						L = p
					} else {
						L = i
					}
					if (N == 6) {
						O = p
					} else {
						O = i
					}
					switch (V) {
					case "N":
						J = [ -P / 2, -u + O / 2, P, u - (O + L) / 2 ];
						break;
					case "S":
						J = [ -P / 2, L / 2, P, u - (O + L) / 2 ];
						break;
					case "W":
						J = [ -u + O / 2, -P / 2, u - (O + L) / 2, P ];
						break;
					case "E":
						J = [ L / 2, -P / 2, u - (O + L) / 2, P ];
						break
					}
					var Z, Y, U = escape(S.name), X = h.strsize(S.name) * 8;
					T.save();
					T.textBaseline = "top";
					T.fillStyle = "#000";
					T.bindData = {
						id : "fmap_title_" + S.id
					};
					if (S.kind > 1) {
						if (!S.is_not_av_halfway) {
							if (!t[U]) {
								t[U] = 1;
								T.font = "16px sans-serif";
								if (S.kind % 2 === 0) {
									T._otherClass += "minimap-text-v";
									Z = -1;
									Y = u / 2 - X / 2
								} else {
									Z = u / 2 - X / 2;
									Y = -1
								}
								T.fillText(S.name, J[0] + Z, J[1] + Y, X)
							}
						} else {
							if (!F[U]) {
								F[U] = true
							}
						}
					} else {
						F[U] = true;
						T.save();
						if (S.kind % 2 === 0) {
							T._otherClass += "minimap-text-v";
							Z = -1;
							Y = u / 2 - X / 2
						} else {
							Z = u / 2 - X / 2;
							Y = -1
						}
						T.fillText(S.name, J[0] + Z, J[1] + Y, X)
					}
					T.restore();
					T.bindData = {
						id : "fmap_node_" + S.id
					};
					var M = S.name || "未知地点[" + S.id + "区]";
					var K = S.kind < 2 ? "#fff" : "#fffe84";
					if (Q.hiddenMode) {
						E[S.id] = {
							title : M,
							halfway : S.kind < 2 ? false : !S.is_not_av_halfway
						}
					} else {
						T.bindData.title = M
					}
					T.fillStyle = K;
					var W = g("#" + T.bindData.id);
					if (W[0]) {
						W.remove()
					}
					T._href = "/" + S.kind_name + "/" + S.id;
					T.fillRect.apply(T, J);
					T.bindData = null;
					T._href = null
				},
				drawMetro : function(K, J) {
					if (K.metro_name) {
						J.save();
						J.globalCompositeOperation = "source-over";
						J.bindData = {
							title : "地铁" + K.metro_name + "站"
						};
						J._otherClass = "";
						J.drawImage(this.metroIcon, -21 / 2, -21 / 2);
						J.restore()
					}
				},
				drawHots : function(Q) {
					var L = +new Date();
					if (q && L - m < 300000) {
						return
					}
					m = L;
					var O, K, M, J = u / 2, N = [];
					for ( var P in Q) {
						O = g("#fmap_node_" + P)[0];
						if (O) {
							K = O.offsetWidth < O.offsetHeight;
							M = J / Q[P].length;
							Q[P].forEach(function(R, S) {
								if (K) {
									R.top = O.offsetTop + u / 8 + M * S;
									R.left = O.offsetLeft - O.offsetWidth * 3
											/ 2 - w / 2
								} else {
									R.left = O.offsetLeft + u / 8 + M * S;
									R.top = O.offsetTop - O.offsetHeight - w
								}
								N.push(h.format(k, R))
							})
						}
					}
					if (q) {
						q.remove()
					}
					q = g(N.join("")).appendTo(this.detailLayer.map)
				},
				drawOverlaps : function(J) {
					if (!this.me) {
						this.me = g('<a class="overlap me" href="javascript:;" title="你当前的位置" style="display:block;"></a>')
					}
					this.me.appendTo(J);
					if (!this.tips) {
						this.tips = g('<span class="tips"><span></span><em><b></b></em></span>')
					}
					this.tips.appendTo(J);
					if (!this.home) {
						this.home = g('<a class="overlap hearthstone" href="javascript:;" title="你的公寓">公寓</a>')
					}
					this.home.appendTo(J);
					if (!this.areaZone) {
						this.areaZone = g(
								'<div class="area-zone"><span class="t1"></span><span class="t2"></span><span class="t3"></span></div>')
								.prependTo(this.detailLayer.map)
					}
				},
				setHome : function(L, K) {
					this.userInfo = L;
					if (L) {
						var J = g("#fmap_node_" + L.street, K.map)[0]
								|| g("#fmap_area_" + L.area_id, K.map)[0];
						this.home.attr("href", L.uri);
						if (J) {
							this.home.css(
									{
										left : J.offsetLeft + J.offsetWidth / 2
												+ p / 2 + 5,
										top : J.offsetTop + J.offsetHeight / 2
												+ p / 2 + 5
									}).show()
						} else {
							this.home.hide()
						}
					} else {
						this.home.hide()
					}
				},
				getPos : function(N, K) {
					K = K || this.detailLayer;
					var M = g("#fmap_node_" + N, K.map)[0]
							|| g("#fmap_area_" + N, K.map)[0];
					if (!M) {
						return false
					}
					var J = M.offsetLeft + M.offsetWidth / 2, L = M.offsetTop
							+ M.offsetHeight / 2;
					return [ J, L, g(M) ]
				},
				move : function(O, M) {
					var K = this, N = this.getPos(O);
					if (!N) {
						return
					}
					M = M || {};
					B.fire("fullmap:moveStart", [ O ]);
					var J = this.detailLayer.config;
					var L = this.detailLayer.locate(N[0] - J.width / 2, N[1]
							- J.height / 2, M.duration);
					if (!this.isHideMe) {
						K.me.css({
							left : N[0] - 8 + "px",
							top : N[1] - 24 + "px"
						}).show();
						if (!M.notips) {
							K.showTips(K.me)
						}
					}
					if (M.duration) {
						L.then(function() {
							B.fire("fullmap:moveEnd")
						})
					} else {
						B.fire("fullmap:moveEnd")
					}
					return B.promise("fullmap:moveEnd")
				},
				moveOverview : function() {
					var K = this.overviewLayer.config;
					var J = (this.lib[this.vision] || {});
					var L = this.getPos(J.area, this.overviewLayer);
					if (L) {
						this.overviewLayer.locate(L[0] - K.width / 2, L[1]
								- K.height / 2, 0);
						if (!this.isHideMe) {
							this.me.css({
								left : L[0] - 8 + "px",
								top : L[1] - 44 + "px"
							}).show()
						}
					} else {
						this.me.hide()
					}
				},
				showTips : function(K, J) {
					var N;
					if (typeof K === "object") {
						var M = K[0];
						N = [
								M.offsetLeft + M.offsetWidth / 2,
								J ? M.offsetTop + M.offsetHeight / 2
										: M.offsetTop, K ]
					} else {
						N = this.getPos(K)
					}
					var L = N[2].attr("title");
					if (!L) {
						return false
					}
					this.tips.find("span").html(
							h.substr(L.replace(/\(.*?\)/g, ""), 22)).end()
							.show().css({
								left : N[0] - this.tips.width() / 2,
								top : N[1] - 29
							})
				},
				showLoading : function() {
					this.loadingLayer.removeClass("disabled");
					A = +new Date()
				},
				hideLoading : function() {
					var J = +new Date() - A;
					if (J < 1400) {
						return setTimeout(function() {
							r.hideLoading()
						}, 1400 - J)
					}
					this.loadingLayer.addClass("disabled")
				},
				explore : function(L) {
					var J = E[L];
					if (J) {
						g("#fmap_node_" + L).removeClass("minimap-hidden");
						g("#fmap_title_" + L).removeClass("minimap-hidden");
						var K = escape(J.title);
						if (y && F[K] && !J.halfway) {
							delete F[K];
							B.fire("fullmap:explore", [ L, J.title ])
						}
					}
				},
				mark : function(O, L) {
					var K = this, N = this.getPos(O);
					if (!N) {
						return
					}
					var J = this.detailLayer.config, M = g(
							'<a class="overlap mark" href="javascript:;" style="display:block;"></a>')
							.appendTo(this.detailLayer.map).attr("title", L)
							.css("left", N[0] - 9);
					this.detailLayer.locate(N[0] - J.width / 2,
							N[1] - J.height / 2, 400).wait(
							function() {
								l.remove("mark:drop").animate("mark:drop", -23,
										N[1] - 23, 400, {
											easing : "easeInOutQuint",
											step : function(P) {
												M[0].style.top = P + "px"
											},
											callback : function() {
												l.remove("mark:drop");
												if (!K.overview_mode) {
													K.showTips(M);
													B.fire("fullmap:marked")
												}
											}
										})
							});
					return B.promise("fullmap:marked")
				},
				clearMark : function() {
					this.tips.hide();
					g(".overlap.mark", this.detailLayer.map).remove()
				},
				locateArea : function(O, N) {
					if (O == this.visionArea) {
						return
					}
					var M = this.arealib[O];
					if (!M) {
						return
					}
					var Q = this.getPos(M.center_cross);
					if (!Q) {
						return
					}
					N = N || {};
					this.visionArea = O;
					var K = this.detailLayer.config, L = this.detailLayer.viewport, J = Q[0]
							- K.width / 2, P = Q[1] - K.height / 2;
					this.areaZone.css({
						left : J + L.offsetWidth / 2 - v / 2 + "px",
						top : P + L.offsetHeight / 2 - v / 2 + "px"
					}).find("span").html(M.name);
					if (N.autocenter) {
						this.detailLayer.locate(J, P, 400)
					}
					if (N.is_focus) {
						B.fire("fullmap:focus", [ {
							area_center : M.center_cross,
							area_name : M.name,
							area_id : O
						} ])
					}
				},
				updateOverview : function() {
					if (!n) {
						return
					}
					this.drawOverlaps(this.sketchbox[0]);
					this.tips.hide();
					this.userInfo.area_id = (this.lib[this.userInfo.street] || {}).area;
					this.setHome(this.userInfo, this.overviewLayer);
					this.moveOverview()
				},
				updateMap : function(J) {
					if (!y) {
						return
					}
					this.drawOverlaps(this.detailLayer.map);
					this.setHome(this.userInfo, this.detailLayer);
					this.move(this.vision, J)
				},
				openOverview : function(J) {
					this.updateOverview();
					g(this.overviewLayer.viewport).removeClass("disabled");
					g(this.detailLayer.viewport).addClass("disabled");
					this.opened = true;
					this.overview_mode = true;
					B.fire("fullmap:focus", [ false, J ]);
					B.fire("fullmap:open")
				},
				open : function(L, N) {
					var K, M = {};
					if (!L) {
						L = {
							area_id : (this.lib[this.vision] || {}).area
						}
					}
					var J = this.arealib[L.area_id];
					if (J) {
						K = J.center_cross;
						M.duration = 0;
						L.area_center = K;
						L.area_name = J.name
					} else {
						L = null
					}
					this.updateMap(M);
					g(this.detailLayer.viewport).removeClass("disabled");
					g(this.overviewLayer.viewport).addClass("disabled");
					this.opened = true;
					this.overview_mode = false;
					if (K) {
						this.locateArea(L.area_id, {
							autocenter : true
						})
					}
					B.fire("fullmap:focus", [ L, N ]);
					B.fire("fullmap:open")
				},
				close : function() {
					g(this.overviewLayer.viewport).addClass("disabled");
					g(this.detailLayer.viewport).addClass("disabled");
					this.opened = false;
					B.fire("fullmap:close")
				}
			};
			function z(N, M) {
				var L = false, K = "";
				function J(P) {
					if (/domcanvas-sprite-/.test(P.target.className)) {
						if ((P.target.id || ".").indexOf(L || "-") === -1) {
							if (L) {
								document.getElementById("fmap_node_" + L).style.backgroundColor = K
							}
							L = (/\d+$/.exec(P.target.id) || [])[0];
							if (L) {
								var O = document.getElementById("fmap_node_"
										+ L);
								K = O.style.backgroundColor;
								O.style.backgroundColor = "#F9CF7F"
							}
						}
					} else {
						if (L) {
							document.getElementById("fmap_node_" + L).style.backgroundColor = K;
							L = ""
						}
					}
				}
				N.mousemove(J)
			}
			function G(R) {
				var P, L, K, T, M = c, J = v * 0.4, S = R[0], Q = R[1];
				for ( var O = 0, N = M.length; O < N; O++) {
					P = M[O].vertex;
					L = P[0][0] + J;
					K = P[1][1] - J;
					if (S > P[0][0] && S < P[2][0] && Q > P[3][1]
							&& Q < P[1][1]) {
						if (S < L && Q < K) {
							if ((P[0][1] - Q) / (S - P[0][0]) < 1) {
								T = M[O].id;
								break
							}
						} else {
							if (S < L && Q > K) {
								if ((Q - P[0][1]) / (S - P[0][0]) < 1) {
									T = M[O].id;
									break
								}
							} else {
								if (S > L && Q > K) {
									if ((Q - P[2][1]) / (P[2][0] - S) < 1) {
										T = M[O].id;
										break
									}
								} else {
									if (S > L && Q < K) {
										if ((P[2][1] - Q) / (P[2][0] - S) < 1) {
											T = M[O].id;
											break
										}
									}
								}
							}
						}
					}
				}
				if (T) {
					clearTimeout(H);
					H = setTimeout(function() {
						r.locateArea(T, {
							is_focus : true
						})
					}, 100)
				}
			}
			return r
		});