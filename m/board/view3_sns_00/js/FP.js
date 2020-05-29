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
				FB.api(opt.pageId + '/picture', {width: 120, height: 120}, function(r) {
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
			$('.fbCover', opt.wrapper).html('<a href="https://facebook.com/' + opt.pageId + '/" target="_blank" title="' + pageInfo.name + ' facebook 바로가기"><img src="' + pageInfo.cover + '" alt="' + pageInfo.name + '"></a>');
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
					else _this.notice('불러올 내용이 없습니다.');
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
				if(typeof data[i]['picture'] === 'string') data[i]['photo'] = response.data['url'];
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
				setTimeout(function() {
					$('.fbMore', opt.wrapper).removeClass('spinner');
					win.trigger('resize');
				}, 200);
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