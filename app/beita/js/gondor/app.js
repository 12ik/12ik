define(
		"gondor/app",
		[ "mod/lang", "mod/url", "mod/key", "mod/cookie", "mod/browsers",
				"mod/mention", "gondor/model", "gondor/view",
				"gondor/observer", "gondor/share", "gondor/toolkit",
				"gondor/trace", "gondor:domain" ],
		function(T, az, ao, S, aS, ax, t, aB, P, aR, U, R, aH) {
			var M = [ "N", "S", "W", "E" ], ad = {
				N : "S",
				S : "N",
				W : "E",
				E : "W"
			}, ar = {
				N : "北",
				S : "南",
				W : "西",
				E : "东"
			}, ap = {}, h = {}, W = false, C, av = aB.town, k = aB.sound, g = aB.shop, J = aB.house, aD = aB.fullmap, m = aB.searchbar, o = aB.dashboard, y = aB.sidebar, aj = aB.guide, j = aB.widget, aC = aB.citizen, Y = aB.card, n = aB.growl, ak = aB.newbie, am = ao({
				trace : 10,
				traceStack : R.uiStack
			}), aK = ao({
				forTextarea : true
			}), s = az();
			s.route("default", function(aZ, aY) {
				if (e) {
					var aW = this, aX = arguments.callee;
					ay = function() {
						aX.call(aW, aZ, aY)
					};
					return
				}
				ay = null;
				if (aY) {
					I({
						r : 10
					})
				} else {
					l.goHome({
						disable_nav : true
					});
					if (aM) {
						return
					}
					P.when("fullmap:ready", "viewport:ready").then(function() {
						if (!aB.host.vision) {
							return P.wait("viewport:ready", arguments.callee)
						}
						var a0 = aB.getFullmapOpenOpt();
						a0.disable_nav = true;
						if (!l.userInfo.source_node || !a0.from) {
							delete a0.from
						} else {
							a0.from.is_lastnode = true
						}
						aD.openOverview(a0)
					})
				}
			}).route([ "/area/:aid/" ], function(aZ, aY) {
				if (e) {
					var aW = this, aX = arguments.callee;
					ay = function() {
						aX.call(aW, aZ, aY)
					};
					return
				}
				ay = null;
				l.goHome({
					disable_nav : true
				});
				if (aM) {
					return
				}
				P.when("fullmap:ready", "viewport:ready").then(function() {
					if (!aB.host.vision) {
						return P.wait("viewport:ready", arguments.callee)
					}
					var a0 = aB.getFullmapOpenOpt();
					a0.disable_nav = true;
					if (!l.userInfo.source_node || !a0.from) {
						delete a0.from
					} else {
						a0.from.is_lastnode = true
					}
					aD.open({
						area_id : aY
					}, a0)
				})
			}).route([ "/street/:nid/", "/avenue/:nid/", "/cross/:nid/" ],
					function(aY, aZ) {
						if (V) {
							if (e) {
								var aW = this, aX = arguments.callee;
								ay = function() {
									aX.call(aW, aY, aZ)
								};
								return
							}
							ay = null;
							l.teleport(aZ, {
								disable_nav : true,
								content_id : aY.cid
							})
						} else {
							l.visit(aZ, false, {
								content_id : aY.cid
							})
						}
					}).route([ "/home/:domain/", "/shop/:domain/" ],
					function(aZ, aY) {
						if (V) {
							if (e) {
								var aW = this, aX = arguments.callee;
								ay = function() {
									aX.call(aW, aZ, aY)
								};
								return
							}
							ay = null;
							l.teleport(aY, {
								is_place : true,
								disable_nav : true,
								content_id : aZ.cid
							})
						} else {
							l.visit(0, aY, {
								is_place : true,
								content_id : aZ.cid
							})
						}
					}).route(
					[ "/shop/:domain/room/:nid", "/home/:domain/room/:nid" ],
					function(aZ, aY, a0) {
						if (V) {
							if (e) {
								var aW = this, aX = arguments.callee;
								ay = function() {
									aX.call(aW, aZ, aY, a0)
								};
								return
							}
							ay = null;
							l.teleport(a0, {
								disable_nav : true,
								content_id : aZ.cid
							})
						} else {
							l.visit(0, a0, {
								content_id : aZ.cid
							})
						}
					});
			am.down([ "up", "w" ], function(aW) {
				ab("N", aW)
			}).down([ "down", "s" ], function(aW) {
				ab("S", aW)
			}).down([ "left", "a" ], function(aW) {
				ab("W", aW)
			}).down([ "right", "d" ], function(aW) {
				ab("E", aW)
			}).down("u", function(aW) {
				o.toggle()
			}).down("i", function(aW) {
				if (aB.host === av || aD.opened) {
					y.toggle()
				} else {
					aB.alert("室内是没有侧边栏的喔！")
				}
			}).down("m", function(aW) {
				aD.open(0)
			}).down("shift+m", function(aW) {
				aD.openOverview()
			}).down("up->up->down->down->left->right->left->right->b->a",
					function() {
						t("map:view").get({}, function(aX) {
							var aW = aX.nodes.filter(function(aZ) {
								return aZ.kind < 4
							});
							var aY = aW[Math.floor(Math.random() * aW.length)];
							P.fire("viewport:teleport", [ aY.id, {
								msg : "你被吸入时空裂隙..."
							} ])
						})
					});
			aK.down(function(aW) {
				if (ax._plugedSuggester !== aB.suggester) {
					ax.plugin(aB.suggester)
				}
				ax.keydownHandler(aW);
				return true
			});
			aK.up(function(aW) {
				if (ax._plugedSuggester !== aB.suggester) {
					ax.plugin(aB.suggester)
				}
				ax.keyupHandler(aW);
				return true
			});
			var aT = {
				"1" : {
					name : "encounter:dou",
					age : 0,
					after : function(aW) {
						if (aE || Math.random() * 10 > 7) {
							if (!aE) {
								U.getRequest("/accounts/show_dou")
							}
							aE = true;
							P.wait("dou:show", function() {
								clearTimeout(E);
								E = setTimeout(function() {
									aE = false
								}, 5000)
							});
							aB.showDou(aW)
						}
					}
				},
				"2" : {
					name : "server:notice",
					title : "通知",
					age : -1,
					onclick : function(aW) {
						aB.dialog.set({
							isHideClose : true,
							isHideTitle : false,
							title : aW.title,
							iframeURL : aW.url,
							width : 500,
							buttons : []
						}).open();
						P.wait("dialog:close", function() {
							aB.dialog.set({
								isHideClose : false
							})
						})
					}
				},
				"12" : {
					name : "server:tips",
					age : 0,
					after : function(aW) {
						if (aB.host !== av && aw && aP !== 2) {
							if (!aP) {
								aP = 1;
								P.wait("walk:start", function() {
									aP = 2
								})
							}
							return false
						}
						var aX = aA[aW.tip];
						if (aX) {
							if (ak.isUnreadTip(aW.tip)) {
								P.wait("fullmap:ready", function() {
									aX(aW);
									ak.markAsShowed(aW.tip)
								})
							}
						}
					}
				},
				"5" : {
					name : "encounter:shop-expire",
					age : 0,
					after : function(aW) {
						g.expireAlert(aW.left_time)
					}
				},
				"6" : {
					name : "badge:achieve",
					age : -1,
					corner : "center",
					effect : "slideTopRight",
					customStyle : true,
					hasButton : true,
					title : "恭喜你！",
					before : function(aW, aX) {
						if (aO) {
							return false
						}
						if (!aX.n_dou) {
							aX.without_dou = " without-dou"
						}
					},
					onclick : function(aW) {
						t("badge:readed").get({
							bid : aW.id
						});
						P.wait("growl:slideover", function() {
							aB.showMyCard(l.userInfo.id)
						})
					}
				},
				"7" : {
					name : "encounter:activity",
					age : 0,
					after : function(aW) {
						if (aD.opened || aM) {
							return
						}
						if (aB.host.zooming) {
							P.wait("place:zoom-ready", function() {
								aB.showActivityAlert(aW.activity_info)
							})
						} else {
							aB.showActivityAlert(aW.activity_info)
						}
					}
				},
				"8" : {
					name : "server:notice",
					title : "通知",
					age : -1,
					onclick : function(aW) {
						switch (aW.action) {
						case "place:checkincome":
							t(aW.action).get({
								pid : aW.pid
							});
							g.showAdmin(aW.pid, "wallet");
							break;
						case "node:checkincome":
							t(aW.action).get({
								nid : aW.nid
							});
							break;
						case "citizen:checkincome":
							t(aW.action).get({
								uid : l.userInfo.id
							});
							aB.showWallet();
							break;
						default:
						}
					}
				},
				"10" : {
					name : "server:sns-sync-error",
					age : 0,
					after : function(aW) {
						aB.alertSNSError(aW)
					}
				},
				"11" : {
					name : "view:content",
					age : 0,
					after : function(aW) {
						if (aM) {
							return
						}
						if (!aW.r) {
							if (aB.host === av) {
								av.openSounds();
								P.wait("soundDetail:ready", function() {
									aj.showContent(aW)
								})
							} else {
								aj.showContent(aW)
							}
						} else {
							aB.alert(aW.msg)
						}
					}
				},
				"13" : {
					name : "activty:show",
					age : 0,
					after : function(aW) {
						if (!aW.available && aW.content_url) {
							aW.activity_info.domain = aH;
							aB.alertArchivedActivity({
								activity_info : aW.activity_info,
								content_url : aW.content_url
							})
						}
					}
				}
			};
			var aA = {
				tip_open_shop : ae,
				tip_settle_apartment : ae,
				tip_navigate_street : ae,
				tip_navigate_shop : ae,
				tip_overview_map : function(aX) {
					if (aD.opened && aD.overview_mode) {
						ak.show(aX.tip, aX.tpl)
					} else {
						var aW = function() {
							if (aD.overview_mode) {
								ak.show(aX.tip, aX.tpl);
								P.unbind("fullmap:open", aW)
							}
						};
						P.bind("fullmap:open", aW)
					}
				},
				tip_detail_map : function(aX) {
					if (aD.opened && !aD.overview_mode) {
						ak.show(aX.tip, aX.tpl)
					} else {
						var aW = function() {
							if (!aD.overview_mode) {
								ak.show(aX.tip, aX.tpl);
								P.unbind("fullmap:open", aW)
							}
						};
						P.bind("fullmap:open", aW)
					}
				}
			};
			var z = {
				citizen : {
					model : "citizen:cardinfo",
					prep : function(aW) {
						aW.isSelf = aW.id == l.userInfo.id
					}
				},
				node : {
					model : "card:info"
				},
				place : {
					model : "card:info"
				},
				area : {
					model : "card:info"
				}
			};
			var p = {
				snow : function(aW) {
					require([ "gondor/view/snow" ], aW)
				}
			};
			P.bind("app:init", function(aY, a1, a2) {
				V = true;
				var a3 = l.env();
				if (a3.nonsupport) {
					c(a3);
					if (aB.host === av) {
						aU("W")
					}
				} else {
					if (a3.lowsupport) {
						var aX = {
							name : "server:notice",
							title : "提示",
							age : -1,
							msg : "升级浏览器可获得更好的体验",
							id : 99099099,
							onclick : function(a6) {
								aB.showPlatformTips(a3, a6)
							}
						};
						P.wait("viewport:ready", function() {
							n.send(aX.name, aX.msg, aX)
						})
					}
				}
				var a4 = Q || [], aW = a2 || [], a0 = S("rctm");
				S("rctm", 0, {
					expires : -1
				});
				a4.unshift(a0);
				U.getRequest("/log/jsperf", {
					topics : [ "init-html", "init-jscombo", "init-mods",
							"api-view", "api-info" ].join("~_~"),
					costs : [ a4[0] && (a4[1] - a4[0]) || 0, a4[2] - a4[1],
							a4[3] - a4[2], aW[0] - a4[3], aW[1] - a4[3] ]
							.join("~_~")
				});
				if (!aS.msie || aS.msie > 8) {
					var a5 = function() {
						if (aB.weather.lock) {
							aB.weather.lock()
						}
					};
					var aZ = function() {
						if (aB.weather.unlock) {
							aB.weather.unlock()
						}
					};
					aB.weather = {};
					P.bind("viewport:ready", function(a9) {
						if (aB.host !== av) {
							return
						}
						var a6 = av.info(av.vision);
						if (!a6) {
							return
						}
						var a8 = parseInt(a6.weather_level, 10);
						if (a8 && a6.weather_type === aB.weather.kind) {
							if (aB.weather.change) {
								aB.weather.change(a8)
							}
						} else {
							if (aB.weather.change) {
								aB.weather.change(0)
							}
							aB.weather = {};
							var a7 = p[a6.weather_type];
							if (a7) {
								a7(function(ba) {
									aB.weather = ba;
									ba.change(a8)
								})
							}
						}
					});
					P.bind("place:enable", a5);
					P.bind("fullmap:open", a5);
					P.bind("place:exit", aZ);
					P.bind("fullmap:close", aZ)
				}
			});
			P.bind("walk:start", function(aW) {
				ag = true;
				clearTimeout(w);
				if (!W) {
					l.disableControl();
					P.wait("viewport:ready", l.enableControl)
				}
				k.clear();
				aB.clearItems();
				j.inactivate();
				if (aj.autonav) {
					aj.hide()
				}
			});
			P.bind("walk:end", function(aY, aW) {
				if (aB.host === av) {
					var aX = aY.toString().split(",");
					if (!W && s.nav("1") != aX[0]) {
						s.nav({
							"0" : aW < 2 && "street" || aW < 4 && "avenue"
									|| aW < 7 && "cross",
							"1" : aX[0],
							"2" : false,
							cid : false
						}, {
							route : false
						})
					}
					af(aX[0], {
						step : aX[1]
					})
				} else {
					s.nav({
						"2" : "room",
						"3" : aY,
						cid : false
					}, {
						route : false
					});
					af(aY)
				}
			});
			P.bind("viewport:resize", function() {
				if (!aB.host.vision) {
					return
				}
				av.needReset = true;
				aB.host.reset()
			});
			P.bind("viewport:update", function(aW) {
				l.updateInfo(aB.host.vision).then(function() {
					t("node:view").update(false, aW)
				})
			});
			P.bind("viewport:beforereset", function(aW) {
				H = 0;
				j.reset();
				k.clear();
				aB.clearItems();
				ak.clear();
				av.resetFolder()
			});
			P.bind("viewport:reset", function(aW) {
				aa = false;
				l.visit(aW)
			});
			P.bind("viewport:ready", function(aY, aW) {
				var aX = aB.host.info(aY);
				if (!aX) {
					return
				}
				if (!W) {
					if (!aD.opened) {
						aB.updateMapNav(aX.breadcrumb)
					}
					ac(aY);
					if (aB.host !== av) {
						j.load(aY)
					} else {
						if (!aW) {
							a(x)
						}
					}
					l.updateInfo(aY);
					if (!A) {
						an(aX)
					}
				}
				if (aB.host === av && ag) {
					aD.vision = parseInt(aY, 10)
				}
			});
			P.bind("viewport:teleport", function(aX, aW) {
				if (!aX) {
					if (!l.userInfo.house) {
						aB.alert("你还没有入住阿尔法城")
					} else {
						aB.alert("要立即回家吗？", function() {
							l.teleport(l.userInfo.home_place_id, {
								is_place : true
							})
						})
					}
				} else {
					l.teleport(aX, aW)
				}
			});
			P.bind("viewport:polling", function(aY) {
				var aW = aY.user.id, aZ = parseInt(aY.nid, 10);
				if (aZ != parseInt(aB.host.vision, 10)) {
					return
				}
				B(aY);
				var aX = 0;
				aO = false;
				aY.event.forEach(function(a1) {
					var a0 = Object.create(aT[a1.type] || null);
					if (a0.name === "server:notice") {
						if (++aX > 2) {
							return
						}
					} else {
						if (a1.type == 12) {
							aO = true
						}
					}
					if (a0.name) {
						if (a0.before && a0.before(a0, a1) === false) {
							return
						}
						a0.nid = aY.nid;
						n.send(a0.name, a0.msg, T.mix(a0, a1))
					}
				});
				aB.sonorus.updateNum(l.userInfo.n_notification);
				aB.updateMail(l.userInfo.n_private_msg);
				aB.updateBookmark(l.userInfo.n_updated_collected);
				al(aY)
			});
			P.bind("app:userinfo-ready", function(aW) {
				aF = +new Date();
				aB.initDashboard(aW);
				aB.newbie.config({
					unread_tips : l.syncDB.unread_tips
				})
			});
			P.wait("app:preloaded", function() {
				aB.changeProcess({
					msg : "阿尔法城：正在粉刷第"
							+ (3000 + Math.floor(Math.random() * 1000))
							+ "家小店..."
				})
			});
			P.bind("app:track", function(aW, aX) {
				U.getRequest("/log/product_usage", T.mix({
					subjects : aW.join("~_~")
				}, aX || {}))
			});
			P.bind("app:query from widget", O);
			P.bind("app:loading start", function() {
				e = true;
				aq()
			});
			P.bind("app:loading end", function() {
				e = false;
				ai();
				if (ay) {
					ay();
					ay = null
				}
			});
			P.bind("card:info", function() {
				d.apply(this, arguments)
			});
			P.bind("citizen:myinfo", function(aX, aW) {
				d(l.userInfo.id, "citizen", aX, aW)
			});
			P.bind("citizen:update", function(aX) {
				var aW = aX.callback;
				delete aX.callback;
				t("citizen:update").get(aX, aW)
			});
			P.bind("citizen:pick", function(aY, aW, aX) {
				aE = false;
				t("citizen:pick").get({
					para : aW
				}, function(aZ) {
					if (!aZ.r) {
						if (aX) {
							setTimeout(function() {
								aB.dialog.set({
									isHideTitle : false,
									title : "捡到阿圆！",
									iframeURL : aX,
									width : 400,
									buttons : []
								}).open()
							}, 1000)
						}
					} else {
						aB.alert(aZ.msg)
					}
				})
			});
			P.bind("citizen:telecontrol", function() {
				aB.dialog.loading();
				t("citizen:shops").get({
					uid : l.userInfo.id
				}, function(aW) {
					aC.telecontrol(aW)
				})
			});
			P.bind("bookmarks:list", function(aW) {
				require([ "gondor/view/cardbox" ], function(aX) {
					aB.showBookmark(l.userInfo.id)
				})
			});
			P.bind("cardbox:list", function(aW) {
				require([ "gondor/view/cardbox" ], function(aY) {
					var aX;
					if (!aY.opened) {
						aY.open()
					}
					aX = aY.limit;
					t("citizen:cardbox").get({
						action : "get",
						uid : l.userInfo.id,
						start : aW || 0,
						limit : aX
					}, function(aZ) {
						aY.render(aZ.collect_list)
					})
				})
			});
			P.bind("citizen:like", function(aW, aY, aX) {
				require([ "gondor/view/cardbox" ], function(aZ) {
					if (aX === "fromCardbox") {
						aZ.showLoading()
					}
					t("citizen:like").get({
						uid : aW,
						op : aY
					}, function(a0) {
						if (aX !== "fromCardbox") {
							if (!a0.r) {
								d(aW, "citizen")
							} else {
								Y.hideCard();
								aB.alert(a0.msg)
							}
						} else {
							aZ.refreshPage()
						}
					})
				})
			});
			P.bind("sonorus:list", function(aW) {
				aB.sonorus.unfold();
				aW.userId = l.userInfo.id;
				t("citizen:sonorus").get(aW, function(aX) {
					aB.sonorus.update(aX)
				})
			});
			P.bind("sonorus:read", function(aW) {
				t("sonorus:read").get({
					noti_id : aW
				});
				l.userInfo.n_notification -= 1;
				aB.sonorus.updateNum(l.userInfo.n_notification)
			});
			P.bind("place:enter", function(aX, aW) {
				aB.showLoading({
					msg : "进入" + (aX === "home" && "公寓" || "小店") + "..."
				});
				s.nav({
					"0" : aX || "place",
					"1" : aW.place_domain,
					"2" : aW.room_id ? "room" : false,
					"3" : aW.room_id || false,
					cid : false
				}, {
					route : false
				});
				af(aW.room_id || aW.id)
			});
			P.bind("place:enable", function(aW) {
				clearTimeout(w);
				k.clear();
				aB.clearItems();
				aB.changeHost(aW);
				if (!aD.opened) {
					y.hide();
					o.disable()
				}
				av.disable();
				if (aj.autonav) {
					aj.hide()
				}
			});
			P.bind("place:zoom-ready", function() {
				aB.hideLoading()
			});
			P.bind("place:exit", function(aW) {
				var aY = aB.host.placeType;
				aB.changeHost(av);
				o.enable();
				y.show();
				var aZ = aB.host.vision.toString().split(",");
				var aX = av.info(av.vision).kind;
				if (!aW || !aW.disableHistory) {
					s.nav({
						"0" : aX < 2 && "street" || aX < 4 && "avenue"
								|| aX < 7 && "cross",
						"1" : aZ[0],
						"2" : false,
						cid : false
					}, {
						route : false
					})
				}
				af(aZ[0], {
					step : aZ[1]
				})
			});
			P.bind("place:disable", function() {
				av.enable()
			});
			P.bind("place:theme", function(aW, aY, aX) {
				aX.pid = aW;
				aB.showLoading();
				t("place:theme").get(aX, function(aZ) {
					if (aZ.r) {
						aB.hideLoading();
						aB.alert(aZ.msg)
					} else {
						P.fire("viewport:update", [ function() {
							av.reset().then(function() {
								av.moveToPlace(aY);
								aB.hideLoading()
							})
						} ])
					}
				})
			});
			P.bind("place:bookmark", function(aW, aX) {
				t("place:collect").get({
					pid : aW,
					op : aX
				}, function(aZ) {
					if (!aZ.r) {
						var aY = aX === "add";
						if (aY) {
							l.syncDB.shop_collection[aW] = true
						} else {
							delete l.syncDB.shop_collection[aW]
						}
						aB.host.updatePlaceInfo({
							collected : aY,
							collect_num : aZ.n_collect
						})
					} else {
						aB.alert(aZ.msg)
					}
				})
			});
			P.bind("houseDetail:open", function(aW, aX) {
				t("node:list").get(
						{
							nid : aW,
							rid : parseInt(av.vision, 10),
							page : aX,
							userId : l.userInfo.id,
							userHouse : l.userInfo.house,
							isNodeAdmin : l.userInfo.adminLib["node-"
									+ parseInt(av.vision, 10)]
						}, function(aY) {
							if (J.houseEnabled == aW) {
								J.renderDoors(aY)
							}
						})
			});
			P.bind("house:op", function(aX, aZ, aW, aY) {
				aB.dialog.set(
						{
							isHideTitle : false,
							title : "提示",
							iframeURL : "/api/node/" + aX + "/resident_op?op="
									+ aZ + "&sub_op=check&needauth=1",
							width : 400,
							buttons : []
						}).open();
				P.wait("dialog:close", function(a1) {
					setTimeout(function() {
						P.cancel("aprt:op", a0)
					}, 0)
				});
				P.wait("aprt:op", a0);
				function a0() {
					aB.showLoading();
					t("house:op").get({
						nid : aX,
						op : aZ
					}, function(a1) {
						if (!a1.r) {
							if (aW) {
								l.updateInfo().wait(function() {
									aB.updateDashboard(l.userInfo);
									aB.hideLoading();
									P.fire("houseDetail:open", [ aW, aY ])
								})
							} else {
								if (aZ === "renew") {
									P.fire("viewport:update", [ function() {
										aB.host.reset().then(function() {
											aB.hideLoading()
										})
									} ])
								}
							}
						} else {
							aB.hideLoading();
							aB.alert(a1.msg)
						}
					})
				}
			});
			P.bind("folderWindow:open", function() {
				aq();
				P.bind("viewport:ready", v)
			});
			P.bind("folderWindow:close", function() {
				ai();
				v()
			});
			P.bind("dialog:open", function() {
				aB._dialog_enabled = true;
				l.disableControl()
			});
			P.bind("dialog:close", function() {
				aB._dialog_enabled = false;
				l.enableControl()
			});
			P.bind("shop:admin", function() {
				aB.showLoading({
					msg : "正在更新视图..."
				});
				var aW = aB.host.vision;
				W = true;
				aB.host.exit({
					disableHistory : true
				});
				P.wait("place:disable", function() {
					q(aW, {
						update : true
					})
				})
			});
			P.bind("node:admin", L);
			P.bind("widget:admin", L);
			P.bind("road:admin", L);
			P.bind("app:logout", function() {
				aL = true;
				aB.showLoginbox()
			});
			P.bind("shop:bid", function() {
				aB.changeMode()
			});
			P.bind("citizen:submit-disabled", function(aW) {
				aB.hideLoading();
				if (aW === "user_is_anon") {
					aB.alertAnonuserPost()
				} else {
					if (aW === "user_is_stranger") {
						aB.alert("只有本街居民才能发言")
					} else {
						aB.alert("你没有发言的权限")
					}
				}
			});
			P.bind("fullmap:loaded", function(aW) {
				aB.changeProcess({
					msg : "阿尔法城：正在为"
							+ aW.areas[Math.floor(Math.random()
									* aW.areas.length)].name + "绘制高清电子地图..."
				});
				P.bind("app:init", function(a0, aY) {
					var aZ;
					if (l.userInfo.id) {
						aZ = l.syncDB.visited;
						if (aZ && aZ != "0") {
							aZ.forEach(function(a1) {
								h[a1] = 1
							})
						}
					}
					function aX(a1) {
						if (aZ == "0") {
							return P.unbind("viewport:ready", aX)
						}
						a1 = parseFloat(a1);
						if (!h[a1]) {
							h[a1] = 1;
							aD.explore(a1)
						}
					}
					P.bind("viewport:ready", aX);
					aB.setupFullmap({
						data : aW,
						userInfo : l.userInfo,
						visited : aZ != "0" && aZ
					});
					aD.drawOverview();
					aD.drawMap(parseFloat(aY))
				})
			});
			P.bind("fullmap:focus", function(a2, aX) {
				if (!aX) {
					aX = aB.getFullmapOpenOpt()
				}
				var a1 = [ {} ];
				var a0 = aB.host.info(aB.host.vision);
				var aY = location.href;
				if (a2) {
					a2.kind_name = "area";
					a1.push(a2)
				}
				if (!aX.disable_nav) {
					if (a2) {
						s.nav({
							"0" : "area",
							"1" : a2.area_id,
							"2" : false,
							cid : false
						}, {
							route : false
						})
					} else {
						s.nav({
							"0" : false,
							cid : false
						}, {
							route : false
						})
					}
				}
				aB.updateMapNav(a1, {
					from : ag && aX.from
				});
				if (aB.host === av && !A) {
					y.saveLocal()
				}
				y.clearHead();
				y.clearContent();
				var aW = aD.overview_mode;
				var a3 = a2 && a2.area_id;
				var aZ = {
					area_id : a3 || ""
				};
				if (ah.mapInfoModel) {
					t("map:info").put(aZ, ah.mapInfoModel)
				}
				t("map:info").get(
						aZ,
						function(a4) {
							if (ah.mapInfoModel) {
								t("map:info").update(aZ);
								delete ah.mapInfoModel
							}
							if (!aD.opened || aD.overview_mode !== aW || a3
									&& aD.visionArea != a3) {
								return
							}
							y.updateLocalInfo({
								userInfo : l.userInfo,
								focus : a4.info
							});
							y.updateLocalList(a4);
							aD.drawHots(a4.hot)
						})
			});
			P.bind("fullmap:open", function() {
				if (aB._dialog_enabled) {
					aB.dialog.close()
				}
				if (aB.host !== av) {
					aB.host.disable()
				}
				o.enable();
				y.show();
				av.disable();
				l.disableMove();
				A = true
			});
			P.bind("fullmap:close", function() {
				aD.hideLoading();
				if (!aj.autonav) {
					aj.finish()
				}
				if (aB.host !== av) {
					aB.host.enable()
				}
				var aW = aB.host.info(aB.host.vision);
				if (aW) {
					aB.updateMapNav(aW.breadcrumb)
				}
				if (aB.host !== av) {
					y.hide();
					o.disable()
				} else {
					av.enable();
					y.restoreLocal()
				}
				l.enableMove();
				A = false
			});
			P.bind("fullmap:return", function(aW) {
				aD.close();
				if (aB.host === av) {
					s.nav({
						"0" : aW.kind < 2 && "street" || aW.kind < 4
								&& "avenue" || aW.kind < 7 && "cross",
						"1" : aW.id,
						"2" : false,
						cid : false
					}, {
						route : false
					})
				} else {
					if (aW.place_kind == 12) {
						s.nav({
							"0" : "home",
							"1" : aW.place_domain,
							"2" : false,
							cid : false
						}, {
							route : false
						})
					} else {
						s.nav({
							"0" : aW.place_kind == 10 && "shop"
									|| aW.place_kind == 11 && "home",
							"1" : aW.place_domain,
							"2" : "room",
							"3" : aW.id,
							cid : false
						}, {
							route : false
						})
					}
				}
			});
			P.bind("dashboard:search", function(aX, aW) {
				t("node:search").get({
					query : aX,
					start : 0,
					limit : 20
				}, function(aZ) {
					if (aW) {
						m.showSearchList(aZ.lists, aW)
					} else {
						var aY = (aZ.lists.place || [ {} ])[0], a0 = aY.name;
						P.fire("node:guide", [ aY.id, a0 ]);
						m.clearInput()
					}
				})
			});
			P.bind("dashboard:enable", function() {
				aB.placelayer.updateSize()
			});
			P.bind("dashboard:toggle", function() {
				aB.resize()
			});
			P.bind("sidebar:toggle", function() {
				aB.resize()
			});
			P.bind("guide:content", function(aW) {
				j.nav(aW)
			});
			P.bind("node:guide", F);
			P.bind("badge:info", function(aW) {
				t("badge:info").get({
					bid : aW
				}, function(aY) {
					var aX = Object.create(aT[6]);
					aX.onclick = null;
					aX.name = "badge:info";
					aX.isReplace = true;
					aY.id = "badgeInfo";
					aY.effect = "fadeFocus";
					n.send(aX.name, "", T.mix(aX, aY))
				})
			});
			P.bind("activity:poster", function(aW, aY, aX) {
				aB.activityPosterDlg.loading();
				t("activity:poster").get({
					pid : aW,
					wid : aY,
					aid : aX
				}, function(aZ) {
					aZ.is_dialog = true;
					aB.showActivityPoster(aZ)
				})
			});
			P.bind("activity:follow", function(aW, aZ, aY, aX) {
				aB.showLoading();
				t("activity:follow").get({
					pid : aW,
					wid : aZ,
					aid : aY
				}, function(a0) {
					aB.hideLoading();
					if (a0.r) {
						aB.alert(a0.msg)
					} else {
						if (aX) {
							aX()
						}
					}
				})
			});
			P.bind("share:site", function(aW) {
				aR.toSite(aW)
			});
			P.bind("joke:pick", function(aZ, aW, aY) {
				var aX = l.userInfo.jokeLuck--
						&& Math.floor(Math.random() * 100) === 7 && 1 || "";
				if (aX) {
					aB.showLuckNum(aW, aY)
				}
				t("joke:pick").get({
					nid : aZ,
					bingo : aX
				}, function(a0) {
					if (a0.r) {
						aB.alert(a0.msg)
					}
				})
			});
			P.bind("stamina:chicken", function() {
				if (x) {
					x.chicken(600)
				}
			});
			P.bind("newbie:done", function(aW, aX) {
				ak.markAsRead(aW, aX)
			});
			P.bind("suggester:query", function(aW, aY, aX) {
				t(aW).get(aY, aX)
			});
			var aQ, V, aa, aL, aw, i, A, e, ay, aN = 0, ag, aM, w = 0, aI = 0, X = 0, D = 0, at = {}, H = 0, aV, f, ah = {}, aJ, au = true, N, aP, aO, aE, E = 0, Q = [], r, aG, aF, x, G, u = 0, Z;
			var l = {
				setup : function(aY) {
					var aW = this;
					if (az.SUPPORT_PUSHSTATE) {
						ah.viewModel = aY.viewModel;
						ah.mapInfoModel = aY.mapInfoModel
					}
					ah.infoModel = aY.infoModel;
					ah.mapViewModel = aY.mapViewModel;
					Q = aY.perfData;
					P.wait("viewport:ready", function() {
						if (ah.mapViewModel) {
							t("map:view").put({}, ah.mapViewModel)
						}
						t("map:view").get({}, function(aZ) {
							P.resolve("fullmap:loaded", [ aZ ])
						});
						if (aY.css) {
							aY.css.forEach(function(aZ) {
								this.getStyle(aZ)
							}, U)
						}
					});
					aB.init(aY);
					l.disableControl();
					aB.changeProcess({
						msg : "阿尔法城：正在规划最优的十字路口布局..."
					});
					var aX = l.env();
					if (aX.nonsupport) {
						aM = aX
					}
					s.listen();
					this.syncDate = 0;
					l.updateInfo();
					return P.when("app:init", "fullmap:ready").then(function() {
						l.enableControl()
					})
				},
				env : function() {
					var aW = Object.create(aS);
					aW.nonsupport = aW.msie && aW.msie < 8;
					aW.lowsupport = !aW.nonsupport && (aW.msie || aW.mozilla)
							&& parseInt(aW.version, 10) < 9;
					return aW
				},
				show : function() {
					aB.show()
				},
				notify : function(aW) {
					return P.promise(aW)
				},
				disableMove : function() {
					au = false
				},
				enableMove : function() {
					au = true
				},
				enableKey : ai,
				disableKey : aq,
				disableControl : function(aW) {
					aq();
					aB.disableControl()
				},
				enableControl : function(aW) {
					ai();
					aB.enableControl()
				},
				walk : function(aW) {
					aB.host.move(aW);
					return P.promise("viewport:ready")
				},
				teleport : function(aX, aW) {
					aW = aW || {};
					if (aB._dialog_enabled) {
						P.unbind("app:query from widget", O);
						P.wait("dialog:close", function() {
							P.bind("app:query from widget", O)
						});
						aB.dialog.close()
					}
					if (!aW.msg) {
						aW.msg = "正在前往..."
					}
					if (!aW.className) {
						aW.className = "loading-teleport"
					}
					aB.showProcess(aW);
					if (aD.opened) {
						aD.close()
					}
					if (aB.host !== av) {
						W = true;
						aB.host.exit({
							disableHistory : true
						});
						P.wait("place:disable", function() {
							q(aX, aW)
						})
					} else {
						q(aX, aW)
					}
				},
				updateInfo : function(a3) {
					var a1 = aB.host, aX = !a3 && !aa, aY = V && +new Date()
							|| "";
					aI = aY;
					a3 = a3 || a1.vision || 0;
					var a0 = !aX && a1.info(a3) || {};
					var aW = true;
					if (a0.id && a0.kind < 4) {
						aW = parseFloat(a3) !== aV
					}
					if (aW) {
						y.clearContent();
						aV = null
					}
					var aZ = {
						nid : parseInt(a3, 10),
						place_id : a0.place_id,
						widget_id : a0.widget_id,
						content_id : encodeURIComponent(!aX && s.nav("cid")
								|| ""),
						need_sync : aX,
						need_local : aW || "",
						is_walk : !aX && ag,
						nav : aj.autonav || "",
						date : aY
					};
					if (ah.infoModel) {
						t("node:info").put(aZ, ah.infoModel)
					}
					clearTimeout(w);
					w = setTimeout(function() {
						t("node:info").get(aZ, a2)
					}, aX ? 0 : 100);
					function a2(a4) {
						if (ah.infoModel) {
							t("node:info").update(aZ);
							delete ah.infoModel
						}
						if (aX) {
							l.syncDate = aY;
							l.syncDB = a4.sync
						}
						if (!l.userInfo) {
							if (!a4.user.id) {
								if (!aw) {
									var a5 = s.nav("0");
									if (a5 === "shop" || a5 === "home") {
										return K()
									}
								}
								if (!aL && !aM) {
									aL = true;
									aB.showLoginbox();
									U.trackRefuseUser(2, aS.browser + "/"
											+ aS.version)
								}
							}
							a4.user.ck = S("gck");
							l.userInfo = a4.user;
							i = window._uid_ = a4.user.id;
							if (a4.user.source_node) {
								ag = true
							}
							P.resolve("app:userinfo-ready", [ a4.user ])
						} else {
							T.occupy(l.userInfo, a4.user)
						}
						if (a3) {
							if (aY < aI || a1 !== aB.host || a1.vision
									&& a3 != a1.vision || !a1.info(a3)) {
								return
							}
							a4.nid = a3;
							P.fire("viewport:polling", [ a4 ])
						}
					}
					return P.promise("viewport:polling")
				},
				trace : function(a1, aZ) {
					var aY = this, a0 = a1.pop();
					if (!a0) {
						return
					}
					var aX;
					var aW = a0[1] == 10 && g || a0[1] == 11 && J;
					if (aW !== J) {
						aX = a0[2]
					}
					av.moveToPlace(a0[0], function(a4) {
						aW.enable();
						P.fire("place:enable", [ aW ]);
						var a3 = a1.pop() || [];
						var a2;
						if (!aX) {
							aX = a3[2];
							a2 = a3[0];
							a3 = a1.pop() || []
						}
						W = false;
						if (!aZ || !aZ.disable_nav) {
							s.nav({
								"0" : aW.placeType || "place",
								"1" : aX,
								"2" : a3[0] ? "room" : false,
								"3" : a3[0] || false,
								cid : aZ.content_id || false
							}, {
								route : false
							})
						}
						af(a3[0] || a2 || a4)
					})
				},
				visit : function(a3, aX, aZ) {
					aZ = aZ || {};
					var a1 = aB.host, a2 = a3.toString().split(",")[0], aY = a1
							.info(a3);
					var aW = +new Date();
					X = aW;
					if (aY) {
						b(a3, aY.kind)
					} else {
						if (l.userInfo) {
							var a0 = {
								nid : a2,
								dest : !aZ.is_place && aX || "",
								pdest : aZ.is_place && aX || "",
								content_id : aZ.content_id || "",
								home : aZ.reset_home,
								mode : aB.layerModeCode,
								syncDB : l.syncDB,
								userInfo : l.userInfo
							};
							if (ah.viewModel) {
								t("node:view").put(a0, ah.viewModel)
							}
							t("node:view")
									.get(
											a0,
											function(a6) {
												if (ah.viewModel) {
													t("node:view").update(a0);
													delete ah.viewModel
												}
												if (a6.r) {
													I(a6);
													return
												}
												var a5, a4 = !aa
														&& a6.focus.kind < 4;
												if (parseFloat(a3) === 0) {
													a5 = a3 = a6.focus.id
															+ (a4 ? ",1" : "")
												} else {
													if (a4) {
														a3 = a2 + ",1"
													}
													a5 = a3 == a2 ? a6.focus.id
															: a3
												}
												if (aW < X || a1.vision
														&& a5 != a1.vision
														|| a1.info(a5)) {
													return
												}
												if (a6.waypoint.length) {
													W = true;
													P
															.wait(
																	"viewport:ready",
																	function() {
																		l
																				.trace(
																						a6.waypoint,
																						aZ)
																	})
												} else {
													if (parseFloat(a2) === 0) {
														if (!aZ.disable_nav) {
															s
																	.nav(
																			{
																				"0" : a6.focus.kind < 2
																						&& "street"
																						|| a6.focus.kind < 4
																						&& "avenue"
																						|| a6.focus.kind < 7
																						&& "cross",
																				"1" : a6.focus.id,
																				"2" : false,
																				cid : aZ.content_id || false
																			},
																			{
																				route : false
																			})
														}
														W = false
													}
												}
												a1.render(a5, a6);
												a1.info(a5).localMeta = a6.focus;
												a1.info(a5).breadcrumb = a6.breadcrumb;
												b(a5, a6.focus.kind);
												if (!aa) {
													aa = true;
													P.fire("viewport:init",
															[ a5 ])
												}
												if (!aQ && !W) {
													aQ = true;
													aG = +new Date();
													P
															.when(
																	"app:userinfo-ready",
																	"app:preloaded")
															.then(
																	function() {
																		P
																				.resolve(
																						"app:init",
																						[
																								a5,
																								av.vision,
																								[
																										aG,
																										aF ] ])
																	})
												}
											})
						} else {
							P.bind("app:userinfo-ready", function() {
								l.visit(a3, aX, aZ)
							})
						}
					}
					return P.promise("viewport:ready")
				},
				goHome : function(aW) {
					if (aa) {
						l.teleport(0, aW)
					} else {
						l.visit(0, false, aW)
					}
				},
				exit : function() {
					aB.host.exit()
				}
			};
			function af(aX, aW) {
				aX += (aW && aW.step) ? "," + aW.step : "";
				setTimeout(function() {
					l.visit(aX)
				}, 0)
			}
			function b(aZ, aW) {
				var aX = aB.host;
				var aY = false;
				if (aW && aW > 3 && aW < 7) {
					aY = !at[aZ];
					at[aZ] = true
				}
				if (aY && ++H >= 3 || aX.needReset) {
					H = 0;
					at = {};
					aX.reset()
				} else {
					aX.locate(aZ);
					P.fire("viewport:ready", [ aZ, !aa ])
				}
			}
			function ac(aZ) {
				var aY = aB.host, aX = aY.neighbors(aZ);
				if (!aX) {
					return false
				}
				var aW = +new Date();
				D = aW;
				M.forEach(function(a1) {
					var a0 = (this[a1] || [])[0];
					if (a0 && !aY.info(a0) && this[a1][1] != 8) {
						t("node:view").get(
								{
									nid : parseInt(a0, 10),
									mode : aB.layerModeCode,
									syncDB : l.syncDB,
									userInfo : l.userInfo
								},
								function(a2) {
									if (aW < D || aW < X || aY.vision
											&& aZ != aY.vision || aY.info(a0)
											|| !aY.info(aZ)) {
										return
									}
									aY.render(a0, a2);
									aY.info(a0).localMeta = a2.focus;
									aY.info(a0).breadcrumb = a2.breadcrumb
								})
					}
				}, aX)
			}
			function an(aW) {
				if (aB.host === av) {
					y.clearHead();
					y.updateLocalInfo({
						userInfo : l.userInfo,
						focus : aW.localMeta
					})
				}
			}
			function al(aY) {
				if (aB.host === av) {
					var aZ = Object.create(aY);
					var aX = aB.host.info(aY.nid);
					if (aX.kind < 4) {
						aV = parseFloat(aY.nid);
						aZ.info = aX.localMeta
					} else {
						aZ.info = {};
						aZ.streets = M.map(function(a0) {
							if (this[a0]) {
								this[a0].toward_name = ar[a0]
							}
							return this[a0]
						}, aX.localMeta).filter(function(a0) {
							return a0
						})
					}
					if (A) {
						var aW = y.getLocalList(aZ);
						if (aW) {
							y.saveLocalList(aW)
						}
					} else {
						y.updateLocalList(aZ)
					}
				}
			}
			function ab(aW, aX) {
				aX.preventDefault();
				if (au) {
					aB.host.move(aW)
				}
			}
			function B(aW) {
				if (aB.layerModeCode == 1) {
					return
				}
				k.host = aB.host;
				k.render(parseInt(aW.nid, 10), aW)
			}
			function q(aZ, aW) {
				aa = false;
				ag = true;
				aB.host.clear();
				var aY = l.visit(0, aZ, aW);
				aY.wait(aX);
				function aX() {
					if (W) {
						return aY.wait(aX)
					}
					if (aW.update) {
						P.fire("viewport:update", [ function() {
							av.needReset = true;
							aB.host.reset().then(function() {
								aB.hideProcess(aW)
							})
						} ])
					} else {
						aB.hideProcess(aW)
					}
				}
			}
			function ai() {
				if (--aN <= 0) {
					if (aN < 0) {
						aN = 0
					}
					am.enable()
				}
			}
			function aq() {
				if (++aN > 0) {
					am.disable()
				}
			}
			function v() {
				P.unbind("viewport:ready", v)
			}
			function O(aW) {
				s.nav(aW, {
					route : false
				})
			}
			function F(aW, aY) {
				var aX;
				if (!aD.opened || aD.overview_mode) {
					if (!aD.opened) {
						aX = aB.getFullmapOpenOpt().from
					}
					aD.open(0)
				}
				if (aj.autonav) {
					aB.alertGuideChange(aY, function() {
						F(aW, aY)
					});
					return
				}
				if (aB._dialog_enabled) {
					aB.dialog.close()
				}
				aD.showLoading();
				aj.lastTarget = aW;
				t("node:guide").get({
					nid : parseInt(aB.host.vision, 10),
					uri : encodeURIComponent(aW)
				}, function(aZ) {
					aD.hideLoading();
					if (!aD.opened || aD.overview_mode || aW != aj.lastTarget) {
						return
					}
					if (aZ.r <= 0) {
						aj.markAndNav(aZ, aZ.nav_name || aY, {
							from_opt : aX
						})
					} else {
						aB.alert(aZ.msg)
					}
				})
			}
			function d(aZ, aX, aY, aW) {
				C = aX + aZ;
				if (Y.cardEnabled && C === f) {
					f = null;
					return Y.hideCard()
				}
				f = C;
				if (aY) {
					Y.showCard(aY, aW)
				}
				t(z[aX].model).get({
					id : encodeURIComponent(aZ)
				}, function(a0) {
					if (!a0.r && aX + aZ == C) {
						if (z[aX].prep) {
							z[aX].prep(a0.card)
						}
						a0.card.directlink = aW && aW.directlink;
						Y.fillCard(a0.card, aX)
					}
				})
			}
			function L() {
				aB.showLoading({
					msg : "正在更新视图..."
				});
				P.fire("viewport:update", [ function() {
					av.needReset = true;
					aB.host.reset().then(function() {
						aB.hideLoading()
					})
				} ])
			}
			function I(aW) {
				if (aW.r == 10) {
					if (az.SUPPORT_PUSHSTATE) {
						if (/#/.test(location.href)) {
							return location.replace(location.href.replace(
									/.*\/?#!?\/?/, "/"))
						}
					} else {
						return location.replace(location.href
								.replace(/#.*/, ""))
					}
				}
				l.goHome();
				aB.alert(aW.r == 21 && "你要访问的小店没有在阿尔法城落地" || "你要访问的地点不存在")
			}
			function c(aW) {
				aB.showPlatformAlert(aW);
				l.disableControl();
				U.trackRefuseUser(1, aS.browser + "/" + aS.version)
			}
			function K() {
				aw = true;
				U.iframeSubmit("/accounts/create_anon", {
					method : "auto"
				}, function() {
					location.reload()
				})
			}
			function aU(aX) {
				var aZ = av.info(av.vision);
				if (!aZ) {
					setTimeout(function() {
						aU(aX)
					}, 1000);
					return
				}
				var aW = aZ.neighbors, aY = [ "N", "W", "S", "E" ];
				while (!aW[aX]) {
					aX = aY[Math.floor(Math.random() * 4)]
				}
				setTimeout(function() {
					l.walk(aX).wait(function() {
						aU(aX)
					})
				}, 4000)
			}
			function a(aY) {
				if (G) {
					if (aY) {
						aY.lose(100)
					} else {
						require([ "gondor/view/stamina" ], function(aZ) {
							if (!x) {
								aZ.enable({
									max : 1000,
									low : 700,
									require : 300,
									restoreSpeed : 1
								});
								x = aZ
							}
						})
					}
				} else {
					var aW = +new Date();
					var aX = 50;
					if (aW - Z < 2000) {
						if (++u > aX) {
							G = true;
							a(aY)
						}
					} else {
						u = 0
					}
					Z = aW
				}
			}
			function ae(aX) {
				if (!aD.opened) {
					ak.show(aX.tip, aX.tpl)
				} else {
					var aW = aB.host.vision;
					P.wait("fullmap:close", function() {
						var aY = function() {
							if (aW === aB.host.vision) {
								ak.show(aX.tip, aX.tpl)
							} else {
								ak.markAsUnread(aX.tip)
							}
						};
						if (e) {
							P.wait("viewport:ready", aY)
						} else {
							aY()
						}
					})
				}
			}
			return l
		});