/**************************************************************************************************
 * THIRD PARTY LIBRARIES
 **************************************************************************************************/
/**
 * jQuery Masonry v2.1.08
 * A dynamic layout plugin for jQuery
 * The flip-side of CSS Floats
 * http://masonry.desandro.com
 *
 * Licensed under the MIT license.
 * Copyright 2012 David DeSandro
 */
!function(t,i){"use strict";var s,e=i.event;e.special.smartresize={setup:function(){i(this).bind("resize",e.special.smartresize.handler)},teardown:function(){i(this).unbind("resize",e.special.smartresize.handler)},handler:function(t,i){var e=this,n=arguments;t.type="smartresize",s&&clearTimeout(s),s=setTimeout(function(){jQuery.event.handle.apply(e,n)},"execAsap"===i?0:100)}},i.fn.smartresize=function(t){return t?this.bind("smartresize",t):this.trigger("smartresize",["execAsap"])},i.Mason=function(t,s){this.element=i(s),this._create(t),this._init()},i.Mason.settings={isResizable:!0,isAnimated:!1,animationOptions:{queue:!1,duration:500},gutterWidth:0,isRTL:!1,isFitWidth:!1,containerStyle:{position:"relative"}},i.Mason.prototype={_filterFindBricks:function(t){var i=this.options.itemSelector;return i?t.filter(i).add(t.find(i)):t},_getBricks:function(t){var i=this._filterFindBricks(t).css({position:"absolute"}).addClass("masonry-brick");return i},_create:function(s){this.options=i.extend(!0,{},i.Mason.settings,s),this.styleQueue=[];var e=this.element[0].style;this.originalStyle={height:e.height||""};var n=this.options.containerStyle;for(var o in n)this.originalStyle[o]=e[o]||"";this.element.css(n),this.horizontalDirection=this.options.isRTL?"right":"left",this.offset={x:parseInt(this.element.css("padding-"+this.horizontalDirection),10),y:parseInt(this.element.css("padding-top"),10)},this.isFluid=this.options.columnWidth&&"function"==typeof this.options.columnWidth;var h=this;setTimeout(function(){h.element.addClass("masonry")},0),this.options.isResizable&&i(t).bind("smartresize.masonry",function(){h.resize()}),this.reloadItems()},_init:function(t){this._getColumns(),this._reLayout(t)},option:function(t){i.isPlainObject(t)&&(this.options=i.extend(!0,this.options,t))},layout:function(t,i){for(var s=0,e=t.length;e>s;s++)this._placeBrick(t[s]);var n={};if(n.height=Math.max.apply(Math,this.colYs),this.options.isFitWidth){var o=0;for(s=this.cols;--s&&0===this.colYs[s];)o++;n.width=(this.cols-o)*this.columnWidth-this.options.gutterWidth}this.element.css(n);var h,r=this.isLaidOut&&this.options.isAnimated?"animate":"css",a=this.options.animationOptions;for(s=0,e=this.styleQueue.length;e>s;s++)h=this.styleQueue[s],h.style.opacity=1,h.$el[r](h.style,a);this.styleQueue=[],i&&i.call(t),this.isLaidOut=!0},_getColumns:function(){var t=this.options.isFitWidth?this.element.parent():this.element,i=t.width();this.columnWidth=this.isFluid?this.options.columnWidth(i):this.options.columnWidth||this.$bricks.outerWidth(!0)||i,this.columnWidth+=this.options.gutterWidth,this.cols=Math.floor((i+this.options.gutterWidth)/this.columnWidth),this.cols=Math.max(this.cols,1)},_placeBrick:function(t){var s,e,n,o,h,r=i(t);if(s=Math.ceil(r.outerWidth(!0)/(this.columnWidth+this.options.gutterWidth)),s=Math.min(s,this.cols),1===s)n=this.colYs;else for(e=this.cols+1-s,n=[],h=0;e>h;h++)o=this.colYs.slice(h,h+s),n[h]=Math.max.apply(Math,o);for(var a=Math.min.apply(Math,n),l=0,c=0,u=n.length;u>c;c++)if(n[c]===a){l=c;break}var d={top:a+this.offset.y};d[this.horizontalDirection]=this.columnWidth*l+this.offset.x,this.styleQueue.push({$el:r,style:d});var m=a+r.outerHeight(!0),p=this.cols+1-u;for(c=0;p>c;c++)this.colYs[l+c]=m},resize:function(){var t=this.cols;this._getColumns(),(this.isFluid||this.cols!==t)&&this._reLayout()},_reLayout:function(t){var i=this.cols;for(this.colYs=[];i--;)this.colYs.push(0);this.layout(this.$bricks,t)},reloadItems:function(){this.$bricks=this._getBricks(this.element.children())},reload:function(t){this.reloadItems(),this._init(t)},appended:function(t,i,s){if(i){this._filterFindBricks(t).css({top:this.element.height()});var e=this;setTimeout(function(){e._appended(t,s)},1)}else this._appended(t,s)},_appended:function(t,i){var s=this._getBricks(t);this.$bricks=this.$bricks.add(s),this.layout(s,i)},remove:function(t){this.$bricks=this.$bricks.not(t),t.remove()},destroy:function(){this.$bricks.removeClass("masonry-brick").each(function(){this.style.position="",this.style.top="",this.style.left=""});var s=this.element[0].style;for(var e in this.originalStyle)s[e]=this.originalStyle[e];this.element.unbind(".masonry").removeClass("masonry").removeData("masonry"),i(t).unbind(".masonry")}},i.fn.imagesLoaded=function(t){function s(){t.call(n,o)}function e(t){var n=t.target;n.src!==r&&-1===i.inArray(n,a)&&(a.push(n),--h<=0&&(setTimeout(s),o.unbind(".imagesLoaded",e)))}var n=this,o=n.find("img").add(n.filter("img")),h=o.length,r="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==",a=[];return h||s(),o.bind("load.imagesLoaded error.imagesLoaded",e).each(function(){var t=this.src;this.src=r,this.src=t}),n};var n=function(i){t.console&&t.console.error(i)};i.fn.masonry=function(t){if("string"==typeof t){var s=Array.prototype.slice.call(arguments,1);this.each(function(){var e=i.data(this,"masonry");return e?i.isFunction(e[t])&&"_"!==t.charAt(0)?void e[t].apply(e,s):void n("no such method '"+t+"' for masonry instance"):void n("cannot call methods on masonry prior to initialization; attempted to call method '"+t+"'")})}else this.each(function(){var s=i.data(this,"masonry");s?(s.option(t||{}),s._init()):i.data(this,"masonry",new i.Mason(t,this))});return this}}(window,jQuery);


/**************************************************************************************************
 * FP | Facebook JavaScript SDK를 이용하여 페이스북 페이지 피드를 가져옵니다.
 *
 * @class FP
 * @constructor
 * @version 1.0
 *
 * @param {Object} container jQuery 객체
 * @param {Object} options 옵션 객체
 *
 **************************************************************************************************/
(function($) {

	'use strict';

	window.FP = function(container, options) {

		if(this instanceof FP === false) {
			return new FP(container, options);
		}

		var _this = this;

		var opt = {appId: '577416002426079', appSecret: 'fb19efb3ebf68849b3ffe627e68104cf', requestUrl: CONST_SKIN_PATH + '/resource/fb_page_feed.php', pageId: null, wrapper: $('.fb_wrap'), limit: 25, textLimit: false};

		for(var prop in options) {
			opt[prop] = options[prop];
		}

		var	access_token = opt.appId + '|' + opt.appSecret,
			pageInfo = {},
			data = [],
			until = null,
			isAnimated = true,
			opacity = true,
			count = 0,
			init = true;

		/*
		 * Facebook class 초기화 함수
		 *
		 * @method initialize
		 */
		this.initialize = function() {
			FB.init({
				appId: opt.appId,
				xfbml: true,
                version: 'v2.5'
			});
			until = new Date().getTime();
			this.getPageInfo();
			this.getPageFeed();
			this.setHandler();
			if(typeof document.createElement('div').style['opacity'] === 'undefined') {
				isAnimated = false;
				opacity = false;
			}
			container.masonry({
				itemSelector: '.grid-item',
				columnWidth: 1,
				isAnimated: isAnimated,
				isResizable: false
			});
		};

		/*
		 * 페이지의 정보를 가져옵니다.
		 *
		 * @method getPageInfo
		 */
		this.getPageInfo = function() {
			FB.api(opt.pageId, {access_token: access_token, fields: 'about, likes, name'}, function(response) {
				pageInfo.about = response.about;
				pageInfo.likes = response.likes;
				pageInfo.name = response.name;
				FB.api(opt.pageId + '/picture', {width: 120, height: 120, redirect: false}, function(r) {
					pageInfo.cover = r.data.url;
					_this.setPageInfo();
				});
			});
		};

		/*
		 * 페이지의 정보를 노출합니다.
		 *
		 * @method setPageInfo
		 */
		 this.setPageInfo = function() {
			$('.fbCover', opt.wrapper).html('<a href="https://facebook.com/' + opt.pageId + '/" target="_blank" title="' + pageInfo.name + ' facebook 바로가기"><img src="' + pageInfo.cover + '" alt="' + pageInfo.name + '" /></a>');
			$('.fbAbout', opt.wrapper).text(pageInfo.about);
			$('.fbName', opt.wrapper).text(pageInfo.name);
 		};

		/*
		 * 페이지의 피드를 가져옵니다.
		 *
		 * @method getPageFeed
		 */
		this.getPageFeed = function() {
			data = [];
			FB.api(opt.pageId + '/feed', {access_token: access_token, limit: opt.limit, until: until, fields: 'created_time, from, link, message, object_id, picture'}, function(response) {
				if(typeof response['error'] === 'object') _this.notice('에러가 발생했습니다. 다시 시도해 주시기 바랍니다.');
				if(response.data.length === 0) {
					if(init === false) _this.notice('더 이상 불러올 내용이 없습니다.');
					else _this.notice('블러올 게시물이 없습니다.');
				} else {
					init = false;
				}
				for(var i=0, j=0; i<response.data.length; i++) {
					if(response.data[i]['from']['name'] !== pageInfo.name) continue;
					data[j] = response.data[i];
					j++;
				}
				for(var i=0; i<data.length; i++) {
					if(i === data.length - 1) {
						// ios와 ie8 이하 버전의 parsing error에 대한 대응
						until = isNaN(Date.parse(data[i]['created_time'])) === false ? (Date.parse(data[i]['created_time']) / 1000) - 1 : (Date.parse(data[i]['created_time'].replace(/-/g, '\/').replace(/T/, ' ')) / 1000) - 1;
					}
					_this.getPicture(data[i]['object_id'], i);
				}
			});
		};

		/*
		 * 원본 이미지 url을 가져옵니다.
		 *
		 * @method getPicture
		 * @param {String} postId 게시물 고유 id값
		 * @param {Number} i 인덱스 번호
		 */
		this.getPicture = function(postId, i) {
			FB.api(postId + '/picture', {access_token: access_token, redirect: false}, function(response) {
				if(typeof data[i]['picture'] === 'string' && response.data['is_silhouette'] === false) data[i]['photo'] = response.data['url'];
				if(count === data.length - 1) _this.setPageFeed(data);
				count++;
			});
		};

		/*
		 * 가져온 페이지 피드를 문서에 전달합니다.
		 *
		 * @method setPageFeed
		 * @param {Object} response 피드 객체
		 */
		this.setPageFeed = function(response) {
			$.post(opt.requestUrl, {pageId: opt.pageId, cover: pageInfo.cover, feed: data, name: pageInfo.name, textLimit: opt.textLimit}, function(response) {
				container.append(response);
				if(opacity === true) container.children('.grid-item').not('.masonry-brick').css({visibility: 'visible', opacity: 0});
				container.imagesLoaded(function() {
					container.masonry('appended', container.children('.grid-item').not('.masonry-brick'), true, function() {
						if(opacity === false) container.children('.grid-item').css({visibility: 'visible'});
					});
					setTimeout(function() {
						$('.fbMore', opt.wrapper).removeClass('spinner');
						win.trigger('resize');
					}, 200);
				});
				if(typeof opt.callback === 'function') opt.callback();
			}, 'html').error(function(e) {
                _this.notice(e.statusText);
            });;
		};

		/*
		 * 더보기 버튼 이벤트 핸들러를 등록합니다.
		 *
		 * @method setPageFeed
		 * @param {Object} response 피드 객체
		 */
		this.setHandler = function() {
			$('.fbMore', opt.wrapper).click(function(e) {
				count = 0;
				$(this).addClass('spinner');
				_this.getPageFeed();
				e.preventDefault();
			});
		};

		/*
		 * 경고창을 띄웁니다.
		 *
		 * @method notice
		 * @param {String} msg 경고 메세지
		 */
		this.notice = function(msg) {
			$('.fbMore', opt.wrapper).removeClass('spinner');
			alert(msg);
			return false;
		};

		// Facebook class 초기화 함수를 호출합니다.
		this.initialize();
	};

}(jQuery));