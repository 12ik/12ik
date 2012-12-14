/*
 * jQuery resize event - v1.1 - 3/14/2010
 * http://benalman.com/projects/jquery-resize-plugin/
 * 
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */
(function($, h, c) {
    var a = $([]),
    e = $.resize = $.extend($.resize, {}),
    i,
    k = "setTimeout",
    j = "resize",
    d = j + "-special-event",
    b = "delay",
    f = "throttleWindow";
    e[b] = 250;
    e[f] = true;
    $.event.special[j] = {
        setup: function() {
            if (!e[f] && this[k]) {
                return false
            }
            var l = $(this);
            a = a.add(l);
            $.data(this, d, {
                w: l.width(),
                h: l.height()
            });
            if (a.length === 1) {
                g()
            }
        },
        teardown: function() {
            if (!e[f] && this[k]) {
                return false
            }
            var l = $(this);
            a = a.not(l);
            l.removeData(d);
            if (!a.length) {
                clearTimeout(i)
            }
        },
        add: function(l) {
            if (!e[f] && this[k]) {
                return false
            }
            var n;
            function m(s, o, p) {
                var q = $(this),
                r = $.data(this, d);
                r.w = o !== c ? o: q.width();
                r.h = p !== c ? p: q.height();
                n.apply(this, arguments)
            }
            if ($.isFunction(l)) {
                n = l;
                return m
            } else {
                n = l.handler;
                l.handler = m
            }
        }
    };
    function g() {
        i = h[k](function() {
            a.each(function() {
                var n = $(this),
                m = n.width(),
                l = n.height(),
                o = $.data(this, d);
                if (m !== o.w || l !== o.h) {
                    n.trigger(j, [o.w = m, o.h = l])
                }
            });
            g()
        },
        e[b])
    }
})(jQuery, this);
/*
 * jQuery hashchange event - v1.3 - 7/21/2010
 * http://benalman.com/projects/jquery-hashchange-plugin/
 * 
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */
(function($, e, b) {
    var c = "hashchange",
    h = document,
    f, g = $.event.special,
    i = h.documentMode,
    d = "on" + c in e && (i === b || i > 7);
    function a(j) {
        j = j || location.href;
        return "#" + j.replace(/^[^#]*#?(.*)$/, "$1")
    }
    $.fn[c] = function(j) {
        return j ? this.bind(c, j) : this.trigger(c)
    };
    $.fn[c].delay = 50;
    g[c] = $.extend(g[c], {
        setup: function() {
            if (d) {
                return false
            }
            $(f.start)
        },
        teardown: function() {
            if (d) {
                return false
            }
            $(f.stop)
        }
    });
    f = (function() {
        var j = {},
        p, m = a(),
        k = function(q) {
            return q
        },
        l = k,
        o = k;
        j.start = function() {
            p || n()
        };
        j.stop = function() {
            p && clearTimeout(p);
            p = b
        };
        function n() {
            var r = a(),
            q = o(m);
            if (r !== m) {
                l(m = r, q);
                $(e).trigger(c)
            } else {
                if (q !== m) {
                    location.href = location.href.replace(/#.*/, "") + q
                }
            }
            p = setTimeout(n, $.fn[c].delay)
        }
        return j
    })()
})(jQuery, this); (function(e, b) {
    function d() {}
    function t(C) {
        c = [C]
    }
    function m(C) {
        f.insertBefore(C, f.firstChild)
    }
    function l(E, C, D) {
        return E && E.apply(C.context || C, D)
    }
    function k(C) {
        return new RegExp(/\?/).test(C) ? "&": "?"
    }
    var n = "async",
    s = "charset",
    q = "",
    A = "error",
    r = "_jqjsp",
    w = "on",
    o = w + "click",
    p = w + A,
    a = w + "load",
    i = w + "readystatechange",
    z = "removeChild",
    g = "<script/>",
    v = "success",
    y = "timeout",
    x = e.browser,
    f = e("head")[0] || document.documentElement,
    u = {},
    j = 0,
    c,
    h = {
        callback: r,
        url: location.href
    };
    function B(C) {
        C = e.extend({},
        h, C);
        var Q = C.complete,
        E = C.dataFilter,
        M = C.callbackParameter,
        R = C.callback,
        G = C.cache,
        J = C.pageCache,
        I = C.charset,
        D = C.url,
        L = C.data,
        P = C.timeout,
        O, K = 0,
        H = d;
        C.abort = function() { ! K++&&H()
        };
        if (l(C.beforeSend, C, [C]) === false || K) {
            return C
        }
        D = D || q;
        L = L ? ((typeof L) == "string" ? L: e.param(L, C.traditional)) : q;
        D += L ? (k(D) + L) : q;
        M && (D += k(D) + encodeURIComponent(M) + "=?"); ! G && !J && (D += k(D) + "_" + (new Date()).getTime() + "=");
        D = D.replace(/=\?(&|$)/, "=" + R + "$1");
        function N(S) { ! K++&&b(function() {
                H();
                J && (u[D] = {
                    s: [S]
                });
                E && (S = E.apply(C, [S]));
                l(C.success, C, [S, v]);
                l(Q, C, [C, v])
            },
            0)
        }
        function F(S) { ! K++&&b(function() {
                H();
                J && S != y && (u[D] = S);
                l(C.error, C, [C, S]);
                l(Q, C, [C, S])
            },
            0)
        }
        J && (O = u[D]) ? (O.s ? N(O.s[0]) : F(O)) : b(function(T, S, U) {
            if (!K) {
                U = P > 0 && b(function() {
                    F(y)
                },
                P);
                H = function() {
                    U && clearTimeout(U);
                    T[i] = T[o] = T[a] = T[p] = null;
                    f[z](T);
                    S && f[z](S)
                };
                window[R] = t;
                T = e(g)[0];
                T.id = r + j++;
                if (I) {
                    T[s] = I
                }
                function V(W) { (T[o] || d)();
                    W = c;
                    c = undefined;
                    W ? N(W[0]) : F(A)
                }
                if (x.msie) {
                    T.event = o;
                    T.htmlFor = T.id;
                    T[i] = function() {
                        T.readyState == "loaded" && V()
                    }
                } else {
                    T[p] = T[a] = V;
                    x.opera ? ((S = e(g)[0]).text = "jQuery('#" + T.id + "')[0]." + p + "()") : T[n] = n
                }
                T.src = D;
                m(T);
                S && m(S)
            }
        },
        0);
        return C
    }
    B.setup = function(C) {
        e.extend(h, C)
    };
    e.jsonp = B
})(jQuery, setTimeout); (function(a) {
    a.fn.appear = function(d, b) {
        var c = a.extend({
            data: undefined,
            one: true,
            offscreen_padding: 0
        },
        b);
        return this.each(function() {
            var g = a(this);
            g.appeared = false;
            if (!d) {
                g.trigger("appear", c.data);
                return
            }
            var f = a(window);
            var e = function() {
                if (!g.is(":visible")) {
                    g.appeared = false;
                    return
                }
                var k = f.scrollLeft();
                var j = f.scrollTop();
                var l = g.offset();
                var i = l.left;
                var m = l.top;
                if (m + g.height() >= j && m <= j + f.height() && i + g.width() >= k && i <= k + f.width() + c.offscreen_padding) {
                    if (!g.appeared) {
                        g.trigger("appear", c.data)
                    }
                } else {
                    g.appeared = false
                }
            };
            var h = function() {
                g.appeared = true;
                if (c.one) {
                    f.unbind("scroll", e);
                    var j = a.inArray(e, a.fn.appear.checks);
                    if (j >= 0) {
                        a.fn.appear.checks.splice(j, 1)
                    }
                }
                d.apply(this, arguments)
            };
            if (c.one) {
                g.one("appear", c.data, h)
            } else {
                g.bind("appear", c.data, h)
            }
            f.scroll(e);
            a.fn.appear.checks.push(e); (e)()
        })
    };
    a.extend(a.fn.appear, {
        checks: [],
        timeout: null,
        checkAll: function() {
            var b = a.fn.appear.checks.length;
            if (b > 0) {
                while (b--) { (a.fn.appear.checks[b])()
                }
            }
        },
        run: function() {
            if (a.fn.appear.timeout) {
                clearTimeout(a.fn.appear.timeout)
            }
            a.fn.appear.timeout = setTimeout(a.fn.appear.checkAll, 20)
        }
    });
    a.each(["append", "prepend", "after", "before", "attr", "removeAttr", "addClass", "removeClass", "toggleClass", "remove", "css", "show", "hide"],
    function(c, d) {
        var b = a.fn[d];
        if (b) {
            a.fn[d] = function() {
                var e = b.apply(this, arguments);
                a.fn.appear.run();
                return e
            }
        }
    })
})(jQuery); (function(v, H) {
    var w = {
        transition: "elastic",
        speed: 200,
        width: 550,
        initialWidth: 550,
        innerWidth: false,
        maxWidth: false,
        height: 72,
        initialHeight: 72,
        innerHeight: false,
        maxHeight: false,
        scalePhotos: true,
        scrolling: false,
        inline: false,
        html: false,
        iframe: false,
        photo: false,
        href: false,
        title: false,
        rel: false,
        opacity: 0.8,
        preloading: true,
        close: "脳",
        open: false,
        returnFocus: true,
        onOpen: false,
        onLoad: false,
        onComplete: false,
        onCleanup: false,
        onClosed: false,
        overlayClose: true,
        escKey: true,
        arrowKey: true,
        fixed: false,
    },
    p = "colorbox",
    E = "cbox",
    G = E + "_open",
    d = E + "_load",
    F = E + "_complete",
    l = E + "_cleanup",
    L = E + "_closed",
    g = E + "_purge",
    C = E + "_loaded",
    m = v.browser.msie && !v.support.opacity,
    O = m && v.browser.version < 7,
    K = E + "_IE6",
    D,
    P,
    Q,
    c,
    b,
    J,
    z,
    i,
    f,
    q,
    o,
    R,
    j,
    h,
    a,
    n,
    u,
    M,
    s,
    I,
    y = false,
    x,
    k = E + "Element";
    function B(T, S) {
        T = T ? ' id="' + E + T + '"': "";
        S = S ? ' style="' + S + '"': "";
        return v("<div" + T + S + "/>")
    }
    function A(S, T) {
        T = T === "x" ? J.width() : J.height();
        return (typeof S === "string") ? Math.round((/%/.test(S) ? (T / 100) * parseInt(S, 10) : parseInt(S, 10))) : S
    }
    function r(S) {
        return M.photo || /\.(gif|png|jpg|jpeg|bmp)(?:\?([^#]*))?(?:#(\.*))?$/i.test(S)
    }
    function N(T) {
        for (var S in T) {
            if (v.isFunction(T[S]) && S.substring(0, 2) !== "on") {
                T[S] = T[S].call(n)
            }
        }
        T.rel = T.rel || n.rel || "nofollow";
        T.href = T.href || v(n).attr("href");
        T.title = T.title || n.title;
        return T
    }
    function t(S, T) {
        if (T) {
            T.call(n)
        }
        v.event.trigger(S)
    }
    function e(S) {
        if (!y) {
            n = S;
            M = N(v.extend({},
            v.data(n, p)));
            b = v(n);
            u = 0;
            if (M.rel !== "nofollow") {
                b = v("." + k).filter(function() {
                    var U = v.data(this, p).rel || this.rel;
                    return (U === M.rel)
                });
                u = b.index(n);
                if (u === -1) {
                    b = b.add(n);
                    u = b.length - 1
                }
            }
            if (!s) {
                s = I = true;
                P.show();
                if (M.returnFocus) {
                    try {
                        n.blur();
                        v(n).one(L,
                        function() {
                            try {
                                this.focus()
                            } catch(U) {}
                        })
                    } catch(T) {}
                }
                D.css({
                    opacity: +M.opacity,
                    cursor: M.overlayClose ? "pointer": "auto"
                }).show();
                M.w = A(M.initialWidth, "x");
                M.h = A(M.initialHeight, "y");
                x.position(0);
                if (O) {
                    J.bind("resize." + K + " scroll." + K,
                    function() {
                        D.css({
                            width: J.width(),
                            height: J.height(),
                            top: J.scrollTop(),
                            left: J.scrollLeft()
                        })
                    }).trigger("scroll." + K)
                }
                t(G, M.onOpen);
                q.html(M.close).show()
            }
            x.load(true)
        }
    }
    x = v.fn[p] = v[p] = function(S, V) {
        var T = this,
        U;
        if (!T[0] && T.selector) {
            return T
        }
        S = S || {};
        if (V) {
            S.onComplete = V
        }
        if (!T[0] || T.selector === undefined) {
            T = v("<a/>");
            S.open = true
        }
        T.each(function() {
            v.data(this, p, v.extend({},
            v.data(this, p) || w, S));
            v(this).addClass(k)
        });
        U = S.open;
        if (v.isFunction(U)) {
            U = U.call(T)
        }
        if (U) {
            e(T[0])
        }
        return T
    };
    x.init = function() {
        J = v(H);
        P = B().attr({
            id: p,
            "class": m ? E + "IE": ""
        });
        D = B("Overlay", O ? "position:absolute": "").hide();
        Q = B("Wrapper");
        c = B("Content").append(z = B("LoadedContent", "width:0; height:0; overflow:hidden"), f = B("LoadingOverlay").add(B("LoadingGraphic")), q = B("Close"));
        Q.append(c);
        i = B(false, "position:absolute; width:9999px; visibility:hidden; display:none");
        v("body").prepend(D, P.append(Q, i));
        c.children().hover(function() {
            v(this).addClass("hover")
        },
        function() {
            v(this).removeClass("hover")
        }).addClass("hover");
        R = c.outerHeight(true) - c.height();
        j = c.outerWidth(true) - c.width();
        h = z.outerHeight(true);
        a = z.outerWidth(true);
        P.css({
            "padding-bottom": R,
            "padding-right": j
        }).hide();
        q.click(x.close);
        c.children().removeClass("hover");
        v("." + k).live("click",
        function(S) {
            if (! ((S.button !== 0 && typeof S.button !== "undefined") || S.ctrlKey || S.shiftKey || S.altKey)) {
                S.preventDefault();
                e(this)
            }
        });
        D.click(function() {
            if (M.overlayClose) {
                x.close()
            }
        });
        v(document).bind("keydown",
        function(S) {
            if (s && M.escKey && S.keyCode === 27) {
                S.preventDefault();
                x.close()
            }
        })
    };
    x.remove = function() {
        P.add(D).remove();
        v("." + k).die("click").removeData(p).removeClass(k)
    };
    x.position = function(V, Y) {
        var S, ac = 0,
        U = 0,
        Z = P.offset(),
        T = J.scrollTop(),
        W = J.scrollLeft(),
        aa = Math.max(document.documentElement.clientHeight - M.h - h - R, 0) / 2 + J.scrollTop(),
        X = Math.max(J.width() - M.w - a - j, 0) / 2 + J.scrollLeft();
        S = (P.width() === M.w + a && P.height() === M.h + h) ? 0 : V;
        if (M.fixed && !O) {
            aa = aa - T;
            P.css("position", "fixed")
        }
        Q[0].style.width = Q[0].style.height = "9999px";
        function ab(ad) {
            c[0].style.width = ad.style.width;
            f[0].style.height = f[1].style.height = c[0].style.height = ad.style.height
        }
        P.dequeue().animate({
            width: M.w + a,
            height: M.h + h,
            top: aa,
            left: X
        },
        {
            duration: S,
            complete: function() {
                ab(this);
                I = false;
                Q[0].style.width = (M.w + a + j) + "px";
                Q[0].style.height = (M.h + h + R) + "px";
                if (Y) {
                    Y()
                }
            },
            step: function() {
                ab(this)
            }
        })
    };
    x.resize = function(S) {
        if (s) {
            S = S || {};
            if (S.width) {
                M.w = A(S.width, "x") - a - j
            }
            if (S.innerWidth) {
                M.w = A(S.innerWidth, "x")
            }
            z.css({
                width: M.w
            });
            if (S.height) {
                M.h = A(S.height, "y") - h - R
            }
            if (S.innerHeight) {
                M.h = A(S.innerHeight, "y")
            }
            if (!S.innerHeight && !S.height) {
                var T = z.wrapInner("<div style='overflow:auto'></div>").children();
                M.h = T.height();
                T.replaceWith(T.children())
            }
            z.css({
                height: M.h
            });
            x.position(M.transition === "none" ? 0 : M.speed)
        }
    };
    x.resizeIframe = function(T, S) {
        if (!s) {
            return
        }
        var U = M.transition === "none" ? 0 : M.speed;
        M.h = T || M.h;
        M.w = S || M.w;
        z.css({
            width: M.w,
            height: M.h
        });
        x.position(U)
    };
    x.prep = function(V) {
        if (!s) {
            return
        }
        var U, W = M.transition === "none" ? 0 : M.speed;
        J.unbind("resize." + E);
        z.remove();
        z = B("LoadedContent").html(V);
        function S() {
            M.w = M.w || z.width();
            M.w = M.mw && M.mw < M.w ? M.mw: M.w;
            return M.w
        }
        function X() {
            M.h = M.h || z.height();
            M.h = M.mh && M.mh < M.h ? M.mh: M.h;
            return M.h
        }
        z.hide().appendTo(i.show()).css({
            width: S(),
            overflow: M.scrolling ? "auto": "hidden"
        }).css({
            height: X()
        }).prependTo(c);
        i.hide();
        v("#" + E + "Photo").css({
            cssFloat: "none",
            marginLeft: "auto",
            marginRight: "auto"
        });
        if (O) {
            v("select").not(P.find("select")).filter(function() {
                return this.style.visibility !== "hidden"
            }).css({
                visibility: "hidden"
            }).one(l,
            function() {
                this.style.visibility = "inherit"
            })
        }
        function T(ab) {
            var ad, ae, aa, Z, ac = b.length,
            Y = M.loop;
            x.position(ab,
            function() {
                function af() {
                    if (m) {
                        P[0].style.filter = false
                    }
                }
                if (!s) {
                    return
                }
                if (m) {
                    if (U) {
                        z.fadeIn(100)
                    }
                }
                z.show();
                t(C);
                f.hide();
                if (M.transition === "fade") {
                    P.fadeTo(W, 1,
                    function() {
                        af()
                    })
                } else {
                    af()
                }
                J.bind("resize." + E,
                function() {
                    x.position(0)
                });
                t(F, M.onComplete)
            })
        }
        if (M.transition === "fade") {
            P.fadeTo(W, 0,
            function() {
                T(0)
            })
        } else {
            T(W)
        }
    };
    x.load = function(V) {
        var U, T, W, S = x.prep;
        I = true;
        n = b[u];
        if (!V) {
            M = N(v.extend({},
            v.data(n, p)))
        }
        t(g);
        t(d, M.onLoad);
        M.h = M.height ? A(M.height, "y") - h - R: M.innerHeight && A(M.innerHeight, "y");
        M.w = M.width ? A(M.width, "x") - a - j: M.innerWidth && A(M.innerWidth, "x");
        M.mw = M.w;
        M.mh = M.h;
        if (M.maxWidth) {
            M.mw = A(M.maxWidth, "x") - a - j;
            M.mw = M.w && M.w < M.mw ? M.w: M.mw
        }
        if (M.maxHeight) {
            M.mh = A(M.maxHeight, "y") - h - R;
            M.mh = M.h && M.h < M.mh ? M.h: M.mh
        }
        U = M.href;
        f.show();
        if (M.inline) {
            B().hide().insertBefore(v(U)[0]).one(g,
            function() {
                v(this).replaceWith(z.children())
            });
            S(v(U))
        } else {
            if (M.iframe) {
                P.one(C,
                function() {
                    var X = v("<iframe name='" + new Date().getTime() + "' frameborder=0" + (M.scrolling ? "": " scrolling='no'") + (m ? " allowtransparency='true'": "") + " style='width:100%; height:100%; border:0; display:block;'/>");
                    X[0].src = M.href;
                    X.appendTo(z).one(g,
                    function() {
                        X[0].src = "//about:blank"
                    })
                });
                S(" ")
            } else {
                if (M.html) {
                    S(M.html)
                } else {
                    if (r(U)) {
                        T = new Image();
                        T.onload = function() {
                            var X;
                            T.onload = null;
                            T.id = E + "Photo";
                            v(T).css({
                                border: "none",
                                display: "block",
                                cssFloat: "left"
                            });
                            if (M.scalePhotos) {
                                W = function() {
                                    T.height -= T.height * X;
                                    T.width -= T.width * X
                                };
                                if (M.mw && T.width > M.mw) {
                                    X = (T.width - M.mw) / T.width;
                                    W()
                                }
                                if (M.mh && T.height > M.mh) {
                                    X = (T.height - M.mh) / T.height;
                                    W()
                                }
                            }
                            if (M.h) {
                                T.style.marginTop = Math.max(M.h - T.height, 0) / 2 + "px"
                            }
                            if (b[1] && (u < b.length - 1 || M.loop)) {
                                v(T).css({
                                    cursor: "pointer"
                                }).click(x.next)
                            }
                            if (m) {
                                T.style.msInterpolationMode = "bicubic"
                            }
                            setTimeout(function() {
                                S(T)
                            },
                            1)
                        };
                        setTimeout(function() {
                            T.src = U
                        },
                        1)
                    } else {
                        if (U) {
                            i.load(U,
                            function(Y, X, Z) {
                                S(X === "error" ? "Request unsuccessful: " + Z.statusText: v(this).children())
                            })
                        }
                    }
                }
            }
        }
    };
    x.close = function() {
        if (s && !y) {
            y = true;
            s = false;
            t(l, M.onCleanup);
            J.unbind("." + E + " ." + K);
            D.fadeTo("fast", 0);
            P.stop().fadeTo("fast", 0,
            function() {
                t(g);
                z.remove();
                P.add(D).css({
                    opacity: 1,
                    cursor: "auto"
                }).hide();
                setTimeout(function() {
                    y = false;
                    t(L, M.onClosed)
                },
                1)
            })
        }
    };
    x.element = function() {
        return v(n)
    };
    x.settings = w;
    v(x.init)
} (jQuery, this));
/*
 * jQuery idleTimer plugin
 * version 0.9.100511
 * by Paul Irish.
 *   http://github.com/paulirish/yui-misc/tree/
 * MIT license

 * adapted from YUI idle timer by nzakas:
 *   http://github.com/nzakas/yui-misc/
 *
 * edited by Phil Tobias
*/
(function(a) {
    a.idleTimer = function(j, c) {
        var d = false,
        g = true,
        h = 30000,
        k = "DOMMouseScroll mousewheel mousedown touchstart touchmove";
        c = c || document;
        var f = function(o) {
            if (typeof o === "number") {
                o = undefined
            }
            var n = a.data(o || c, "idleTimerObj");
            n.idle = !n.idle;
            var l = ( + new Date()) - n.olddate;
            n.olddate = +new Date();
            if (n.idle && (l < h)) {
                n.idle = false;
                clearTimeout(a.idleTimer.tId);
                if (g) {
                    a.idleTimer.tId = setTimeout(f, h)
                }
                return
            }
            var m = jQuery.Event(a.data(c, "idleTimer", n.idle ? "idle": "active") + ".idleTimer");
            a(c).trigger(m)
        },
        i = function(l) {
            var m = a.data(l, "idleTimerObj");
            m.enabled = false;
            clearTimeout(m.tId);
            a(l).off(".idleTimer")
        },
        b = function(m) {
            var l = a.data(this, "idleTimerObj");
            clearTimeout(l.tId);
            if (l.enabled) {
                if (l.idle) {
                    f(this)
                }
                l.tId = setTimeout(f, l.timeout)
            }
        };
        var e = a.data(c, "idleTimerObj") || {};
        e.olddate = e.olddate || +new Date();
        if (typeof j === "number") {
            h = j
        } else {
            if (j === "destroy") {
                i(c);
                return this
            } else {
                if (j === "getElapsedTime") {
                    return ( + new Date()) - e.olddate
                }
            }
        }
        a(c).on(a.trim((k + " ").split(" ").join(".idleTimer ")), b);
        a(c).on("mousemove",
        function(l) {
            if (l.pageX != e.mX || l.pageY != e.mY) {
                e.mX = l.pageX;
                e.mY = l.pageY;
                a(c).trigger("mousewheel")
            }
        });
        e.idle = d;
        e.enabled = g;
        e.timeout = h;
        e.tId = setTimeout(f, e.timeout);
        a.data(c, "idleTimer", "active");
        a.data(c, "idleTimerObj", e)
    };
    a.fn.idleTimer = function(b) {
        if (this[0]) {
            a.idleTimer(b, this[0])
        }
        return this
    }
})(jQuery); (function() {
    var b = (/msie/i).test(navigator.userAgent) && !(/opera/i).test(navigator.userAgent);
    var a = window.soundcloud = {
        version: "0.1",
        debug: false,
        _listeners: [],
        _redispatch: function(c, n, g) {
            var j, m = this._listeners[c] || [],
            d = "soundcloud:" + c;
            try {
                j = this.getPlayer(n)
            } catch(k) {
                if (this.debug && window.console) {
                    console.error("unable to dispatch widget event " + c + " for the widget id " + n, g, k)
                }
                return
            }
            if (window.jQuery) {
                jQuery(j).trigger(d, [g])
            } else {
                if (window.Prototype) {
                    $(j).fire(d, g)
                } else {}
            }
            for (var h = 0,
            f = m.length; h < f; h += 1) {
                m[h].apply(j, [j, g])
            }
            if (this.debug && window.console) {
                console.log(d, c, n, g)
            }
        },
        addEventListener: function(c, d) {
            if (!this._listeners[c]) {
                this._listeners[c] = []
            }
            this._listeners[c].push(d)
        },
        removeEventListener: function(e, g) {
            var f = this._listeners[e] || [];
            for (var d = 0,
            c = f.length; d < c; d += 1) {
                if (f[d] === g) {
                    f.splice(d, 1)
                }
            }
        },
        getPlayer: function(f) {
            var c;
            try {
                if (!f) {
                    throw "The SoundCloud Widget DOM object needs an id atribute, please refer to SoundCloud Widget API documentation."
                }
                c = b ? window[f] : document[f];
                if (c) {
                    if (c.api_getFlashId) {
                        return c
                    } else {
                        throw "The SoundCloud Widget External Interface is not accessible. Check that allowscriptaccess is set to 'always' in embed code"
                    }
                } else {
                    throw "The SoundCloud Widget with an id " + f + " couldn't be found"
                }
            } catch(d) {
                if (console && console.error) {
                    console.error(d)
                }
                throw d
            }
        },
        onPlayerReady: function(c, d) {
            this._redispatch("onPlayerReady", c, d)
        },
        onMediaStart: function(c, d) {
            this._redispatch("onMediaStart", c, d)
        },
        onMediaEnd: function(c, d) {
            this._redispatch("onMediaEnd", c, d)
        },
        onMediaPlay: function(c, d) {
            this._redispatch("onMediaPlay", c, d)
        },
        onMediaPause: function(c, d) {
            this._redispatch("onMediaPause", c, d)
        },
        onMediaBuffering: function(c, d) {
            this._redispatch("onMediaBuffering", c, d)
        },
        onMediaSeek: function(c, d) {
            this._redispatch("onMediaSeek", c, d)
        },
        onMediaDoneBuffering: function(c, d) {
            this._redispatch("onMediaDoneBuffering", c, d)
        },
        onPlayerError: function(c, d) {
            this._redispatch("onPlayerError", c, d)
        }
    }
})(); (function(f) {
    var B = function(I) {
        var J = function(K) {
            return {
                h: Math.floor(K / (60 * 60 * 1000)),
                m: Math.floor((K / 60000) % 60),
                s: Math.floor((K / 1000) % 60)
            }
        } (I),
        H = [];
        if (J.h > 0) {
            H.push(J.h)
        }
        H.push((J.m < 10 && J.h > 0 ? "0" + J.m: J.m));
        H.push((J.s < 10 ? "0" + J.s: J.s));
        return H.join(".")
    };
    var g = function(H) {
        H.sort(function() {
            return Math.round(Math.random())
        });
        return H
    };
    var w = true,
    c = false,
    l = f(document),
    k = function(H) {
        try {
            if (w && window.console && window.console.log) {
                window.console.log.apply(window.console, arguments)
            }
        } catch(I) {}
    },
    G = c ? "sandbox-soundcloud.com": "soundcloud.com",
    u = function(H, I) {
        return (/api\./.test(H) ? H + "?": "http://api." + G + "/resolve?url=" + H + "&") + "format=json&consumer_key=" + I + "&callback=?"
    };
    var j = function() {
        var I = function() {
            var M = false;
            try {
                var L = new Audio();
                M = L.canPlayType && (/maybe|probably/).test(L.canPlayType("audio/mpeg"));
                M = M && (/iPad|iphone|mobile|pre\//i).test(navigator.userAgent)
            } catch(N) {}
            return M
        } (),
        J = {
            onReady: function() {
                l.trigger("scPlayer:onAudioReady")
            },
            onPlay: function() {
                l.trigger("scPlayer:onMediaPlay")
            },
            onPause: function() {
                l.trigger("scPlayer:onMediaPause")
            },
            onEnd: function() {
                l.trigger("scPlayer:onMediaEnd")
            },
            onBuffer: function(L) {
                l.trigger({
                    type: "scPlayer:onMediaBuffering",
                    percent: L
                })
            }
        };
        var K = function() {
            var L = new Audio(),
            M = function(P) {
                var Q = P.target,
                O = ((Q.buffered.length && Q.buffered.end(0)) / Q.duration) * 100;
                J.onBuffer(O);
                if (Q.currentTime === Q.duration) {
                    J.onEnd()
                }
            },
            N = function(P) {
                var Q = P.target,
                O = ((Q.buffered.length && Q.buffered.end(0)) / Q.duration) * 100;
                J.onBuffer(O)
            };
            f('<div class="sc-player-engine-container"></div>').appendTo(document.body).append(L);
            L.addEventListener("play", J.onPlay, false);
            L.addEventListener("pause", J.onPause, false);
            L.addEventListener("ended", J.onEnd, false);
            L.addEventListener("timeupdate", M, false);
            L.addEventListener("progress", N, false);
            return {
                load: function(O, P) {
                    L.pause();
                    L.src = O.stream_url + "?consumer_key=" + P;
                    L.load();
                    L.play()
                },
                play: function() {
                    L.play()
                },
                pause: function() {
                    L.pause()
                },
                stop: function() {
                    L.currentTime = 0;
                    L.pause()
                },
                seek: function(O) {
                    L.currentTime = L.duration * O;
                    L.play()
                },
                getDuration: function() {
                    return L.duration
                },
                getPosition: function() {
                    return L.currentTime
                },
                setVolume: function(O) {
                    if (a) {
                        a.volume = O / 100
                    }
                }
            }
        };
        var H = function() {
            var L = "scPlayerEngine",
            M, N = function(O) {
                var P = "http://player." + G + "/player.swf?url=" + O + "&amp;enable_api=true&amp;player_type=engine&amp;object_id=" + L;
                if (f.browser.msie) {
                    return '<object height="100%" width="100%" id="' + L + '" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" data="' + P + '"><param name="movie" value="' + P + '" /><param name="allowscriptaccess" value="always" /></object>'
                } else {
                    return '<object height="100%" width="100%" id="' + L + '"><embed allowscriptaccess="always" height="100%" width="100%" src="' + P + '" type="application/x-shockwave-flash" name="' + L + '" /></object>'
                }
            };
            soundcloud.addEventListener("onPlayerReady",
            function(O, P) {
                M = soundcloud.getPlayer(L);
                J.onReady()
            });
            soundcloud.addEventListener("onMediaEnd", J.onEnd);
            soundcloud.addEventListener("onMediaBuffering",
            function(O, P) {
                J.onBuffer(P.percent)
            });
            soundcloud.addEventListener("onMediaPlay", J.onPlay);
            soundcloud.addEventListener("onMediaPause", J.onPause);
            return {
                load: function(O) {
                    var P = O.permalink_url;
                    if (M) {
                        M.api_load(P)
                    } else {
                        f('<div class="sc-player-engine-container"></div>').appendTo(document.body).html(N(P))
                    }
                },
                play: function() {
                    M && M.api_play()
                },
                pause: function() {
                    M && M.api_pause()
                },
                stop: function() {
                    M && M.api_stop()
                },
                seek: function(O) {
                    M && M.api_seekTo((M.api_getTrackDuration() * O))
                },
                getDuration: function() {
                    return M && M.api_getTrackDuration && M.api_getTrackDuration() * 1000
                },
                getPosition: function() {
                    return M && M.api_getTrackPosition && M.api_getTrackPosition() * 1000
                },
                setVolume: function(O) {
                    if (M && M.api_setVolume) {
                        M.api_setVolume(O)
                    }
                }
            }
        };
        return I ? K() : H()
    } ();
    var E, t = false,
    d = [],
    p = {},
    D,
    m = function(L, H, J) {
        var I = 0,
        M = {
            node: L,
            tracks: []
        },
        K = function(N) {
            f.getJSON(u(N.url, E),
            function(O) {
                I += 1;
                if (O.tracks) {
                    M.tracks = M.tracks.concat(O.tracks)
                } else {
                    if (O.duration) {
                        O.permalink_url = N.url;
                        M.tracks.push(O)
                    } else {
                        if (O.username) {
                            if (/favorites/.test(N.url)) {
                                H.push({
                                    url: O.uri + "/favorites"
                                })
                            } else {
                                H.push({
                                    url: O.uri + "/tracks"
                                })
                            }
                        } else {
                            if (f.isArray(O)) {
                                M.tracks = M.tracks.concat(O)
                            }
                        }
                    }
                }
                if (H[I]) {
                    K(H[I])
                } else {
                    M.node.trigger({
                        type: "onTrackDataLoaded.scPlayer",
                        playerObj: M
                    })
                }
            })
        };
        E = J;
        d.push(M);
        K(H[I])
    },
    h = function(H, I) {
        if (I) {
            return '<div class="sc-loading-artwork">Loading Artwork</div>'
        } else {
            if (H.artwork_url) {
                return '<img src="' + H.artwork_url.replace("-large", "-t300x300") + '"/>'
            } else {
                return '<div class="sc-no-artwork">No Artwork</div>'
            }
        }
    },
    y = function(I, H) {
        f(".sc-info", I).each(function(J) {
            f("h3", this).html('<a href="' + H.permalink_url + '">' + H.title + "</a>");
            f("h4", this).html('by <a href="' + H.user.permalink_url + '">' + H.user.username + "</a>");
            f("p", this).html(H.description || "no Description")
        });
        f(".sc-artwork-list li", I).each(function(L) {
            var J = f(this),
            K = J.data("sc-track");
            if (K === H) {
                J.addClass("sc_active").find(".sc-loading-artwork").each(function(M) {
                    f(this).removeClass("sc-loading-artwork").html(h(H, false))
                })
            } else {
                J.removeClass("sc_active")
            }
        });
        f(".sc-duration", I).html(B(H.duration));
        f(".sc-waveform-container", I).html('<img src="' + H.waveform_url + '" />');
        I.trigger("onPlayerTrackSwitch.scPlayer", [H])
    },
    C = function(H) {
        var I = H.permalink_url;
        if (D === I) {
            j.play()
        } else {
            D = I;
            j.load(H, E)
        }
    },
    s = function(H) {
        return d[f(H).data("sc-player").id]
    },
    r = function(I, H) {
        if (H) {
            f("div.sc-player.playing").removeClass("playing")
        }
        f(I).toggleClass("playing", H).trigger((H ? "onPlayerPlay": "onPlayerPause") + ".scPlayer")
    },
    v = function(I, J) {
        var H = s(I).tracks[J || 0];
        y(I, H);
        p = {
            $buffer: f(".sc-buffer", I),
            $played: f(".sc-played", I),
            position: f(".sc-position", I)[0]
        };
        r(I, true);
        C(H)
    },
    A = function(H) {
        r(H, false);
        j.pause()
    },
    F = function() {
        var H = p.$played.closest(".sc-player"),
        I;
        p.$played.css("width", "0%");
        p.position.innerHTML = B(0);
        r(H, false);
        j.stop();
        k("track finished get the next one");
        I = f(".sc-trackslist li.sc_active", H).next("li");
        if (!I.length) {
            I = H.nextAll("div.sc-player:first").find(".sc-trackslist li.sc_active")
        }
        I.click()
    },
    z = function(H, I) {
        j.seek(I)
    },
    n = function() {
        var J = 80,
        H = document.cookie.split(";"),
        K = new RegExp("scPlayer_volume=(\\d+)");
        for (var I in H) {
            if (K.test(H[I])) {
                J = parseInt(H[I].match(K)[1], 10);
                break
            }
        }
        return J
    } (),
    b = function(J) {
        var I = Math.floor(J);
        var H = new Date();
        H.setTime(H.getTime() + (365 * 24 * 60 * 60 * 1000));
        n = I;
        document.cookie = ["scPlayer_volume=", I, "; expires=", H.toUTCString(), '; path="/"'].join("");
        j.setVolume(n)
    },
    o;
    l.bind("scPlayer:onAudioReady",
    function(H) {
        j.play();
        b(n)
    }).bind("scPlayer:onMediaPlay",
    function(H) {
        clearInterval(o);
        o = setInterval(function() {
            var K = j.getDuration(),
            I = j.getPosition(),
            J = (I / K);
            p.$played.css("width", (100 * J) + "%");
            p.position.innerHTML = B(I);
            l.trigger({
                type: "onMediaTimeUpdate.scPlayer",
                duration: K,
                position: I,
                relative: J
            })
        },
        500)
    }).bind("scPlayer:onMediaPause",
    function(H) {
        clearInterval(o);
        o = null
    }).bind("scPlayer:onVolumeChange",
    function(H) {
        b(H.volume)
    }).bind("scPlayer:onMediaEnd",
    function(H) {
        F()
    }).bind("scPlayer:onMediaBuffering",
    function(H) {
        p.$buffer.css("width", H.percent + "%")
    });
    f.scPlayer = function(R, J) {
        var H = f.extend({},
        f.scPlayer.defaults, R),
        K = d.length,
        O = J && f(J),
        S = O[0].className.replace("sc-player", ""),
        P = H.links || f.map(f("a", O).add(O.filter("a")),
        function(T) {
            return {
                url: T.href,
                title: T.innerHTML
            }
        }),
        L = f('<div class="sc-player loading"></div>').data("sc-player", {
            id: K
        }),
        Q = f('<ol class="sc-artwork-list"></ol>').appendTo(L),
        I = f('<div class="sc-info"><h3></h3><h4></h4><p></p><a href="#" class="sc-info-close">X</a></div>').appendTo(L),
        N = f('<div class="sc-controls"></div>').appendTo(L),
        M = f('<ol class="sc-trackslist"></ol>').appendTo(L);
        if (S || H.customClass) {
            L.addClass(S).addClass(H.customClass)
        }
        L.find(".sc-controls").append('<a href="#play" class="sc-play">Play</a> <a href="#pause" class="sc-pause hidden">Pause</a>').end().append('<a href="#info" class="sc-info-toggle">Info</a>').append('<div class="sc-scrubber"></div>').find(".sc-scrubber").append('<div class="sc-volume-slider"><span class="sc-volume-status" style="width:' + n + '%"></span></div>').append('<div class="sc-time-span"><div class="sc-waveform-container"></div><div class="sc-buffer"></div><div class="sc-played"></div></div>').append('<div class="sc-time-indicators"><span class="sc-position"></span> | <span class="sc-duration"></span></div>');
        m(L, P, H.apiKey);
        L.bind("onTrackDataLoaded.scPlayer",
        function(U) {
            var T = U.playerObj.tracks;
            if (H.randomize) {
                T = g(T)
            }
            f.each(T,
            function(W, V) {
                var X = W === 0;
                f('<li><a href="' + V.permalink_url + '">' + V.title + '</a><span class="sc-track-duration">' + B(V.duration) + "</span></li>").data("sc-track", {
                    id: W
                }).toggleClass("sc_active", X).appendTo(M);
                f("<li></li>").append(h(V, W >= H.loadArtworks)).appendTo(Q).toggleClass("sc_active", X).data("sc-track", V)
            });
            L.removeClass("loading").trigger("onPlayerInit.scPlayer");
            L.each(function() {
                if (f.isFunction(H.beforeRender)) {
                    H.beforeRender.call(this, T)
                }
            });
            f(f(".sc-duration", L)[0]).html(B(T[0].duration));
            f(f(".sc-position", L)[0]).html(B(0));
            y(L, T[0]);
            if (H.autoPlay && !t) {
                v(L);
                t = true
            }
        });
        O.each(function(T) {
            f(this).replaceWith(L)
        });
        return L
    };
    f.scPlayer.stopAll = function() {
        f(".sc-player.playing a.sc-pause").click()
    };
    f.fn.scPlayer = function(H) {
        t = false;
        this.each(function() {
            f.scPlayer(H, this)
        });
        return this
    };
    f.scPlayer.defaults = f.fn.scPlayer.defaults = {
        customClass: null,
        beforeRender: function(H) {
            var I = f(this)
        },
        onDomReady: function() {
            f("a.sc-player, div.sc-player").scPlayer()
        },
        autoPlay: false,
        randomize: false,
        loadArtworks: 5,
        apiKey: "77ae5a57d4c1c6bc80b37e7e903c77cb"
    };
    f(".sc_active a").live("click",
    function() {
        window.open(f(this).attr("href"));
        return false
    });
    f("a.sc-play, a.sc-pause").live("click",
    function(I) {
        var H = f(this).closest(".sc-player").find("ol.sc-trackslist");
        H.find("li.sc_active").click();
        return false
    });
    f("a.sc-info-toggle, a.sc-info-close").live("click",
    function(I) {
        var H = f(this);
        H.closest(".sc-player").find(".sc-info").toggleClass("sc_active").end().find("a.sc-info-toggle").toggleClass("sc_active");
        return false
    });
    f(".sc-trackslist li").live("click",
    function(H) {
        var L = f(this),
        I = L.closest(".sc-player"),
        K = L.data("sc-track").id,
        J = I.is(":not(.playing)") || L.is(":not(.sc_active)");
        if (J) {
            v(I, K)
        } else {
            A(I)
        }
        L.addClass("sc_active").siblings("li").removeClass("sc_active");
        f(".artworks li", I).each(function(M) {
            f(this).toggleClass("sc_active", M === K)
        });
        return false
    });
    var q = function(K, N) {
        var J = f(K).closest(".sc-time-span"),
        I = J.find(".sc-buffer"),
        H = J.find(".sc-waveform-container img"),
        M = J.closest(".sc-player"),
        L = Math.min(I.width(), (N - H.offset().left)) / H.width();
        z(M, L)
    };
    var e = function(H) {
        if (H.targetTouches.length === 1) {
            q(H.target, H.targetTouches && H.targetTouches.length && H.targetTouches[0].clientX);
            H.preventDefault()
        }
    };
    f(".sc-time-span").live("click",
    function(H) {
        q(this, H.pageX);
        return false
    }).live("touchstart",
    function(H) {
        this.addEventListener("touchmove", e, false);
        H.originalEvent.preventDefault()
    }).live("touchend",
    function(H) {
        this.removeEventListener("touchmove", e, false);
        H.originalEvent.preventDefault()
    });
    var x = function(M, I) {
        var J = f(M),
        K = J.offset().left,
        H = J.width(),
        L = function(O) {
            return Math.floor(((O - K) / H) * 100)
        },
        N = function(O) {
            l.trigger({
                type: "scPlayer:onVolumeChange",
                volume: L(O.pageX)
            })
        };
        J.bind("mousemove.sc-player", N);
        N(I)
    };
    var i = function(I, H) {
        f(I).unbind("mousemove.sc-player")
    };
    f(".sc-volume-slider").live("mousedown",
    function(H) {
        x(this, H)
    }).live("mouseup",
    function(H) {
        i(this, H)
    });
    l.bind("scPlayer:onVolumeChange",
    function(H) {
        f("span.sc-volume-status").css({
            width: H.volume + "%"
        })
    });
    f(function() {
        if (f.isFunction(f.scPlayer.defaults.onDomReady)) {
            f.scPlayer.defaults.onDomReady()
        }
    })
})(jQuery);
if (typeof(console) == "undefined") {
    var console = {
        log: function() {}
    }
}
var tbwaClass = (function(d) {
    var c = {
        LINEAR_MODE: 1,
        GRID_MODE: 2,
        FULL_MODE: 3,
        BACKGROUND_COLORS: {
            light: "#ffffff",
            dark: "#0c0c0c",
            IFRAMED: {
                light: "#f8f8f8",
                dark: "#313131"
            }
        },
        BASE_URL: __BASEURL__,
        EMBED_MODE: {
            SMALL: 0,
            LARGE: 1,
            LARGE_MIN_SIZE: {
                WIDTH: 550,
                HEIGHT: 500
            }
        },
        ENABLE_HARDWARE_ACCELERATION: false,
        ENABLE_DRAGGING_MOBILE: true,
        ENABLE_DRAGGING_DESKTOP: false,
        FEED_ITEM_COUNTS: {
            TWEETS: {
                linear_mode: 10,
                grid_mode: 10,
                full_mode: 10
            }
        },
        FULLSCREEN_IMAGE: {
            width: 1024,
            full_height: 768,
            nav_height: 54,
            nav_width: 140
        },
        LINEAR_IMAGES: {
            width: 512
        },
        GRID_IMAGES: {
            width: 256,
            height: 214,
            margin_tb: 17,
            margin_lr: 48
        },
        IDLE_TIMER_SECONDS: 3,
        IMAGE_URL: {
            device: "",
            base: __ASSETSURL__.matrix,
            filmstrip: "filmstrip/",
            document: "document/",
            small: "grid/",
            medium: "linear/",
            large: "fullscreen/"
        },
        JSONP: {
            get: "/api/projeqt/get/",
            getDefault: "/api/projeqt/get_default/",
            getFeed: "/api/feeds/get/",
            searchResults: "/api/projeqt/search/",
            searchSuggestions: "/api/search/get/",
            token: "?t=" + __token__,
            timeout: 30000
        },
        MOUSE_THRESHOLD: 10,
        NUM_SLIDES_TO_LOAD: 10,
        NUM_IMAGES_TO_SHOW: {
            linear: 5,
            full: 5
        },
        OFFICE_MATCH_TERM: "Contact Us",
        OVERLAY: {
            ERROR: {
                width: 180,
                height: 135
            },
            HELP: {
                width: 349
            },
            SLIDEINFO: {
                width: 370
            }
        },
        PRELOAD: {
            linear: ["shell_loader.gif"],
            grid: ["shell_loader_small.gif"],
            fullscreen: ["shell_loader.gif"]
        },
        SEARCH: {
            autoSuggestTimeout: 500
        },
        SCRIPTS: {
            swfobject: "/shared/scripts/min/lib/swfobject.min.js"
        },
        SCROLL_EASING: "easeOutCirc",
        SCROLL_SPEED: {
            web: 500,
            mobile: 500
        },
        SHELL_OFFSETS: {
            linear: {
                width: 0
            },
            fullscreen: {
                width: 0,
                height: 0
            }
        },
        VIDEO_CONTROLS_HEIGHT: {
            vimeo: 0,
            youtube: 30,
            tudou: 0,
            youku: 0
        }
    };
    function a(e) {
        var j, g;
        g = function(k) {
            return k.split(".")
        };
        e = g(e);
        for (var f = 0,
        h = e.length; f < h; f++) {
            if (f > 0) {
                j = (j != undefined) ? j[e[f]] : null
            } else {
                j = c[e[f]] || null
            }
        }
        return j
    }
    function b(f) {
        var e = a("IMAGE_URL")["base"] + a("IMAGE_URL")["device"];
        switch (f) {
        case a("LINEAR_MODE"):
            e += a("IMAGE_URL")["medium"];
            break;
        case a("GRID_MODE"):
            e += a("IMAGE_URL")["small"];
            break;
        case a("FULL_MODE"):
            e += a("IMAGE_URL")["large"];
            break;
        case "filmstrip":
            e += a("IMAGE_URL")["filmstrip"];
            break;
        case "document":
            e = a("IMAGE_URL")["base"] + a("IMAGE_URL")["document"];
            break;
        default:
            throw new Error("Unknown user mode in getURL function.");
            return false
        }
        return e
    }
    return function() {
        var o = 0,
        j = 0,
        f = null,
        h = 0,
        m = false,
        n = null,
        k = null,
        e = {
            linear: false,
            grid: false,
            fullscreen: false
        };
        this.getConstant = function(p) {
            return a(p)
        };
        this.getURL = function(p) {
            return b(p)
        };
        this.application = {
            header: {
                init: function() {
                    this.titleBar.setTitle(g.header.searchBar.query ? "search": "navigation", true);
                    this.searchBar.init()
                },
                titleBar: {
                    setTitle: function(u, x) {
                        x = x || false;
                        var r = d(".title_bar:first"),
                        v = d("#title_bar_stories").find("ul"),
                        s = false,
                        y = [],
                        B,
                        t,
                        A,
                        q = 25 - 3,
                        p = n.breadcrumbs,
                        z = p.length;
                        if (x) {
                            v.children().remove()
                        }
                        switch (u) {
                        case "search":
                            s = true;
                        case "navigation":
                            if (z > 1) {
                                for (var w = 0; w < z; w++) {
                                    breadcrumb = p[w];
                                    B = d(g.htmlTemplates.titleBarTemplate);
                                    if (breadcrumb.name.length > q) {
                                        A = breadcrumb.name.match(new RegExp("^.{0," + q + "}"))[0];
                                        breadcrumb.name = A + "&hellip;"
                                    }
                                    B.find(".breadcrumb").attr("data-stack-id", breadcrumb.stack_id).find(".name").html(breadcrumb.name);
                                    if (breadcrumb.image && breadcrumb.image != "") {
                                        t = g.htmlTemplates.titleBarThumbTemplate;
                                        t = t.replaceVars({
                                            "image-src": b("filmstrip") + breadcrumb.image,
                                            name: breadcrumb.name
                                        });
                                        B.find(".thumb").remove().end().find(".thumb_over").after(t)
                                    }
                                    if (breadcrumb.type == "title" || breadcrumb.type == "text") {
                                        B.find(".thumb").removeClass("sprite_home sprite").addClass("text thumb_sprite").after(g.htmlTemplates.textContainerBg)
                                    }
                                    if (w + 1 == z) {
                                        B.addClass("last");
                                        g.$top_bar.find(".current").html(B.html())
                                    } else {
                                        B.removeClass("last")
                                    }
                                    y.push(B.wrap("div").parent().html())
                                }
                                v.append(y.join(""));
                                r.show()
                            } else {
                                r.hide()
                            }
                            if (s) {
                                r.addClass("search")
                            } else {
                                r.removeClass("search")
                            }
                            break
                        }
                    }
                },
                searchBar: {
                    query: "",
                    slideIndex: null,
                    init: function() {
                        d("#search_box").bind("lookup",
                        function(p, q) {
                            tbwa.application.header.searchBar.lookUp(q)
                        })
                    },
                    clear: function() {
                        this.query = "";
                        d("#search_box").find(".search_text").val("").trigger("blur");
                        d("#searchResultsWrapper").remove();
                        g.updateHash()
                    },
                    clearSuggestions: function() {
                        d("#search_box").find(".in_progress").removeClass("in_progress");
                        window.setTimeout(function() {
                            d("#searchResultsWrapper").remove()
                        },
                        300)
                    },
                    lookUp: function(q) {
                        var p = g.header.searchBar,
                        r = q;
                        if (typeof(q) === "undefined") {
                            return
                        }
                        p.query = d.trim(r);
                        if (p.query != "" && p.query.length <= 50) {
                            g.updateHash();
                            g.XHR.getJSON(a("JSONP.searchResults") + a("JSONP.token"), {
                                terms: p.query
                            },
                            function(t) {
                                n = t;
                                var s = n.slides.length;
                                g.activeSlide.id = (!s) ? 0 : n.slides[0].slide_id || "0" + n.slides[0].stack_id;
                                g.activeStack.id = 0;
                                g.activeSlide.index = (!s) ? null: 0;
                                g.activeSlide.relativePosition = 0;
                                if (g.getCurrentMode() === "full_mode") {
                                    g.$btn_linear_view.trigger("click")
                                } else {
                                    g.viewport.render();
                                    g.updateHash()
                                }
                                g.header.titleBar.setTitle("search", true)
                            })
                        }
                    },
                    suggest: function() {
                        var r = d("#search_box").find(".search_text"),
                        p = r.data("lastQuery"),
                        q = r.val();
                        r.data("lastQuery", q);
                        g.XHR.getJSON(a("JSONP.searchSuggestions") + a("JSONP.token"), {
                            terms: q
                        },
                        function(z) {
                            d("#search_box").find(".search_button").removeClass("in_progress");
                            var x = "",
                            t = d(g.htmlTemplates.searchResults),
                            y = z.terms,
                            v = y.length,
                            u = d("<li onclick='void(0)'></li>");
                            d("#searchResultsWrapper").remove();
                            for (var w = 0,
                            s = ""; w < v; w++) {
                                s = y[w].name.replace(new RegExp(q, "i"), "<strong>" + q + "</strong>");
                                x += u.html("<a href='#' class='result' onclick='void(0)'>" + s + "</a>").outerHTML()
                            }
                            t.find("ul").append(x);
                            d("#search_box").append(t)
                        })
                    }
                }
            },
            viewport: {
                windowHeight: 0,
                windowWidth: 0,
                documentHeight: 0,
                documentWidth: 0,
                backgroundColor: 0,
                numSlidesFillWidth: 0,
                init: function() {
                    if (__FB__) {
                        this.windowHeight = 800;
                        this.windowWidth = 810
                    } else {
                        this.windowHeight = g.$window.height();
                        this.windowWidth = g.$window.width()
                    }
                    this.documentHeight = g.$document.height();
                    this.documentWidth = g.$document.width();
                    if (window.navigator.standalone) {
                        g.$body.addClass("kiosk")
                    }
                    if (g.is_mobile) {
                        try {
                            window.scrollTo(0, 1)
                        } catch(p) {}
                    }
                },
                displayHelp: function() {
                    g.$footer.find(".help").trigger("click")
                },
                entranceAnimation: function() {
                    var r = d(".slide_container"),
                    s = r.find(".active");
                    switch (j) {
                    case a("LINEAR_MODE"):
                        if (s.length) {
                            var q = Math.floor((g.viewport.windowWidth / 2) - (s.width() / 2)),
                            p = s.position().left,
                            t = (q - p);
                            s.parents(".slides").css("left", t);
                            g.events.viewport.slide.loadSlideInfo.call(s, true);
                            if (d.browser.ie6 || d.browser.ie7 || d.browser.ie8) {
                                r.find(".shell_contents img").each(function() {
                                    this.style.filter = "alpha(opacity=100)";
                                    this.style.display = "block"
                                })
                            }
                        }
                        break;
                    case a("GRID_MODE"):
                        break;
                    case a("FULL_MODE"):
                        if (s.length) {
                            s.fadeIn();
                            g.events.viewport.slide.loadSlideInfo.call(s[0], true)
                        }
                        g.$top_bar.animate({
                            "margin-top": -30,
                            opacity: 0
                        });
                        g.$footer.add("#top_bar .logo").hide();
                        break
                    }
                },
                exitAnimation: function(p) {
                    p = (typeof p !== "undefined") ? p: o;
                    switch (p) {
                    case a("LINEAR_MODE"):
                        break;
                    case a("GRID_MODE"):
                        break;
                    case a("FULL_MODE"):
                        if (!__EMBED__) {
                            g.$top_bar.animate({
                                "margin-top": "+=30",
                                opacity: 1
                            });
                            g.$footer.add("#top_bar .logo").show()
                        }
                        break
                    }
                },
                render: function(w, q) {
                    if (g.isTBWA) {
                        if (n.stack.length && n.stack[0].name.toLowerCase() == a("OFFICE_MATCH_TERM").toLowerCase()) {
                            try {
                                tbwa.offices.init(n)
                            } catch(v) {
                                throw new Error("Function: Render. Unable to load TBWA Contact Us.")
                            }
                            return false
                        }
                    } else {
                        if (g.is_homepage_embed()) {
                            tbwa.homepage_embed.init()
                        }
                    }
                    var u = {
                        entranceAnimation: true
                    },
                    s = d("#content_area"),
                    r = d("#bg"),
                    p = d(".pagination");
                    w = w || u;
                    q = (typeof q === "boolean") ? q: true;
                    if (g.embedMode != a("EMBED_MODE.SMALL") && j === 0) {
                        g.setCurrentMode(a("LINEAR_MODE"));
                        g.$btn_linear_view.addClass("selected")
                    }
                    if (__EMBED__) {
                        if (g.embedMode == a("EMBED_MODE.SMALL") && j != a("GRID_MODE")) {
                            g.setCurrentMode(a("GRID_MODE"));
                            g.$btn_grid_view.addClass("selected")
                        } else {
                            if (g.embedMode != a("EMBED_MODE.SMALL") && j != a("LINEAR_MODE")) {
                                g.setCurrentMode(a("LINEAR_MODE"));
                                g.$btn_linear_view.addClass("selected")
                            }
                        }
                    }
                    g.$view_panel.find(".disabled").removeClass("disabled");
                    s.removeClass("offices");
                    s.children().not("#content_arrows").remove();
                    if (!w.isHideBreadcrumbs) {
                        if (p.hasClass("open")) {
                            if (p.hasClass("is-init")) {
                                p.removeClass("is-init")
                            } else {
                                p.css("bottom", "").trigger("togglePagination", true)
                            }
                        }
                    }
                    if ((w.entranceAnimation && j != a("GRID_MODE"))) {
                        d(".pagination:not(.is-init)").trigger("togglePagination", true)
                    }
                    switch (j) {
                    case a("LINEAR_MODE"):
                        s.append(g.htmlTemplates.linearTemplate);
                        s.append(g.htmlTemplates.slideInfoTemplate);
                        g.viewport.loadLinear();
                        g.viewport.paginate.loadSlidePage();
                        g.events.viewport.bindLinearEvents();
                        d(".slide").eq(parseInt(g.activeSlide.relativePosition, 10)).addClass("active");
                        break;
                    case a("GRID_MODE"):
                        s.append(g.htmlTemplates.gridTemplate);
                        if (g.embedMode != a("EMBED_MODE.SMALL")) {
                            s.append(g.htmlTemplates.gridPaginateTemplate)
                        }
                        g.viewport.loadGrid(q);
                        if (g.embedMode != a("EMBED_MODE.SMALL")) {
                            g.viewport.paginate.loadGridPages();
                            if (!w.isHideBreadcrumbs) {
                                g.viewport.paginate.loadSlidePage()
                            }
                        }
                        g.events.viewport.bindGridEvents();
                        if (__EMBED__ && g.embedMode == a("EMBED_MODE.SMALL") && n.slides.length > 1) {
                            var t = g.activeSlide.index != null ? g.activeSlide.index: g.activeSlide.relativePosition;
                            if (t == null) {
                                t = 0;
                                g.activeSlide.index = 0;
                                g.activeSlide.relativePosition = 0
                            }
                            tbwa.application.events.viewport.slide.loadSlideIndex(t);
                            g.viewport.paginate.showIndicator(t)
                        }
                        break;
                    case a("FULL_MODE"):
                        s.append(g.htmlTemplates.fullTemplate);
                        s.append(g.htmlTemplates.slideInfoTemplate);
                        g.viewport.loadFullscreen(q);
                        g.viewport.paginate.loadSlidePage();
                        g.events.viewport.bindFullscreenEvents();
                        g.viewport.paginate.showIndicator();
                        d(".slide").eq(parseInt(g.activeSlide.index, 10)).addClass("active");
                        break
                    }
                    if (w.entranceAnimation) {
                        g.viewport.entranceAnimation()
                    }
                    if (j === a("FULL_MODE") && !g.getSlidesFromIndex(g.activeSlide.index).length) {
                        g.viewport.exitAnimation(a("FULL_MODE"))
                    }
                    if (a("ENABLE_HARDWARE_ACCELERATION") && g.is_mobile) {
                        g.events.mobile_touch.init()
                    }
                    if (r.find(".bg-image").length) {
                        g.events.scale_to_fit_bg()
                    }
                    r.toggleClass("full_mode", j == a("FULL_MODE"));
                    if (p.hasClass("open")) {
                        p.css("bottom", g.events.getPaginationOpenValue())
                    } else {
                        p.css("bottom", g.events.getPaginationCloseValue())
                    }
                },
                resizeGrid: function(r) {
                    g.viewport.init();
                    var A = g.viewport.documentHeight,
                    x = g.viewport.documentWidth,
                    u = g.viewport.windowHeight,
                    q = d("#content_area"),
                    w = d(".pagination"),
                    t = (true) ? g.$footer.height() + parseInt(g.$footer.css("margin-top"), 10) : 0,
                    z = (true) ? g.$top_bar.height() + parseInt(g.$top_bar.css("padding-top"), 10) : 0,
                    p,
                    v,
                    y = function(E) {
                        E = (typeof(E) == "undefined") ? z + g.$view_panel.height() + q.height() + t: E;
                        var D, F, C, B;
                        if (E - u >= 10) {
                            B = __EMBED__ ? "absolute": "static";
                            g.$vertically_centered.stop().animate({
                                top: z
                            },
                            "fast",
                            function() {
                                g.$vertically_centered.css("position", B)
                            });
                            g.$body.css("overflow", "hidden");
                            if (!__EMBED__) {
                                g.$outerWrapper.css({
                                    "overflow-y": "auto",
                                    "overflow-x": "hidden"
                                })
                            }
                        } else {
                            F = u - (z + t) - g.$vertically_centered.height();
                            C = z + (F / 2);
                            B = "absolute";
                            if (__EMBED__) {
                                if (g.embedMode == a("EMBED_MODE.SMALL")) {
                                    C = "50%";
                                    g.$vertically_centered.css("margin-top", -1 * (Math.floor(g.$vertically_centered.height() / 2) + 15))
                                }
                            }
                            if (j == a("FULL_MODE")) {
                                C = 0
                            }
                            g.$vertically_centered.stop().css("position", B).animate({
                                top: C
                            },
                            "fast");
                            g.$body.css("overflow", "hidden")
                        }
                        D = {
                            fold: E,
                            footerOffset: t,
                            headerOffset: z
                        };
                        return D
                    },
                    s = function() {
                        var B = w.find(".thumbWrapper"),
                        F = w.find("ul"),
                        H = F.width(),
                        C = w.find(".arrow"),
                        E = C.width(),
                        G = 2 * E,
                        D = g.$footer.width();
                        if (H > D - G) {
                            w.addClass("scrollable");
                            B.width(D - G)
                        } else {
                            w.removeClass("scrollable");
                            B.width(D)
                        }
                    };
                    if (__EMBED__) {
                        tbwa.application.renderEmbedSize()
                    }
                    s();
                    switch (j) {
                    case a("LINEAR_MODE"):
                        g.$vertically_centered.css("height", "auto");
                        y();
                        d(".slide.active").removeClass("snapped").addClass("noAnimation").trigger("load");
                        break;
                    case a("GRID_MODE"):
                        if (__EMBED__ && g.embedMode != a("EMBED_MODE.SMALL")) {
                            g.$vertically_centered.css("position", "absolute")
                        } else {
                            g.$vertically_centered.css("position", "static")
                        }
                        v = (arguments.length && typeof(arguments[0]) !== "object") ? arguments[0] : true; (v) ? g.viewport.render() : null;
                        p = y();
                        if (p.fold > u) {
                            d("body, #outerWrapper").css({
                                "overflow-y": "auto",
                                "overflow-x": "hidden"
                            })
                        } else {
                            d("body, #outerWrapper").css("overflow", "hidden")
                        }
                        break;
                    case a("FULL_MODE"):
                        y();
                        g.$vertically_centered.css("height", "");
                        if (typeof arguments[0] === "object" && arguments[0].type && arguments[0].type === "resize") {
                            g.viewport.render(false, false)
                        }
                        d(".slide_container").css({
                            "margin-top": -1 * ((d(".slide_container").outerHeight()) * 0.5)
                        });
                        break
                    }
                },
                createSlide: function(r, p, t, q, s) {
                    switch (t.type) {
                    case "stack":
                        switch (p.stack_type) {
                        case "title":
                            g.viewport.slides.titleSlide.apply(r, [t]);
                            break;
                        case "text":
                            g.viewport.slides.textSlide.apply(r, [t]);
                            break;
                        default:
                            g.viewport.slides.imageSlide.apply(r, [t])
                        }
                        break;
                    case "image":
                    case "flickr":
                    case "instagram":
                        g.viewport.slides.imageSlide.apply(r, [t]);
                        break;
                    case "rss":
                    case "pinterest":
                    case "twitter":
                        g.viewport.slides.feedSlide.apply(r, [t]);
                        break;
                    case "title":
                        g.viewport.slides.titleSlide.apply(r, [t]);
                        break;
                    case "text":
                        g.viewport.slides.textSlide.apply(r, [t]);
                        break;
                    case "youtube":
                    case "vimeo":
                        g.viewport.slides.videoSlide.apply(r, [t]);
                        break;
                    case "iframe":
                        g.viewport.slides.iframeSlide.apply(r, [t]);
                        break;
                    case "flash":
                        g.viewport.slides.flashSlide.apply(r, [t]);
                        break;
                    case "soundcloud":
                        g.viewport.slides.audioSlide.apply(r, [t]);
                        break;
                    case "google_maps":
                        g.viewport.slides.locationSlide.apply(r, [t]);
                        break;
                    case "google_docs":
                        g.viewport.slides.googleViewerSlide.apply(r, [t]);
                        break;
                    case "facebook":
                        g.viewport.slides.facebookSlide.apply(r, [t]);
                        break;
                    case "spotify":
                        g.viewport.slides.spotifySlide.apply(r, [t]);
                        break;
                    case "foursquare":
                        g.viewport.slides.foursquareSlide.apply(r, [t])
                    }
                    r.find(".slide").attr("data-title", t.title).attr("data-tags", t.tags).attr("data-id", t.slideId).attr("data-stack-id", t.stackId).attr("data-stack-name", t.stackName).attr("data-slideindex", s).attr("data-index", q).attr("data-type", t.type).attr("data-stack-type", t.stackType).attr("data-image", t.img).attr("data-has-poster-image", t.has_poster_image);
                    return r
                },
                loadLinear: function() {
                    var x = g.$vertically_centered,
                    t = d(".slide_container"),
                    w = d(".slide_info"),
                    K = x.find(".slides").html(),
                    M,
                    F = (g.activeSlide.index == null) ? g.getSlidesFromId(g.activeSlide.id) : g.getSlidesFromIndex(g.activeSlide.index),
                    C = F.length,
                    O = a("SHELL_OFFSETS.linear.width"),
                    H = 0;
                    if (w.length) {
                        w.makeHidden()
                    }
                    if (!e.linear) {
                        g.$view_panel.makeHidden()
                    }
                    x.find(".slides").children().remove();
                    if (C == 0) {
                        x.css("height", "auto");
                        t.find(".slides").children().remove();
                        t.addClass("no_results").append(g.htmlTemplates.noResults);
                        g.$btn_content_arrow_prev.makeHidden();
                        g.$btn_content_arrow_next.makeHidden();
                        g.$view_panel.makeHidden();
                        if (n.breadcrumbs.length > 1) {
                            g.$btn_content_arrow_up.makeVisible().show()
                        }
                        return
                    }
                    for (var I = 0; I < C; I++) {
                        var p = F[I].object,
                        B = g.viewport.processSlideInfo(p),
                        E = B.imageWidth ? B.imageWidth + O: a("LINEAR_IMAGES.width") + O,
                        L = F[I].index,
                        y,
                        s,
                        D,
                        z,
                        A,
                        N,
                        u;
                        M = g.viewport.createSlide(d(K), p, B, I, L);
                        if (n.breadcrumbs.length > 1) {
                            g.$btn_content_arrow_up.makeVisible().show()
                        } else {
                            g.$btn_content_arrow_up.makeHidden()
                        }
                        M.appendTo(x.find(".slides"));
                        if (B.use_transparency) {
                            M.find(".slide").addClass("transparent-slide")
                        }
                        if (B.type === "youtube" || B.type === "vimeo") {
                            A = M.find("iframe");
                            D = (B.video_aspect_ratio === "16:9");
                            customAspectRatio = false,
                            s;
                            if (!D && typeof B.video_aspect_ratio === "string" && B.video_aspect_ratio !== "4:3") {
                                customAspectRatio = B.video_aspect_ratio.split(":");
                                customAspectRatio = parseInt(customAspectRatio[0], 10) / parseInt(customAspectRatio[1], 10)
                            }
                            y = g.viewport.slides.calculateVideoPlayerWidth(B.resource_data, A.height(), D, customAspectRatio);
                            s = y.width;
                            var G = d("<div class='video_img_matrix'></div>").css({
                                width: s,
                                height: A.height() - 2
                            });
                            A.add(M.find("img")).width(s);
                            if (B.has_poster_image == 1) {
                                M.find(".shell_contents").append(G)
                            }
                            E = s + O
                        }
                        M.find(".shell").css("width", E);
                        if (B.containerName != "" && M.find(".stack_shadow").length) {
                            M.find(".stack_shadow").width(E)
                        }
                        if (B.type == "soundcloud") {
                            M.find(".audio-container").css({
                                width: E - 100,
                                "margin-left": -1 * Math.round((E - 100) * 0.5)
                            })
                        }
                        if (B.type == "flash") {
                            N = M.find(".slide").attr("data-linear-width");
                            u = {
                                width: N ? parseInt(N, 10) : E
                            };
                            M.find(".shell").css(u).find(".flash-wrapper").css(u)
                        }
                        $bgImage = M.find(".bgimage");
                        if ($bgImage.length) {
                            $bgImage.css({
                                width: E
                            })
                        }
                        if (B.type == "text" || B.type == "title" || B.stackType == "text" || B.stackType == "title") {
                            var v = M.find(".text-content"),
                            r = parseInt(v.css("padding-left")) + parseInt(v.css("padding-right"));
                            text_content_width = E - r;
                            if (B.type == "title" || B.stackType == "title") {
                                var q = M.height() - parseInt(v.css("padding-top"), 10) - parseInt(v.css("padding-bottom"), 10) - 11;
                                var J = M.find(".shell").width() - parseInt(v.css("padding-left"), 10) - parseInt(v.css("padding-right"), 10);
                                v.height(q + 10).width(J);
                                v.find("h1").height(q + 10).width(J)
                            } else {
                                if (d.browser.webkit) {
                                    text_content_width -= 5
                                }
                                v.width(text_content_width)
                            }
                        }
                    }
                    t.find(".slides li").each(function() {
                        H += d(this).outerWidth(true)
                    });
                    t.find(".slides").width(H);
                    if (C == 1) {
                        g.$btn_content_arrow_prev.makeHidden();
                        g.$btn_content_arrow_next.makeHidden()
                    } else {
                        g.$btn_content_arrow_prev.makeVisible();
                        g.$btn_content_arrow_next.makeVisible()
                    }
                    if (!e.linear) {
                        g.preloadImageGroup(a("PRELOAD.linear"),
                        function() {
                            g.$view_panel.makeVisible();
                            t.makeVisible();
                            e.linear = true
                        })
                    } else {
                        t.makeVisible()
                    }
                    g.$view_panel.makeVisible();
                    t.makeVisible();
                    window.setTimeout(function() {
                        g.events.viewport.renderSlidesInView();
                        var P = d(".slide.active"),
                        R = P.attr("data-title"),
                        Q = P.attr("data-type");
                        g.tracker.recordView("Slide View - Linear", R + " (" + Q + ")")
                    },
                    500)
                },
                loadGrid: function(G) {
                    G = (typeof G === "boolean") ? G: true;
                    var u = a("GRID_IMAGES"),
                    z = u.width,
                    O = u.height,
                    N = u.margin_tb,
                    J = u.margin_lr,
                    M,
                    s = __EMBED__ && (g.embedMode == a("EMBED_MODE.SMALL")),
                    T = a("ENABLE_HARDWARE_ACCELERATION") && g.is_mobile,
                    y = g.$btn_content_arrow_next.width() * 2,
                    t = d(".pagination"),
                    F = d(".grid_pagination"),
                    w = g.$window.height(),
                    A = s ? w - (g.$top_bar.height() + parseInt(g.$top_bar.css("margin-top"), 10)) - (g.$footer.height() + parseInt(g.$footer.css("margin-top"), 10)) : w - (g.$top_bar.height() + parseInt(g.$top_bar.css("margin-top"), 10)) - (g.$view_panel.height() + parseInt(g.$view_panel.css("margin-top"), 10)) - (F.height() + parseInt(F.css("margin-top"), 10) + parseInt(F.css("padding-bottom"), 10)) - (t.height() + parseInt(t.css("margin-top"), 10) + parseInt(t.css("padding-bottom"), 10)) - (g.$footer.height() + parseInt(g.$footer.css("margin-top"), 10)),
                    x = Math.floor((g.$window.width() - y) / (z + J)) || 1,
                    v = Math.floor(A / (O + N)) || 1,
                    I = (z + J) * x,
                    D = (v || 1) * (O + N),
                    B = d(".slide_container"),
                    r = d(".grid"),
                    q = d("#grid_wrapper"),
                    Q = B.find(".grid").html(),
                    S;
                    if ((g.is_mobile && !g.is_ipad) || __FB__) {
                        x = v = 2;
                        I = (z + J) * x;
                        D = (v || 1) * (O + N)
                    }
                    h = x * v;
                    var H = (g.activeSlide.index == null) ? g.getSlidesFromId(g.activeSlide.id) : g.getSlidesFromIndex(g.activeSlide.index),
                    E = H.length,
                    P;
                    if (s) {
                        x = H.length;
                        v = 1;
                        I = (z + J) * x;
                        D = (v || 1) * (O + N)
                    }
                    h = x * v;
                    g.preloadImageGroup(a("PRELOAD.grid"));
                    if (!e.grid) {
                        g.$btn_content_arrow_prev.makeHidden();
                        g.$btn_content_arrow_next.makeHidden()
                    }
                    B.attr("data-cols", x).attr("data-rows", v).height(D).width(I);
                    r.height(D).width(I);
                    g.$vertically_centered.height(d("#content_area").height());
                    if (H.length == 0) {
                        q.add(d("a.arrow.prev, a.arrow.next")).remove();
                        B.addClass("no_results").append(g.htmlTemplates.noResults).css({
                            width: "",
                            "margin-left": ""
                        });
                        g.$vertically_centered.css("height", "auto");
                        d(".slide_info").css("display", "none");
                        g.$btn_content_arrow_prev.makeHidden();
                        g.$btn_content_arrow_next.makeHidden();
                        g.$view_panel.makeHidden();
                        if (n.breadcrumbs.length > 1) {
                            g.$btn_content_arrow_up.makeVisible().show()
                        }
                        return
                    }
                    B.find(".grid").children().remove();
                    for (var L = 0,
                    p, C, R; L < x * v && L < E; L++) {
                        p = H[L].object;
                        C = g.viewport.processSlideInfo(p);
                        R = H[L].index;
                        S = g.viewport.createSlide(d(Q), p, C, L, R);
                        S.find(".slide").find(".grid_slide_info").html(g.viewport.slides.set_title(C.title, 75));
                        if (C.use_transparency) {
                            S.find(".slide").addClass("transparent-slide")
                        }
                        M = b(j) + C.img;
                        if ((C.type == "youtube" || C.type == "vimeo") && C.has_poster_image == "1") {
                            M = C.img
                        }
                        if (C.type != "twitter" && C.type != "rss" && C.type != "pinterest") { (function(V, U) {
                                d.preloadImage(U,
                                function() {
                                    V.find("img").attr("src", U).fadeIn(400).end().addClass("loaded").find(".shell_loader").remove()
                                })
                            })(S, M)
                        }
                        if ((C.type == "youtube" || C.type == "vimeo") && C.has_poster_image == 1) {
                            var K = d("<div class='video_img_matrix'></div>");
                            S.find(".shell_contents").append(K)
                        }
                        S.appendTo(r)
                    }
                    r.eq(0).addClass("selectedPage");
                    if (n.breadcrumbs.length > 1) {
                        g.$btn_content_arrow_up.makeVisible().show()
                    } else {
                        g.$btn_content_arrow_up.makeHidden()
                    }
                    if (!e.grid) {
                        g.preloadImageGroup(a("PRELOAD.grid"),
                        function() {
                            e.grid = true
                        })
                    }
                    if ((!s && n.slides.length <= h) || (s && n.slides.length == 1)) {
                        g.$btn_content_arrow_prev.makeHidden();
                        g.$btn_content_arrow_next.makeHidden()
                    } else {
                        g.$btn_content_arrow_prev.makeVisible();
                        g.$btn_content_arrow_next.makeVisible()
                    }
                    if (s && n.slides.length == 1) {
                        var I = d(".grid").find("li").width();
                        d(".slide").addClass("active");
                        d(".slide_container, .grid").width(I)
                    }
                    g.$view_panel.makeVisible();
                    q.makeVisible();
                    P = q.find(".selectedPage li");
                    P.each(function(U) {
                        var V = this,
                        W = function() {
                            if (d.browser.ie6 || d.browser.ie7 || d.browser.ie8) {
                                d(V).find("img").css({
                                    display: "block",
                                    opacity: 0
                                }).animate({
                                    opacity: 1
                                },
                                250)
                            } else {
                                d(V).animate({
                                    opacity: 1
                                },
                                250)
                            }
                        };
                        window.setTimeout(W, 80 * parseInt(U, 10))
                    });
                    g.events.viewport.renderSlidesInView();
                    if (G) {
                        window.setTimeout(function() {
                            var V = n.slides.length,
                            W = parseInt(g.activeSlide.index, 10) + 1 || 1,
                            U = W + E - 1;
                            if (s) {
                                W = 1;
                                U = V
                            }
                            g.tracker.recordView("Slide View - Grid", "Viewing slides " + W + "鈥�" + U + " of " + V)
                        },
                        500)
                    }
                },
                loadFullscreen: function(z) {
                    var u = g.$vertically_centered,
                    s = d(".slide_container"),
                    G = u.find(".slides").html(),
                    A = (g.activeSlide.index == null) ? g.getSlidesFromId(g.activeSlide.id) : g.getSlidesFromIndex(g.activeSlide.index),
                    y = A.length,
                    C = g.activeSlide.relativePosition,
                    I,
                    v,
                    w,
                    F = true,
                    J = 140,
                    r,
                    t = a("SHELL_OFFSETS.fullscreen");
                    if (!e.fullscreen) {
                        g.$view_panel.makeHidden()
                    }
                    u.find(".slides").children().remove();
                    v = g.viewport.windowHeight - J;
                    if (v > a("FULLSCREEN_IMAGE.full_height")) {
                        w = a("FULLSCREEN_IMAGE.full_height")
                    } else {
                        w = a("FULLSCREEN_IMAGE.scaled_height");
                        F = false
                    }
                    if (y == 0) {
                        s.find(".slides").children().remove();
                        s.addClass("no_results").append(g.htmlTemplates.noResults);
                        d(".slide_info").css("display", "none");
                        g.$view_panel.makeHidden();
                        g.$btn_content_arrow_prev.makeHidden();
                        g.$btn_content_arrow_next.makeHidden();
                        if (n.breadcrumbs.length > 1) {
                            g.$btn_content_arrow_up.css("top", 30).makeVisible().show()
                        }
                        return
                    }
                    for (var D = 0; D < y; D++) {
                        var p = A[D].object,
                        x = g.viewport.processSlideInfo(p),
                        H = A[D].index,
                        B;
                        I = g.viewport.createSlide(d(G), p, x, D, H);
                        I.find(".slide").trigger("renderSlide");
                        if (n.breadcrumbs.length > 1) {
                            g.$btn_content_arrow_up.css("top", 0).makeVisible().show()
                        } else {
                            g.$btn_content_arrow_up.makeHidden()
                        }
                        if (x.use_transparency) {
                            I.find(".slide").addClass("transparent-slide")
                        } (function(ab, L, Q, R, Z) {
                            if (Q == R) {
                                ab.find(".slide").addClass("active")
                            }
                            var X = ab.find("iframe"),
                            S = d(".slide_info"),
                            P = g.$window.width(),
                            V = g.$window.height(),
                            aa = a("FULLSCREEN_IMAGE"),
                            M = Z.imageWidth || aa.width,
                            Y = aa.full_height,
                            W,
                            ad = 0,
                            T,
                            ae,
                            N,
                            O,
                            af;
                            if (Z.type == "youtube" || Z.type === "vimeo") {
                                T = (Z.video_aspect_ratio === "16:9");
                                ae = false;
                                if (!T && typeof Z.video_aspect_ratio === "string" && Z.video_aspect_ratio !== "4:3") {
                                    ae = Z.video_aspect_ratio.split(":");
                                    ae = parseInt(ae[0], 10) / parseInt(ae[1], 10)
                                }
                                W = g.viewport.slides.calculateVideoPlayerWidth(Z.resource_data, Y, T, ae);
                                M = W.width;
                                ad = W.controlBarHeight;
                                if (Z.has_poster_image == 1) {
                                    var ac = d("<div class='video_img_matrix'></div>");
                                    I.find(".shell_contents").append(ac)
                                }
                            }
                            N = M;
                            M = Math.min((P - aa.nav_width), M);
                            Y = Math.round(((M / N) * (Y - ad)) + ad);
                            O = Y;
                            Y = Math.min(V - aa.nav_height, Y);
                            M = Math.round(((Y - ad) / (O - ad)) * M);
                            ab.find(".slide, .shell").css("width", M + t.width).end().find(".shell").height(Y + t.height).end().find(".slide").height(Y).end().find(".shell img, .shell iframe, .shell .video_img_matrix").width(M).height(Y).end().find(".stack_shadow").width(M).height(Y);
                            if (Z.type == "soundcloud") {
                                ab.find(".audio-container").css({
                                    width: M - 100,
                                    "margin-left": -1 * Math.round((M - 100) * 0.5)
                                })
                            }
                            if (Z.type == "google_maps") {
                                ab.find(".location-container").width(M).height(Y);
                                var K = ab.data("location");
                                var U = setTimeout(function() {
                                    google.maps.event.trigger(K.map, "resize");
                                    K.map.setCenter(new google.maps.LatLng(K.lat, K.lng));
                                    clearTimeout(U)
                                },
                                20)
                            }
                            if (Z.type == "facebook") {}
                            if (Z.type == "spotify") {
                                g.viewport.slides.loadSpotifySlide(ab, M - 300, Y - 40)
                            }
                            if (Z.type == "flash") {
                                af = ab.find(".slide").attr("data-presentation-width");
                                if (af) {
                                    af = parseInt(af, 10)
                                }
                                flash_css_obj = {
                                    width: (M > af) ? af: M,
                                    height: Y
                                };
                                I.find(".slide").css(flash_css_obj).find(".shell").css(flash_css_obj).find(".flash-wrapper").css(flash_css_obj)
                            }
                            if (ab.find(".slide.active").length && S.length) {
                                S.makeVisible()
                            }
                        })(I, b(j) + x.img, C, D, x);
                        if (x.type == "stack") {
                            I.addClass(x.type)
                        }
                        I.appendTo(u.find(".slides"));
                        r = I.find(".bgimage");
                        if (r.length) {
                            r.css({
                                width: r.width() + Math.abs(t.width),
                                height: r.height() + Math.abs(t.height)
                            })
                        }
                        B = I.find(".text-content");
                        if (B.length) {
                            var q = I.height() - parseInt(B.css("padding-top"), 10) - parseInt(B.css("padding-bottom"), 10) - 11;
                            if (x.type == "title" || x.stackType == "title" || x.stackType == "text") {
                                var E = I.find(".shell").width() - parseInt(B.css("padding-left"), 10) - parseInt(B.css("padding-right"), 10);
                                B.height(q + 11).width(E)
                            } else {
                                if (x.type == "text") {
                                    q += 11
                                }
                                B.height(q)
                            }
                        }
                    }
                    if (y == 1) {
                        g.$btn_content_arrow_prev.makeHidden();
                        g.$btn_content_arrow_next.makeHidden()
                    } else {
                        g.$btn_content_arrow_prev.makeVisible();
                        g.$btn_content_arrow_next.makeVisible()
                    }
                    g.$view_panel.makeVisible();
                    s.makeVisible();
                    g.preloadImageGroup(a("PRELOAD.fullscreen"),
                    function() {
                        g.$view_panel.makeVisible();
                        s.makeVisible();
                        e.fullscreen = true
                    });
                    d(".sc-player").scPlayer();
                    d(".slide.facebook").each(function() {
                        g.viewport.slides.loadFacebookSlide(d(this))
                    });
                    d(".slide.flash").each(function() {
                        d(this).trigger("renderSlide")
                    });
                    g.events.viewport.loadFullImages();
                    if ((d(".slide.active").attr("data-type") == "youtube" || d(".slide.active").attr("data-type") == "vimeo") && d(".slide.active").attr("data-autoplay") == "1") {
                        d(".slide.active").find(".video_button a.button").trigger("click")
                    }
                    if (z) {
                        window.setTimeout(function() {
                            var K = d(".slide.active"),
                            M = K.attr("data-title"),
                            L = K.attr("data-type");
                            g.tracker.recordView("Slide View - Fullscreen", M + " (" + L + ")")
                        },
                        500)
                    }
                },
                paginate: {
                    prevOffset: 0,
                    completed: true,
                    totalThumbs: null,
                    loadSlidePage: function(x) {
                        x = x || g.activePage;
                        var u = d(".pagination"),
                        y = n.slides.length,
                        z = 50,
                        A = z * y,
                        v = d("<ul></ul>"),
                        s,
                        B,
                        r,
                        p,
                        w;
                        this.currPage = x;
                        u.find(".thumbWrapper ul").remove();
                        for (var q = 0; q < y; q++) {
                            B = d(d(g.htmlTemplates.paginateTemplate).find("li").outerHTML());
                            s = n.slides[q];
                            w = s.stack_id ? s.stack_type: s.type || "image";
                            r = s.image || s.stack_image;
                            has_poster_image = s.has_poster_image;
                            p = false;
                            B.attr("title", s.name || s.stack_name);
                            switch (w) {
                            case "image":
                            case "flickr":
                            case "instagram":
                                r = b("filmstrip") + r;
                                B.find("a").append('<img src="' + r + '" alt="' + s.stack_name + '" />').find(".icon").remove();
                                break;
                            case "facebook":
                                p = 1;
                                B.addClass("facebook overlay");
                                break;
                            case "google_docs":
                            case "google":
                                p = 1;
                                B.addClass("google overlay");
                                break;
                            case "rss":
                                p = 1;
                                B.addClass("rss overlay");
                                break;
                            case "pinterest":
                                p = 1;
                                B.addClass("pinterest overlay");
                                break;
                            case "title":
                            case "text":
                                p = 1;
                                B.addClass("text overlay");
                                break;
                            case "twitter":
                                p = 1;
                                B.addClass("twitter overlay");
                                break;
                            case "youtube":
                            case "vimeo":
                                p = 1;
                                B.addClass("video overlay");
                                break;
                            case "soundcloud":
                                B.addClass("audio overlay");
                                break;
                            case "google_maps":
                                p = 1;
                                B.addClass("location overlay");
                                break;
                            case "spotify":
                                p = 1;
                                B.addClass("spotify overlay");
                                break;
                            case "foursquare":
                                p = 1;
                                B.addClass("foursquare overlay");
                                break;
                            case "flash":
                                B.addClass("flash overlay");
                                break;
                            case "iframe":
                                p = 1;
                                B.addClass("iframe overlay");
                                break
                            }
                            if (p) {
                                if (r) {
                                    var t = b("filmstrip") + r;
                                    if ((w == "youtube" || w == "vimeo") && has_poster_image == "1") {
                                        t = r
                                    }
                                    B.find("a").css({
                                        "background-image": "url(" + t + ")",
                                        "background-size": "40px 30px",
                                        "background-position": "0px 0px"
                                    })
                                }
                                B.find(".icon").addClass("sprite")
                            }
                            if (s.stack_id) {
                                B.addClass("stack").find("a").append(g.htmlTemplates.stackBordersThumb);
                                if (w == "text" || w == "title") {
                                    B.find(".thumb_over").after(g.htmlTemplates.textContainerBg)
                                }
                            }
                            v.append(B)
                        }
                        u.find(".thumbWrapper").append(v).find("ul").css({
                            width: A,
                            margin: "0 auto"
                        })
                    },
                    loadGridPages: function(v) {
                        v = v || g.activePage;
                        h = (h == 0) ? 1 : h;
                        var u = d(".slide_container"),
                        t = Math.floor((n.slides.length - 1) / h),
                        p = d(".grid_pagination");
                        page = p.find("a").outerHTML(),
                        linkWidth = 15;
                        p.children().remove();
                        if (t == 0) {
                            u.find(".arrow.prev, .arrow.next").remove();
                            p.remove();
                            return
                        }
                        for (var r = 0; r <= t; r++) {
                            var q = d(page);
                            q.attr("data-page", r);
                            if (r == v) {
                                q.addClass("selected")
                            }
                            p.append(q)
                        }
                        var s = linkWidth * (t + 1);
                        p.width(s)
                    },
                    showIndicator: function(s) {
                        var r = d(".pagination"),
                        t = r.find("ul");
                        if (r.find("li").length) {
                            var p = parseInt(t.css("margin-left")),
                            s = (s === undefined) ? d(".slide.active").attr("data-slideindex") : s,
                            q = r.find(".thumbWrapper").width(),
                            x = r.find(".thumb").outerWidth(true),
                            v = parseInt(r.find(".thumb").css("margin-left")),
                            w,
                            u = 0;
                            r.find("li .current").removeClass("current").end().find("li:eq(" + s + ")").find("a").addClass("current");
                            w = r.find(".current").position().left;
                            if (w != p) {
                                if (w + x > q) {
                                    u = p + ( - 1 * ((w + x) - q))
                                } else {
                                    if (w - v < 0) {
                                        u = -1 * (s * x) - v
                                    }
                                }
                                if (u != 0) {
                                    r.trigger("animateTo", u)
                                }
                            }
                        }
                    }
                },
                processSlideInfo: function(H) {
                    var G = {},
                    p = H,
                    x = n.stack[0],
                    N = p.name || p.stack_name || "",
                    F = p.tags || p.stack_tags || "",
                    O = p.image || p.stack_image || "",
                    s = p.has_poster_image || 0,
                    t = (p.stack_id) ? "stack": p.type,
                    y = (p.stack_id) ? p.stack_id: "",
                    z = (p.stack_name) ? p.stack_name: "",
                    E = (p.stack_id) ? p.stack_type: "",
                    r = (p.slide_id) ? p.slide_id: "0" + String(y),
                    A = p.link || "",
                    J = p.resource_data || "",
                    K = p.video_aspect_ratio,
                    u = p.player_color || "#000",
                    w = p.lat || "",
                    M = p.lng || "",
                    L = p.marker_color || "",
                    C = p.map_color || "",
                    I = p.use_transparency ? parseInt(p.use_transparency) : 0,
                    q = {},
                    D = {},
                    B,
                    v;
                    if (g.is_spotlites && I == 0) {
                        I = p.stack_use_transparency ? parseInt(p.stack_use_transparency) : 0
                    }
                    if (p.extra_data) {
                        D = d.parseJSON(unescape(p.extra_data))
                    }
                    if ((t == "youtube" || t == "vimeo") && O == "") {
                        if (K == "4:3") {
                            O = (f == 1) ? "default_4x3_poster_dark.jpg": "default_4x3_poster_light.jpg"
                        } else {
                            O = (f == 1) ? "default_16x9_poster_dark.jpg": "default_16x9_poster_light.jpg"
                        }
                    }
                    switch (j) {
                    case a("LINEAR_MODE"):
                        B = p.linear_width || p.stack_linear_width;
                        break;
                    case a("GRID_MODE"):
                        B = a("GRID_IMAGES.width");
                        break;
                    case a("FULL_MODE"):
                        B = p.fullscreen_width || p.stack_fullscreen_width;
                        break
                    }
                    if (!x) {
                        x = {
                            name: "",
                            tags: ""
                        }
                    }
                    if (x.tags) {
                        F = (F) ? x.tags + ", " + F: x.tags
                    }
                    F = F.split(",");
                    F = F.unique().join(", ");
                    F = F || "none";
                    G = {
                        title: N,
                        tags: F,
                        img: O,
                        has_poster_image: s,
                        type: t,
                        stackId: y,
                        stackName: z,
                        stackType: E,
                        slideId: r,
                        imageWidth: parseInt(B, 10),
                        link: A,
                        use_transparency: I,
                        resource_data: J
                    };
                    switch (t) {
                    case "title":
                        G.position = parseInt(p.headline_position);
                    case "text":
                        G.body = p.body;
                        G.headline = p.headline;
                    case "rss":
                    case "pinterest":
                    case "twitter":
                        G.body_color = p.body_color || G.body_color || "";
                        G.headline_color = p.headline_color || G.headline_color || "";
                        G.link_color = p.link_color || "";
                        G.hover_color = p.hover_color || "";
                        break;
                    case "stack":
                        if (E == "title" || E == "text") {
                            if (E == "title") {
                                G.headline = p.stack_headline;
                                G.position = parseInt(p.stack_headline_position)
                            } else {
                                if (E == "text") {
                                    G.body = p.stack_body;
                                    G.headline = p.stack_headline
                                }
                            }
                            G.body_color = p.stack_body_color || G.body_color || "";
                            G.headline_color = p.stack_headline_color || G.headline_color || "";
                            G.link_color = p.stack_link_color || "";
                            G.hover_color = p.stack_hover_color || ""
                        }
                        break;
                    case "youtube":
                    case "vimeo":
                        G.video_aspect_ratio = K;
                        G.autoplay = parseInt(p.autoplay);
                        break;
                    case "soundcloud":
                        G.player_color = u;
                        break;
                    case "google_maps":
                        G.lat = w;
                        G.lng = M;
                        G.marker_color = L;
                        G.map_color = C;
                        G.body = p.body;
                        break;
                    case "flash":
                        G.flashvars = D.flashvars || "";
                        G.flashattributes = D.flashattributes || "";
                        G.flashparams = D.flashparams || "";
                        G.disable_keys = D.enable_keyboard || false;
                        G.linear_width = D.linear_width || "";
                        G.presentation_width = D.presentation_width || "";
                        break;
                    case "iframe":
                        G.no_background = D.no_background || false
                    }
                    return G
                },
                map_init: function(G, E) {
                    var H = 100;
                    switch (j) {
                    case a("LINEAR_MODE"):
                        mode = "linear";
                        H = 300;
                        break;
                    case a("GRID_MODE"):
                        mode = "grid";
                        H = 100;
                        break;
                    case a("FULL_MODE"):
                        mode = "full";
                        H = 500;
                        break
                    }
                    var v = 15,
                    r = (mode != "grid" && !g.is_mobile),
                    t = E.lat,
                    O = E.lng,
                    q = E.resource_data,
                    y = E.map_color,
                    J = E.marker_color,
                    I = g.$outerWrapper.hasClass("bgdark") ? "dark": "light",
                    K = '<div class="info_window_body_content">' + d.trim(d.trim(E.body)) + "</div>",
                    s = "https://maps.google.com/maps?q=" + encodeURIComponent(q) + "&hl=en&ll=" + t + "," + O + "&vpsrc=6&hnear=" + encodeURIComponent(q) + "&t=m&z=" + v,
                    x = '<a href="' + s + '" target="_blank" class="map_address">' + q + "</a>",
                    F = '<a href="' + s + '" target="_blank" class="btn-open-in-google-maps">open in Google Maps</a>',
                    C = null;
                    if (y == "greyscale") {
                        if (I == "light") {
                            C = [{
                                stylers: [{
                                    saturation: -100
                                }]
                            }]
                        } else {
                            C = [{
                                stylers: [{
                                    saturation: -100
                                },
                                {
                                    invert_lightness: true
                                },
                                {
                                    gamma: 0.92
                                },
                                {
                                    lightness: 8
                                }]
                            }]
                        }
                    }
                    var p = {
                        panControl: true,
                        panControlOptions: {
                            position: google.maps.ControlPosition.LEFT_CENTER
                        },
                        zoomControlOptions: {
                            position: google.maps.ControlPosition.LEFT_CENTER
                        },
                        addressControlOptions: {
                            position: google.maps.ControlPosition.TOP_CENTER
                        },
                        enableCloseButton: true,
                        visible: false
                    },
                    z = new google.maps.StreetViewPanorama(G.find(".location-container")[0], p),
                    w = new google.maps.LatLng(t, O),
                    D = {
                        zoom: v,
                        zoomControl: r,
                        streetView: z,
                        streetViewControl: r,
                        mapTypeControl: r,
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        draggable: r,
                        scrollwheel: r,
                        styles: C,
                        panControl: r,
                        panControlOptions: {
                            position: google.maps.ControlPosition.RIGHT_TOP
                        },
                        streetViewControlOptions: {
                            position: google.maps.ControlPosition.LEFT_BOTTOM
                        },
                        zoomControlOptions: {
                            position: google.maps.ControlPosition.LEFT_CENTER
                        }
                    },
                    L = new google.maps.Map(G.find(".location-container")[0], D),
                    N = {
                        position: w,
                        map: L,
                        title: q + ""
                    };
                    if (J) {
                        var B = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + J, new google.maps.Size(21, 34), new google.maps.Point(0, 0), new google.maps.Point(10, 34)),
                        M = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_shadow", new google.maps.Size(40, 37), new google.maps.Point(0, 0), new google.maps.Point(12, 35));
                        N.icon = B;
                        N.shadow = M
                    }
                    var u = new google.maps.Marker(N);
                    var A = new google.maps.InfoWindow({
                        content: '<div class="google_maps_infowindow">' + x + K + F + "</div>",
                        maxWidth: H
                    });
                    if (mode == "grid") {
                        google.maps.event.addListener(A, "closeclick",
                        function() {
                            L.setCenter(w)
                        })
                    }
                    google.maps.event.addListener(u, "click",
                    function(P) {
                        A.open(L, u);
                        d(".google_maps_infowindow").find("a").each(function() {
                            if (!d(this).attr("target")) {
                                d(this).attr("target", "_blank")
                            }
                        });
                        if (d.browser.msie) {
                            d(".location-container").find(".gmnoscreen").remove()
                        }
                    });
                    G.data("location", {
                        map: L,
                        lat: t,
                        lng: O
                    })
                },
                slides: {
                    imageSlide: function(r) {
                        var q = this;
                        q.find(".slide").addClass("image-slide").find(".shell_contents").append("<img class='shell_img' src='/shared/images/1x1.gif' />");
                        if (r.link) {
                            var p = d(g.htmlTemplates.externalLinks.replaceVars({
                                content: r.link
                            }));
                            p.attr("href", r.link).click(function(s) {
                                g.tracker.recordExitClick(r.link, s)
                            });
                            q.find(".shell_contents").append(p)
                        }
                        switch (j) {
                        case a("FULL_MODE"):
                        case a("LINEAR_MODE"):
                            if (r.type == "stack") {
                                q.addClass(r.type).find(".slide").append(g.htmlTemplates.pageCurl).append(g.htmlTemplates.stackBorders)
                            }
                            break;
                        case a("GRID_MODE"):
                            if (r.type == "stack") {
                                q.find(".slide").addClass("has_children").append(g.htmlTemplates.pageCurl).append(g.htmlTemplates.stackBorders)
                            }
                            break
                        }
                    },
                    titleSlide: function(r) {
                        var q = this,
                        p = "position-top-left";
                        switch (r.position) {
                        case 1:
                            p = "position-top-left";
                            break;
                        case 2:
                            p = "position-top-center";
                            break;
                        case 3:
                            p = "position-top-right";
                            break;
                        case 4:
                            p = "position-center-left";
                            break;
                        case 5:
                            p = "position-center-center";
                            break;
                        case 6:
                            p = "position-center-right";
                            break;
                        case 7:
                            p = "position-bottom-left";
                            break;
                        case 8:
                            p = "position-bottom-center";
                            break;
                        case 9:
                            p = "position-bottom-right";
                            break
                        }
                        q.addClass("title " + p);
                        g.viewport.slides.textSlide.apply(q, [r])
                    },
                    textSlide: function(r) {
                        var p = this,
                        q = function(x) {
                            var B = this,
                            t = B.closest(".slide"),
                            v = B.closest(".shell"),
                            u,
                            D = "bgimage",
                            w = a("BASE_URL"),
                            A,
                            s,
                            y = d("<div></div>"),
                            z = (x.headline && x.headline !== "") ? g.htmlTemplates.textHeader.replaceVars({
                                headline: x.headline
                            }) : "",
                            C = "text-content-wrapper";
                            if (!v.length) {
                                v = B.removeClass("text-content");
                                B = d(document.createElement("div")).addClass("text-content").appendTo(B);
                                B.wrap('<div class="' + C + ' bgimage" />');
                                if (v.hasClass(D)) {
                                    v.removeClass(D)
                                }
                            } else {
                                if (t.find(".bgimage").length) {
                                    C += " nobg"
                                }
                                B.wrap('<div class="' + C + '" />')
                            }
                            B.append(z);
                            if (x.body) {
                                B.append("<p>" + x.body + "</p>")
                            }
                            u = t.find(".bgimage");
                            A = x.link;
                            if (A && A !== "") {
                                s = d(g.htmlTemplates.siteVisitLink.replaceVars({
                                    "site-link": A
                                }));
                                s.click(function(E) {
                                    g.tracker.recordExitClick(d(this).attr("href"), E)
                                }).attr("target", "_blank");
                                v.append(s)
                            }
                            t.find(".shell_loader").remove();
                            if (typeof iScroll !== "undefined" && !p.hasClass("title")) {
                                B.wrap('<div class="wrapper"></div>');
                                window.setTimeout(function() {
                                    var E = new iScroll(B[0], {
                                        hScrollbar: false,
                                        vScrollbar: true,
                                        checkDOMChanges: false
                                    });
                                    B.data("scroller", E);
                                    B.width(B.width() - 100)
                                },
                                0)
                            }
                            if (u.length) {
                                u.css({
                                    display: "block",
                                    opacity: 0
                                }).animate({
                                    opacity: 1
                                },
                                500, "linear")
                            }
                            B.css({
                                display: "block",
                                opacity: 0
                            }).animate({
                                opacity: 1
                            },
                            500, "linear")
                        };
                        g.viewport.slides.setupSlideContentContainer(p, r,
                        function() {
                            q.call(this, r)
                        });
                        switch (j) {
                        case a("FULL_MODE"):
                        case a("LINEAR_MODE"):
                            if (r.type == "stack") {
                                p.addClass(r.type).find(".slide").append(g.htmlTemplates.pageCurl).append(g.htmlTemplates.stackBorders)
                            }
                            break;
                        case a("GRID_MODE"):
                            if (r.type == "stack") {
                                p.find(".slide").addClass("has_children").append(g.htmlTemplates.pageCurl).append(g.htmlTemplates.stackBorders)
                            }
                            break
                        }
                    },
                    feedSlide: function(r) {
                        var p = this,
                        q = function(A) {
                            var B = this,
                            w = B.closest(".slide"),
                            y = B.closest(".shell"),
                            C = a("FEED_ITEM_COUNTS.TWEETS"),
                            z = a("BASE_URL"),
                            u,
                            v,
                            t,
                            x = function(J) {
                                var L = J.tweets,
                                M = d("<ul></ul>").appendTo(B),
                                F,
                                H,
                                E,
                                K,
                                I,
                                G;
                                if (L.length > 0) {
                                    for (K = 0, u = C[g.getCurrentMode()]; K < u; K++) {
                                        F = L[K];
                                        if (!F) {
                                            break
                                        }
                                        H = F.in_reply_to;
                                        E = H.status_id ? g.htmlTemplates.tootInReplyTo.replaceVars({
                                            username: H.screen_name,
                                            "toot-id": H.status_id
                                        }) : "";
                                        M.append(d("<li></li>").addClass("tweet").attr("data-index", "tweet-" + K).append(g.htmlTemplates.tootProfileImg.replaceVars({
                                            username: F.from_user,
                                            "image-src": F.profile_img
                                        }), d("<div></div>").addClass("tweet_info").append(F.text, g.htmlTemplates.tootMeta.replaceVars({
                                            date: F.date,
                                            source: F.source,
                                            "in-reply": E
                                        }))))
                                    }
                                } else {
                                    M.append(g.htmlTemplates.noFeedResults.replaceVars({
                                        query: J.source
                                    }))
                                }
                                if (j == a("LINEAR_MODE") || j == a("FULL_MODE")) {
                                    var O = M.find(".tweet"),
                                    D = O.find(".profile_img"),
                                    G = D.outerWidth() + parseInt(D.css("margin-right")),
                                    I = p.find(".slide").width() - parseInt(B.css("margin-right"), 10) - parseInt(B.css("padding-left"), 10) - parseInt(B.css("padding-right"), 10) - 20,
                                    N = p.find(".slide").width() - parseInt(B.css("padding-left"), 10) - parseInt(B.css("padding-right"), 10);
                                    if (d.browser.webkit) {
                                        N -= 5
                                    }
                                    O.find(".tweet_info").width(I - G);
                                    B.width(N)
                                }
                            },
                            s = function(G) {
                                var D = G.rssitems,
                                E, H, F;
                                for (i = 0; i < D.length; i++) {
                                    F = D[i];
                                    B.append(g.htmlTemplates.rssHeadline.replaceVars({
                                        item_link: F.link,
                                        item_title: F.title
                                    }), g.htmlTemplates.rssMeta.replaceVars({
                                        item_meta: F.pubDate
                                    }), d('<div class="content"></div>').html(F.description))
                                }
                            };
                            g.XHR.getJSON(a("JSONP.getFeed") + A.slideId + a("JSONP.token"), {},
                            function(H) {
                                var D, G, F = "bgimage",
                                E = "text-content-wrapper";
                                if (H.error) {
                                    g.XHR.__displayError();
                                    return
                                }
                                if (!y.length) {
                                    y = B.removeClass("text-content");
                                    B = d(document.createElement("div")).addClass("text-content").appendTo(B);
                                    B.wrap('<div class="text-content-wrapper bgimage" />');
                                    if (y.hasClass(F)) {
                                        y.removeClass(F)
                                    }
                                } else {
                                    if (w.find(".bgimage").length) {
                                        E += " nobg"
                                    }
                                    B.wrap('<div class="' + E + '" />')
                                }
                                y.append(g.htmlTemplates.feedBadge);
                                if (H.tweets) {
                                    x(H);
                                    G = "http://twitter.com/#!/search/" + encodeURIComponent(A.resource_data);
                                    if (A.resource_data[0] == "@") {
                                        G = "http://twitter.com/" + A.resource_data.substr(1)
                                    }
                                }
                                if (H.rssitems) {
                                    s(H);
                                    G = A.link
                                }
                                if (G && G !== "") {
                                    D = d(g.htmlTemplates.feedVisitLink.replaceVars({
                                        "feed-link": G
                                    }));
                                    D.click(function(I) {
                                        g.tracker.recordExitClick(d(this).attr("href"), I)
                                    }).attr("target", "_blank");
                                    y.append(D)
                                }
                                B.find("a").each(function() {
                                    var J = d(this).attr("href"),
                                    I = function(K) {
                                        return RegExp("^mailto:").test(K)
                                    };
                                    if (!I(J)) {
                                        d(this).attr("target", "_blank")
                                    }
                                }).click(function(I) {
                                    g.tracker.recordExitClick(d(this).attr("href"), I)
                                });
                                if (typeof iScroll !== "undefined") {
                                    B.wrap('<div class="wrapper"></div>');
                                    window.setTimeout(function() {
                                        var I = new iScroll(B[0], {
                                            hScrollbar: false,
                                            vScrollbar: true,
                                            checkDOMChanges: false
                                        });
                                        B.data("scroller", I)
                                    },
                                    0)
                                }
                                if (j == a("FULL_MODE")) {
                                    y.find(".text-content-wrapper").height(y.height())
                                }
                                y.find(".bgimage, .text-content").fadeIn(500,
                                function() {
                                    y.find(".shell_loader").remove()
                                });
                                w.find(".shell_loader").remove();
                                y.addClass("loaded")
                            })
                        };
                        g.viewport.slides.setupSlideContentContainer(p, r,
                        function() {
                            var s = this;
                            p.find(".slide").one("renderSlide",
                            function() {
                                q.call(s, r)
                            })
                        })
                    },
                    videoSlide: function(s) {
                        var q = this,
                        r = q.find(".slide"),
                        p = s.resource_data;
                        r.addClass("video").attr("data-autoplay", s.autoplay).find(".shell_contents").append("<img class='shell_img' src='/shared/images/1x1.gif' />");
                        if (s.resource_data) {
                            q.find(".shell_contents").append(g.htmlTemplates.videoIcon, g.htmlTemplates.videoSlide);
                            q.find("iframe").data("resource_data", p + ((/\?/.test(p)) ? "&": "?") + "wmode=transparent" + ((s.autoplay == 1) ? "&autoplay=1": "")).load(function() {
                                g.$body.focus()
                            })
                        }
                    },
                    iframeSlide: function(s) {
                        var q = this,
                        r = q.find(".slide"),
                        p = s.resource_data;
                        r.addClass("iframe");
                        if (p) {
                            q.find(".shell_contents").append(g.htmlTemplates.videoSlide).find("iframe").attr("src", p).data("url", p).load(function() {
                                r.find(".shell_loader").remove();
                                g.$body.focus()
                            });
                            if (s.no_background) {
                                q.find("iframe").attr("allowtransparency", s.no_background).css({
                                    background: "transparent"
                                })
                            }
                        }
                    },
                    flashSlide: function(u) {
                        var r = this,
                        t = r.find(".slide"),
                        p = u.resource_data;
                        if (!g.is_mobile && !g.hasOwnProperty("has_flash")) {
                            g.has_flash = false;
                            try {
                                var q = new ActiveXObject("ShockwaveFlash.ShockwaveFlash");
                                if (q) {
                                    g.has_flash = true
                                }
                            } catch(s) {
                                if (navigator.mimeTypes["application/x-shockwave-flash"] != undefined) {
                                    g.has_flash = true
                                }
                            }
                        }
                        if (g.has_flash) {
                            t.attr("data-linear-width", u.linear_width).attr("data-presentation-width", u.presentation_width)
                        } else {
                            t.addClass("no-flash")
                        }
                        t.addClass("flash").attr("data-url", p).attr("data-flashvars", u.flashvars).attr("data-flashparams", u.flashparams).attr("data-disable-keys", u.disable_keys);
                        if (p) {
                            r.find(".shell_contents").append(g.htmlTemplates.flashTemplate.replaceVars({
                                id: u.slideId,
                                "image-src": "/shared/images/1x1.gif"
                            })).end().find(".shell_loader").remove();
                            t.bind("renderSlide",
                            function() {
                                t.removeClass("rendering").find(".flash-wrapper").click()
                            })
                        }
                    },
                    audioSlide: function(v) {
                        var r = this,
                        q = r.find(".slide"),
                        t = "",
                        s = "full",
                        p,
                        w = "slide_" + v.slideId,
                        x = function(y) {
                            if (typeof y !== "string") {
                                return y
                            }
                            return (y.match(/^([0-9a-f]{3}){1,2}$/i)) ? "#" + y: y
                        };
                        switch (j) {
                        case a("LINEAR_MODE"):
                            s = "linear";
                            break;
                        case a("GRID_MODE"):
                            s = "grid";
                            break;
                        case a("FULL_MODE"):
                            s = "full";
                            break
                        }
                        var u = d(g.htmlTemplates.externalLinks.replaceVars({
                            content: v.resource_data
                        }));
                        u.attr("href", v.resource_data).click(function(y) {
                            g.tracker.recordExitClick(v.link, y)
                        });
                        r.find(".shell_contents").append(u);
                        if (!v.img) {
                            t = "/assets/images/bg_audio_" + s + ".jpg"
                        }
                        q.addClass("audio").attr("id", w).find(".shell_contents").append('<img class="shell_img" src="' + t + '" alt=""/>', g.htmlTemplates.audioPlayer.replaceVars({
                            resource_data: v.resource_data,
                            audio_name: v.title
                        }), g.htmlTemplates.feedBadge).end().find(".shell_loader").remove();
                        p = g.htmlTemplates.audioSlideCSS.replaceVars({
                            base_id: w,
                            player_color: x(v.player_color)
                        });
                        d("<style>" + p + "</style>").insertBefore(r.find(".shell_contents"));
                        q.one("renderSlide",
                        function() {
                            q.removeClass("rendering");
                            if (j != a("FULL_MODE")) {
                                q.find(".sc-player").scPlayer()
                            }
                        })
                    },
                    locationSlide: function(r) {
                        var p = this,
                        q = p.find(".slide");
                        q.addClass("location").find(".shell_contents").append(g.htmlTemplates.locationContainer, g.htmlTemplates.feedBadge);
                        q.one("renderSlide",
                        function() {
                            g.viewport.map_init(p, r);
                            var s = p.data("location");
                            google.maps.event.trigger(s.map, "resize");
                            s.map.setCenter(new google.maps.LatLng(s.lat, s.lng));
                            q.removeClass("rendering")
                        })
                    },
                    googleViewerSlide: function(s) {
                        var q = this,
                        r = q.find(".slide"),
                        p;
                        if (s.resource_data.indexOf("<img") != -1) {
                            p = g.htmlTemplates.googleDocsImage.replaceVars({
                                url: s.resource_data
                            })
                        } else {
                            p = g.htmlTemplates.googleDocs.replaceVars({
                                url: s.resource_data
                            })
                        }
                        r.addClass("document").find(".shell_contents").append(p);
                        r.one("renderSlide",
                        function() {
                            q.find("iframe").load(function() {
                                q.find(".shell_loader").remove();
                                r.removeClass("rendering")
                            })
                        })
                    },
                    facebookSlide: function(r) {
                        var p = this,
                        q = p.find(".slide");
                        q.addClass("facebook").data("resource_data", r.resource_data);
                        if (j != a("FULL_MODE")) {
                            q.one("renderSlide",
                            function() {
                                g.viewport.slides.loadFacebookSlide(d(this))
                            })
                        }
                    },
                    loadFacebookSlide: function(t) {
                        var r = t.width() + 2,
                        p = t.height() + 6,
                        s = g.$outerWrapper.hasClass("bgdark") ? "dark": "light",
                        q = t.data("resource_data");
                        t.find(".shell_contents").append(g.htmlTemplates.facebookLikebox.replaceVars({
                            resource_data: q,
                            colorscheme: s,
                            width: r,
                            height: p
                        }));
                        t.find("iframe").load(function() {
                            t.find(".shell_loader").remove().end().find(".slide").removeClass("rendering")
                        })
                    },
                    spotifySlide: function(u) {
                        var q = this,
                        t = q.find(".slide"),
                        s = "/shared/images/1x1.gif",
                        v = "",
                        r,
                        p;
                        t.addClass("spotify").data("resource_data", u.resource_data);
                        switch (j) {
                        case a("LINEAR_MODE"):
                            v = "linear";
                            r = 271;
                            p = 350;
                            break;
                        case a("GRID_MODE"):
                            v = "grid";
                            r = 256;
                            p = 80;
                            break;
                        case a("FULL_MODE"):
                            v = "full";
                            break
                        }
                        if (!u.img) {
                            s = "/assets/images/bg_audio_" + v + ".jpg"
                        }
                        q.find(".shell_contents").append("<img class='shell_img' src='" + s + "' />", g.htmlTemplates.feedBadge);
                        if (j != a("FULL_MODE")) {
                            t.one("renderSlide",
                            function() {
                                g.viewport.slides.loadSpotifySlide(q, r, p)
                            })
                        }
                    },
                    loadSpotifySlide: function(q, r, p) {
                        var s = q.find(".slide");
                        s.find(".shell_contents").append(g.htmlTemplates.spotifyTemplate.replaceVars({
                            uri: s.data("resource_data"),
                            width: r,
                            height: p
                        }));
                        s.find("iframe").load(function() {
                            s.find(".shell_loader").remove();
                            s.find(".shell_img").animate({
                                opacity: 1
                            },
                            function() {
                                s.find(".shell_img").show()
                            });
                            s.removeClass("rendering")
                        })
                    },
                    foursquareSlide: function(r) {
                        var p = this,
                        q = p.find(".slide");
                        q.addClass("foursquare").find(".shell_contents").append(g.htmlTemplates.feedBadge);
                        q.one("renderSlide",
                        function() {
                            g.viewport.slides.loadFoursquareSlide(p, r)
                        })
                    },
                    loadFoursquareSlide: function(p, r) {
                        var q = p.find(".slide");
                        if (!q.hasClass("loaded")) {
                            var s = "";
                            switch (j) {
                            case a("LINEAR_MODE"):
                                s = "l";
                                break;
                            case a("GRID_MODE"):
                                s = "g";
                                break;
                            case a("FULL_MODE"):
                                s = "p";
                                break
                            }
                            d.ajax({
                                url: a("JSONP.getFeed") + r.slideId + "/" + s + a("JSONP.token"),
                                timeout: a("JSONP.timeout"),
                                success: function(v) {
                                    q.find(".shell_loader").remove().end().find(".shell_contents").prepend(v);
                                    q.toggleClass("loaded rendering");
                                    if (s == "p") {
                                        var t = q.width(),
                                        D = q.height(),
                                        w = p.find(".left-group").width(),
                                        y = t < 860,
                                        x = t < 500,
                                        A = 100,
                                        E = t - A,
                                        C = E - 130,
                                        u = E - p.find(".left-group").outerWidth(true),
                                        z = u - 110;
                                        info_width = u - 70;
                                        p.find(".foursquare-data-scrollable").toggleClass("mini", x).css({
                                            width: d.browser.webkit ? t - 5 : t,
                                            height: D
                                        }).find(".foursquare-data").css({
                                            width: E
                                        }).find(".bio").css({
                                            width: C
                                        }).end().find(".group").toggleClass("cascade", y).end().find(".right-group").css({
                                            width: y ? "": u
                                        }).find(".user").css({
                                            width: y ? "": z
                                        }).end().find(".info").css({
                                            width: y ? "": info_width
                                        })
                                    }
                                    if (typeof iScroll !== "undefined") {
                                        var B = q.find(".foursquare-data-scrollable");
                                        B.wrap('<div class="wrapper"></div>');
                                        window.setTimeout(function() {
                                            var F = new iScroll(B[0], {
                                                hScrollbar: false,
                                                vScrollbar: true,
                                                checkDOMChanges: false
                                            });
                                            B.data("scroller", F);
                                            B.width(B.width() - 100)
                                        },
                                        0)
                                    }
                                }
                            })
                        }
                    },
                    calculateVideoPlayerWidth: function(v, p, q, s, u) {
                        if (typeof v !== "string" || typeof p !== "number" || typeof q !== "boolean") {
                            return
                        }
                        var t = a("VIDEO_CONTROLS_HEIGHT"),
                        r;
                        if (typeof s === "number") {
                            r = s
                        } else {
                            r = (q) ? (16 / 9) : (4 / 3)
                        }
                        if (!/ip(ad|od|hone)/.test(g.$body.attr("class"))) {
                            if (typeof u === "number") {
                                p -= u
                            } else {
                                if (/youtube\.com/.test(v)) {
                                    u = t.youtube;
                                    p -= u
                                } else {
                                    if (/vimeo\.com/.test(v)) {
                                        u = t.vimeo;
                                        p -= u
                                    } else {
                                        if (/tudou\.com/.test(v)) {
                                            u = t.tudou;
                                            p -= u
                                        } else {
                                            if (/youku\.com/.test(v)) {
                                                u = t.youku;
                                                p -= u
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        return {
                            width: Math.round(p * r),
                            controlBarHeight: u
                        }
                    },
                    setupSlideContentContainer: function(s, x, y) {
                        var z = s.find(".shell_contents"),
                        q = z.closest(".slide"),
                        v = z.closest(".shell"),
                        u = g.getCurrentMode(),
                        w = "slide_" + x.slideId,
                        r,
                        p,
                        t,
                        A;
                        A = function(B) {
                            if (typeof B !== "string") {
                                return B
                            }
                            return (B.match(/^([0-9a-f]{3}){1,2}$/i)) ? "#" + B: B
                        };
                        if (!g.isTBWA || (g.isTBWA && x.img && !/default_background/.test(x.img))) {
                            p = g.htmlTemplates.userSlideCSS.replaceVars({
                                base_id: w,
                                background_image: (x.img === "") ? "none": "url(" + b(j) + x.img + ")",
                                headline_color: A(x.headline_color),
                                body_color: A(x.body_color),
                                link_color: A(x.link_color),
                                hover_color: A(x.hover_color)
                            });
                            d("<style>" + p + "</style>").insertBefore(z)
                        }
                        if (x.img !== "") {
                            if (g.getCurrentMode(j) === "grid_mode") {
                                z.addClass("bgimage")
                            } else {
                                r = d(document.createElement("div")).addClass("bgimage");
                                z.css("background-color", "transparent");
                                v.append(r);
                                r.fadeIn()
                            }
                        } else {
                            q.addClass("nobg")
                        }
                        q.attr("id", w).addClass(x.type);
                        if (x.type == "pinterest") {
                            q.attr("id", w).addClass("rss pinterest")
                        }
                        z.addClass("text-content");
                        if (typeof y === "function") {
                            y.call(z)
                        }
                        return z
                    },
                    set_title: function(r, p) {
                        r = r || "";
                        if (typeof p === "number") {
                            var q = r.match(new RegExp("^.{0," + p + "}"))[0];
                            if (q.length === p) {
                                r = q.replace(/\s+\w*$/, "鈥�")
                            } else {
                                r = q
                            }
                        }
                        return r
                    }
                }
            },
            footer: {
                init: function() {
                    var r = d(".user_profile"),
                    s = r.find(".user_profile_expanded"),
                    p = g.$footer.find(".user_profile_toggle");
                    d("#footer, #footer-copyright").find(".overlay").each(function() {
                        var u = d(this),
                        v = a("OVERLAY.HELP.width"),
                        t = {
                            iframe: true,
                            returnFocus: false
                        };
                        if (u.hasClass("help")) {
                            t.initialWidth = v;
                            t.width = v
                        }
                        u.colorbox(t)
                    });
                    p.click(function(t) {
                        t.preventDefault();
                        d(".pagination.open").trigger("togglePagination", true);
                        d(".title_bar.open").trigger("toggleBreadcrumbs", true);
                        d(this).trigger("toggleUserProfile")
                    }).bind("toggleUserProfile",
                    function(x, v) {
                        var t = g.$window.height(),
                        w = s.find(".user_profile_content");
                        if (__EMBED__ && g.embedMode == a("EMBED_MODE.SMALL")) {
                            var u = t - g.$top_bar.outerHeight(true) - g.$footer.outerHeight(true);
                            s.height(u);
                            w.height(u - s.find(".top_bar").outerHeight(true))
                        } else {
                            s.css("height", "");
                            w.css("height", "")
                        }
                        if (v || p.hasClass("open")) {
                            s.slideUp(a("SCROLL_SPEED").web, a("SCROLL_EASING"),
                            function() {
                                p.removeClass("open")
                            })
                        } else {
                            s.slideDown(a("SCROLL_SPEED").web, a("SCROLL_EASING"),
                            function() {
                                p.addClass("open")
                            })
                        }
                    }).end().find(".user_profile_expanded .top_bar").click(function() {
                        p.trigger("toggleUserProfile", true)
                    });
                    if (typeof iScroll !== "undefined") {
                        var q = r.find(".user_profile_content");
                        q.wrap('<div class="wrapper""></div>');
                        window.setTimeout(function() {
                            var t = new iScroll(q[0], {
                                hScrollbar: false,
                                vScrollbar: true,
                                checkDOMChanges: true
                            });
                            q.data("scroller", t)
                        },
                        0)
                    }
                    g.$footer.find("a:external").click(function(t) {
                        g.tracker.recordExitClick(d(this).attr("href"), false, "Footer")
                    });
                    g.$footer.find(".filters li:not('.logout') a").bind("click",
                    function(y) {
                        var x = d(this).attr("href"),
                        B = location.protocol,
                        C = location.host,
                        D = location.search,
                        A = d(this),
                        u,
                        z,
                        v,
                        w = function(E) {
                            return RegExp("^mailto:").test(E)
                        },
                        t = function(E) {
                            return RegExp("^/|^#$").test(E)
                        };
                        if (!A.attr("target")) {
                            u = x.match(/#([lgf]si\d+ci\d+(b\d)?q.*)$/i);
                            if (u) {
                                z = g.getURLHashValues(u[1]);
                                if (z.searchQuery) {
                                    y.preventDefault();
                                    v = a("JSONP.searchResults") + a("JSONP.token");
                                    g.XHR.getJSON(v, {
                                        terms: z.searchQuery
                                    },
                                    function(E) {
                                        n = E;
                                        g.activeSlide.id = 0;
                                        g.activeSlide.index = null;
                                        g.header.searchBar.query = z.searchQuery;
                                        g.header.titleBar.setTitle("navigation", true);
                                        g.viewport.render();
                                        window.focus()
                                    })
                                } else {
                                    g.events.viewport.slide.loadChildSlides({},
                                    {
                                        stackId: parseInt(z.stackId, 10),
                                        slideId: parseInt(z.slideId, 10),
                                        stackName: ""
                                    })
                                }
                                return
                            }
                            if (A.is(":external")) {
                                A.attr("target", "_blank")
                            }
                        }
                    })
                }
            },
            events: {
                init: function() {
                    this.window.init();
                    this.header.init();
                    this.viewpanel.init();
                    this.viewport.init();
                    this.pagination.init();
                    if (!a("ENABLE_HARDWARE_ACCELERATION")) {
                        if (g.is_mobile && document.addEventListener) {
                            document.addEventListener("touchmove",
                            function(p) {
                                p.preventDefault()
                            })
                        }
                    } else {
                        if (a("ENABLE_HARDWARE_ACCELERATION") && g.is_mobile) {
                            g.$body.addClass("mobile_ha")
                        }
                    }
                },
                mobile_touch: {
                    $slide: null,
                    $slide_container: null,
                    speed: 500,
                    transformX: 0,
                    swipeOptions: {
                        triggerOnTouchEnd: true,
                        swipeStatus: function(t, s, r, q) {
                            g.events.mobile_touch.swipe_status(t, s, r, q)
                        },
                        allowPageScroll: "vertical",
                        threshold: 200
                    },
                    col_index: null,
                    col_max_index: null,
                    grid_visible_width: null,
                    grid_visible_cols: null,
                    init: function() {
                        switch (j) {
                        case a("LINEAR_MODE"):
                            var r = d(".slide:first"),
                            t = r.width(),
                            s = d(".slide.active"),
                            q = s.width(),
                            p;
                            g.events.mobile_touch.$slide = d(".slide");
                            g.events.mobile_touch.$slide_container = d(".slides").css({
                                left: 0,
                                "margin-left": Math.floor((window.innerWidth / 2) - (t / 2))
                            });
                            p = Math.floor((t - q) / 2);
                            g.events.mobile_touch.move_to(s.position().left - p, 0);
                            break;
                        case a("GRID_MODE"):
                            g.events.mobile_touch.$slide = d(".grid");
                            g.events.mobile_touch.$slide_container = d(".slide_container");
                            g.events.mobile_touch.grid_visible_width = g.events.mobile_touch.$slide_container.attr("data-visible-width");
                            g.events.mobile_touch.grid_visible_cols = parseInt(g.events.mobile_touch.$slide_container.attr("data-visible-cols"), 10);
                            g.events.mobile_touch.col_index = Math.max(0, (Math.floor(parseInt(g.activeSlide.relativePosition, 10) / g.events.mobile_touch.grid_visible_cols) - 1));
                            g.events.mobile_touch.col_max_index = g.events.mobile_touch.$slide_container.attr("data-num-grids") - 1;
                            g.events.mobile_touch.move_to(g.events.mobile_touch.get_move_position(0, g.events.mobile_touch.col_index), 0);
                            break
                        }
                        g.events.mobile_touch.$slide_container.swipe(g.events.mobile_touch.swipeOptions)
                    },
                    swipe_status: function(s, q, u, v) {
                        var r = false;
                        if (q == "move" && (u == "left" || u == "right")) {
                            var t = 0;
                            if (u == "left") {
                                g.events.mobile_touch.move_to(( - g.events.mobile_touch.transformX) + v, t)
                            } else {
                                if (u == "right") {
                                    g.events.mobile_touch.move_to(( - g.events.mobile_touch.transformX) - v, t)
                                }
                            }
                        } else {
                            if (q == "cancel") {
                                g.events.mobile_touch.move_to( - g.events.mobile_touch.transformX, g.events.mobile_touch.speed)
                            } else {
                                if (q == "end") {
                                    if (u == "right") {
                                        g.events.mobile_touch.prev();
                                        r = true
                                    } else {
                                        if (u == "left") {
                                            g.events.mobile_touch.next();
                                            r = true
                                        }
                                    }
                                    if (r) {
                                        switch (j) {
                                        case a("LINEAR_MODE"):
                                            d(".slide:eq(" + g.activeSlide.index + ")").trigger("loadSlideFromIndex", [g.activeSlide.index, g.activeSlide.index]);
                                            break;
                                        case a("GRID_MODE"):
                                            var p = d(".grid:eq(" + g.events.mobile_touch.col_index + ") .slide:first").attr("data-slideindex");
                                            g.events.viewport.slide.loadSlideIndex(p);
                                            break
                                        }
                                    }
                                } else {
                                    if (q == "start") {
                                        g.events.mobile_touch.transformX = new WebKitCSSMatrix(window.getComputedStyle(g.events.mobile_touch.$slide_container[0]).webkitTransform).e
                                    }
                                }
                            }
                        }
                    },
                    click_prev: function() {
                        g.events.mobile_touch.swipe_status(null, "start");
                        g.events.mobile_touch.swipe_status(null, "end", "right")
                    },
                    prev: function() {
                        var q, p;
                        switch (j) {
                        case a("LINEAR_MODE"):
                            q = parseInt(g.activeSlide.index, 10);
                            break;
                        case a("GRID_MODE"):
                            q = g.events.mobile_touch.col_index;
                            break
                        }
                        p = q - 1;
                        if (p < 0) {
                            g.events.mobile_touch.swipe_status(null, "cancel");
                            return
                        }
                        g.events.mobile_touch.move_to(g.events.mobile_touch.get_move_position(q, p, -1), g.events.mobile_touch.speed);
                        if (j == a("LINEAR_MODE")) {
                            g.activeSlide.index = p;
                            g.activeSlide.relativePosition = p
                        } else {
                            g.events.mobile_touch.col_index = p
                        }
                    },
                    click_next: function() {
                        g.events.mobile_touch.swipe_status(null, "start");
                        g.events.mobile_touch.swipe_status(null, "end", "left")
                    },
                    next: function() {
                        var r, p, q;
                        switch (j) {
                        case a("LINEAR_MODE"):
                            r = parseInt(g.activeSlide.index, 10);
                            q = n.slides.length - 1;
                            break;
                        case a("GRID_MODE"):
                            r = g.events.mobile_touch.col_index;
                            q = g.events.mobile_touch.col_max_index;
                            break
                        }
                        p = r + 1;
                        if (p > q) {
                            g.events.mobile_touch.swipe_status(null, "cancel");
                            return
                        }
                        g.events.mobile_touch.move_to(g.events.mobile_touch.get_move_position(r, p, 1), g.events.mobile_touch.speed);
                        if (j == a("LINEAR_MODE")) {
                            g.activeSlide.index = p
                        } else {
                            g.events.mobile_touch.col_index = p
                        }
                    },
                    get_move_position: function(w, q, u) {
                        var p, s, t, r, v;
                        switch (j) {
                        case a("LINEAR_MODE"):
                            p = d(".slide:eq(" + w + ")").parent(),
                            s = d(".slide:eq(" + q + ")").parent(),
                            t = p.outerWidth(true),
                            r = s.outerWidth(true),
                            v = -g.events.mobile_touch.transformX + (u * (t + Math.floor((r - t) / 2)));
                            break;
                        case a("GRID_MODE"):
                            v = q * g.events.mobile_touch.grid_visible_width;
                            break
                        }
                        return v
                    },
                    move_to: function(r, q) {
                        g.events.mobile_touch.$slide_container.css("-webkit-transition-duration", (q / 1000).toFixed(1) + "s");
                        var p = (r < 0 ? "": "-") + Math.abs(r).toString();
                        g.events.mobile_touch.$slide_container.css("-webkit-transform", "translate3d(" + p + "px,0px,0px)")
                    }
                },
                header: {
                    init: function() {
                        var p = d("#search_box"),
                        q = d(".title_bar");
                        p.find(".search_text").focus(function() {
                            var r = d(this);
                            this.select();
                            r.attr("data-focused", true);
                            if (r.val().toLowerCase() == r.attr("data-default_value")) {
                                r.val("")
                            }
                        }).blur(function() {
                            var r = d(this);
                            r.attr("data-focused", false);
                            if (r.val() == "") {
                                r.val(r.attr("data-default_value"))
                            }
                            g.header.searchBar.clearSuggestions()
                        }).keyup(function(s) {
                            var r = d(this).siblings(".search_button");
                            r.addClass("in_progress");
                            window.clearTimeout(k);
                            k = window.setTimeout(g.header.searchBar.suggest, a("SEARCH.autoSuggestTimeout"));
                            switch (s.keyCode) {
                            case 13:
                                s.preventDefault();
                                s.stopPropagation();
                                s.stopImmediatePropagation();
                                r.click();
                                this.blur();
                                break;
                            case 27:
                                g.header.searchBar.clearSuggestions();
                                break
                            }
                        }).end().find(".search_button").click(function(t) {
                            var s = d("#search_box").find(".search_text"),
                            r = s.val();
                            if (r === s.attr("data-default_value")) {
                                return
                            }
                            g.header.searchBar.lookUp(r)
                        });
                        p.delegate(".result", "click",
                        function(s) {
                            s.preventDefault();
                            var r = d("#search_box").find(".search_text");
                            r.val(d(this).text());
                            d("#searchResultsWrapper").remove();
                            g.header.searchBar.lookUp(r.val())
                        });
                        q.bind("click",
                        function(w, r) {
                            var t = d(w.target),
                            v,
                            s,
                            u;
                            w.preventDefault();
                            if (t.hasClass("bottom_bar") || t.parent().hasClass("bottom_bar")) {
                                q.trigger("toggleBreadcrumbs", true)
                            }
                            if (!t.hasClass("breadcrumb")) {
                                t = t.parents(".breadcrumb")
                            }
                            if (t.parents(".current").length || t.parents(".last").length) {
                                d(".user_profile_toggle").trigger("toggleUserProfile", true);
                                if (q.hasClass("open") && t.parents(".last").length) {
                                    if (g.embedMode == a("EMBED_MODE.SMALL")) {
                                        g.events.viewport.slide.loadSlideIndex(0)
                                    } else {
                                        d(".pagination li:first a").click()
                                    }
                                } else {
                                    q.trigger("toggleBreadcrumbs")
                                }
                                return
                            }
                            if (typeof r != "undefined") {
                                s = r.parent_stack_id || r.stack_id
                            }
                            v = t.attr("data-stack-id") || null;
                            v = (typeof r === "object") ? parseInt(s, 10) : v;
                            u = t.attr("data-slide-id") || 0;
                            u = (typeof r === "object") ? "0" + parseInt(g.activeStack.id, 10) : u;
                            if (v == null) {
                                return
                            }
                            g.header.searchBar.clear();
                            t.nextAll().remove();
                            g.activeSlide.id = u;
                            g.activeSlide.index = null;
                            g.activeStack.id = v;
                            g.activeSlide.relativePosition = 0;
                            g.XHR.getJSON(a("JSONP.get") + v + a("JSONP.token"), "",
                            function(x) {
                                n = x;
                                g.header.titleBar.setTitle("navigation", true);
                                g.viewport.render();
                                g.updateHash();
                                g.viewport.resizeGrid(false)
                            })
                        }).bind("toggleBreadcrumbs",
                        function(r, s) {
                            if (s || q.hasClass("open")) {
                                d("#title_bar_expanded").slideUp(a("SCROLL_SPEED").web, a("SCROLL_EASING"),
                                function() {
                                    q.removeClass("open")
                                })
                            } else {
                                d("#title_bar_expanded").slideDown(a("SCROLL_SPEED").web, a("SCROLL_EASING"),
                                function() {
                                    var t = d("#title_bar_stories");
                                    t.animate({
                                        scrollTop: t.height()
                                    });
                                    q.addClass("open")
                                })
                            }
                        })
                    }
                },
                viewpanel: {
                    init: function() {
                        var p = (g.is_mobile && !g.is_ipad),
                        r,
                        q = this;
                        if (typeof window.orientation !== "undefined" && typeof window.addEventListener !== "undefined") {
                            r = "onorientationchange" in window ? "orientationchange": "resize";
                            window.addEventListener(r,
                            function() {
                                switch (g.getCurrentMode()) {
                                case "linear_mode":
                                    q.linearView();
                                    g.events.viewpanel.runPostCommonCode();
                                    break;
                                case "grid_mode":
                                    q.gridView();
                                    g.events.viewpanel.runPostCommonCode();
                                    break
                                }
                            });
                            if (p) {
                                window.addEventListener(r,
                                function() {
                                    switch (window.orientation) {
                                    case 90:
                                    case - 90 : g.events.viewpanel.runPreCommonCode.call(g.$btn_linear_view.get(0));
                                        q.linearView();
                                        g.events.viewpanel.runPostCommonCode()
                                    }
                                })
                            }
                            if (g.is_ipad) {
                                window.addEventListener(r,
                                function() {
                                    if (g.getCurrentMode() !== "full_mode") {
                                        return
                                    }
                                    switch (window.orientation) {
                                    case 0:
                                    case 180:
                                        g.events.viewpanel.runPreCommonCode.call(g.$btn_linear_view.get(0));
                                        q.linearView();
                                        g.events.viewpanel.runPostCommonCode()
                                    }
                                })
                            }
                        }
                        g.$view_panel.find("a").bind("click",
                        function(t) {
                            t.preventDefault();
                            t.stopPropagation();
                            var s = d(this);
                            if (s.parent(".presentation_view").length) {
                                return
                            }
                            if (s.hasClass("selected") || s.parent().hasClass("disabled")) {
                                t.stopImmediatePropagation()
                            }
                        }).end().find(".slide_view a").bind("click", q.linearView).end().find(".grid_view a").bind("click", q.gridView).end().find(".full_screen a").bind("click", q.fullscreenView).end().find(".background a").bind("click", q.colorToggle).end().find(".presentation_view a").bind("click", q.presentationView);
                        g.$vertically_centered.click(function(t) {
                            var s = d(".logo:first");
                            if (g.events.viewpanel.isMouseOverLogo(t) && !g.events.viewpanel.isMouseOverSlide(t)) {
                                document.location.href = s.prop("href")
                            }
                        }).mousemove(function(t) {
                            var s = d(this);
                            if (g.events.viewpanel.isMouseOverLogo(t)) {
                                if (g.events.viewpanel.isMouseOverSlide(t)) {
                                    s.css("cursor", "default")
                                } else {
                                    s.css("cursor", "pointer")
                                }
                            } else {
                                s.css("cursor", "default")
                            }
                        });
                        g.$document.bind("mozfullscreenchange fullscreeneventchange",
                        function() {
                            g.$body.trigger("toggleFullscreen")
                        });
                        g.$body.bind("webkitfullscreenchange",
                        function(s) {
                            g.$body.trigger("toggleFullscreen")
                        }).bind("toggleFullscreen",
                        function(s) {
                            if (document.webkitIsFullScreen || document.mozFullScreen || document.fullscreenEnabled) {
                                d(this).addClass("presentation_mode")
                            } else {
                                d(this).removeClass("presentation_mode")
                            }
                        })
                    },
                    isMouseOverSlide: function(v) {
                        var r = v.pageX,
                        q = v.pageY,
                        w = d(".slide"),
                        y = w.length,
                        u,
                        s,
                        p,
                        x;
                        for (var t = 0; t < y; t++) {
                            u = d(w[t]);
                            if (u.css("visibility") != "hidden") {
                                s = u.offset();
                                p = u.width();
                                x = u.height();
                                if (r > s.left && r < s.left + p && q > s.top && q < s.top + x) {
                                    return u
                                }
                            }
                        }
                        return false
                    },
                    isMouseOverLogo: function(u) {
                        var s = u.pageX,
                        q = u.pageY,
                        r = d(".logo:first"),
                        v = r.offset(),
                        t = r.width(),
                        p = r.height();
                        return (s > v.left && s < v.left + t && q > v.top && q < v.top + p)
                    },
                    runPreCommonCode: function() {
                        g.$view_panel.find(".selected").removeClass("selected");
                        d(this).addClass("selected");
                        g.events.stopAudio();
                        if (d.browser.msie) {
                            d("#content_area iframe").remove()
                        }
                    },
                    runPostCommonCode: function() {
                        g.updateHash();
                        g.viewport.resizeGrid()
                    },
                    linearView: function() {
                        g.events.viewpanel.runPreCommonCode.call(this);
                        g.setCurrentMode(a("LINEAR_MODE"));
                        g.viewport.render();
                        g.events.viewpanel.runPostCommonCode()
                    },
                    gridView: function() {
                        g.events.viewpanel.runPreCommonCode.call(this);
                        g.setCurrentMode(a("GRID_MODE"));
                        g.viewport.render(false, false);
                        g.events.viewpanel.runPostCommonCode()
                    },
                    fullscreenView: function() {
                        g.events.viewpanel.runPreCommonCode.call(this);
                        g.setCurrentMode(a("FULL_MODE"));
                        g.viewport.render();
                        g.events.viewpanel.runPostCommonCode.call(this)
                    },
                    presentationView: function() {
                        g.events.viewpanel.presentationMode();
                        setTimeout(function() {
                            g.viewport.resizeGrid()
                        },
                        1000)
                    },
                    presentationMode: function() {
                        var r = "webkit moz o ms khtml".split(" "),
                        t = r.length,
                        s = g.$body.hasClass("presentation_mode") ? "Cancel": "Request",
                        p = s == "Cancel" ? document: document.body;
                        for (var q = 0; q < t; q++) {
                            if (p[r[q] + s + "FullScreen"]) {
                                p[r[q] + s + "FullScreen"](Element.ALLOW_KEYBOARD_INPUT)
                            }
                        }
                    },
                    colorToggle: function() {
                        var t = a("BACKGROUND_COLORS"),
                        p = 0,
                        w = 1,
                        A = "bgdark",
                        u = d(".pagination"),
                        v = d("#search_box"),
                        q = d(".title_bar"),
                        x = d(".slide_info"),
                        r = d(".slide_container"),
                        s = 1000,
                        z = function() {
                            g.$view_panel.animate({
                                opacity: 1
                            });
                            u.add(x).add(r).animate({
                                opacity: 1
                            })
                        },
                        y = function(F) {
                            var B = u.find(".thumb a"),
                            D = u.find(".thumb img"),
                            C = new RegExp(".*icon_white.png.*|.*icon_black.png.*"),
                            E,
                            G;
                            if (F == p) {
                                B.each(function() {
                                    var H = d(this);
                                    E = C.exec(H.css("background-image"));
                                    if (E !== null) {
                                        H.css("background-image", E[0].replace("icon_white", "icon_black"))
                                    }
                                });
                                D.each(function() {
                                    var H = d(this);
                                    G = C.exec(H.attr("src"));
                                    if (G !== null) {
                                        H.attr("src", G[0].replace("icon_white", "icon_black"))
                                    }
                                })
                            } else {
                                B.each(function() {
                                    var H = d(this);
                                    E = C.exec(H.css("background-image"));
                                    if (E !== null) {
                                        H.css("background-image", E[0].replace("icon_black", "icon_white"))
                                    }
                                });
                                D.each(function() {
                                    var H = d(this);
                                    G = C.exec(H.attr("src"));
                                    if (G !== null) {
                                        H.attr("src", G[0].replace("icon_black", "icon_white"))
                                    }
                                })
                            }
                        };
                        g.$view_panel.css("opacity", 0);
                        u.add(x).add(r).css("opacity", 0);
                        if (g.viewport.backgroundColor == 0) {
                            g.$body.animate({
                                backgroundColor: t.dark
                            },
                            s,
                            function() {
                                g.$outerWrapper.addClass(A);
                                y(p);
                                z()
                            });
                            f = g.viewport.backgroundColor = 1;
                            g.updateHash()
                        } else {
                            g.$body.animate({
                                backgroundColor: t.light
                            },
                            s,
                            function() {
                                g.$outerWrapper.removeClass(A);
                                y(w);
                                z()
                            });
                            f = g.viewport.backgroundColor = 0;
                            g.updateHash()
                        }
                    }
                },
                viewport: {
                    init: function() {
                        d("#content_area").bind("click",
                        function(p) {
                            if (g.events.isTextSlide(p.target) || g.events.isAudioSlide(p.target) || g.events.isLocationSlide(p.target) || g.events.isFoursquareSlide(p.target) || g.events.isFlashSlide(p.target)) {
                                return
                            }
                            p.preventDefault();
                            window.focus()
                        });
                        d("#content_area").delegate(".sc-player", "onPlayerInit.scPlayer",
                        function() {
                            if (j == a("LINEAR_MODE") || j == a("FULL_MODE")) {
                                var r = d(this),
                                q = r.parents(".audio-container"),
                                p = q.width();
                                r.css({
                                    width: q.width() - (r.position().left * 2)
                                });
                                q.find(".sc-artwork-list, .sc-info, .sc-tracklist .sc-track-duration, .sc-info-toggle").remove()
                            }
                        });
                        d(".flash-wrapper:not(.is-flash-active)").live("click",
                        function(s) {
                            s.preventDefault();
                            if (!g.is_mobile && g.has_flash) {
                                var r = d(this).addClass("is-flash-active"),
                                q = Object.prototype.hasOwnProperty.call(window, "swfobject"),
                                p = function(y) {
                                    var x = y.parents(".slide"),
                                    v = g.getObjectFromQuery(x.attr("data-flashvars")) || {},
                                    w = d.extend({
                                        wmode: "transparent",
                                        allowfullscreen: true
                                    },
                                    g.getObjectFromQuery(x.attr("data-flashparams"))),
                                    u = y.attr("data-content-id"),
                                    t = a("IMAGE_URL.base") + a("IMAGE_URL.document") + x.attr("data-url");
                                    x.find(".flash-image").remove();
                                    swfobject.embedSWF(t, u, "100%", "100%", "9.0.0", false, v, w)
                                };
                                if (!q) {
                                    d.getScript(a("SCRIPTS.swfobject"),
                                    function() {
                                        p(r)
                                    })
                                } else {
                                    p(r)
                                }
                            }
                        });
                        d(".video_button a.button").live("click",
                        function(u) {
                            u.preventDefault();
                            var t = d(this),
                            s = t.parents(".slide:first"),
                            r,
                            w = (g.getCurrentMode() === "full_mode") ? "Fullscreen": "Linear",
                            q = 0,
                            v,
                            p;
                            if (g.getCurrentMode() == "grid_mode") {
                                d(".slide.video iframe.playing").attr("src", "").removeClass("playing").parents(".slide").find(".shell_contents").find("img").show().end().find(".video_button").show()
                            }
                            p = function() {
                                t.parent().add(t.parent().siblings("img")).fadeOut(function() {
                                    if (q) {
                                        return
                                    }
                                    q++;
                                    r = t.parent().siblings("iframe");
                                    r.attr("src", r.data("resource_data")).addClass("playing");
                                    v = s.attr("data-title");
                                    g.tracker.recordView("Video Playback - " + w, v)
                                })
                            };
                            window.setTimeout(p, 500)
                        });
                        d("#content_area").delegate(".slide_info .overlay", "click",
                        function() {
                            var r = d(this),
                            q = a("OVERLAY.SLIDEINFO.width"),
                            p = {
                                iframe: true,
                                onCleanup: function() {
                                    d("#commenting-coming-soon:visible").hide()
                                }
                            };
                            if (r.hasClass("slideinfo")) {
                                p.initialWidth = q;
                                p.width = q
                            }
                            r.colorbox(p)
                        });
                        g.$top_bar.delegate(".share.overlay", "click",
                        function() {
                            var r = d(this),
                            q = a("OVERLAY.SLIDEINFO.width"),
                            p = {
                                initialWidth: q,
                                width: q,
                                iframe: true,
                                onCleanup: function() {
                                    d("#commenting-coming-soon:visible").hide()
                                }
                            };
                            if (d(".pagination").length) {
                                d(".pagination.open").trigger("togglePagination", true)
                            }
                            r.colorbox(p)
                        })
                    },
                    bindLinearEvents: function() {
                        var p = g.events.viewport,
                        q = p.slide.currSlide.mouse,
                        r;
                        if (!a("ENABLE_HARDWARE_ACCELERATION") && (g.is_mobile && a("ENABLE_DRAGGING_MOBILE")) || (!g.is_mobile && a("ENABLE_DRAGGING_DESKTOP"))) {
                            d(".slide_container").bind("touchstart",
                            function(u) {
                                var v = u.originalEvent.touches,
                                t = (v.length == 1) ? true: false,
                                s = v[0];
                                d(this).trigger("mousedown", [s])
                            }).bind("touchmove",
                            function(u) {
                                var v = u.originalEvent.touches,
                                t = (v.length == 1) ? true: false,
                                s = v[0];
                                if (!t) {
                                    return
                                }
                                d(this).trigger("mousemove", [s])
                            }).bind("touchend",
                            function(u) {
                                var v = u.originalEvent.touches,
                                t = (v.length == 1) ? true: false,
                                s = v[0];
                                d(this).trigger("mouseup", [s])
                            });
                            d(".slide_container").bind("mousemove",
                            function(z, s) {
                                z.preventDefault();
                                z = (typeof(s) !== "undefined") ? s: z;
                                if (q.capture) {
                                    var x = z.pageX - q.start.x,
                                    v = a("MOUSE_THRESHOLD"),
                                    A,
                                    u,
                                    y,
                                    C = a("NUM_SLIDES_TO_LOAD"),
                                    w = g.activePage * C,
                                    t = (w + C) - 1,
                                    B = n.slides.length - 1;
                                    if (x > v) {
                                        q.capture = false;
                                        u = d(".active", ".slide_container");
                                        A = parseInt(u.attr("data-slideindex"), 10);
                                        y = parseInt(u.attr("data-index"), 10);
                                        A--;
                                        y--
                                    } else {
                                        if (x < -v) {
                                            q.capture = false;
                                            u = d(".active", ".slide_container");
                                            A = parseInt(u.attr("data-slideindex"), 10);
                                            y = parseInt(u.attr("data-index"), 10);
                                            A++;
                                            y++
                                        } else {
                                            return false
                                        }
                                    }
                                    d(this).trigger("loadSlideFromIndex", [A, y])
                                }
                            })
                        } else {
                            d(".slide_container").bind("mousemove",
                            function(s) {
                                s.preventDefault()
                            })
                        }
                        g.$content_arrows.delegate("a", "click",
                        function(s) {
                            if (j == a("LINEAR_MODE")) {
                                s.stopImmediatePropagation();
                                d(".slide_container").trigger("slideclick", s)
                            }
                        });
                        d(".slide_container").bind("mousedown",
                        function(v, s) {
                            if (j == a("LINEAR_MODE")) {
                                var u = d(v.target).parents(".slide"),
                                t = u.parents("li").hasClass("stack");
                                if ((g.events.isTextSlide(v.target) || g.events.isFlashSlide(v.target)) && u.hasClass("active") && !t) {
                                    return
                                }
                                v.preventDefault();
                                v = (typeof(s) !== "undefined") ? s: v;
                                q.capture = true;
                                q.start.x = v.pageX;
                                q.target = v.target
                            }
                        }).bind("mouseup",
                        function(w, t) {
                            if (j == a("LINEAR_MODE")) {
                                if (!g.events.isFlashSlide(w.target)) {
                                    w.preventDefault()
                                }
                                w = t || w;
                                q.capture = false;
                                q.end.x = w.pageX;
                                var s = 3,
                                x = Math.abs(q.end.x - q.start.x),
                                u,
                                v;
                                if (x <= 3) {
                                    u = w.target.className;
                                    v = d(w.target).parents(".slide");
                                    if (v.hasClass("active")) {
                                        if (u.indexOf("prev") == -1 && u.indexOf("next") == -1 && u.indexOf("up") == -1) {
                                            p.slide.loadChildSlides.call(v[0], w);
                                            return
                                        }
                                    }
                                    d(this).trigger("slideclick", [q]);
                                    d("#search_box").find(".search_text").trigger("blur")
                                }
                                q.target = undefined;
                                g.$body.focus()
                            }
                        }).bind("loadSlideFromIndex",
                        function(w, x, C) {
                            var B = a("NUM_SLIDES_TO_LOAD"),
                            u = g.activePage * B,
                            t = (u + B) - 1,
                            y = n.slides.length - 1,
                            v,
                            A = (typeof(C) === "undefined") ? false: true,
                            z = function() {
                                g.activeSlide.index = x;
                                g.viewport.render({
                                    entranceAnimation: false
                                });
                                d(".slides").css("left", "200%").find(".active").trigger("load")
                            },
                            s = function() {
                                g.activeSlide.index = x;
                                g.viewport.render({
                                    entranceAnimation: false
                                });
                                d(".slides").css("left", "-200%").find(".active").trigger("load")
                            };
                            if (x > y) {
                                C = 0
                            } else {
                                if (x < 0) {
                                    C = y
                                }
                            }
                            if (A) {
                                g.activeSlide.relativePosition = C
                            }
                            p.slide.loadSlideIndex(C);
                            g.viewport.paginate.showIndicator(C);
                            if (!r) {
                                r = window.setTimeout(function() {
                                    var D = d(".slide.active"),
                                    F = D.attr("data-title"),
                                    E = D.attr("data-type");
                                    g.tracker.recordView("Slide View - Linear", F + " (" + E + ")");
                                    r = false
                                },
                                500)
                            }
                        }).bind("slideclick",
                        function(y, s) {
                            if (!s.target) {
                                throw new Error("Invalid event passed to 'slideclick' event handler.");
                                return
                            }
                            if (g.events.isTextSlide(s.target)) {}
                            var u = s.target.tagName.toLowerCase(),
                            v = d(".snapped", ".slide_container").attr("data-index"),
                            x,
                            z;
                            y.stopPropagation();
                            switch (u) {
                            case "img":
                                x = d(s.target).parents(".slide").attr("data-index");
                                if (x != v) {
                                    p.slide.loadSlideIndex(x, s);
                                    g.viewport.paginate.showIndicator(x)
                                }
                                break;
                            case "span":
                                z = d(s.currentTarget);
                            default:
                                var w = d(".slide.active");
                                z = (!z) ? d(s.target) : z;
                                x = w.attr("data-index");
                                if (w.length) {
                                    if (z.hasClass("next")) {
                                        x = parseInt(w.attr("data-slideindex"), 10);
                                        index = parseInt(w.attr("data-index"), 10);
                                        x++;
                                        index++;
                                        if (a("ENABLE_HARDWARE_ACCELERATION") && g.is_mobile) {
                                            g.events.mobile_touch.click_next();
                                            return
                                        }
                                        d(this).trigger("loadSlideFromIndex", [x, index]);
                                        break
                                    } else {
                                        if (z.hasClass("prev")) {
                                            x = parseInt(w.attr("data-slideindex"), 10);
                                            index = parseInt(w.attr("data-index"), 10);
                                            x--;
                                            index--;
                                            if (a("ENABLE_HARDWARE_ACCELERATION") && g.is_mobile) {
                                                g.events.mobile_touch.click_prev();
                                                return
                                            }
                                            d(this).trigger("loadSlideFromIndex", [x, index]);
                                            break
                                        }
                                    }
                                    if (z.hasClass("up")) {
                                        var t = d("#title_bar_stories .last").prev();
                                        if (g.$top_bar.find(".title_bar .breadcrumb").length > 1) {
                                            t.trigger("click", [n.parent]);
                                            break
                                        }
                                    }
                                    if (w.attr("data-index") != v) {
                                        var x = parseInt(w.attr("data-index"), 10);
                                        p.slide.loadSlideIndex(x);
                                        g.viewport.paginate.showIndicator(x)
                                    } else {
                                        x = z.parents(".slide").attr("data-index");
                                        if (x !== undefined && x != v) {
                                            p.slide.loadSlideIndex(x, s);
                                            g.viewport.paginate.showIndicator(x)
                                        }
                                    }
                                }
                                if (z.hasClass("up")) {
                                    var t = d("#title_bar_stories .last").prev();
                                    if (g.$top_bar.find(".title_bar .breadcrumb").length > 1) {
                                        t.trigger("click", [n.parent])
                                    }
                                }
                                break
                            }
                            g.viewport.paginate.showIndicator.call(this)
                        });
                        d(".slide").bind("load",
                        function() {
                            if (j == a("LINEAR_MODE")) {
                                d(".slide_container").trigger("slideclick", [{
                                    target: d(this).find(".shell_contents").get(0)
                                }])
                            }
                        })
                    },
                    loadLinearImage: function(v) {
                        var u = v,
                        q = u.attr("data-image") || false,
                        t = u.attr("data-type") || "",
                        s = u.attr("data-has-poster-image") || "0",
                        w = false,
                        r = parseInt(u.attr("data-index"), 10),
                        p;
                        if (!q || t == "twitter" || t == "rss" || t == "pinterest") {
                            return
                        }
                        p = b(j) + q;
                        if ((t == "youtube" || t == "vimeo") && s == "1") {
                            p = q
                        }
                        if (r === 0 && g.is_homepage_embed()) {
                            p = "/assets/images/main/embed/slide.png";
                            w = true
                        }
                        d.preloadImage(p,
                        function() {
                            u.find(".shell_contents").show().find("img").filter(function() {
                                return ! d(this).parents(".audio-container").length
                            }).attr("src", p).css("filter", "").fadeIn().end().addClass("loaded");
                            u.find(".shell_loader").remove();
                            u.removeAttr("data-image").removeClass("rendering");
                            if (w) {
                                w = false;
                                tbwa.homepage_embed.first_slide()
                            }
                        })
                    },
                    bindGridEvents: function() {
                        var p = g.events.viewport,
                        q = p.slide.currSlide.mouse,
                        r;
                        if (!a("ENABLE_HARDWARE_ACCELERATION") && (g.is_mobile && a("ENABLE_DRAGGING_MOBILE")) || (!g.is_mobile && a("ENABLE_DRAGGING_DESKTOP"))) {
                            d(".grid").bind("touchstart",
                            function(u) {
                                var v = u.originalEvent.touches,
                                t = (v.length == 1) ? true: false,
                                s = v[0];
                                d(this).trigger("mousedown", [s])
                            }).bind("touchmove",
                            function(u) {
                                var v = u.originalEvent.touches,
                                t = (v.length == 1) ? true: false,
                                s = v[0];
                                if (!t) {
                                    return
                                }
                                d(this).trigger("mousemove", [s])
                            }).bind("touchend",
                            function(u) {
                                var v = u.originalEvent.touches,
                                t = (v.length == 1) ? true: false,
                                s = v[0];
                                d(this).trigger("mouseup", [s])
                            });
                            d(".grid").bind("mousedown",
                            function(t, s) {
                                if (g.events.isTextSlide(t.target) || g.events.isAudioSlide(t.target) || g.events.isLocationSlide(t.target)) {
                                    return
                                }
                                t.preventDefault();
                                t = (typeof(s) !== "undefined") ? s: t;
                                q.capture = true;
                                q.start.x = t.pageX;
                                q.target = t.target
                            }).bind("mouseup",
                            function(t, s) {
                                t.preventDefault();
                                t = (typeof(s) !== "undefined") ? s: t;
                                q.capture = false;
                                q.end.x = t.pageX;
                                q.target = undefined;
                                g.$body.focus()
                            }).bind("mousemove",
                            function(u, t) {
                                u.preventDefault();
                                u = (typeof(t) !== "undefined") ? t: u;
                                if (q.capture) {
                                    var v = u.pageX - q.start.x,
                                    s = a("MOUSE_THRESHOLD");
                                    if (v > s) {
                                        q.capture = false;
                                        g.$btn_content_arrow_prev.trigger("click")
                                    } else {
                                        if (v < -s) {
                                            q.capture = false;
                                            g.$btn_content_arrow_next.trigger("click")
                                        } else {
                                            return false
                                        }
                                    }
                                }
                            })
                        } else {
                            d(".grid").bind("mousemove",
                            function(s) {
                                s.preventDefault()
                            })
                        }
                        d(".grid_pagination a").bind("click",
                        function(u) {
                            u.preventDefault();
                            var s = d(this).attr("data-page"),
                            t = h * s;
                            g.activeSlide.index = t;
                            g.activeSlide.id = n.slides[t].slide_id || "0" + String(n.slides[t].stack_id);
                            g.updateHash();
                            g.viewport.render({
                                isHideBreadcrumbs: true
                            });
                            g.viewport.resizeGrid(false);
                            g.viewport.paginate.showIndicator(g.activeSlide.index)
                        });
                        g.$btn_content_arrow_up.bind("click",
                        function(t) {
                            if (j == a("GRID_MODE")) {
                                t.stopImmediatePropagation();
                                var s = d("#title_bar_stories .last").prev();
                                if (s) {
                                    g.events.stopAudio();
                                    s.trigger("click", [n.parent])
                                }
                            }
                        });
                        g.$content_arrows.find(".next, .prev").bind("click",
                        function(y) {
                            if (j == a("GRID_MODE")) {
                                y.preventDefault();
                                g.events.stopAudio();
                                y.stopImmediatePropagation();
                                var x = (d(this).hasClass("next")) ? "next": "prev";
                                if ((a("ENABLE_HARDWARE_ACCELERATION") && g.is_mobile) || (__EMBED__ && g.embedMode == a("EMBED_MODE.SMALL"))) {
                                    if (n.slides.length == 1) {
                                        return
                                    }
                                    var w = d(".slide.active"),
                                    u = n.slides.length - 1;
                                    if (!w.length) {
                                        w = d(".slide:first")
                                    }
                                    var v = w.attr("data-slideindex");
                                    if (x == "next") {
                                        v = parseInt(w.attr("data-slideindex"), 10);
                                        v++
                                    } else {
                                        v = parseInt(w.attr("data-slideindex"), 10);
                                        v--
                                    }
                                    if (v > u) {
                                        v = 0
                                    } else {
                                        if (v < 0) {
                                            v = u
                                        }
                                    }
                                    if (a("ENABLE_HARDWARE_ACCELERATION") && g.is_mobile) {
                                        if (x == "next") {
                                            g.events.mobile_touch.click_next();
                                            return
                                        } else {
                                            if (x == "prev") {
                                                g.events.mobile_touch.click_prev();
                                                return
                                            }
                                        }
                                    }
                                    w.addClass("active");
                                    p.slide.loadSlideIndex(v);
                                    g.viewport.paginate.showIndicator(v)
                                } else {
                                    var s = d(".grid_pagination"),
                                    t = s.find("a.selected")[x]();
                                    if (t.length) {
                                        t.click()
                                    } else {
                                        if (x == "next") {
                                            s.find("a:first").click()
                                        } else {
                                            s.find("a:last").click()
                                        }
                                    }
                                }
                            }
                        });
                        d("#grid_wrapper").bind("click",
                        function(v) {
                            v.preventDefault();
                            var u = d(v.target).parents(".slide"),
                            t;
                            d("#search_box").find(".search_text").trigger("blur");
                            if ((g.events.isTextSlide(v.target) || g.events.isLocationSlide(v.target)) && v.target.tagName === "A") {
                                if (v.target.href) {
                                    window.open(v.target.href);
                                    return
                                }
                            }
                            if (g.events.isAudioSlide(v.target) || d(v.target).hasClass("audio")) {
                                return
                            }
                            if (u.length) {
                                if (g.embedMode == a("EMBED_MODE.SMALL") && !u.hasClass("active") && n.slides.length > 1) {
                                    var s = u.attr("data-slideindex") - d(".grid").find(".active").attr("data-slideindex");
                                    if (s > 0) {
                                        g.$btn_content_arrow_next.click()
                                    } else {
                                        g.$btn_content_arrow_prev.click()
                                    }
                                    return
                                }
                                d(".grid").find(".active").removeClass("active");
                                u.addClass("active");
                                t = u.attr("data-slideindex");
                                g.activeSlide.index = t;
                                g.activeSlide.id = String(u.attr("data-id"));
                                g.updateHash();
                                if (u.hasClass("has_children")) {
                                    g.events.stopAudio();
                                    g.events.viewport.slide.loadChildSlides.call(u[0], v)
                                }
                            }
                        });
                        d("#grid_wrapper").find(".link").bind("click",
                        function(s) {
                            s.stopPropagation()
                        })
                    },
                    bindFullscreenEvents: function() {
                        var p = g.events.viewport,
                        q = p.slide.currSlide.mouse,
                        r;
                        if (!a("ENABLE_HARDWARE_ACCELERATION") && (g.is_mobile && a("ENABLE_DRAGGING_MOBILE")) || (!g.is_mobile && a("ENABLE_DRAGGING_DESKTOP"))) {
                            d(".slide_container").bind("touchstart",
                            function(u) {
                                var v = u.originalEvent.touches,
                                t = (v.length == 1) ? true: false,
                                s = v[0];
                                d(this).trigger("mousedown", [s])
                            }).bind("touchmove",
                            function(u) {
                                var v = u.originalEvent.touches,
                                t = (v.length == 1) ? true: false,
                                s = v[0];
                                if (!t) {
                                    return
                                }
                                d(this).trigger("mousemove", [s])
                            }).bind("touchend",
                            function(u) {
                                var v = u.originalEvent.touches,
                                t = (v.length == 1) ? true: false,
                                s = v[0];
                                d(this).trigger("mouseup", [s])
                            });
                            d(".slide_container").bind("mousedown",
                            function(t, s) {
                                if (g.events.isTextSlide(t.target) || g.events.isAudioSlide(t.target) || g.events.isLocationSlide(t.target)) {
                                    return
                                }
                                t.preventDefault();
                                t = (typeof(s) !== "undefined") ? s: t;
                                q.capture = true;
                                q.start.x = t.pageX;
                                q.target = t.target
                            }).bind("mouseup",
                            function(t, s) {
                                t.preventDefault();
                                t = (typeof(s) !== "undefined") ? s: t;
                                q.capture = false;
                                q.end.x = t.pageX;
                                q.target = undefined;
                                g.$body.focus()
                            }).bind("mousemove",
                            function(u, t) {
                                u.preventDefault();
                                u = (typeof(t) !== "undefined") ? t: u;
                                if (q.capture) {
                                    var v = u.pageX - q.start.x,
                                    s = a("MOUSE_THRESHOLD");
                                    if (v > s) {
                                        q.capture = false;
                                        g.$btn_content_arrow_prev.click()
                                    } else {
                                        if (v < -s) {
                                            q.capture = false;
                                            g.$btn_content_arrow_next.click()
                                        } else {
                                            return false
                                        }
                                    }
                                }
                            })
                        } else {
                            d(".slide_container").bind("mousemove",
                            function(s) {
                                s.preventDefault()
                            })
                        }
                        d(".slide").bind("load",
                        function() {
                            if (j == a("FULL_MODE")) {
                                var u = d(".slide_container"),
                                s = u.find(".active"),
                                t = d(this);
                                s.fadeOut(300,
                                function() {
                                    d(this).removeClass("active");
                                    u.find(".video iframe").each(function() {
                                        var v = d(this),
                                        w = v.parents(".slide:first");
                                        if (!w.hasClass("active") && v.hasClass("playing")) {
                                            v.attr("src", "").removeClass("playing");
                                            w.find(".shell_contents").find("img").show().end().find(".video_button").show()
                                        }
                                    });
                                    t.addClass("active").fadeIn(400,
                                    function() {
                                        g.viewport.resizeGrid();
                                        g.events.viewport.loadFullImages()
                                    });
                                    if ((t.attr("data-type") == "youtube" || t.attr("data-type") == "vimeo") && t.attr("data-autoplay") == "1") {
                                        t.find(".video_button a.button").trigger("click")
                                    }
                                });
                                g.events.viewport.slide.loadSlideInfo.call(t[0], true)
                            }
                        });
                        g.$btn_content_arrow_up.bind("click",
                        function(t) {
                            if (j == a("FULL_MODE")) {
                                var s = d("#title_bar_stories .last").prev();
                                if (g.$top_bar.find(".title_bar .breadcrumb").length > 1) {
                                    s.trigger("click", [n.parent])
                                }
                            }
                        });
                        g.$content_arrows.find(".prev, .next").on("click",
                        function(y) {
                            if (j == a("FULL_MODE")) {
                                y.preventDefault();
                                var u = d(".slide_container"),
                                x = (d(this).hasClass("next")) ? "next": "prev",
                                t = u.find(".active"),
                                s = u.find(".active").parent()[x](),
                                w = s.find(".slide").attr("data-slideindex"),
                                v;
                                if (s.length) {
                                    v = s.find(".slide");
                                    v.trigger("load");
                                    g.activeSlide.id = v.attr("data-id");
                                    g.activeSlide.index = w;
                                    g.activeSlide.relativePosition = v.attr("data-index");
                                    g.updateHash()
                                } else {
                                    if (x == "next") {
                                        w = 0
                                    } else {
                                        w = u.find(".slide").length - 1
                                    }
                                    v = u.find(".slide:eq(" + w + ")").load();
                                    g.activeSlide.id = v.attr("data-id");
                                    g.activeSlide.index = w;
                                    g.activeSlide.relativePosition = v.attr("data-index");
                                    g.updateHash()
                                }
                                g.viewport.paginate.showIndicator(w);
                                if (!r) {
                                    r = window.setTimeout(function() {
                                        var z = d(".slide.active"),
                                        B = z.attr("data-title"),
                                        A = z.attr("data-type");
                                        g.tracker.recordView("Slide View - Fullscreen", B + " (" + A + ")");
                                        r = false
                                    },
                                    500)
                                }
                            }
                        });
                        g.$outerWrapper.delegate(".stack .shell", "click",
                        function(u) {
                            if (j == a("FULL_MODE")) {
                                u.preventDefault();
                                u.stopPropagation();
                                var t = d(".slide_container"),
                                s = t.find(".active");
                                d("#search_box").find(".search_text").trigger("blur");
                                g.events.viewport.slide.loadChildSlides.call(s[0])
                            }
                        }).delegate(".stack .page_curl", "click",
                        function(s) {
                            d(this).parents(".stack").find(".shell").click()
                        }).delegate(".slide", "click",
                        function(t) {
                            if (j == a("FULL_MODE")) {
                                var s = d(t.target);
                                switch (t.target.tagName.toLowerCase()) {
                                case "a":
                                    if (s.hasClass("link")) {
                                        if (!s.attr("data-type") == "image" && !s.attr("data-type") == "flickr" && !s.attr("data-type") == "instagram") {
                                            window.open(s.attr("href")).focus()
                                        }
                                    }
                                    break
                                }
                            }
                        })
                    },
                    loadFullImages: function() {
                        var w = parseInt(g.activeSlide.relativePosition, 10),
                        s = d(".slide"),
                        p = s.eq(w),
                        r = a("NUM_IMAGES_TO_SHOW.full"),
                        u = s.length,
                        t,
                        q,
                        v;
                        if (w < r) {
                            v = s.slice(0, r)
                        } else {
                            if (w == u) {
                                v = s.slice( - r)
                            } else {
                                t = Math.max(w - Math.ceil(r / 2), 0);
                                q = Math.min(w + Math.ceil(r / 2), u);
                                v = s.slice(t, q)
                            }
                        }
                        v.each(function() {
                            var G = d(this),
                            B = G.attr("data-image") || false,
                            x = a("SHELL_OFFSETS"),
                            E = G.find(".video_button .button"),
                            I = G.find(".text-content"),
                            H = G.attr("data-type") || "",
                            J = G.attr("data-stack-type") || "",
                            A = G.attr("data-has-poster-image") || "0",
                            y,
                            D,
                            C;
                            if (I.length) {
                                var F = G.height() - parseInt(I.css("padding-top"), 10) - parseInt(I.css("padding-bottom"), 10) - 11;
                                if (H == "title" || J == "title" || J == "text") {
                                    var z = G.find(".shell").width() - parseInt(I.css("padding-left"), 10) - parseInt(I.css("padding-right"), 10);
                                    I.height(F + 11).width(z)
                                } else {
                                    if (H == "text") {
                                        F += 11
                                    }
                                    I.height(F)
                                }
                            } (function() {
                                window.setTimeout(function() {
                                    E.animate({
                                        opacity: 1
                                    },
                                    "normal")
                                },
                                1000)
                            })();
                            if (!B || H == "twitter" || H == "rss" || H == "pinterest") {
                                return
                            }
                            C = b(j) + B;
                            if ((H == "youtube" || H == "vimeo") && A == "1") {
                                C = B
                            } (function(L, K) {
                                d.preloadImage(K,
                                function() {
                                    L.find(".shell_contents").show().find("img").filter(function() {
                                        return ! d(this).parents(".audio-container").length
                                    }).attr("src", K).fadeIn().end().addClass("loaded");
                                    L.find(".shell_loader").remove()
                                })
                            })(G, C)
                        })
                    },
                    slide: {
                        currSlide: {
                            slideWidth: 0,
                            mouse: {
                                start: {
                                    x: 0,
                                    y: 0
                                },
                                end: {
                                    x: 0,
                                    y: 0
                                }
                            }
                        },
                        loadChildSlides: function(v, p) {
                            var u = d(".slide_container"),
                            w = d("#grid_wrapper"),
                            t,
                            s = (typeof p === "undefined") ? false: true,
                            p = p || false,
                            r,
                            q;
                            loadContainer = function() {
                                if (!p) {
                                    p = {
                                        stackId: parseInt(t.attr("data-stack-id"), 10),
                                        stackName: t.attr("data-stack-name")
                                    }
                                }
                                g.activeStack.id = p.stackId;
                                g.activeSlide.id = 0;
                                g.activeSlide.index = 0;
                                g.activeSlide.relativePosition = 0;
                                g.header.searchBar.clear();
                                g.updateHash();
                                r = t.attr("data-title") || "";
                                if (g.isTBWA && r.toLowerCase() == a("OFFICE_MATCH_TERM").toLowerCase()) {
                                    g.activeStack.id = p.stackId;
                                    g.activeStack.name = p.stackName;
                                    try {
                                        g.XHR.getJSON(a("JSONP.get") + p.stackId + a("JSONP.token"), "",
                                        function(y) {
                                            n = y;
                                            tbwa.offices.init(n);
                                            window.focus()
                                        })
                                    } catch(x) {
                                        throw new Error("Function: loadChildSlides. Unable to load TBWA Contact Us.")
                                    }
                                    return false
                                }
                                q = (p.stackId != 0) ? a("JSONP.get") + p.stackId + a("JSONP.token") : a("JSONP.getDefault") + a("JSONP.token");
                                g.XHR.getJSON(q, "",
                                function(y) {
                                    if (typeof p.slideId !== "undefined") {
                                        g.activeSlide.id = p.slideId;
                                        g.activeSlide.index = null
                                    }
                                    n = y;
                                    g.header.titleBar.setTitle("navigation", true);
                                    g.viewport.render();
                                    g.updateHash();
                                    g.viewport.resizeGrid(false);
                                    window.focus()
                                })
                            };
                            switch (j) {
                            case a("FULL_MODE"):
                                t = u.find(".slides .active");
                                if (d(this).parent().hasClass("stack") || s) {
                                    d(".slide_info").animate({
                                        opacity: 0
                                    });
                                    d(".slides").fadeOut(500,
                                    function() {
                                        loadContainer()
                                    })
                                }
                                break;
                            case a("LINEAR_MODE"):
                                t = u.find(".slides .active");
                                if (d(this).parent().hasClass("stack") || s) {
                                    d(".slide_info").animate({
                                        opacity: 0
                                    });
                                    d(".slides").animate({
                                        opacity: 0
                                    },
                                    "fast",
                                    function() {
                                        loadContainer();
                                        d(this).makeHidden().css("opacity", 1)
                                    })
                                }
                                break;
                            case a("GRID_MODE"):
                                t = w.find(".active");
                                if (!t.length) {
                                    t = d(".slide").eq(parseInt(g.activeSlide.index, 10)).addClass("active")
                                }
                                w.find(".selectedPage").fadeOut("fast",
                                function() {
                                    loadContainer()
                                });
                                break
                            }
                        },
                        loadSlideIndex: function(u, w) {
                            u = parseInt(u, 10);
                            w = (typeof(w) !== "function") ? tbwa.fn: w;
                            var t = (__EMBED__ && (g.embedMode == a("EMBED_MODE.SMALL"))),
                            v = t ? "#grid_wrapper": ".slide_container",
                            p = t ? ".grid": ".slides",
                            r = d(v),
                            x = a("ENABLE_HARDWARE_ACCELERATION") && g.is_mobile,
                            s = r.find(".slide").eq(u),
                            q = (t && g.is_mobile) ? g.mobile_embed_window_width: g.viewport.windowWidth;
                            snapCoords = Math.floor((q / 2) - (s.width() / 2)),
                            parentOffset = s.position().left,
                            moveToPos = (snapCoords - parentOffset),
                            device = (g.is_mobile) ? "mobile": "web",
                            speed = a("SCROLL_SPEED")[device],
                            $activeSlide = r.find(".slide.active");
                            if (!s.hasClass("noAnimation")) {
                                if (x) {
                                    w()
                                } else {
                                    r.find(p).stop().animate({
                                        left: moveToPos
                                    },
                                    speed, a("SCROLL_EASING"),
                                    function() {
                                        w()
                                    })
                                }
                            } else {
                                if (x) {} else {
                                    r.find(".slides").css("left", moveToPos)
                                }
                            }
                            r.find(".snapped, .active").removeClass("snapped active");
                            s.addClass("snapped active");
                            this.loadSlideInfo.call(s[0], !s.hasClass("noAnimation"));
                            s.removeClass("noAnimation");
                            g.activeSlide.id = s.attr("data-id");
                            g.activeSlide.index = s.attr("data-slideindex");
                            g.activeSlide.relativePosition = s.attr("data-index");
                            g.updateHash();
                            r.find(".video iframe").each(function() {
                                var y = d(this),
                                z = y.parents(".slide:first");
                                if (!z.hasClass("active") && y.hasClass("playing")) {
                                    y.attr("src", "").removeClass("playing");
                                    z.find(".shell_contents").find("img").show().end().find(".video_button").show()
                                }
                            });
                            if (!t) {}
                            if ((s.attr("data-type") == "youtube" || s.attr("data-type") == "vimeo") && s.attr("data-autoplay") == "1") {
                                s.find(".video_button a.button").trigger("click")
                            }
                        },
                        loadSlideInfo: function(s) {
                            s = s || false;
                            var v = (__EMBED__) ? "1": "0",
                            u = __EMBED__ && g.embedMode == a("EMBED_MODE.SMALL"),
                            t = d(".slide_info"),
                            r = d(this),
                            q = r.attr("data-title"),
                            w = d(".slide_info_wrapper"),
                            p = function() {
                                if (t.length) {
                                    t.find(".title").html(g.viewport.slides.set_title(q));
                                    if (!q) {
                                        t.addClass("no_slide_title");
                                        if (w.find(".slide_tags").length == 0) {
                                            w.css("opacity", 0)
                                        }
                                    } else {
                                        t.removeClass("no_slide_title");
                                        w.css("opacity", 1)
                                    }
                                }
                                if (!__EMBED__ || (__EMBED__ && !u)) {
                                    if (!r.hasClass("noAnimation") && t.length) {
                                        t.animate({
                                            opacity: 0.8
                                        },
                                        {
                                            easing: "linear",
                                            complete: function() {
                                                if (d.browser.msie) {
                                                    t.css("filter", "")
                                                }
                                            }
                                        })
                                    } else {
                                        r.removeClass("noAnimation")
                                    }
                                }
                            };
                            if (r.hasClass("noAnimation")) {
                                g.viewport.slides.set_title(q);
                                p();
                                if (t.length) {
                                    t.css("opacity", 0.8)
                                }
                                if (s && t.length) {
                                    t.makeVisible()
                                }
                            } else {
                                if (t.length && r.get(0) !== window) {
                                    t.stop().animate({
                                        opacity: 0
                                    },
                                    "normal",
                                    function() {
                                        g.viewport.slides.set_title(q);
                                        p();
                                        if (s) {
                                            d(this).makeVisible()
                                        }
                                    })
                                }
                            }
                        },
                        mousemove: function(p) {}
                    },
                    renderSlidesInView: function() {
                        var p = d(".slide:not(.offscreen):not(.rendering)").addClass("offscreen");
                        p.appear(g.events.viewport.renderSlide, {
                            offscreen_padding: __EMBED__ && g.embedMode == a("EMBED_MODE.SMALL") ? 250 : 600
                        })
                    },
                    renderSlide: function() {
                        var p = d(this);
                        if (!p.hasClass("rendering")) {
                            p.toggleClass("offscreen rendering").trigger("renderSlide");
                            if (j == a("LINEAR_MODE")) {
                                g.events.viewport.loadLinearImage(p)
                            }
                        }
                    }
                },
                pagination: {
                    init: function() {
                        var p = d(".pagination");
                        p.delegate(".thumb a", "click",
                        function(v) {
                            v.preventDefault();
                            if (d(this).parent().hasClass("blank")) {
                                return
                            }
                            var y = a("NUM_SLIDES_TO_LOAD"),
                            u = d(".pagination"),
                            z = u.find(".indicator"),
                            r = g.viewport.paginate.totalThumbs,
                            q,
                            A,
                            x,
                            s;
                            if (r == null) {
                                r = u.find(".thumb a")
                            }
                            q = r.index(this);
                            x = Math.floor(q / y);
                            if (x == 0) {
                                A = q
                            } else {
                                A = q - (x * y)
                            }
                            g.activeSlide.relativePosition = q;
                            g.activeSlide.index = q;
                            switch (j) {
                            case a("LINEAR_MODE"):
                                d(".slide_container").trigger("loadSlideFromIndex", [q, q]);
                                break;
                            case a("GRID_MODE"):
                                var t = d(".grid_pagination"),
                                w = t.find(".selected").index();
                                page = Math.floor(q / h);
                                if (page != w) {
                                    t.find("a:eq(" + page + ")").click()
                                }
                                g.activeSlide.index = q;
                                g.activeSlide.id = n.slides[q].slide_id || "0" + String(n.slides[q].stack_id);
                                g.updateHash();
                                break;
                            case a("FULL_MODE"):
                                s = d(".slide:eq(" + q + ")").trigger("load");
                                g.activeSlide.id = s.attr("data-id");
                                g.activeSlide.index = q;
                                g.activeSlide.relativePosition = s.attr("data-index");
                                g.updateHash();
                                break
                            }
                            g.viewport.paginate.showIndicator(q)
                        }).delegate(".arrow a", "click",
                        function(q) {
                            q.preventDefault()
                        }).delegate(".arrow a", "mousedown",
                        function(t) {
                            t.preventDefault();
                            var r = d(this).parent(),
                            u = p.find("ul"),
                            v = u.width(),
                            q = parseInt(u.css("margin-left")),
                            s = 5;
                            thumb_width = p.find(".thumb").outerWidth(true) * s;
                            thumb_margin_left = parseInt(p.find(".thumb").css("margin-left")),
                            viewable_area = p.find(".thumbWrapper").width(),
                            max_left = Math.abs(viewable_area - v),
                            move_amount = 0,
                            arrow_class = "";
                            if (r.hasClass("next") && q > -max_left) {
                                arrow_class = "next";
                                if (q + max_left < thumb_width) {
                                    thumb_width = q + max_left
                                }
                                move_amount = -1 * thumb_width
                            } else {
                                if (r.hasClass("prev") && q < 0) {
                                    arrow_class = "prev";
                                    if (q + thumb_width > 0) {
                                        thumb_width = -q + thumb_margin_left
                                    }
                                    move_amount = thumb_width
                                }
                            }
                            if (move_amount != 0) {
                                p.trigger("animateTo", [q + move_amount, arrow_class])
                            }
                        }).bind("animateTo",
                        function(q, r, s) {
                            p.find("ul").stop().animate({
                                "margin-left": r
                            },
                            500, a("SCROLL_EASING"))
                        }).delegate(".nav", "click",
                        function(q) {
                            q.preventDefault();
                            p.trigger("togglePagination")
                        }).bind("togglePagination",
                        function(q, s) {
                            var r = g.events.getPaginationOpenValue(),
                            t = g.events.getPaginationCloseValue();
                            if (s || p.hasClass("open")) {
                                p.stop().animate({
                                    bottom: t,
                                },
                                a("SCROLL_SPEED").web, a("SCROLL_EASING"),
                                function() {
                                    p.removeClass("open")
                                })
                            } else {
                                d(".user_profile_toggle:visible").trigger("toggleUserProfile", true);
                                p.addClass("open").stop().animate({
                                    bottom: r,
                                },
                                a("SCROLL_SPEED").web, a("SCROLL_EASING"))
                            }
                        })
                    }
                },
                onhashchange: function() {
                    if (!m) {
                        var q = g.getURLHashValues(location.hash.replace("#", "")),
                        p = (q.stackId == g.activeStack.id) ? true: false,
                        r;
                        if (q && p && q.searchQuery == "") {
                            switch (q.appMode) {
                            case "l":
                                r = a("LINEAR_MODE");
                                break;
                            case "g":
                                r = a("GRID_MODE");
                                break;
                            case "f":
                                r = a("FULL_MODE");
                                break
                            }
                            g.activeSlide.index = g.getSlideIndex(q.slideId);
                            g.activeSlide.id = q.slideId;
                            g.activeStack.id = q.stackId;
                            if (r == j) {
                                d(".slide").eq(g.activeSlide.index).trigger("load");
                                m = false
                            } else {
                                location.reload()
                            }
                        } else {}
                    } else {
                        m = false
                    }
                },
                window: {
                    lastEvent: null,
                    init: function() {
                        var p = g.events.viewport.slide,
                        r = g.$body.hasClass("embed_mode"),
                        s = [".logo:first", ".slide_info", "#content_arrows .up", "#content_arrows .prev", "#content_arrows .next", ".view_panel", "#top_bar_inner", ".pagination", "#footer", "#footer-copyright"],
                        q = ["#content_arrows .up", "#content_arrows .prev", "#content_arrows .next", ".pagination"];
                        d.resize.throttleWindow = true;
                        d.resize.delay = 1000;
                        g.$window.bind("resize", tbwa.application.viewport.resizeGrid).hashchange(g.events.onhashchange).bind("orientationchange",
                        function(t) {
                            if (window.orientation == 90 || window.orientation == -90) {
                                g.$body.addClass("landscape").removeClass("portrait")
                            } else {
                                g.$body.removeClass("landscape").addClass("portrait")
                            }
                        }).trigger("orientationchange");
                        g.events.load_background_image();
                        if (r) {
                            s = q
                        }
                        g.$document.bind("idle.idleTimer",
                        function() {
                            if (!d("#colorbox:visible").length && j == a("FULL_MODE") && !g.$body.hasClass("idle")) {
                                var t = function() {
                                    return d(s.join(",")).stop().animate({
                                        opacity: 0
                                    },
                                    250)
                                };
                                g.is_idle = true;
                                d.when(t()).done(function() {
                                    g.$body.addClass("idle");
                                    d(".pagination").trigger("togglePagination", true);
                                    d("#title_bar_expanded").trigger("toggleBreadcrumbs", true);
                                    d(".user_profile_toggle").trigger("toggleUserProfile", true)
                                })
                            }
                        }).bind("active.idleTimer",
                        function() {
                            if (!d("#colorbox:visible").length) {
                                g.is_idle = false;
                                g.$body.removeClass("idle");
                                d(s.join(",")).stop().animate({
                                    opacity: 1
                                });
                                d(".slide_info").stop().animate({
                                    opacity: 0.8
                                })
                            }
                        }).bind("click",
                        function(u) {
                            var t = d(u.target);
                            if (!t.parents(".title_bar").length) {
                                d("#title_bar_expanded").trigger("toggleBreadcrumbs", true)
                            }
                            if (!t.parents("#footer").length) {
                                d(".user_profile_toggle").trigger("toggleUserProfile", true)
                            }
                        }).bind("keyup",
                        function(y) {
                            var x = function() {
                                var B = g.$top_bar.find(".title_bar"),
                                A = d("#title_bar_stories .last").prev();
                                A = (A.prev().length) ? A.prev() : A;
                                if (A.length) {
                                    if (A[0].tagName != "A") {
                                        A = A.find("a")
                                    }
                                    A.click()
                                } else {
                                    if (g.embedMode == a("EMBED_MODE.SMALL")) {
                                        g.events.viewport.slide.loadSlideIndex(0)
                                    } else {
                                        d(".pagination li:first a").click()
                                    }
                                }
                            },
                            u = function() {
                                var A = d("#title_bar_stories .last").prev();
                                if (A) {
                                    g.events.stopAudio();
                                    A.trigger("click", [n.parent])
                                }
                            };
                            if (d("#search_box .search_text").attr("data-focused") == "true") {
                                if (y.keyCode == 13) {
                                    y.preventDefault();
                                    y.stopPropagation();
                                    y.stopImmediatePropagation()
                                }
                                return
                            }
                            if (this.lastEvent != null) {
                                var t = y.timeStamp - this.lastEvent;
                                if (t < 300) {
                                    return
                                }
                            }
                            this.lastEvent = y.timeStamp;
                            var z = function(G) {
                                if (typeof G === "undefined") {
                                    return
                                }
                                g.events.stopAudio();
                                var E = d(".slide_container"),
                                B = E.find(".active"),
                                D = B.data("disable-keys") || false,
                                C,
                                F;
                                if (D) {
                                    return
                                }
                                switch (G.keyCode) {
                                case 13:
                                    if (B.attr("data-type") == "youtube" || B.attr("data-type") == "vimeo") {
                                        B.find(".video_button a.button").trigger("click")
                                    } else {
                                        g.events.viewport.slide.loadChildSlides.call(B[0])
                                    }
                                    break;
                                case 66:
                                    G.preventDefault();
                                    G.stopPropagation();
                                    x();
                                    break;
                                case 32:
                                    d(".pagination").trigger("togglePagination");
                                    break;
                                case 37:
                                    E.trigger("slideclick", [{
                                        target: g.$btn_content_arrow_prev[0]
                                    }]);
                                    break;
                                case 38:
                                    u();
                                    break;
                                case 39:
                                    E.trigger("slideclick", [{
                                        target: g.$btn_content_arrow_next[0]
                                    }]);
                                    break;
                                case 40:
                                    g.events.viewport.slide.loadChildSlides.call(B[0]);
                                    break;
                                case 66:
                                    if (!__EMBED__) {
                                        g.$view_panel.find(".background a").trigger("click")
                                    }
                                    break;
                                case 70:
                                    if (!__EMBED__ && g.$view_panel.find(".presentation_view a").is(":visible")) {
                                        g.$view_panel.find(".presentation_view a").trigger("click")
                                    }
                                    break;
                                case 80:
                                    if (!__EMBED__ && g.$btn_presentation_view.is(":visible")) {
                                        g.$btn_presentation_view.trigger("click")
                                    }
                                    break;
                                case 83:
                                    var A = g.$top_bar.find(".share");
                                    if (A.length) {
                                        A.trigger("click")
                                    }
                                    break;
                                case 71:
                                    if (!__EMBED__ && g.$btn_grid_view.is(":visible")) {
                                        g.$btn_grid_view.trigger("click")
                                    }
                                    break
                                }
                            };
                            var w = function(G) {
                                if (typeof G === "undefined") {
                                    return
                                }
                                g.events.stopAudio();
                                var F = d(".slide_container"),
                                E = d(".grid").find(".slide.flash").data("disable-keys") || false,
                                D,
                                C;
                                if (E) {
                                    return
                                }
                                switch (G.keyCode) {
                                case 13:
                                    if (g.embedMode == a("EMBED_MODE.SMALL")) {
                                        var B = d(".grid").find(".slide.active");
                                        if (B.hasClass("video")) {
                                            B.find(".video_button a.button").trigger("click")
                                        } else {
                                            if (B.hasClass("has_children")) {
                                                g.events.viewport.slide.loadChildSlides.call(B[0], G)
                                            }
                                        }
                                    }
                                    break;
                                case 66:
                                    G.preventDefault();
                                    G.stopPropagation();
                                    x();
                                    break;
                                case 32:
                                    d(".pagination").trigger("togglePagination");
                                    break;
                                case 37:
                                    D = g.$btn_content_arrow_prev;
                                    if (D.length) {
                                        D.trigger("click")
                                    }
                                    break;
                                case 38:
                                    u();
                                    break;
                                case 39:
                                    C = g.$btn_content_arrow_next;
                                    if (C.length) {
                                        C.trigger("click")
                                    }
                                    break;
                                case 40:
                                    var B = d(".grid").find(".slide.active");
                                    if (B.hasClass("has_children")) {
                                        g.events.viewport.slide.loadChildSlides.call(B[0])
                                    }
                                    break;
                                case 66:
                                    g.$view_panel.find(".background a").trigger("click");
                                    break;
                                case 70:
                                    if (!__EMBED__ && g.$view_panel.find(".presentation_view a").is(":visible")) {
                                        g.$view_panel.find(".presentation_view a").trigger("click")
                                    }
                                    break;
                                case 76:
                                    if (g.$btn_linear_view.is(":visible")) {
                                        g.$btn_linear_view.trigger("click")
                                    }
                                    break;
                                case 80:
                                    if (!__EMBED__ && g.$btn_presentation_view.is(":visible")) {
                                        g.$btn_presentation_view.trigger("click")
                                    }
                                    break;
                                case 83:
                                    var A = g.$top_bar.find(".share");
                                    if (A.length) {
                                        A.trigger("click")
                                    }
                                    break
                                }
                            };
                            var v = function(G) {
                                if (typeof G === "undefined") {
                                    return
                                }
                                g.events.stopAudio();
                                var F = d(".slide_container"),
                                B = F.find(".active"),
                                E = B.data("disable-keys") || false,
                                H = g.$top_bar.find(".title_bar"),
                                D,
                                C;
                                if (E) {
                                    return
                                }
                                switch (G.keyCode) {
                                case 13:
                                    if (B.attr("data-type") == "youtube" || B.attr("data-type") == "vimeo") {
                                        B.find(".video_button a.button").trigger("click")
                                    } else {
                                        g.events.viewport.slide.loadChildSlides.call(B[0])
                                    }
                                    break;
                                case 66:
                                    G.preventDefault();
                                    G.stopPropagation();
                                    x();
                                    break;
                                case 32:
                                    d(".pagination").trigger("togglePagination");
                                    break;
                                case 37:
                                    g.$btn_content_arrow_prev.trigger("click");
                                    break;
                                case 38:
                                    u();
                                    break;
                                case 39:
                                    g.$btn_content_arrow_next.trigger("click");
                                    break;
                                case 40:
                                    g.events.viewport.slide.loadChildSlides.call(B[0]);
                                    break;
                                case 66:
                                    g.$view_panel.find(".background a").trigger("click");
                                    break;
                                case 71:
                                    if (g.$btn_grid_view.is(":visible")) {
                                        g.$btn_grid_view.trigger("click")
                                    }
                                    break;
                                case 76:
                                    if (g.$btn_linear_view.is(":visible")) {
                                        g.$btn_linear_view.trigger("click")
                                    }
                                    break;
                                case 70:
                                    if (!__EMBED__ && g.$view_panel.find(".presentation_view a").is(":visible")) {
                                        g.$view_panel.find(".presentation_view a").trigger("click")
                                    }
                                    break;
                                case 83:
                                    var A = g.$top_bar.find(".share");
                                    if (A.length) {
                                        A.trigger("click")
                                    }
                                    break
                                }
                            };
                            if (y.keyCode) {
                                switch (y.keyCode) {
                                case 76:
                                case 71:
                                case 70:
                                case 80:
                                    if (n.slides.length == 0 || (g.activeSlide.index == null && g.activeSlide.id == 0 && g.header.searchBar.query)) {
                                        return
                                    }
                                    break
                                }
                            }
                            switch (j) {
                            case a("LINEAR_MODE"):
                                z(y);
                                break;
                            case a("GRID_MODE"):
                                w(y);
                                break;
                            case a("FULL_MODE"):
                                v(y);
                                break
                            }
                        });
                        if (__EMBED__) {
                            document.onkeydown = function(t) {
                                t = t || window.event;
                                var u = t.keyCode;
                                if (u == 32 || (u >= 37 && u <= 40)) {
                                    return false
                                }
                            }
                        }
                    }
                },
                load_background_image: function() {
                    var p = d("#bg"),
                    r = p.find(".bg-image").length,
                    q;
                    if (p.length && (!g.hasOwnProperty("is_loading_background") || !g.is_loading_background && p.length)) {
                        g.is_loading_background = true;
                        q = p.data("background-image");
                        d.preloadImage(q,
                        function() {
                            if (!__EMBED__ || (__EMBED__ && g.embedMode != a("EMBED_MODE.SMALL")) || (__EMBED__ && g.embedMode == a("EMBED_MODE.SMALL") && g.is_spotlites)) {
                                if (r) {
                                    p.find(".bg-image").attr("src", q)
                                } else {
                                    p.css({
                                        "background-image": "url(" + q + ")"
                                    }).animate({
                                        opacity: 1
                                    })
                                }
                                if (r) {
                                    g.$window.bind("load",
                                    function() {
                                        g.events.scale_to_fit_bg()
                                    }).resize(g.events.scale_to_fit_bg)
                                }
                            }
                        });
                        if (!r && g.is_mobile && __EMBED__) {
                            g.$window.bind("load",
                            function() {
                                p.height(window.innerHeight - 60)
                            })
                        }
                    }
                },
                scale_to_fit_bg: function() {
                    var r = function() {
                        return ! __EMBED__ || (__EMBED__ && g.embedMode != a("EMBED_MODE.SMALL")) || (__EMBED__ && g.embedMode == a("EMBED_MODE.SMALL") && g.is_spotlites)
                    };
                    if (r()) {
                        var u = d("#bg"),
                        w = u.find(".bg-image"),
                        y = j == a("FULL_MODE"),
                        s = w.width(),
                        v = w.height(),
                        q = s / v,
                        p = v / s,
                        t = g.is_mobile ? window.innerWidth: g.$window.width(),
                        x = g.is_mobile ? window.innerHeight: g.$window.height();
                        if (s == 0 || v == 0) {
                            return
                        }
                        if (!y) {
                            x -= d("#top_bar:visible").height() + d("#footer:visible").height()
                        }
                        u.css({
                            width: t,
                            height: x
                        });
                        if (t / x >= q) {
                            w.css({
                                width: t,
                                height: Math.ceil(p * t),
                                left: 0,
                                top: -1 * (Math.abs(p * t - x) / 2)
                            })
                        } else {
                            w.css({
                                width: Math.ceil(q * x),
                                height: x,
                                top: 0,
                                left: -1 * (Math.abs(q * x - t) / 2)
                            })
                        }
                        if (u.css("opacity") == 0) {
                            setTimeout(function() {
                                if (r()) {
                                    u.animate({
                                        opacity: 1
                                    })
                                }
                            },
                            200)
                        }
                    }
                },
                getPaginationOpenValue: function() {
                    var p = __EMBED__ ? 86 : 30;
                    if (g.$outerWrapper.hasClass("full_mode")) {
                        p -= 30
                    }
                    return p
                },
                getPaginationCloseValue: function() {
                    var p = __EMBED__ ? 30 : -28;
                    if (g.$outerWrapper.hasClass("full_mode")) {
                        p -= 30
                    }
                    return p
                },
                stopAudio: function() {
                    if (d(".sc-player.playing").length) {
                        d(".sc-player.playing").find(".sc-pause").click()
                    }
                },
                isLocationSlide: function(p) {
                    return d(p).parents(".location-container").length
                },
                isAudioSlide: function(p) {
                    return d(p).parents(".audio-container").length
                },
                isFoursquareSlide: function(p) {
                    return d(p).parents(".foursquare-data").length
                },
                isFlashSlide: function(p) {
                    return d(p).parents(".flash-wrapper").length
                },
                isTextSlide: function(t) {
                    var p = d(t),
                    q = "text-content",
                    u = "vcard",
                    r = "link",
                    s = false;
                    if (p.hasClass(q) || p.parents("." + q).length) {
                        s = true
                    } else {
                        if (p.parents("." + u).length) {
                            s = true
                        } else {
                            if (p.hasClass(r)) {
                                s = true
                            } else {
                                if (p.siblings("." + q).length) {
                                    s = true
                                }
                            }
                        }
                    }
                    return s
                }
            },
            activeStack: {
                id: 0,
                name: ""
            },
            activeSlide: {
                id: 0,
                index: null,
                relativePosition: null
            },
            activePage: 0,
            end: function() {},
            embedMode: a("EMBED_MODE.LARGE"),
            extend: function() {
                var p = (arguments.length) ? arguments[0] : undefined;
                if (typeof(p) !== "object") {
                    return
                }
                for (var t in p) {
                    var u = tbwa;
                    for (var q = 0,
                    s = t.split("."), r = s.length - 1; q <= r; q++) {
                        if (typeof u[s[q]] !== "undefined" && q != r) {
                            u = u[s[q]]
                        }
                        if (q == r) {
                            u[s[q]] = p[t]
                        }
                    }
                }
            },
            getCurrentMode: function(q) {
                var p;
                q = (typeof q === "undefined") ? j: q;
                switch (q) {
                case a("LINEAR_MODE"):
                    p = "linear_mode";
                    break;
                case a("GRID_MODE"):
                    p = "grid_mode";
                    break;
                case a("FULL_MODE"):
                    p = "full_mode";
                    break;
                default:
                    throw new Error("Invalid mode passed in getCurrentMode.");
                    return false
                }
                return p
            },
            getObjectFromQuery: function(q) {
                var p = {};
                q.replace(/\b([^&=]*)=([^&=]*)\b/g,
                function(r, s, t) {
                    if (typeof p[s] != "undefined") {
                        p[s] += "," + t
                    } else {
                        p[s] = t
                    }
                });
                return p
            },
            getSlideIndex: function(u) {
                if (typeof(u) == "undefined") {
                    throw new Error("Must pass id when calling function getSlideIndex");
                    return
                }
                var r = n.slides,
                s = 0,
                p = (u.length > 0 && u.substring(0, 1) == "0") ? "stack_id": "slide_id";
                u = parseInt(u, 10);
                for (var q = 0,
                t = r.length; q < t; q++) {
                    if (r[q][p] == u) {
                        s = q;
                        break
                    }
                }
                return s
            },
            getSlidesFromId: function(q) {
                var p;
                if (typeof(q) == "undefined") {
                    throw new Error("Must pass id when calling function getSlidesFromId");
                    return
                }
                p = g.getSlideIndex(q);
                return g.getSlidesFromIndex(p)
            },
            getSlidesFromIndex: function(x) {
                if (typeof(x) === "undefined") {
                    throw new Error("Must pass index in getSlidesFromIndex.");
                    return
                }
                var q = n.slides,
                w = q.length,
                p, y = x,
                u, v = [],
                z = w - 1,
                A = 0,
                B,
                t;
                switch (j) {
                case a("LINEAR_MODE"):
                    p = w;
                    break;
                case a("GRID_MODE"):
                    if ((a("ENABLE_HARDWARE_ACCELERATION") && g.is_mobile) || g.embedMode == a("EMBED_MODE.SMALL")) {
                        p = w
                    } else {
                        p = h
                    }
                    break;
                case a("FULL_MODE"):
                    p = w;
                    break
                }
                pageNum = Math.floor(Math.abs(y / p));
                B = pageNum * p;
                t = B + (p - 1);
                for (var s = B,
                r = 0; s <= t; s++, r++) {
                    if (s == y) {
                        g.activeSlide.relativePosition = r
                    }
                    u = q[s];
                    if (u) {
                        v[r] = {
                            index: s,
                            object: u
                        }
                    } else {
                        break
                    }
                }
                A = Math.floor(y / p);
                g.activePage = A;
                return v
            },
            htmlTemplates: {
                ajaxError: '<div id="XHRError"><p>{error_message}</p></div>',
                audioPlayer: '<div class="audio-container"><div class="sc-player"><a href="{resource_data}">{audio_name}</a></div></div>',
                audioSlideCSS: "#{base_id} .sc-player, #{base_id} .sc-scrubber, #{base_id} .sc-scrubber .sc-played, #{base_id} .sc-scrubber .sc-time-span img {background-color: {player_color}}",
                blankIframe: "<iframe frameborder='0' src='{domain}/docs/blank'></iframe>",
                stackBorders: '<div class="stack_shadow stack_shadow_1"></div><div class="stack_shadow stack_shadow_2"></div>',
                stackBordersThumb: '<span class="stack_shadow stack_shadow_1"></span><span class="stack_shadow stack_shadow_2"></span>',
                facebookLikebox: '<iframe src="http://www.facebook.com/plugins/likebox.php?href={resource_data}&amp;width={width}&amp;height={height}&amp;colorscheme={colorscheme}&amp;show_faces=false&amp;border_color=000&amp;stream=true&amp;header=false&amp;appId=266024073429715" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:{width}px; height:{height}px" allowTransparency="false;"></iframe>',
                feedBadge: '<div class="badge"></div>',
                feedVisitLink: '<a href="{feed-link}" class="visit-feed hideText link">Visit the Feed</a>',
                flashTemplate: "<div class='flash-wrapper' data-content-id='flash-content-{id}'><div class='flash-content' id='flash-content-{id}'></div><img class='flash-image' src='{image-src}' alt='' /></div>",
                flashContentTemplate: "<div class='flash-content' id='{content-id}'></div>",
                fullTemplate: null,
                googleDocs: '<iframe src="{url}" style="background-color:#FFF; overflow:auto;"></iframe>',
                googleDocsImage: "{url}",
                gridPaginateTemplate: "<div class='grid_pagination'><a href='#'>&nbsp;</a></div>",
                gridTemplate: null,
                linearTemplate: null,
                linkCSS: "<link rel='stylesheet' type='text/css' media='all' href='{href}'/>",
                locationContainer: '<div class="location-container"></div>',
                externalLinks: "<a class='link hideText' href='#' onclick='void(0)' target='_blank'>{content}</a>",
                noResults: "<p class='message'><span>No Results</span></p>",
                pageCurl: "<div class='sprite page_curl'></div>",
                paginateTemplate: null,
                privacyPolicy: null,
                searchResults: "<div id='searchResultsWrapper'><ul></ul><div class='shadow'></div></div>",
                shareDescription: "Check out {username}'s #projeqt",
                siteVisitLink: '<a href="{site-link}" class="visit-site hideText link">Visit Site</a>',
                slideInfoTemplate: null,
                spotifyTemplate: '<iframe src="https://embed.spotify.com/?uri={uri}&view=coverart" width="{width}" height="{height}" frameborder="0" allowtransparency="true"></iframe>',
                tagWrapper: "<span class='tag'>{content}</span>",
                rssHeadline: '<h1><a href="{item_link}">{item_title}</a></h1>',
                rssMeta: '<h2 class="meta">{item_meta}</h2>',
                textHeader: "<h1>{headline}</h1>",
                textContainerBg: '<span class="text_bg"></span>',
                titleBarTemplate: null,
                titleBarThumbTemplate: '<img class="thumb" src="{image-src}" alt="{name}" />',
                tootInReplyTo: '<a href="http://twitter.com/{username}/status/{toot-id}/">in reply to {username}</a>',
                tootMeta: '<span class="meta">{date} via {source} {in-reply}</span>',
                tootProfileImg: '<a class="profile_img" href="http://twitter.com/{username}"><img src="{image-src}" alt="{username}" /></a>',
                noFeedResults: '<li class="no-results">No search results for: {query}</li>',
                upArrow: '<a class="up"></a>',
                userSlideCSS: "#{base_id} p, #{base_id} ol, #{base_id} ul, #{base_id}.rss .meta, #{base_id}.rss .content, #{base_id} .tweet .meta, #{base_id} .text-content{ color:{body_color};} #{base_id} .bgimage {background-image:{background_image};} #{base_id} a, #{base_id} a:visited, #{base_id} .tweet .meta a, #{base_id} .tweet .meta a:visited {color:{link_color}; text-decoration:none;} #{base_id} a:hover, #{base_id} .tweet .meta a:hover {color:{hover_color}; text-decoration:underline;} #{base_id} h1, #{base_id} .tweet {color:{headline_color};} #{base_id} h1 a {color:{headline_color}; text-decoration:none;} #{base_id} h1 a:hover, #{base_id} .tweet a:hover{color:{hover_color}; text-decoration:underline}",
                videoIcon: "<div class='video_button'><a href='#' class='button noEffect'></a></div>",
                videoSlide: "<iframe src='' frameborder='0'></iframe>"
            },
            getURLHashValues: function(q) {
                if (typeof(q) === "undefined") {
                    return ""
                }
                var p = "";
                q = q.match(/^(l|g|f)(si\d+)(ci\d+)(b\d)?(q.*)$/i) || [];
                if (q && q.length === 6) {
                    bgColor = (typeof has);
                    p = {
                        appMode: q[1].toLowerCase(),
                        slideId: String(q[2].match(/\d+/)[0]),
                        stackId: q[3].match(/\d+/)[0],
                        searchQuery: unescape(q[q.length - 1]).substring(1),
                        backgroundColor: ((typeof q[4] === "string" && g.isTBWA) ? q[4].match(/\d+/)[0] : (g.$outerWrapper.hasClass("bgdark") ? 1 : 0))
                    }
                }
                return p
            },
            checkURL: function() {
                if (location.hash === "") {
                    return
                }
                var r = location.href,
                s = location.hash,
                p = location.search,
                u = location.protocol,
                v = location.host,
                x = location.pathname,
                q = /^([^q]+)q(%3F.*)$/,
                w, t;
                if (/q%3F/.test(s)) {
                    w = s.replace(q, "$1q");
                    t = decodeURIComponent(s.replace(q, "$2"));
                    if (p.indexOf("?") > -1) {
                        p += t.replace(/^\?/, "&")
                    } else {
                        p = t
                    }
                    location.replace(u + "//" + v + x + p + w)
                }
            },
            loadURL: function() {
                var s = g.$outerWrapper.attr("class").split(" "),
                p = location.hash.replace("#", ""),
                r = null;
                for (var q = 0,
                t = s.length; q < t; q++) {
                    switch (s[q]) {
                    case "linear_mode":
                        r = "l";
                        break;
                    case "grid_mode":
                        r = "g";
                        break;
                    case "full_mode":
                        r = "f";
                        break
                    }
                    if (r) {
                        break
                    }
                }
                p = this.getURLHashValues(p);
                if (typeof(p) === "object") {
                    r = p.appMode;
                    g.activeSlide.id = p.slideId;
                    g.activeSlide.index = null;
                    g.activeStack.id = p.stackId;
                    g.viewport.backgroundColor = f = p.backgroundColor;
                    g.header.searchBar.query = (p.searchQuery > 0 && p.searchQuery <= 50) ? p.searchQuery: ""
                }
                switch (r) {
                case "l":
                    g.setCurrentMode(a("LINEAR_MODE"));
                    g.$btn_linear_view.addClass("selected");
                    break;
                case "g":
                    g.setCurrentMode(a("GRID_MODE"));
                    g.$view_panel.find(".grid_view a").addClass("selected");
                    break;
                case "f":
                    g.setCurrentMode(a("FULL_MODE"));
                    g.$view_panel.find(".full_screen a").addClass("selected");
                    break
                }
            },
            preloadImageGroup: function(p, u) {
                u = u || tbwa.fn;
                var q = p || false,
                t;
                if (!q) {
                    throw new Error("Invalid parameter passed to preloadImageGroup function.");
                    return
                } else {
                    q = p.join(",").split(",")
                }
                for (var s = 0,
                r = (q) ? q.length: 0; s < r; s++) {
                    t = "/assets/images/" + q[s]; (function(w, v) {
                        d.preloadImage(t,
                        function() {
                            if (v !== undefined) {
                                v[w] = undefined;
                                var x = v.join(",").replace(/,/g, "").length;
                                if (x == 0) {
                                    v = undefined;
                                    jQuery.isFunction(u) ? u() : null
                                }
                            }
                        })
                    })(s, q)
                }
            },
            renderEmbedSize: function() {
                var q = g.$window.width(),
                p = g.$window.height();
                if (__EMBED__ && (q < a("EMBED_MODE.LARGE_MIN_SIZE.WIDTH") || p < a("EMBED_MODE.LARGE_MIN_SIZE.HEIGHT"))) {
                    if (g.embedMode != a("EMBED_MODE.SMALL")) {
                        g.$body.addClass("embed_mode_small");
                        g.embedMode = a("EMBED_MODE.SMALL");
                        if (g.is_mobile) {
                            g.mobile_embed_window_width = window.innerWidth
                        }
                        g.setCurrentMode(a("GRID_MODE"));
                        g.activeSlide.index = g.activeSlide.index || g.getSlideIndex(g.activeSlide.id);
                        d(".slide").eq(parseInt(g.activeSlide.index, 10)).addClass("active");
                        g.activeSlide.relativePosition = g.activeSlide.index;
                        g.$view_panel.find(".grid_view a").click();
                        if (g.is_spotlites) {
                            g.events.load_background_image()
                        } else {
                            d("#bg").css("opacity", 0)
                        }
                    }
                } else {
                    if (g.embedMode != a("EMBED_MODE.LARGE")) {
                        g.$body.removeClass("embed_mode_small");
                        g.embedMode = a("EMBED_MODE.LARGE");
                        g.setCurrentMode(a("LINEAR_MODE"));
                        g.$btn_linear_view.click();
                        g.events.load_background_image()
                    } else {
                        if (__EMBED__) {
                            g.events.load_background_image()
                        }
                    }
                }
                g.$window.trigger("renderEmbedSizeComplete", g.embedMode)
            },
            is_homepage_embed: function() {
                var q = false;
                try {
                    if (__EMBED__ && g.$body.data("username") == "about" && (top.location.host == location.host || top.location.host == "www.projeqt.com" || top.location.host == "projeqt.com") && window.parent != window && n.breadcrumbs.length == 1) {
                        q = true
                    }
                } catch(p) {}
                return q
            },
            start: function() {
                if (g.$vertically_centered.css("display") == "none") {
                    g.$vertically_centered.fadeIn("slow")
                }
                g.viewport.resizeGrid()
            },
            setCurrentMode: function(r) {
                var q = d(".slide_container"),
                p;
                p = this.getCurrentMode(r);
                q.children().remove();
                g.$outerWrapper.removeClass("linear_mode grid_mode full_mode").addClass(p);
                o = j;
                j = r;
                this.viewport.exitAnimation()
            },
            storeTemplates: function() {
                var t = tbwa.application.htmlTemplates,
                s = d("#linear_template"),
                q = d("#grid_template"),
                p = d("#fullscreen_template"),
                r = d(".pagination"),
                u = d(".slide_info_wrapper");
                t.linearTemplate = s.html();
                t.gridTemplate = q.html();
                t.fullTemplate = p.html();
                t.paginateTemplate = r.html();
                t.slideInfoTemplate = u.wrap("<div></div>").parent().html();
                t.titleBarTemplate = d.trim(d("#title_bar_stories").find("ul").html());
                s.remove();
                q.remove();
                p.remove();
                u.parent().remove()
            },
            trigger: function(p) {
                switch (p) {
                case "fullscreenExit":
                    g.viewport.exitAnimation();
                    break
                }
            },
            updateHash: function() {
                var w, u, t, q, s, v, r, p = document.location.protocol + "//" + document.location.host;
                username = g.$body.attr("data-username"),
                projeqt_name = g.$body.attr("data-projeqt"),
                dynamic_slide_info_elts = [".slide_info li a"],
                is_embedmode = (__EMBED__) ? "1": "0";
                switch (j) {
                case a("LINEAR_MODE"):
                    w = "l";
                    break;
                case a("GRID_MODE"):
                    w = "g";
                    break;
                case a("FULL_MODE"):
                    w = "f";
                    break
                }
                u = String(this.activeSlide.id);
                t = this.activeStack.id;
                q = f;
                s = encodeURIComponent(this.header.searchBar.query) || "";
                if (s) {
                    g.activeStack.id = 0;
                    d("#search_box").find(".search_text").val(decodeURIComponent(s))
                }
                if (w != "g") {
                    g.events.stopAudio()
                }
                d(".title_bar").trigger("toggleBreadcrumbs", true);
                d(".user_profile_toggle").trigger("toggleUserProfile", true);
                v = w + ("si" + u) + ("ci" + t) + (g.isTBWA ? ("b" + q) : "") + ("q" + s);
                m = true;
                location.hash = v;
                if (w == "f") {
                    if ( !! !g.is_idle) {
                        g.is_idle = true;
                        d.idleTimer(a("IDLE_TIMER_SECONDS") * 1000)
                    }
                } else {
                    if (d.data(document, "idleTimer")) {
                        if (g.$body.hasClass("idle")) {
                            g.$document.trigger("active.idleTimer")
                        }
                    }
                }
                dynamic_slide_info_elts.push("#top_bar .share");
                if (__EMBED__ || __FB__) {
                    r = "l" + v.substr(1);
                    d("#share_full .presentation_mode").attr("href", [p, username, projeqt_name].join("/") + "#" + r)
                }
                d(dynamic_slide_info_elts.join(",")).each(function() {
                    parts = [];
                    parts.push("slide", d(this).attr("data-type"), u, v, is_embedmode);
                    d(this).attr("href", p + "/" + parts.join("/"))
                })
            },
            XHR: {
                cacheJSON: function(r, q, p, s, t) {
                    this._ajax({
                        url: r,
                        dataParams: q,
                        jsonCallback: p,
                        successFunc: s,
                        errorFunc: t
                    })
                },
                getJSON: function(q, p, r, s) {
                    this._ajax({
                        url: q,
                        dataParams: p,
                        successFunc: r,
                        errorFunc: s
                    })
                },
                _ajax: function(s) {
                    var q = s.url,
                    u = s.dataParams,
                    v = s.successFunc,
                    x = s.errorFunc,
                    w = s.jsonCallback || false,
                    t, r = a("BASE_URL"),
                    p = a("JSONP.timeout");
                    if (typeof(v) === "undefined") {
                        throw new Error("Success function undefined in tbwa.application.XHR.getJSON request!");
                        return false
                    }
                    if (q.indexOf(r) == -1) {
                        if (r.substring(r.length - 1) == "/" && q.substring(0, 1) == "/") {
                            q = q.substring(1)
                        }
                        q = r + q
                    }
                    u = u || false;
                    if (u) {
                        t = {
                            url: q,
                            data: u,
                            callbackParameter: "jsoncallback",
                            timeout: p,
                            success: v,
                            error: x || this._displayError,
                            pageCache: true
                        }
                    } else {
                        t = {
                            url: q,
                            callbackParameter: "jsoncallback",
                            timeout: p,
                            success: v,
                            error: x || this._displayError,
                            pageCache: true
                        }
                    }
                    if (w) {
                        t.jsonpCallback = w
                    }
                    d.jsonp(t)
                },
                _displayError: function(r, q) {
                    var p = a("OVERLAY.ERROR");
                    d.colorbox({
                        initialWidth: p.width,
                        width: p.width,
                        initialHeight: p.height,
                        height: p.height,
                        html: g.htmlTemplates.ajaxError.replaceVars({
                            error_message: "We're sorry but the server has encountered an error."
                        })
                    })
                }
            },
            tracker: {
                recordView: function(u, s, p) {
                    if (typeof u !== "string") {
                        return
                    }
                    var w = jQuery(".title_bar"),
                    q = jQuery("#top_bar img"),
                    t = p || d("#title_bar_stories").find("li").find(".name").map(function(y, x) {
                        return d.trim(d(x).text())
                    }).get().join(" \\ ") || q.attr("alt") || "Uncategorized",
                    r = s || "";
                    try {
                        if (__GA__.user && __GA__.user !== "") {
                            _gaq.push(["_setAccount", __GA__.projeqt], ["_trackEvent", t, u, r], ["b._setAccount", __GA__.user], ["b._trackEvent", t, u, r])
                        } else {
                            _gaq.push(["_trackEvent", t, u, r])
                        }
                    } catch(v) {} finally {
                        if (__DEV__) {
                            try {
                                if (__GA__.user && __GA__.user !== "") {
                                    console.log("Tracking ( accounts %s, %s ): %s | %s | %s", __GA__.projeqt, __GA__.user, t, u, r)
                                } else {
                                    console.log("Tracking ( account %s ): %s | %s | %s", __GA__.projeqt, t, u, r)
                                }
                            } catch(v) {}
                        }
                    }
                },
                recordExitClick: function(r, u, w) {
                    if (!r || typeof r !== "string") {
                        return
                    }
                    var t = r,
                    v, p, q, s;
                    if (u && u.target) {
                        p = d(u.target).closest(".slide");
                        q = p.attr("data-title");
                        s = p.attr("data-type");
                        t = "From slide " + q + " (" + s + ") to " + r
                    }
                    w = w || d("#title_bar_stories").find("li").find(".name").map(function(y, x) {
                        return d.trim(d(x).text())
                    }).get().join(" \\ ");
                    switch (g.getCurrentMode()) {
                    case "linear_mode":
                        v = "Linear";
                        break;
                    case "grid_mode":
                        v = "Grid";
                        break;
                    case "full_mode":
                        v = "Fullscreen";
                        break
                    }
                    tbwa.application.tracker.recordView("External Link Click - " + v, t, w)
                }
            },
            init: function() {
                var p, s, r, q;
                g.$html = d("html");
                g.$window = d(window);
                g.$document = d(document);
                g.$body = d("body");
                g.$outerWrapper = d("#outerWrapper");
                g.$vertically_centered = g.$outerWrapper.find(".vertically_centered");
                g.$content_arrows = d("#content_arrows");
                g.$btn_content_arrow_up = g.$content_arrows.find(".up");
                g.$btn_content_arrow_prev = g.$content_arrows.find(".prev");
                g.$btn_content_arrow_next = g.$content_arrows.find(".next");
                g.$view_panel = d(".view_panel");
                g.$btn_linear_view = g.$view_panel.find(".slide_view a");
                g.$btn_grid_view = g.$view_panel.find(".grid_view a");
                g.$btn_presentation_view = g.$view_panel.find(".full_screen a");
                g.$btn_full_screen = g.$view_panel.find(".presentation_view a");
                g.$top_bar = d("#top_bar");
                g.$footer = d("#footer");
                g.is_spotlites = g.$body.hasClass("spotlites");
                g.is_mobile = g.$body.hasClass("mobile");
                g.is_ipad = g.is_mobile && g.$body.hasClass("ipad");
                g.is_iphone = g.is_mobile && g.$body.hasClass("iphone");
                g.isTBWA = g.$outerWrapper.hasClass("tbwa");
                c.IMAGE_URL.device = (g.is_mobile ? "mobile": "web") + "/";
                if (c.IMAGE_URL.device != "web/") {
                    c.IMAGE_URL.device = "web/"
                }
                this.events.init();
                this.storeTemplates();
                this.loadURL();
                if (f == null) {
                    if (g.$outerWrapper.hasClass("bgdark")) {
                        g.viewport.backgroundColor = f = 1
                    } else {
                        g.viewport.backgroundColor = f = 0
                    }
                }
                if (g.isTBWA) {
                    if (f == 1) {
                        g.$body.css("background-color", a("BACKGROUND_COLORS.dark"));
                        g.$outerWrapper.addClass("bgdark")
                    } else {
                        g.$body.css("background-color", a("BACKGROUND_COLORS.light"));
                        g.$outerWrapper.removeClass("bgdark")
                    }
                    g.viewport.backgroundColor = f
                }
                g.updateHash();
                r = g.header.searchBar.query;
                if (r) {
                    p = a("JSONP.searchResults") + a("JSONP.token");
                    s = {
                        terms: r
                    }
                } else {
                    p = (g.activeStack.id != 0) ? a("JSONP.get") + g.activeStack.id + a("JSONP.token") : a("JSONP.getDefault") + a("JSONP.token");
                    s = null
                }
                this.XHR.getJSON(p, s,
                function(t) {
                    n = t;
                    g.viewport.init();
                    g.viewport.render({
                        isHideBreadcrumbs: true,
                        entranceAnimation: true
                    });
                    g.header.init();
                    g.start();
                    window.focus()
                });
                g.footer.init()
            }
        };
        var l = this,
        g = this.application
    }
})(jQuery); (function(a) {
    tbwaClass.prototype.core = {
        init: function() {
            tbwa.application.checkURL();
            var b = a("base").attr("href");
            if (typeof b === "string") {
                b = b.replace(/^https?:\/\/([^\/]*).*$/, "$1")
            }
            a.expr[":"].internal = function(d) {
                return (d.hostname === location.hostname || d.hostname === b)
            };
            a.expr[":"].external = function(d) {
                return (d.hostname !== location.hostname && d.hostname !== b)
            };
            if (a.fn.outerHTML) {
                try {
                    console.warn("Attempting to overwrite existing jQuery function outerHTML!")
                } catch(c) {}
            }
            a.fn.outerHTML = function() {
                var f = this.clone(),
                e = a("<div />"),
                d = "";
                e.append(f);
                d = e.html();
                f.remove();
                e.remove();
                f = undefined;
                e = undefined;
                return d
            };
            if (a.fn.makeVisible) {
                try {
                    console.warn("Attempting to overwrite existing jQuery function makeVisible!")
                } catch(c) {}
            }
            a.fn.makeVisible = function() {
                return this.css("visibility", "visible")
            };
            if (a.fn.makeHidden) {
                try {
                    console.warn("Attempting to overwrite existing jQuery function makeHidden!")
                } catch(c) {}
            }
            a.fn.makeHidden = function() {
                return this.css("visibility", "hidden")
            };
            if (a.preloadImage) {
                try {
                    console.warn("Attempting to overwrite existing jQuery function preloadImage!")
                } catch(c) {}
            }
            a.extend(jQuery, {
                preloadImage: function(h, j) {
                    if (typeof h !== "string" || typeof h === "string" && !(/\.(gif|jpg|jpeg|png)$/.test(h))) {
                        return
                    }
                    var d = a(document.createElement("img")),
                    g = false,
                    e;
                    d.addClass("preload_image");
                    d.each(function() {
                        var f, l, k = a(this);
                        k.bind("load readystatechange",
                        function() {
                            g = true;
                            k.addClass("complete");
                            if (typeof j === "function") {
                                j.call(this);
                                k.remove()
                            }
                        });
                        if (!g) {
                            k.css({
                                display: "none",
                                width: 0,
                                height: 0
                            }).appendTo(document.body);
                            l = h;
                            this.src = "/shared/images/1x1.gif";
                            this.src = l
                        }
                    })
                }
            });
            a.extend(a.browser, {
                ie6: !!(a.browser.msie && parseInt(a.browser.version, 10) === 6),
                ie7: !!(a.browser.msie && parseInt(a.browser.version, 10) === 7 && !a.support.tbody && !a.support.style && !a.support.hrefNormalized),
                ie8: !!(a.browser.msie && ((parseInt(a.browser.version, 10) === 8) || (parseInt(a.browser.version, 10) === 7 && a.support.tbody && a.support.style && a.support.hrefNormalized)))
            });
            jQuery.extend(jQuery.easing, {
                easeOutCirc: function(f, g, e, j, h) {
                    return j * Math.sqrt(1 - (g = g / h - 1) * g) + e
                }
            });
            if ("replaceVars" in String.prototype) {
                try {
                    console.warn("Attempting to overwrite existing String function replaceVars!")
                } catch(c) {}
            }
            String.prototype.replaceVars = function(h, g, e) {
                var f = this,
                j, d;
                d = function(k, l, m) {
                    return k.replace(new RegExp(l, "g"), m)
                };
                if (typeof h == "undefined") {
                    return this
                }
                g = (typeof(g) == "undefined") ? "{": g;
                e = (typeof(e) == "undefined") ? "}": e;
                for (j in h) {
                    f = d(f, g + j + e, h[j])
                }
                return f
            };
            if (!Array.prototype.indexOf) {
                Array.prototype.indexOf = function(e) {
                    var d, f;
                    d = this.length >>> 0;
                    f = Number(arguments[1]) || 0;
                    f = (f < 0) ? Math.ceil(f) : Math.floor(f);
                    if (f < 0) {
                        f += d
                    }
                    for (; f < d; f++) {
                        if (f in this && this[f] === e) {
                            return f
                        }
                    }
                    return - 1
                }
            }
            if ("unique" in String.prototype) {
                try {
                    console.warn("Attempting to overwrite existing Array function unique!")
                } catch(c) {}
            }
            Array.prototype.unique = function(f) {
                f = f || true;
                var e = [],
                d = this.length;
                for (var g = 0; g < d; g++) {
                    this[g] = (f) ? this[g].replace(/^\s+|\s+$/, "") : this[g];
                    if (e.indexOf(this[g], 0) < 0) {
                        e.push(this[g])
                    }
                }
                return e
            }
        }
    }
})(jQuery);
var tbwa = tbwa || undefined;
if (tbwa == undefined) {
    tbwa = new tbwaClass();
    tbwa.fn = function() {};
    tbwaClass = undefined;
    jQuery(function() {
        tbwa.core.init();
        tbwa.application.init()
    })
}
jQuery.noConflict();