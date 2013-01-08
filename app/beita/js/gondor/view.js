define(
		"gondor/view",
		[ "mod/lang", "lib/jquery", "host", "mod/browsers", "mod/template",
				"mod/uiproxy", "mod/mainloop", "mod/animate", "mod/easing",
				"mod/dialog", "mod/editable", "mod/stick", "mod/mention",
				"gondor/observer", "gondor/toolkit", "gondor/view/uievent",
				"gondor/view/maplayers", "gondor/view/fullmap",
				"gondor/view/dashboard", "gondor/view/sidebar",
				"gondor/view/searchbar", "gondor/view/sonorus",
				"gondor/view/town", "gondor/view/shop", "gondor/view/house",
				"gondor/view/widget", "gondor/view/sound",
				"gondor/view/citizen", "gondor/view/growl",
				"gondor/view/newbie", "gondor/view/card", "gondor/view/dou",
				"gondor/view/guide", "gondor/view/dialog",
				"gondor/view/suggester", "gondor:domain" ],
		function(M, an, K, az, y, ao, a, Q, P, I, q, C, ad, E, O, av, G, al, m,
				r, i, af, f, t, N, v, b, ak, l, Y, R, p, X, z, J, ap) {
			var g = S("area"), ae = S("node"), ay = S("place"), ab = {
				hd : function(aE, aD) {
					an(aE).find("h6").css("background", aD).end().find(
							".hd-roof-2").css("background", aD)
				},
				hdBorder : function(aE, aD) {
					an(aE).css("borderColor", aD).find("h6").css("borderColor",
							aD).end().find(".hd-roof-1").css("background", aD)
				},
				hdText : function(aE, aD) {
					an(aE).find("h6").css("color", aD)
				}
			}, aa = {
				hd : function(aE, aD) {
					an(aE).find("h6").css("background", aD).end().find(
							".hd-roof-1,.hd-roof-2").css("background", aD)
				},
				hdBorder : function(aE, aD) {
					an(aE).css("borderColor", aD).find("h6").css("borderColor",
							aD)
				},
				hdText : function(aE, aD) {
					an(aE).find("h6").css("color", aD)
				}
			};
			var aA = {
				".toward.arrowW" : function() {
					aj.move("W")
				},
				".toward.arrowE" : function() {
					aj.move("E")
				},
				".toward.arrowN" : function() {
					aj.move("N")
				},
				".toward.arrowS" : function() {
					aj.move("S")
				},
				".layer-loading" : ac,
				".globalmask" : ac,
				".bg.app-loadingmask" : V,
				".box.app-loadingmask" : V,
				".bd.app-loadingmask" : V,
				".icon.app-loadingmask" : V,
				".msg.app-loadingmask" : V,
				".hearthstone" : n,
				".overlap.hearthstone" : n,
				".overlap.me" : function() {
				},
				".overlap.mark" : function() {
					var aD = an(this);
					al.showTips(aD)
				},
				".overlap.refer-activity" : x,
				".overlap.refer-activity.cate-" : x,
				".guide-btn.start" : function() {
					var aD = /#nav_id=(\w*)&nav_kind=(\w*)&cid=(\w*)/
							.exec(this.href)
							|| [];
					E.cancel("fullmap:close", T).fire("viewport:teleport",
							[ aD[1], {
								content_id : aD[3],
								is_place : aD[2] === "place"
							} ])
				},
				".guide-btn.cancel" : function() {
					X.clearPath();
					al.clearMark();
					var aD = /#id=(\w*)&kind=(\w*)&place_domain=([\w\-\.]*)&place_kind=(\w*)/
							.exec(this.href);
					if (aD) {
						E.fire("fullmap:return", [ {
							id : aD[1],
							kind : aD[2],
							place_domain : aD[3],
							place_kind : aD[4]
						} ])
					}
				},
				".sprite-area" : c,
				".domcanvas-sprite-rect" : function() {
					if (!/cross/.test(this.href)) {
						w.apply(this)
					}
				},
				".domcanvas-sprite-text" : w,
				".domcanvas-sprite-text.minimap-text-v" : w,
				".domcanvas-sprite-image" : function() {
					al.showTips(an(this))
				},
				".refer-activity" : x,
				".sound-river" : function() {
					f.openSounds()
				},
				".sound" : H,
				".sound-bubble.layer0" : H,
				".sound-bubble.layer1" : H,
				".sound-bubble.layer2" : H,
				".sound-bubble.layer3" : H,
				".sound-bubble.layer0.sound-top" : H,
				".sound-bubble.layer1.sound-top" : H,
				".sound-bubble.layer2.sound-top" : H,
				".sound-bubble.layer3.sound-top" : H,
				".shop-overlap" : j,
				".shop-preview-overlap" : j,
				".hot-pop" : j,
				".num.num-style.theme0" : B,
				".num.num-style.theme1" : B,
				".num.num-style.theme2" : B,
				".num.num-style.theme3" : B,
				".shop-overlap.forsale" : function() {
					ai.alert(an(this).attr("title"), null, {
						cancelText : "知道了"
					})
				},
				".theme-btn" : function() {
					an(this).addClass("theme-enabled").parent().parent()
							.addClass("theme-enabled").parent().find(
									".shop-overlap").hide()
				},
				".theme-btn.theme-enabled" : function() {
					var aE = {};
					var aD = /#pid=(\d+)/.exec(this.href)[1];
					var aF = (/place\-\d+\-(\d+)/
							.exec(this.parentNode.parentNode.parentNode.className) || [])[1];
					an(this).removeClass("theme-enabled").parent().parent()
							.removeClass("theme-enabled").parent().find(
									".shop-overlap").show().end().find(
									".theme-panel").find("input").each(
									function() {
										aE[this.name] = this.value
									});
					E.fire("place:theme", [ aD, aF, aE ])
				},
				".theme-prop" : function() {
					var aF = this, aD = this.parentNode.parentNode, aE = an(aD)
							.attr("data-shopkind");
					ai.showColorPicker(aF.value, aD, function(aG, aJ, aI) {
						var aH = aF.value = "#" + aJ;
						aF.style.backgroundColor = aH;
						(aE < 2 ? aa : ab)[aF.name](aD.parentNode, aH);
						ai.hideColorPicker()
					})
				},
				".shop-bid-btn" : function() {
					var aD = (/pid=(\d+)/.exec(this.href) || [])[1];
					z.set({
						isHideTitle : true,
						iframeURL : "/api/node/" + aD + "/bid",
						width : 500,
						buttons : []
					}).open()
				},
				".shop-admin-btn" : function() {
					t.showAdmin(this.href)
				},
				".shop-kick" : function() {
					z.set({
						title : "将小店踢出街道",
						isHideTitle : false,
						iframeURL : this.href,
						width : 500,
						buttons : []
					}).open()
				},
				".shop-admin-btn.shop-admin-expire-btn" : function() {
					if (this.nodeName !== "A") {
						return arguments.callee.call(this.parentNode)
					}
					t.showAdmin(this.href)
				},
				".house-admin-btn" : function() {
					z.set({
						isHideTitle : true,
						iframeURL : this.href,
						width : 500,
						buttons : []
					}).open()
				},
				".widget-admin-btn" : function() {
					var aD = /#wid=(\d+)/.exec(this.href)[1];
					v.showAdmin(aD)
				},
				".house-doors" : function() {
					var aD = /#hid=(\d+)&hpage=(\d+)/.exec(this.href);
					N.open(f.vision, aD[1], aD[2])
				},
				".house-doors.ban" : function() {
					ai.alert("坊大道的公寓暂时不开放入住，请选择街道上的公寓")
				},
				".door-btn" : function() {
					if (this.nodeName !== "A") {
						return arguments.callee.call(this.parentNode)
					}
					var aD = /\/home\/([\w\-\.]+)\/#nid=(\d+)/.exec(an(this)
							.attr("href"));
					N.zoom({
						parent_id : f.vision,
						place_domain : aD[1],
						id : aD[2]
					})
				},
				".door-btn.sale" : function() {
					if (this.nodeName !== "A") {
						return arguments.callee.call(this.parentNode)
					}
					var aD = /node\/(\d+)\/resident_op\?op=(\w+)&hid=(\d+)&page=(\d+)/
							.exec(an(this).attr("href"));
					if (aD) {
						E.fire("house:op", aD.slice(1))
					}
				},
				".icon.full" : at,
				".road-logo" : at,
				".mapnav-fold.first" : function() {
					an(this).addClass("folded");
					an(this).parent().addClass("folded")
				},
				".mapnav-fold.first.folded" : function() {
					an(this).removeClass("folded");
					an(this).parent().removeClass("folded")
				},
				".mapnav-current" : function() {
				},
				".mapnav-node" : function() {
					ai.alert("要离开这里，回到街道上吗？", function() {
						ai.host.exit()
					})
				},
				".mapnav-area" : function() {
					if (this.nodeName !== "A") {
						return arguments.callee.call(this.parentNode)
					}
					var aD = (/\/area\/(\w+)/.exec(an(this).attr("href")) || [])[1];
					al.open({
						area_id : aD
					})
				},
				".mapnav-town" : function() {
					var aD = ai.host.info(ai.host.vision);
					al.openOverview()
				},
				".mapnav-close" : function() {
					if (this.nodeName !== "A") {
						if (this.nodeName === "DIV") {
							return arguments.callee.call(an("a", this)[0])
						} else {
							return arguments.callee.call(this.parentNode)
						}
					}
					var aD = /#id=(\w*)&kind=(\w*)&place_domain=([\w\-\.]*)&place_kind=(\w*)/
							.exec(an(this).attr("href"));
					E.fire("fullmap:return", [ {
						id : aD[1],
						kind : aD[2],
						place_domain : aD[3],
						place_kind : aD[4]
					} ])
				},
				".toggle-dashboard" : function() {
					m.toggle();
					an(this).addClass("folded")
				},
				".toggle-dashboard.folded" : function() {
					m.toggle();
					an(this).removeClass("folded")
				},
				".toggle-appsidebar" : function() {
					r.toggle();
					an(this).addClass("folded")
				},
				".toggle-appsidebar.folded" : function() {
					r.toggle();
					an(this).removeClass("folded")
				},
				".search-btn" : function() {
					i.search(an(this).parent().find(".text").val())
				},
				".go-area" : c,
				".go-node" : Z,
				".go-node.btn" : Z,
				".go-place" : k,
				".go-place.btn" : k,
				".go-place.btn.disabled" : at,
				".go-content" : h,
				".link-area" : c,
				".link-area.btn" : c,
				".link-place" : aw,
				".link-place.btn" : aw,
				".link-place.btn.disabled" : at,
				".link-content" : aw,
				".link-node" : aw,
				".link-node.btn" : aw,
				".link-node.on" : aw,
				".link-node.pic" : aw,
				".refer-area" : g,
				".refer-node" : ae,
				".refer-place" : ay,
				".citizen" : function() {
					var aD = an(this).attr("href");
					if (!aD) {
						return arguments.callee.call(this.parentNode)
					}
					var aF = (/id=(\d+)/.exec(aD) || [])[1];
					if (aF) {
						var aE = an(this).offset();
						E.fire("card:info", [ aF, "citizen", aE ])
					}
				},
				".login-lnk" : function() {
					z.close();
					ai.showLoginbox()
				},
				".user-login" : function() {
					ai.showLoginbox()
				},
				".myinfo-card" : function() {
					var aD = an(this).offset();
					E.fire("citizen:myinfo", [ ai.userbar.find(".myinfo")[0], {
						clock : 7,
						enableAlign : true
					} ])
				},
				".myinfo-money" : function() {
					ai.showWallet()
				},
				".myinfo-account" : function() {
					var aD = an(this).attr("data-user-id");
					ai.showAccountEditor(aD)
				},
				".user-login.anonuser" : function() {
					ai.showLoginbox()
				},
				".myinfo-card.anonuser" : aC,
				".myinfo-money.anonuser" : aC,
				".myinfo-account.anonuser" : aC,
				".hearthstone.anonuser" : aC,
				".insert-tag.insert-sharp" : function() {
					var aD = an(this).closest("form, .note-form").find(
							"textarea.mention");
					ad.lib.insertAtCaret(aD[0], "#");
					aD.keydown().keyup()
				},
				".insert-tag.insert-at" : function() {
					var aD = an(this).closest("form, .note-form").find(
							"textarea.mention");
					ad.lib.insertAtCaret(aD[0], "@");
					aD.keydown().keyup()
				},
				".edit-card" : function() {
					R.hideCard();
					var aE = (/user\/(\d+)/.exec(this.href) || [])[1], aD = "/api/user/"
							+ aE + "/update";
					z.set({
						isHideTitle : true,
						iframeURL : aD,
						width : 490,
						buttons : []
					}).open()
				},
				".btn.citizen-follow" : function() {
					var aD = (/uid=(\d+)/.exec(this.href) || [])[1];
					E.fire("citizen:like", [ aD, "add" ])
				},
				".btn.citizen-unfollow" : function() {
					var aD = an(this).attr("href");
					if (!aD) {
						return arguments.callee.call(this.parentNode)
					}
					var aE = (aD.match(/uid=(\d+)/) || [])[1];
					if (aE) {
						E.fire("citizen:like", [ aE, "delete" ])
					}
				},
				".citizen-unfollow" : function() {
					var aD = (/uid=(\d+)/.exec(this.href) || [])[1];
					z.confirm("确定要取消喜欢TA吗？", function() {
						E.fire("citizen:like", [ aD, "delete", "fromCardbox" ])
					})
				},
				".editnow" : function() {
					q.toEdit(this)
				},
				".editnow-yes" : function() {
					var aG = this.parentNode, aH = an(".editnow", aG), aF = aH
							.attr("href").replace(/.*#/, ""), aD = encodeURIComponent(an(
							".editnow-input", aG).val()), aE = {
						callback : function(aI) {
							if (!aI.r) {
								q.toNormal(aH[0], aI.text || aD)
							} else {
								ai
										.alert(aI.msg
												|| "你的修改无法保存，可能是网络问题，或是内容不符合要求")
							}
						}
					};
					(/\?(.*)/.exec(aF) || [ "", "" ])[1].split("&").forEach(
							function(aI) {
								if (aI) {
									aI = aI.split("=");
									aE[aI[0]] = aI[1] || aD || "%20"
								}
							});
					aE.api = aF.replace(/\?.*/, "");
					E.fire("citizen:update", [ aE ])
				},
				".editnow-no" : function() {
					q.toNormal(an(".editnow", this.parentNode)[0])
				},
				".normal-mode" : function() {
					ai.changeMode()
				},
				".shop-rent" : am,
				".shop-create" : aB,
				".shop-manage" : A,
				".shop-rent.disabled" : W,
				".shop-manage.disabled" : W,
				".shop-rent.disabled.anonuser" : aC,
				".shop-create.anonuser" : aC,
				".shop-manage.disabled.anonuser" : aC,
				".telectrl-target" : function() {
					if (this.nodeName !== "A") {
						return arguments.callee.call(this.parentNode)
					}
					var aD = (/\/shop\/([\w\-\.]+)/.exec(an(this).attr("href")) || [])[1];
					z.close();
					E.fire("viewport:teleport", [ aD, {
						is_place : true
					} ])
				},
				".transfer-dou" : function() {
					z.set({
						isHideTitle : true,
						iframeURL : this.href,
						width : 500,
						buttons : []
					}).open()
				},
				".write-mail" : function() {
					z.set({
						isHideTitle : true,
						iframeURL : this.href,
						width : 720,
						buttons : []
					}).open()
				},
				".bookmark-btn" : function() {
					E.fire("place:bookmark", [
							(/pid=(\d+)/.exec(this.href) || [])[1], "add" ])
				},
				".bookmark-btn.bookmarked" : function() {
					var aE = an(this).attr("href");
					if (!aE) {
						return arguments.callee.call(this.parentNode)
					}
					var aD = (aE.match(/pid=(\d+)/) || [])[1];
					if (aD) {
						E.fire("place:bookmark", [ aD, "delete" ])
					}
				},
				".house-extend-btn" : function() {
					var aD = /node\/(\d+)\/resident_op\?op=(\w+)/
							.exec(this.href);
					if (aD) {
						E.fire("house:op", aD.slice(1))
					}
				},
				".house-extend-btn.house-extended" : at,
				".shop-exit" : function() {
					ai.showProcess({
						msg : "出门到街上...",
						className : "loading-teleport"
					});
					E.wait("place:disable", function() {
						ai.hideProcess()
					});
					setTimeout(function() {
						ai.host.exit()
					}, 200)
				},
				".loot-dou" : function(aG) {
					var aF = this, aD = arguments.callee;
					if (aF.nodeName !== "A") {
						return aD.call(aF.parentNode, aG)
					}
					var aE = an(aF);
					p.hide();
					aE.addClass("picked");
					Q.addStage("lootDou", {
						target : aE.find(".loot-tips")[0],
						prop : "transform",
						from : "scale(1)",
						to : "scale(5)",
						duration : 1000,
						easing : "easeOut"
					}, {
						target : aE.find(".loot-tips")[0],
						prop : "top",
						from : "10px",
						to : "-300px",
						duration : 1000,
						easing : "easeOut"
					}, {
						target : aE[0],
						prop : "opacity",
						from : "1",
						to : "0",
						duration : 1000,
						easing : "easeOut",
						callback : function() {
							Q.remove("lootDou");
							p.remove()
						}
					});
					E.fire("citizen:pick", /num=(\d+)&para=(.+?)&url=(.*)/
							.exec(aE.attr("data-opt")).slice(1))
				},
				".newbie-done" : function() {
					var aD = this.href, aE = an(this).data("tip");
					E.fire("newbie:done", [ aD, aE ])
				},
				".bookmarks-view" : function() {
					z.loading();
					E.fire("bookmarks:list")
				},
				".bookmarks-view.anonuser" : aC,
				".cardbox-view.anonuser" : aC,
				".bn-prev.cardbox-prev" : function() {
					require([ "gondor/view/cardbox" ], function(aD) {
						aD.prevPage()
					})
				},
				".bn-next.cardbox-next" : function() {
					require([ "gondor/view/cardbox" ], function(aD) {
						aD.nextPage()
					})
				},
				".link-node-activity" : d,
				".activity-follow-btn" : function() {
					var aE = /pid=(\d+)&wid=(\d+)&aid=(\d+)/.exec(this.href);
					var aD = this;
					E
							.fire(
									"activity:follow",
									[
											aE[1],
											aE[2],
											aE[3],
											function() {
												an(aD)
														.addClass("disabled")
														.html("即将收到提醒")
														.parent()
														.find("em")
														.html(
																function(aF, aG) {
																	if (/\d/
																			.test(aG)) {
																		return aG
																				.replace(
																						/\d+/,
																						function(
																								aH) {
																							return parseInt(
																									aH,
																									10) + 1
																						})
																	} else {
																		return "1人感兴趣"
																	}
																})
											} ])
				},
				".activity-follow-btn.disabled" : at,
				".activity-vip-list" : function() {
					var aD = an(this).parent().find(".viplist").html();
					ai.alert('<ul class="viplist">' + aD + "</ul>", false, {
						title : "嘉宾列表"
					})
				},
				".activity-vip-list.with_dialog" : function() {
					var aD = an(this).parent().find(".viplist").html();
					ai.activityPosterDlg.confirm('<ul class="viplist">' + aD
							+ "</ul>")
				},
				".mail-view" : function() {
					var aD = "/api/mail/list";
					z.set({
						isHideTitle : true,
						iframeURL : aD,
						width : 720,
						buttons : []
					}).open()
				},
				".mail-view.anonuser" : aC,
				".sonorus-view" : function() {
					E.fire("sonorus:list", [ {
						start : 0,
						limit : 5
					} ])
				},
				".sonorus-view.anonuser" : aC,
				".sonorus-more" : function() {
					var aD = /#kind=(\w+)/.exec(this.href)[1];
					af.fold();
					af.open({
						kind : aD
					})
				},
				".sonorus-tab" : function() {
					var aD = /#kind=(\w+)/.exec(this.href)[1];
					af.goTo({
						kind : aD
					})
				},
				".sonorus-tab.on" : at,
				".link-node-sonorus" : function() {
					var aD = this;
					af.lock = true;
					o.call(this, function() {
						setTimeout(function() {
							af.lock = false
						}, 0);
						aw.call(aD)
					})
				},
				".link-node-sonorus-detail" : aw,
				".sonorus-close" : function() {
					o.call(this)
				},
				".hearthstone-sonorus" : function() {
					var aD = /noti=(\d+)/.exec(this.href)[1];
					E.fire("sonorus:read", [ aD ]);
					n()
				},
				".bn-prev.sonorus-prev" : function() {
					af.prevPage()
				},
				".bn-next.sonorus-next" : function() {
					af.nextPage()
				},
				".staminabar-chicken" : function() {
					E.fire("stamina:chicken")
				},
				".lnk-douban" : ah,
				".lnk-sina" : ah,
				".refer-badge.badge-8000" : F,
				".refer-badge.badge-8001" : F,
				".refer-badge.badge-8002" : F,
				".refer-badge.badge-8003" : F,
				".refer-badge.badge-8004" : F,
				".refer-badge.badge-8005" : F,
				".refer-badge.badge-8006" : F,
				".refer-badge.badge-8007" : F,
				".refer-badge.badge-8008" : F,
				".refer-badge.badge-8009" : F,
				".refer-badge.badge-9101" : F,
				".refer-badge.badge-9102" : F,
				".refer-badge.badge-9201" : F,
				".refer-badge.badge-9202" : F,
				".refer-badge.badge-9301" : F,
				".refer-badge.badge-9302" : F,
				".refer-badge.badge-9303" : F,
				".refer-badge.badge-9304" : F,
				".refer-badge.badge-9305" : F,
				".refer-badge.badge-9306" : F,
				".refer-badge.badge-9307" : F,
				".refer-badge.badge-9308" : F,
				".path-theme-btn" : function() {
					z.set({
						isHideTitle : true,
						iframeURL : this.href,
						width : 640,
						buttons : []
					}).open()
				},
				".arrow" : at,
				".tipsbox.server-tips-2" : at,
				".donothing" : at,
				".nearest-info" : at,
				".nearest-info.nearW" : at
			};
			var ax = {
				".comment-input.mention" : u,
				".wall-post.mention" : u,
				".wall-comment-input.mention" : u,
				".post-area.mention" : u,
				".note-text.mention" : u
			};
			var s = "加载中...", au = document.title, U = 4000, aj, ag = 0, D = 0, ar = 0, e = {};
			function j() {
				if (this.nodeName !== "A") {
					return arguments.callee.call(this.parentNode)
				}
				var aD = /\/shop\/([\w\-\.]+)\/#nid=(\d+)/.exec(an(this).attr(
						"href"));
				if (aD) {
					t.zoom({
						parent_id : f.vision,
						place_domain : aD[1],
						id : aD[2]
					})
				}
			}
			function aB() {
				z.set({
					isHideTitle : false,
					title : "提示",
					iframeURL : "/api/place/shop_apply",
					width : 400,
					buttons : []
				}).open()
			}
			function A() {
				E.fire("citizen:telecontrol")
			}
			function am() {
				ai.changeMode("mode:shopbid")
			}
			function B() {
				var aE = an(this), aH = aE.attr("data-nid"), aF = aE.offset(), aD = aF.left + 0, aG = aF.top + 40;
				aE.addClass("flying");
				E.fire("joke:pick", [ aH, aD, aG ]);
				Q.addStage("numCanFly" + aH, {
					target : this,
					prop : "top",
					from : aE.css("top"),
					to : 0 - (aG + 50) + "px",
					duration : Math.floor((aG + 50) / 0.15),
					callback : function() {
						Q.complete("numCanFly" + aH);
						aE.remove()
					}
				})
			}
			function n() {
				E.fire("viewport:teleport")
			}
			function H() {
				if (this.nodeName !== "A") {
					return arguments.callee.call(this.parentNode)
				}
				var aD = /type(\w)/.exec(this.className);
				if (aD) {
					an(this).remove();
					aj.move(aD[1])
				} else {
					f.openSounds()
				}
			}
			function c() {
				var aD = /\/area\/(\w+)/.exec(this.href);
				if (aD) {
					al.open({
						area_id : aD[1]
					})
				}
			}
			function Z() {
				var aD = /\/\w+\/([\w\-\.]+)/.exec(this.href);
				E.fire("viewport:teleport", [ aD[1] ])
			}
			function k() {
				var aD = /\/\w+\/([\w\-\.]+)/.exec(this.href);
				E.fire("viewport:teleport", [ aD[1], {
					is_place : true
				} ])
			}
			function h() {
				var aD = /\/\w+\/([\w\-\.]+)\/?\?cid=(\w*)/.exec(this.href);
				if (aD) {
					E.fire("viewport:teleport", [ aD[1], {
						content_id : aD[2]
					} ])
				} else {
					return true
				}
			}
			function S(aD) {
				return function() {
					var aF = an(this).attr("href");
					if (!aF) {
						return arguments.callee.call(this.parentNode)
					} else {
						var aE = an(this).offset();
						E.fire("card:info", [ aF, aD, aE, {
							directlink : an(this).attr("data-directlink")
						} ])
					}
				}
			}
			function w() {
				var aD = an("#fmap_node_" + (/\d+$/.exec(this.id)[0]));
				E.fire("card:info", [ aD[0].href, "node", aD[0], {
					clock : aD.width() > aD.height() ? 1 : 10,
					enableAlign : true,
					directlink : true
				} ])
			}
			function aw() {
				var aD = an(this).attr("href");
				if (!aD) {
					return aw.call(this.parentNode)
				}
				var aE = an(this).attr("title");
				E.fire("node:guide", [ aD, aE ])
			}
			function o(aD) {
				var aF = this;
				var aE = an(aF).attr("data-noti");
				aF.className = "sonorus-closing";
				E.fire("sonorus:read", [ encodeURIComponent(aE) ]);
				an(aF).parent().animate({
					height : 0
				}, 400, aD)
			}
			function d() {
				if (ai.activityPosterDlg) {
					ai.activityPosterDlg.close()
				}
				aw.call(this)
			}
			function x() {
				var aD = /place\/(\d+)\/widget\/(\d+)\/activity\/(\d+)/
						.exec(this.href);
				E.fire("activity:poster", [ aD[1], aD[2], aD[3] ])
			}
			function F() {
				var aD = /bid=(\d+)/.exec(this.href)[1];
				E.fire("badge:info", [ aD ])
			}
			function at() {
			}
			function aC() {
				ai.alert("你目前的身份是游客，无法使用这项功能。请先登录。", function() {
					setTimeout(function() {
						ai.showLoginbox()
					}, 10)
				}, {
					title : "请登录",
					confirmText : "登录"
				})
			}
			function W() {
				ai.alert("你还没拥有小店，所以不能使用这项功能哟")
			}
			function ac() {
				if (+new Date() - ag < U) {
					return
				}
				ai.alert("请等待数据加载完成之后再操作，如果等待时间太久，可能是网络连接或服务器有问题，可以刷新页面再试试。",
						function() {
							z.close()
						}, {
							title : "正在加载数据...",
							confirmText : "我知道了",
							cancelText : "刷新页面",
							cancelMethod : function() {
								location.reload()
							}
						})
			}
			function V() {
				if (+new Date() - ag < U) {
					return
				}
				ai.loadingBox.css("z-index", 5500);
				E.wait("dialog:close", function() {
					ai.loadingBox.css("z-index", "")
				});
				ac()
			}
			function T() {
				af.open()
			}
			function ah(aD) {
				var aE = an(this).parent().find("input");
				if (!aE[0]) {
					return true
				}
				E.fire("share:site", [ {
					site : this.className.replace(/lnk\-/, ""),
					href : this.href,
					image : aE.attr("data-image"),
					pic : aE.attr("data-pic"),
					name : aE.attr("data-name"),
					note : aE.attr("data-note"),
					kind : aE.attr("data-kind"),
					text : aE.attr("data-text"),
					address : aE.attr("data-address"),
					desc : aE.attr("data-desc")
				} ])
			}
			function u() {
				setTimeout(function() {
					ai.suggester.clear()
				}, 200)
			}
			function L(aD) {
				return aD.place_name || aD.node_name || aD.area_name || au
			}
			var aq = {
				"mode:shopbid" : [ 1, f, "在街道上才能进入租赁模式" ]
			};
			E.bind("mode:shopbid", function(aE) {
				var aD = ai.userbar;
				if (ai.layerModeCode) {
					aD.addClass("rent-mode")
				} else {
					aD.removeClass("rent-mode")
				}
			});
			var ai = {
				init : function(aD) {
					this.viewport = aD.viewport;
					av.clickProxy.bind(aA);
					ao.add(K.document, "focusout", ax);
					this.layerModeCode = 0;
					this.changeHost(f);
					this.itemsPool = [];
					this.loadingBox = an("#apploading");
					this._loadingBoxClassName = this.loadingBox[0].className;
					this.header = this.viewport.find(".dashboard");
					this.mapnav = this.header.find(".mapnav");
					this.userbar = this.header.find(".userbar");
					this.loginbar = this.header.find(".loginbar");
					this.footer = an("#appfooter");
					this.mailNum = this.userbar.find("strong.mail-view");
					this.bookmarkNum = this.userbar
							.find("strong.bookmarks-view");
					this.mask = this.viewport.find(".globalmask");
					if (!this.mask[0]) {
						this.mask = an('<div class="globalmask"></div>')
								.appendTo(this.viewport)
					}
					var aG = this.viewport.find(".maplayer");
					O.getAssets(aD.assets, function() {
						E.resolve("app:preloaded")
					});
					setTimeout(function() {
						E.resolve("app:preloaded")
					}, 8000);
					O.getAssets(aD.moreAssets);
					af.init({
						viewport : this.viewport,
						num : this.userbar.find("strong.sonorus-view")
					});
					m.init({
						box : this.header
					});
					i.init({
						box : this.header.find(".search-box"),
						viewport : this.viewport
					});
					r.init({
						wrapper : this.viewport.find(".app-sidebar")
					});
					var aF = this.mainlayer = G(aG[0]), aE = this.placelayer = G(
							aG[1], {
								disable_dashboard : true,
								disable_sidebar : true
							});
					this.mainlayer.event.bind("resize", function(aH) {
						m.updateSize();
						r.updateSize();
						al.updateSize()
					});
					this.initResize();
					f.init({
						viewport : this.viewport,
						canvas : aF,
						cover : this.viewport.find(".bglayer"),
						smallScreenWidth : 1024 - r.width,
						smallScreenHeight : 800 - m.height
					});
					t.init({
						viewport : this.viewport,
						canvas : aE
					});
					N.init({
						viewport : this.viewport,
						canvas : aE
					});
					m.enable();
					Q.config({
						easing : P
					});
					a.config({
						fps : 40
					}).run();
					Y.init({
						detailLayer : this.viewport.find(".minilayer").eq(0),
						overviewLayer : this.viewport.find(".overview-map")
					});
					this.activityPosterDlg = I({
						isTrueShadow : true,
						customClassName : "activity-poster-box",
						title : "阿尔法城现场活动",
						borderWidth : 0,
						autoupdate : true,
						buttons : []
					}, true);
					this.initClickTrack()
				},
				disableControl : function() {
					if (++D > 0) {
						this.mask.show();
						ag = +new Date()
					}
				},
				enableControl : function() {
					if (--D <= 0) {
						if (D < 0) {
							D = 0
						}
						this.mask.hide();
						ag = 0
					}
				},
				changeHost : function(aD) {
					aj = this.host = aD;
					v.changeHost(aD)
				},
				initResize : function() {
					var aD = 0, aE;
					an(K)
							.resize(
									function() {
										clearTimeout(aD);
										aD = setTimeout(
												function() {
													if (az.mobilesafari) {
														if (K.innerWidth < 1024) {
															ai.resize();
															ai
																	.showLoading({
																		msg : "这个应用能支持的最小屏幕宽度1024象素，请保持在横屏状态下使用。"
																	});
															aE = true
														} else {
															if (aE) {
																aE = false;
																ai.resize();
																ai
																		.hideLoading()
															}
														}
													} else {
														ai.resize()
													}
												}, 200)
									})
				},
				resize : function() {
					this.mainlayer.updateSize();
					this.placelayer.updateSize();
					E.fire("viewport:resize")
				},
				setupFullmap : function(aD) {
					al.init(M.mix(aD, {
						detailLayer : this.viewport.find(".minilayer").eq(0),
						overviewLayer : this.viewport.find(".overview-map"),
						loadingLayer : this.viewport.find(".layer-loading")
					}))
				},
				getFullmapOpenOpt : function() {
					var aD = ai.host.info(ai.host.vision);
					if (aD) {
						return {
							from : {
								id : parseInt(aD.id, 10),
								kind : aD.kind,
								place_domain : aD.place_domain,
								place_kind : aD.place_kind
							}
						}
					} else {
						return {}
					}
				},
				initDashboard : function(aD) {
					if (aD.id) {
						this.userbar.append(y.convertTpl("tplUserbar", aD,
								"user"));
						this.updateDashboard(aD)
					}
				},
				updateDashboard : function(aD) {
					this.loginbar.html(y.convertTpl("tplLoginbar", aD, "user"));
					if (aD.isShopAdmin) {
						this.userbar.find(".shop-opt .menu span").removeClass(
								"disabled")
					}
					if (aD.role === "anonuser") {
						this.userbar.find("a,.menu span").addClass("anonuser");
						this.loginbar.addClass("anonuser")
					}
				},
				initClickTrack : function() {
					an(document).mousedown(function(aE) {
						if (aE.target.nodeType === 1) {
							var aD = aE.target.getAttribute("tksub");
							if (aD) {
								E.fire("app:track", [ aD.split(",") ])
							}
						}
					})
				},
				showBookmark : function(aD) {
					ai.dialog
							.set(
									{
										isHideTitle : true,
										iframeURL : "/api/user/"
												+ aD
												+ "/collections?action=get&alt=html&start=0&limit=20",
										width : 900,
										buttons : []
									}).open()
				},
				updateBookmark : function(aD) {
					if (aD) {
						this.bookmarkNum.html(aD || 0).show()
					} else {
						this.bookmarkNum.hide()
					}
				},
				updateMail : function(aD) {
					if (aD) {
						this.mailNum.html(aD || 0).show()
					} else {
						this.mailNum.hide()
					}
				},
				updateMapNav : function(aF, aD) {
					var aE = aF || [ {} ];
					this.mapnav[0].innerHTML = y.convertTpl("tplMapNav", {
						list : aE,
						from : aD && aD.from
					}, "nav");
					document.title = aF.length === 1 ? au
							: (L(aE[aE.length - 1]) + " - " + au)
				},
				show : function() {
					var aD = this, aE = +new Date() - ar;
					if (aE < 600) {
						return setTimeout(function() {
							aD.show()
						}, 600 - aE)
					}
					this._loadingBoxClassName += " app-loading-inited";
					aD.loadingBox.hide().find("div")
							.addClass("app-loadingmask").end().find(".msg")
							.html(s).end()[0].className = this._loadingBoxClassName;
					setTimeout(function() {
						r.enable()
					}, az.msie && az.msie < 10 ? 0 : 400)
				},
				showLoading : function(aD) {
					return this.showProcess(aD)
				},
				hideLoading : function() {
					return this.hideProcess({
						duration : 500
					})
				},
				showProcess : function(aD) {
					aD = M.mix({
						msg : s
					}, aD);
					this.loadingBox.find(".msg").html(aD.msg).end().show()[0].className = this._loadingBoxClassName
							+ " " + aD.className;
					ar = ag = +new Date();
					E.fire("app:loading start")
				},
				hideProcess : function(aF) {
					aF = M.mix({
						duration : 800
					}, aF);
					var aD = this, aG = +new Date() - ar;
					if (aG < aF.duration) {
						setTimeout(function() {
							aD.hideProcess(aF)
						}, aF.duration - aG)
					} else {
						if (aF.complete_msg || aF.complete_className) {
							this.loadingBox.addClass(aF.complete_className)
									.find(".msg").html(aF.complete_msg);
							setTimeout(function() {
								aE()
							}, aF.delay)
						} else {
							aE()
						}
					}
					function aE() {
						aD.loadingBox.hide();
						E.fire("app:loading end");
						ag = 0
					}
				},
				changeProcess : function(aD) {
					this.loadingBox.find(".msg").html(aD.msg);
					ar = +new Date()
				},
				showLoginbox : function() {
					if (!this.loginbox) {
						this.loginbox = I({
							isHideClose : true,
							isTrueShadow : true,
							isHideMask : false,
							isHideTitle : true,
							customClassName : "login-box",
							title : "",
							width : 980,
							autoupdate : true,
							buttons : []
						}, true)
					}
					this.loginbox.set({
						iframeURL : "/accounts/login"
					}).open();
					E.fire("dialog:open", [ this.loginbox ]);
					this.footer.show()
				},
				hideLoginbox : function() {
					if (this.loginbox) {
						this.loginbox.close();
						E.fire("dialog:close", [ this.loginbox ])
					}
					this.footer.hide()
				},
				showPlatformAlert : function(aD) {
					var aE = I({
						isHideClose : true,
						isTrueShadow : true,
						isHideMask : false,
						customClassName : "platform-box",
						title : "",
						content : y.convertTpl("tplPlatform", aD, "env"),
						width : 480,
						autoupdate : true,
						buttons : []
					}, true).open()
				},
				showPlatformTips : function(aE, aD) {
					var aF = ai.dialog.set({
						isHideTitle : false,
						title : aD.title,
						content : y.convertTpl("tplPlatformTips", aE, "env"),
						width : 540,
						buttons : [ {
							text : "以后再提醒我",
							method : function() {
								aF.close()
							}
						} ]
					}).open()
				},
				showActivityAlert : function(aD) {
					aD.domain = ap;
					ai.alert(y.convertTpl("tplActivityPoster", aD), function() {
						ai.host.move("N");
						E.wait("viewport:ready", function() {
							setTimeout(function() {
								ai.host.move("N")
							}, 0)
						})
					}, {
						title : "后花园正在举行活动...",
						confirmText : "去看看",
						cancelText : "没兴趣"
					})
				},
				showActivityPoster : function(aG) {
					aG.domain = ap;
					this.activityPosterDlg.set({
						width : 838,
						content : y.convertTpl("tplActivityPoster", aG)
					}).open();
					var aE = this, aF = false;
					this.activityPosterDlg.node.click(aD);
					an("body").click(
							function() {
								if (!aF) {
									aE.activityPosterDlg.close().node.unbind(
											"click", aD);
									an(this).unbind("click", arguments.callee)
								}
								aF = false
							});
					function aD() {
						aF = true
					}
				},
				showWallet : function() {
					ai.dialog.set({
						isHideTitle : true,
						title : "我的钱包",
						iframeURL : "/accounts/bank_transactions",
						width : 650,
						buttons : []
					}).open()
				},
				showAccountEditor : function(aD) {
					ai.dialog.set({
						isHideTitle : true,
						title : "我的账户",
						iframeURL : "/api/user/" + aD + "/account",
						width : 460,
						buttons : []
					}).open()
				},
				showDou : function(aF) {
					var aE = this;
					var aG = aE.host;
					if (aF.nid != aG.vision) {
						return
					}
					var aI = aG.activity[aG.vision], aD = an(aG === f ? ".shop"
							: ".edge-S .wall", aI.dom), aH = aD.eq(parseInt(
							Math.random() * aD.length, 10));
					p.show(aH, aF);
					aE.itemsPool.push(p)
				},
				clearItems : function() {
					this.itemsPool.forEach(function(aD) {
						aD.remove()
					});
					this.itemsPool.length = 0
				},
				showLuckNum : function(aD, aF) {
					var aE = an(
							'<span class="loot-tips">+<span class="refer-price">1</span></span>')
							.css({
								left : aD + "px",
								top : aF + "px"
							}).appendTo("body");
					Q.addStage("luckNum", {
						target : aE[0],
						prop : "top",
						from : aF + "px",
						to : (aF - 100) + "px",
						duration : 1000
					}, {
						target : aE[0],
						prop : "transform",
						from : "scale(0.5)",
						to : "scale(1.8)",
						duration : 1000,
						easing : "easeIn"
					}, {
						target : aE[0],
						prop : "opacity",
						from : "1",
						to : "0",
						delay : 800,
						duration : 200,
						easing : "easeIn",
						callback : function() {
							Q.complete("luckNum");
							aE.remove()
						}
					})
				},
				showColorPicker : function(aG, aH, aD) {
					var aF = this, aE = this._picker;
					if (!aE) {
						require([ "mod/colorpicker" ], function(aI) {
							aI.init({
								color : "#fff"
							});
							aF._picker = aI;
							aF.showColorPicker.call(aF, aG, aH, aD)
						});
						return
					}
					if (aG) {
						aE.setColor(aG)
					}
					aE.showPicker(aH, aD)
				},
				hideColorPicker : function() {
					if (this._picker) {
						this._picker.hidePicker()
					}
				},
				alert : function(aH, aD, aE) {
					aH = aH || "操作失败";
					aE = aE || {};
					var aG = z;
					var aF = [];
					if (aD) {
						aF.push({
							text : aE.confirmText || "确定",
							method : function() {
								aD();
								aG.close()
							}
						}, {
							text : aE.cancelText || "取消",
							method : aE.cancelMethod || function() {
								aG.close()
							}
						})
					} else {
						aF.push(aE.cancelText ? ({
							text : aE.cancelText,
							method : aE.cancelMethod || function() {
								aG.close()
							}
						}) : "confirm")
					}
					aG.set({
						isHideTitle : false,
						title : aE.title || "提示",
						content : '<div class="alert-dlg">' + aH + "</div>",
						width : 450,
						buttons : aF
					}).open()
				},
				alertGuideChange : function(aE, aD) {
				},
				alertSNSError : function(aD) {
					var aE = [];
					if (aD.ap_douban) {
						aE.push("豆瓣")
					}
					if (aD.ap_weibo) {
						aE.push("微博")
					}
					ai
							.alert("<p>由于授权过期，刚才发表的内容无法分享到"
									+ aE.join("、")
									+ "，请重新授权：</p><p>"
									+ (aD.ap_douban
											&& '<a href="/accounts/oauth_login_request?source=ap_douban" target="_blank" style="margin:0 10px">豆瓣账号授权</a>' || "")
									+ (aD.ap_weibo
											&& '<a href="/accounts/oauth_login_request?source=ap_weibo" target="_blank" style="margin:0 10px">微博账号授权</a>' || "")
									+ "</p>")
				},
				alertAnonuserPost : function() {
					ai.alert("你目前的身份是游客，无法在城内发表任何言论和互动。请先登录。", function() {
						setTimeout(function() {
							ai.showLoginbox()
						}, 10)
					}, {
						title : "请登录",
						confirmText : "登录"
					})
				},
				alertArchivedActivity : function(aD) {
					ai.alert(y
							.convertTpl("tplActivityPoster", aD.activity_info),
							function() {
								window.location = aD.content_url
							}, {
								title : "查看活动存档页",
								confirmText : "去看看",
								cancelText : "取消"
							})
				},
				changeMode : function(aG, aF) {
					var aH = aG || this._layerMode, aE = aq[aH];
					if (!aE) {
						return false
					}
					if (aE[1] && ai.host === aE[1] && !al.opened) {
						this.showLoading();
						if (this.layerModeCode === aE[0]) {
							this.layerModeCode = 0
						} else {
							this.layerModeCode = aE[0]
						}
						f.changeMode(this.layerModeCode);
						E.fire("viewport:update");
						if (aH) {
							E.fire(aH, [ aE ])
						}
						this._layerMode = aG;
						if (!aF) {
							var aD = an(".shop", f.activity[f.vision].dom)[1];
							if (aD) {
								aF = (/place\-\d+\-(\d+)/.exec(aD.className) || [])[1]
							}
						}
						aE[1].reset().then(function() {
							if (aF) {
								f.moveToPlace(aF)
							}
							ai.hideLoading()
						})
					} else {
						ai.alert(aE[2])
					}
				},
				showMyCard : function(aD) {
					E.fire("card:info", [ aD, "citizen",
							this.userbar.find(".myinfo").offset() ])
				},
				town : f,
				sound : b,
				shop : t,
				house : N,
				citizen : ak,
				card : R,
				widget : v,
				dialog : z,
				growl : l,
				newbie : Y,
				guide : X,
				fullmap : al,
				dashboard : m,
				sidebar : r,
				sonorus : af,
				searchbar : i,
				suggester : J()
			};
			return ai
		});