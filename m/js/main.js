(function($) {

	'use strict';

	window.YMotion = function(motionItems, options) {

		var _this = this;

        var opt = {oElems: 'motion-offset', rewind: false, oFixed: false, singly: false, half: false, divide: 2};

        for(var prop in options) {
            opt[prop] = options[prop];
        }

		var motionOffsetElems = [],
			motionOffset = [],
			rewindOffset = [],
			limitOffset,
			tempTl = [],
            sortTl = [],
			motionEnded = [],
			prevScrollTop = win.scrollTop(),
			scrollTop = prevScrollTop,
			winH,
			prevDocH,
			docH = doc.height(),
			docDiff = 0,
			queued = false,
			active = false;

		var	LENGTH = motionItems.length;

		this.initialize = function() {
			this.setMotionOffset();
			this.setElements();
			this.setTimeline();
		};

		this.setMotionOffset = function() {
			$('[data-' + opt.oElems + ']').each(function(i) {
				motionOffsetElems[i] = $(this);
				motionOffsetElems[i].data({offset: motionOffsetElems[i].offset().top, height: parseFloat(motionOffsetElems[i].css('height'), 10)});
			});

			prevDocH = docH;
			docH = doc.height();
			docDiff = docH - prevDocH;
			winH = win.height();
			limitOffset = docH - winH;
			for(var i=0, j=0, tempH; i<motionOffsetElems.length; i++) {
				tempH = opt.half === false ? motionOffsetElems[i].data('height') : motionOffsetElems[i].data('height') / 2;
				motionOffset[i] = tempH > winH / opt.divide ? (motionOffsetElems[i].data('offset') + docDiff) - winH + (winH / opt.divide) : (motionOffsetElems[i].data('offset') + docDiff) - winH + tempH;
				if(typeof motionOffsetElems[i].data('diff') === 'number') motionOffset[i] -= motionOffsetElems[i].data('diff');
				if(motionOffset[i] > limitOffset) {
					motionOffset[i] = limitOffset - motionOffsetElems.length + j;
					j++;
				}
				if(opt.oFixed === true && motionOffset[i] < 0) motionOffset[i] = 0;
				rewindOffset[i] = motionOffset[i];
			}
			motionOffset[motionOffsetElems.length] = limitOffset + 1;
			rewindOffset[motionOffsetElems.length] = limitOffset + 1;
		};

		this.setElements = function() {
			for(var i=0; i<LENGTH; i++) {
				for(var j=0, o; j<motionItems[i].length; j++) {
					o = motionItems[i][j];
                    if(typeof o.method === 'undefined') {
						if(o.el.length === 0) continue;
						if(o.effect === 'text') {
							$(o.el).each(function(k) {
								var _text = $(this).html();
								var html = '';
								var text = _text.replace(/\<br(\s?\/?)\>/g, '^').replace('&amp;', '&');
								for(var l=0; l<text.length; l++) {
									if(text[l] !== '^') html += '<i>'+ text[l] +'</i>';
									else html += '<br>';
								}
								$(this).html(html);
							});
						}
						if(typeof o.set === 'undefined') continue;
                        TweenMax.set(o.el, o.set);
                    } else {
                        switch(o.method) {
                            case 'add':
								if(typeof o.items === 'object') {
	                                for(var k=0; k<o.items.length; k++) {
										if(typeof o.items[k].set === 'undefined' || o.items[k] instanceof TimelineMax === true || o.items[k].el.length === 0) continue;
										TweenMax.set(o.items[k].el, o.items[k].set);
									}
								}
                                break;
                            default:
                                break;
                        }
                    }
				}
			}
		};

		this.setTimeline = function() {
			for(var i=0; i<LENGTH; i++) {
				tempTl[i] = new TimelineMax({paused: true, onComplete: function() {
					if(opt.singly === true) {
						queued = false;
						_this.handler.scroll();
					}
				}, onReverseComplete: function() {
					if(opt.singly === true) {
						queued = false;
						if(opt.oFixed === false) _this.handler.scroll();
						else {
							if(scrollTop <= 0 && scrollTop - prevScrollTop <= 0) {
								prevScrollTop = 0.5;
								_this.scroll();
							}
						}
					} else {
						if(opt.oFixed === true && scrollTop <= 0 && scrollTop - prevScrollTop <= 0) {
							prevScrollTop = 0.5;
							_this.scroll();
						}
					}
				}});
				motionEnded[i] = false;
				for(var j=0, o; j<motionItems[i].length; j++) {
                    o = motionItems[i][j];
					if(typeof o.method === 'undefined' && typeof o.to === 'undefined') continue;
                    if(typeof o.method === 'undefined') {
						if(o.el.length === 0) continue;
						if(o.effect !== 'text') {
							typeof o.t === 'undefined' ? tempTl[i].to(o.el, o.d, o.to) : tempTl[i].to(o.el, o.d, o.to, o.t);
						} else {
							$(o.el).each(function(k) {
								$(this).find('i').each(function(l) {
									if($.trim($(this).text()) !== '') typeof o.t === 'undefined' ? tempTl[i].to($(this), o.d, o.to) : tempTl[i].to($(this), o.d, o.to, l > 0 ? o.t : '+=0');
								});
							});
						}
                    } else {
                        switch(o.method) {
							case 'addLabel':
								tempTl[i][o.method](o.label);
								break;
                            case 'add':
								var a = [];
								if(typeof o.items === 'object') {
									for(var k=0; k<o.items.length; k++) {
										if(o.items[k] instanceof TimelineMax === true || o.items[k].el.length === 0) continue;
										a[k] = TweenMax.to(o.items[k].el, o.items[k].d, o.items[k].to);
									}
								}
								if(typeof o.tl === 'object') a.push(o.tl);
								typeof o.t === 'undefined' ? tempTl[i][o.method](a) : tempTl[i][o.method](a, o.t);
                                break;
							case 'call':
								typeof o.t === 'undefined' ? tempTl[i][o.method](o.fx) : tempTl[i][o.method](o.fx, null, null, o.t);
                            default:
                                break;
                        }
                    }
				}
			}
            for(var i=0; i<motionOffsetElems.length; i++) {
				sortTl[i] = typeof +motionOffsetElems[i].data(opt.oElems) === 'number' ? tempTl[+motionOffsetElems[i].data(opt.oElems) - 1] : '움직이지 않을래';
			}
		};

		this.setHandler = function() {
			win.scroll(this.handler.scroll).resize(this.handler.resize);
		};

        this.handler = {
            scroll: function() {
				prevScrollTop = scrollTop;
				_this.scroll();
            },
            resizeTimer: null,
            resize: function() {
                clearTimeout(_this.handler.resizeTimer);
				_this.handler.resizeTimer = setTimeout(function() {
					_this.setMotionOffset();
					_this.handler.scroll();
				}, 100);
            }
        };

		this.scroll = function() {
			scrollTop = win.scrollTop() >= 0 ? (win.scrollTop() <= limitOffset ? win.scrollTop() : limitOffset) : 0;
			opt.rewind === false ? _this.motion() : scrollTop - prevScrollTop >= 0 ? _this.motion() : _this.rewind();
		};

		this.motion = function() {
			for(var i=0; i<LENGTH; i++) {
				if(scrollTop >= motionOffset[i] && motionEnded[i] === false && typeof sortTl[i] === 'object') {
					if(opt.singly === false) {
						sortTl[i].timeScale(1).play();
						motionEnded[i] = true;
					} else {
						if(i === 0 || sortTl[i - 1].isActive() === false && queued === false) {
							sortTl[i].timeScale(1).play();
							motionEnded[i] = true;
						} else if(i > 0 && sortTl[i - 1].isActive() === true) {
							queued = true;
						}
					}
				}
			}
		};

		this.rewind = function() {
			for(var i=LENGTH - 1; i>-1; i--) {
				if(scrollTop <= rewindOffset[i] && motionEnded[i] === true && typeof sortTl[i] === 'object') {
					if(opt.singly === false) {
						sortTl[i].timeScale(2).reverse();
						motionEnded[i] = false;
					} else {
						if(i === LENGTH - 1 || sortTl[i + 1].isActive() === false && queued === false) {
							sortTl[i].timeScale(2).reverse();
							motionEnded[i] = false;
						} else if(i < LENGTH - 1 && sortTl[i + 1].isActive() === true) {
							queued = true;
						}
					}
				}
			}
		};

		this.activate = function() {
            if(active === false) {
                this.setHandler();
                this.handler.scroll();
                active = true;
            }
		};

		this.disable = function() {
			for(var i=0; i<LENGTH; i++) {
				if(typeof sortTl[i] === 'object') sortTl[i].progress(1);
				motionEnded[i] = true;
			}
		};

		this.reset = function() {
			$('[data-' + opt.oElems + ']').each(function(i) {
				motionOffsetElems[i] = $(this);
				motionOffsetElems[i].data({offset: motionOffsetElems[i].offset().top, height: parseFloat(motionOffsetElems[i].css('height'), 10)});
			});
			for(var i=0; i<LENGTH; i++) {
				if(typeof sortTl[i] === 'object') sortTl[i].pause(0);
				motionEnded[i] = false;
				queued = false;
			}
			this.setMotionOffset();
			this.handler.scroll();
		};

		this.initialize();
	};

}(jQuery));

(function($) {

    'use strict';

	window.Counting = function(elems, options) {

		var _this = this;

        var opt = {type: 'text', unit: 'px', duration: 100, delay: 1000, interval: 5000, repeat: 0, loop: 1, diff: 100, min: 0, max: 10, slowFx: false, slowV: 10, anim: false};

		for(var prop in options) {
			opt[prop] = options[prop];
		}

		var	numbers = [], repeatTimer = null, slotTimer = [], repeat = 0, distance = opt.max - opt.min, slowlyI = 0, animTl = [];

		var LENGTH = elems.length,
            LIMIT = distance * opt.loop * LENGTH - 1;

		this.initialize = function() {
			for(var i=0, start; i<LENGTH; i++) {
                numbers[i] = [];
				start = elems.eq(i).data('number') + 1;
				for(var j=0; j<distance * opt.loop; j++) {
					if(opt.anim === false && start === distance) start = opt.min;
					numbers[i][j] = start;
					start++;
				}
			}
            if(opt.type === 'img' && opt.anim === true) {
                this.setTimeline();
            }
		};

        this.action = function() {
            if(opt.type === 'img' && opt.anim === true) {
                for(var i=0; i<LENGTH; i++) {
                    animTl[i].restart(true, false);
                }
            } else {
                for(var i=0; i<LENGTH; i++) {
                    for(var j=0; j<distance * opt.loop; j++) {
                        this.queue(i, j);
                    }
                }
            }
        };

        this.queue = function(i, j) {
            if(opt.slowFx === true) j - (distance * (opt.loop - 1)) >= 0 ? slowlyI++ : slowlyI = 0;
            var t = (j * opt.duration) + (i * opt.delay) + (Math.pow(slowlyI, 2) * opt.slowV);
            var k = distance * opt.loop * i + j;
            slotTimer[k] = setTimeout(function() {
                if(opt.type === 'text') {
                    elems.eq(i).text(numbers[i][j]);
                } else {
                    opt.unit === 'px' ? elems.eq(i).css({backgroundPositionY: -(opt.diff * numbers[i][j])}) : elems.eq(i).css({top: -(numbers[i][j] * 100) + '%'});
                }
                if(k === LIMIT) {
                    if(opt.repeat === 1 || repeat < opt.repeat - 1) {
                        _this.setTimer();
                        repeat++;
                    } else {
                        typeof opt.callback === 'function' ? opt.callback() : null;
                    }
                }
            }, t);
		};

		this.setTimer = function() {
			clearTimeout(repeatTimer);
			repeatTimer = setTimeout(function() {
				_this.action();
			}, opt.interval);
		};

        this.setTimeline = function(i, j) {
            for(var i=0; i<LENGTH; i++) {
                animTl[i] = new TimelineLite({paused: true, delay: i * (opt.delay / 1000), onComplete: function() {
                    if(opt.repeat === 1 || repeat < opt.repeat - 1) {
                        _this.setTimer();
                        repeat++;
                    } else {
                        typeof opt.callback === 'function' ? opt.callback() : null;
                    }
                }});
                for(var j=0; j<distance * opt.loop; j++) {
                    if(opt.slowFx === true) j - (distance * (opt.loop - 1)) >= 0 ? slowlyI++ : slowlyI = 0;
                    if(opt.unit === 'px') {
                        animTl[i].to(elems.eq(i), (opt.duration / 1000) + (Math.pow(slowlyI, 2) * (opt.slowV / 1000)), {backgroundPositionY: -(opt.diff * numbers[i][j])});
                    } else {
                        animTl[i].to(elems.eq(i), (opt.duration / 1000) + (Math.pow(slowlyI, 2) * (opt.slowV / 1000)), {top: -(numbers[i][j] * 100) + '%'});
                    }
                }
            }
        };

		this.initialize();
	};

}(jQuery));

!function() {
    function e() {
        if (!H && document.body) {
            H = !0;
            var e = document.body
              , t = document.documentElement
              , o = window.innerHeight
              , r = e.scrollHeight;
            if (z = document.compatMode.indexOf("CSS") >= 0 ? t : e,
            y = e,
            M.keyboardSupport && s("keydown", n),
            top != self)
                E = !0;
            else if (J && r > o && (e.offsetHeight <= o || t.offsetHeight <= o)) {
                var a, i = document.createElement("div");
                i.style.cssText = "position:absolute; z-index:-10000; top:0; left:0; right:0; height:" + z.scrollHeight + "px",
                document.body.appendChild(i),
                g = function() {
                    a || (a = setTimeout(function() {
                        T || (i.style.height = "0",
                        i.style.height = z.scrollHeight + "px",
                        a = null)
                    }, 500))
                }
                ,
                setTimeout(g, 10),
                s("resize", g);
                if ((b = new V(g)).observe(e, {
                    attributes: !0,
                    childList: !0,
                    characterData: !1
                }),
                z.offsetHeight <= o) {
                    var l = document.createElement("div");
                    l.style.clear = "both",
                    e.appendChild(l)
                }
            }
            M.fixedBackground || T || (e.style.backgroundAttachment = "scroll",
            t.style.backgroundAttachment = "scroll")
        }
    }
    function t(e, t, o) {
        if (i = o,
        a = (a = t) > 0 ? 1 : -1,
        i = i > 0 ? 1 : -1,
        C.x === a && C.y === i || (C.x = a,
        C.y = i,
        A = [],
        N = 0),
        1 != M.accelerationMax) {
            var n = Date.now() - N;
            if (n < M.accelerationDelta) {
                var r = (1 + 50 / n) / 2;
                r > 1 && (r = Math.min(r, M.accelerationMax),
                t *= r,
                o *= r)
            }
            N = Date.now()
        }
        var a, i;
        if (A.push({
            x: t,
            y: o,
            lastX: t < 0 ? .99 : -.99,
            lastY: o < 0 ? .99 : -.99,
            start: Date.now()
        }),
        !B) {
            var l = e === document.body
              , c = function(n) {
                for (var r = Date.now(), a = 0, i = 0, u = 0; u < A.length; u++) {
                    var d = A[u]
                      , s = r - d.start
                      , f = s >= M.animationTime
                      , m = f ? 1 : s / M.animationTime;
                    M.pulseAlgorithm && (m = (v = m) >= 1 ? 1 : v <= 0 ? 0 : (1 == M.pulseNormalize && (M.pulseNormalize /= p(1)),
                    p(v)));
                    var w = d.x * m - d.lastX >> 0
                      , h = d.y * m - d.lastY >> 0;
                    a += w,
                    i += h,
                    d.lastX += w,
                    d.lastY += h,
                    f && (A.splice(u, 1),
                    u--)
                }
                var v;
                l ? window.scrollBy(a, i) : (a && (e.scrollLeft += a),
                i && (e.scrollTop += i)),
                t || o || (A = []),
                A.length ? q(c, e, 1e3 / M.frameRate + 1) : B = !1
            };
            q(c, e, 0),
            B = !0
        }
    }
    function o(o) {
        H || e();
        var n = o.target;
        if (o.defaultPrevented || o.ctrlKey)
            return !0;
        if (m(y, "embed") || m(n, "embed") && /\.pdf/i.test(n.src) || m(y, "object") || n.shadowRoot)
            return !0;
        var r = -o.wheelDeltaX || o.deltaX || 0
          , i = -o.wheelDeltaY || o.deltaY || 0;
        O && (o.wheelDeltaX && w(o.wheelDeltaX, 120) && (r = o.wheelDeltaX / Math.abs(o.wheelDeltaX) * -120),
        o.wheelDeltaY && w(o.wheelDeltaY, 120) && (i = o.wheelDeltaY / Math.abs(o.wheelDeltaY) * -120)),
        r || i || (i = -o.wheelDelta || 0),
        1 === o.deltaMode && (r *= 40,
        i *= 40);
        var c = l(n);
        return c ? !!function(e) {
            if (e)
                return L.length || (L = [e, e, e]),
                e = Math.abs(e),
                L.push(e),
                L.shift(),
                clearTimeout(x),
                x = setTimeout(function() {
                    try {
                        localStorage.SS_deltaBuffer = L.join(",")
                    } catch (e) {}
                }, 1e3),
                !h(120) && !h(100)
        }(i) || (Math.abs(r) > 1.2 && (r *= M.stepSize / 120),
        Math.abs(i) > 1.2 && (i *= M.stepSize / 120),
        t(c, r, i),
        o.preventDefault(),
        void a()) : !E || !W || (Object.defineProperty(o, "target", {
            value: window.frameElement
        }),
        parent.wheel(o))
    }
    function n(e) {
        var o = e.target
          , n = e.ctrlKey || e.altKey || e.metaKey || e.shiftKey && e.keyCode !== X.spacebar;
        document.body.contains(y) || (y = document.activeElement);
        var r = /^(button|submit|radio|checkbox|file|color|image)$/i;
        if (e.defaultPrevented || /^(textarea|select|embed|object)$/i.test(o.nodeName) || m(o, "input") && !r.test(o.type) || m(y, "video") || function(e) {
            var t = e.target
              , o = !1;
            if (-1 != document.URL.indexOf("www.youtube.com/watch"))
                do {
                    if (o = t.classList && t.classList.contains("html5-video-controls"))
                        break
                } while (t = t.parentNode);return o
        }(e) || o.isContentEditable || n)
            return !0;
        if ((m(o, "button") || m(o, "input") && r.test(o.type)) && e.keyCode === X.spacebar)
            return !0;
        if (m(o, "input") && "radio" == o.type && Y[e.keyCode])
            return !0;
        var i = 0
          , c = 0
          , u = l(y);
        if (!u)
            return !E || !W || parent.keydown(e);
        var d = u.clientHeight;
        switch (u == document.body && (d = window.innerHeight),
        e.keyCode) {
        case X.up:
            c = -M.arrowScroll;
            break;
        case X.down:
            c = M.arrowScroll;
            break;
        case X.spacebar:
            c = -(e.shiftKey ? 1 : -1) * d * .9;
            break;
        case X.pageup:
            c = .9 * -d;
            break;
        case X.pagedown:
            c = .9 * d;
            break;
        case X.home:
            c = -u.scrollTop;
            break;
        case X.end:
            var s = u.scrollHeight - u.scrollTop - d;
            c = s > 0 ? s + 10 : 0;
            break;
        case X.left:
            i = -M.arrowScroll;
            break;
        case X.right:
            i = M.arrowScroll;
            break;
        default:
            return !0
        }
        t(u, i, c),
        e.preventDefault(),
        a()
    }
    function r(e) {
        y = e.target
    }
    function a() {
        clearTimeout(S),
        S = setInterval(function() {
            P = {}
        }, 1e3)
    }
    function i(e, t) {
        for (var o = e.length; o--; )
            P[K(e[o])] = t;
        return t
    }
    function l(e) {
        var t = []
          , o = document.body
          , n = z.scrollHeight;
        do {
            var r = P[K(e)];
            if (r)
                return i(t, r);
            if (t.push(e),
            n === e.scrollHeight) {
                var a = u(z) && u(o) || d(z);
                if (E && c(z) || !E && a)
                    return i(t, F())
            } else if (c(e) && d(e))
                return i(t, e)
        } while (e = e.parentElement)
    }
    function c(e) {
        return e.clientHeight + 10 < e.scrollHeight
    }
    function u(e) {
        return "hidden" !== getComputedStyle(e, "").getPropertyValue("overflow-y")
    }
    function d(e) {
        var t = getComputedStyle(e, "").getPropertyValue("overflow-y");
        return "scroll" === t || "auto" === t
    }
    function s(e, t) {
        window.addEventListener(e, t, !1)
    }
    function f(e, t) {
        window.removeEventListener(e, t, !1)
    }
    function m(e, t) {
        return (e.nodeName || "").toLowerCase() === t.toLowerCase()
    }
    function w(e, t) {
        return Math.floor(e / t) == e / t
    }
    function h(e) {
        return w(L[0], e) && w(L[1], e) && w(L[2], e)
    }
    function p(e) {
        var t, o;
        return (e *= M.pulseScale) < 1 ? t = e - (1 - Math.exp(-e)) : (e -= 1,
        t = (o = Math.exp(-1)) + (1 - Math.exp(-e)) * (1 - o)),
        t * M.pulseNormalize
    }
    function v(e) {
        for (var t in e)
            D.hasOwnProperty(t) && (M[t] = e[t])
    }
    var y, b, g, S, x, k, D = {
        frameRate: 150,
        animationTime: 1000,
        stepSize: 100,
        pulseAlgorithm: !0,
        pulseScale: 4,
        pulseNormalize: 1,
        accelerationDelta: 10,
        accelerationMax: 3,
        keyboardSupport: !0,
        arrowScroll: 50,
        fixedBackground: !0,
        excluded: ""
    }, M = D, T = !1, E = !1, C = {
        x: 0,
        y: 0
    }, H = !1, z = document.documentElement, L = [], O = /^Mac/.test(navigator.platform), X = {
        left: 37,
        up: 38,
        right: 39,
        down: 40,
        spacebar: 32,
        pageup: 33,
        pagedown: 34,
        end: 35,
        home: 36
    }, Y = {
        37: 1,
        38: 1,
        39: 1,
        40: 1
    }, A = [], B = !1, N = Date.now(), K = (k = 0,
    function(e) {
        return e.uniqueID || (e.uniqueID = k++)
    }
    ), P = {};
    if (window.localStorage && localStorage.SS_deltaBuffer)
        try {
            L = localStorage.SS_deltaBuffer.split(",")
        } catch (e) {}
    var R, j, q = window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || function(e, t, o) {
        window.setTimeout(e, o || 1e3 / 60)
    }
    , V = window.MutationObserver || window.WebKitMutationObserver || window.MozMutationObserver, F = function() {
        if (!j) {
            var e = document.createElement("div");
            e.style.cssText = "height:10000px;width:1px;",
            document.body.appendChild(e);
            var t = document.body.scrollTop;
            document.documentElement.scrollTop,
            window.scrollBy(0, 3),
            j = document.body.scrollTop != t ? document.body : document.documentElement,
            window.scrollBy(0, -3),
            document.body.removeChild(e)
        }
        return j
    }, I = window.navigator.userAgent,
    _ = /Edge/.test(I), W = /chrome/i.test(I) && !_, $ = /safari/i.test(I) && !_, U = /mobile/i.test(I), G = /Windows NT 6.1/i.test(I) && /rv:11/i.test(I), J = $ && (/Version\/8/i.test(I) || /Version\/9/i.test(I)), Q = (W || $ || G) && !U;
    "onwheel"in document.createElement("div") ? R = "wheel" : "onmousewheel"in document.createElement("div") && (R = "mousewheel"),
    R && Q && (s(R, o),
    s("mousedown", r),
    s("load", e)),
    v.destroy = function() {
        b && b.disconnect(),
        f(R, o),
        f("mousedown", r),
        f("keydown", n),
        f("resize", g),
        f("load", e)
    }
    ,
    window.SmoothScrollOptions && v(window.SmoothScrollOptions),
    "function" == typeof define && define.amd ? define(function() {
        return v
    }) : "object" == typeof exports ? module.exports = v : window.SmoothScroll = v
}();

(function($) {
    doc.ready(function(){
		(function() {
            function setRotateOffset() {
                $rotateItems.each(function(i) {
                    var $t = $(this);
                    startY[i] = $t.offset().top - diff;
                    endY[i] = startY[i] + ($t.height() / 2);
                });
            }

            function scrollHandler() {
                var scrollTop = win.scrollTop();
                for(var i=0; i<length; i++) {
                    if(scrollTop >= startY[i] && scrollTop <= endY[i]) {
                        var progres = parseFloat(Math.abs(startY[i] - scrollTop) / (endY[i] - startY[i])).toFixed(2);
                        TweenLite.to($rotateItems.eq(i), 0.2, {y: Math.abs(startY[i] - scrollTop)});
                        TweenLite.to($rotateItems.eq(i), 1.5, {opacity: 1 - progres, rotationX: 45 * progres});
                    } else if(scrollTop < startY[i]) {
                        TweenLite.to($rotateItems.eq(i), 0.2, {y: 0});
                        TweenLite.to($rotateItems.eq(i), 1.5, {opacity: 1, rotationX: 0});
                    } else if(scrollTop > endY[i]) {
                        TweenLite.to($rotateItems.eq(i), 1.5, {opacity: 0, rotationX: 45});
                    }
                }
            }

            function resizeHandler() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    setRotateOffset();
                    scrollHandler();
                }, 100);
            }

            var $rotateItems = $('.rotate-item'),
                startY = [],
                endY = [],
                length = $rotateItems.length,
                resizeTimer = null,
                diff = 20;

            $(window).on('scroll', scrollHandler).on('resize', resizeHandler).on('load', function() {
                setRotateOffset();
                scrollHandler();
            });
            setRotateOffset();
            scrollHandler();
        }());

		TweenMax.to($('.popup'), 0.4, {height: "20.3125vw", ease: Power0.easeNone});
		$('.popup .close_x').click(function(){
			$('#popupTop').slideUp();
		});

        new Swiper('.main_visual .swiper-container', {
            loop:true,
            speed: 500,
                autoplay: {
                delay: 1500,
            },
            effect: 'fade',
            fadeEffect: {
            	crossFade: true
            },
            allowTouchMove: false,
        });

        var $swiperItems = $('.lyr2_slide .swiper-slide'),
            $progress,
            custPging = $('.lyr2_paging li');
            interval = 5000;

        var lyr2Slide = new Swiper('.lyr2_slide .swiper-container', {
            setWrapperSize: true,
            speed: 500,
            autoplay: {
                delay: 5000,
            },
            pagination: {
            	el: '.lyr2_paging',
            	clickable: true,
            	renderBullet: function(index, className){
            		return '<li class="' + className + '">'+ custPging.eq(index).html() +'</li>';
            	}
            },
            on: {
                slideChangeTransitionEnd: function() {
                    $progress = $('.lyr2_paging').find('.progress-bar');
                    var prevI = lyr2Slide.previousIndex, i = lyr2Slide.activeIndex;
                    TweenMax.killTweensOf($progress.eq(prevI));
                    TweenMax.set($progress.eq(prevI), {width: 0})
                    TweenMax.to($progress.eq(i), interval / 1000, {width: '100%', ease: Power0.easeNone});
                }
            },
            observer: true,
            observeParents: true,
        });
        $progress = $('.lyr2_paging li a').find('.progress-bar');
        TweenMax.to($progress.eq(0), interval / 1000, {width: '100%', ease: Power0.easeNone});
        lyr2Slide.autoplay.stop();

        new Swiper('.lyr5_slide .swiper-container', {
            slidesPerView: 'auto',
            loop:true,
            speed: 500,
                autoplay: {
                delay: 3000,
            },
        });

        var mainMotion = [
			// [
			// 	{el: $('.header_wrap'),set: {top: 0}, to: {top: 100}, d: 0.001}
			// ],
			// [
			// 	{el: $('#popupTop'), set: {height: 0}, to: {height: 100}, d: 0.6}
			// ],
            [
                {el: $('.num1 span'), to: {text: {value: ''}}, d: 0.001},
                {method: 'add', tl: [
                    TweenMax.to({number: 0}, 1.0, {number: $('.num1 span').data('number'), ease: Back.easeOut, onUpdate: function() {
                        $('.num1 span').text(parseInt((this.vars['number'] * this.progress()), 10).toLocaleString().split('.')[0]);
                    }, onComplete: function() {
                        $('.num1 span').text(parseInt(this.vars['number'], 10).toLocaleString().split('.')[0]);
                    }})
                ]},
				{el: $('.num2 span'), to: {text: {value: ''}}, d: 0.001},
                {method: 'add', tl: [
                    TweenMax.to({number: 0}, 1.0, {number: $('.num2 span').data('number'), ease: Back.easeOut, onUpdate: function() {
                        $('.num2 span').text(parseInt((this.vars['number'] * this.progress()), 10).toLocaleString().split('.')[0]);
                    }, onComplete: function() {
                        $('.num2 span').text(parseInt(this.vars['number'], 10).toLocaleString().split('.')[0]);
                    }})
                ]},
				{el: $('.num3 span'), to: {text: {value: ''}}, d: 0.001},
                {method: 'add', tl: [
                    TweenMax.to({number: 0}, 1.0, {number: $('.num3 span').data('number'), ease: Back.easeOut, onUpdate: function() {
                        $('.num3 span').text(parseInt((this.vars['number'] * this.progress()), 10).toLocaleString().split('.')[0]);
                    }, onComplete: function() {
                        $('.num3 span').text(parseInt(this.vars['number'], 10).toLocaleString().split('.')[0]);
                    }})
                ]},
				{el: $('.num4 span'), to: {text: {value: ''}}, d: 0.001},
                {method: 'add', tl: [
                    TweenMax.to({number: 0}, 1.0, {number: $('.num4 span').data('number'), ease: Back.easeOut, onUpdate: function() {
                        $('.num4 span').text(parseInt((this.vars['number'] * this.progress()), 10).toLocaleString().split('.')[0]);
                    }, onComplete: function() {
                        $('.num4 span').text(parseInt(this.vars['number'], 10).toLocaleString().split('.')[0]);
                    }})
                ]},
				{method: 'call', fx: function(){
					var updateCounter = function(){
						$.ajax({
							url : CONST_REQUEST_ROOT+'/inc/get_sales.php',
							dataType: 'jsonp',
							success : function(result){
								$('.num1 span').text(result.cnt_sushi.toLocaleString().split('.')[0]);
								$('.num2 span').text(result.cnt_takeaway.toLocaleString().split('.')[0]);
								$('.num3 span').text(result.cnt_delivery.toLocaleString().split('.')[0]);
								$('.num4 span').text(result.cnt_visitor.toLocaleString().split('.')[0]);
								setTimeout(function(){
									updateCounter();
								},3000);
							}
						});
					}
					updateCounter();
				}},
    		],
            [
                {method: 'call', fx: function() {
                    lyr2Slide.autoplay.start();
    			}},
            ]
    	];
    	new YMotion(mainMotion).activate();
    });
}(jQuery));
