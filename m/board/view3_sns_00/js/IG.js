/**************************************************************************************************
 * IG | Instagram API를 이용하여 해시 태그로 검색한 내용을 표시합니다.
 *
 * @class IG
 * @constructor
 * @version 1.0
 *
 * @param {Object} container jQuery 객체
 * @param {Object} options 옵션 객체
 *
 **************************************************************************************************/
(function($) {

	'use strict';

	window.IG = function(container, options) {

		if(this instanceof IG === false) {
			return new IG(container, options);
		}

		var _this = this;

		var opt = {getJsonpUrl: '/freebest/xcross.php?http://view3landing.ivyro.net/_outline/instagram.php?', requestUrl: CONST_SKIN_PATH + '/resource/ig_hash_feed.php', hashTag: null, wrapper: $('.ig_wrap'), ignoreCaption: null};

		for(var prop in options) {
			opt[prop] = options[prop];
		}

		var maxId;

		this.initialize = function() {
			this.setHashFeed();
			this.setHandler();
		};

		this.setHashFeed = function() {
			switch(typeof maxId) {
				case 'string':
					var data = {hashTag: opt.hashTag, maxId: maxId};
					break;
				case 'boolean':
					$('.igMore', opt.wrapper).removeClass('spinner');
					alert('더 이상 불러올 내용이 없습니다.');
					return false;
				default:
					var data = {hashTag: opt.hashTag};
					break;
			}
            $.ajax({
                url: opt.getJsonpUrl,
                data: data,
                dataType: 'jsonp',
                type: 'get',
                success: function(response) {
					if(typeof response.entry_data.TagPage === 'undefined') {
						$('.igMore', opt.wrapper).removeClass('spinner');
						return false;
					}
                    $.post(opt.requestUrl, {hashTag: opt.hashTag, feed: response.entry_data.TagPage[0].tag.media.nodes, ignoreCaption: opt.ignoreCaption, skinPath: opt.skinPath}, function(html) {
                        container.append(html);
                        maxId = typeof response.entry_data.TagPage[0].tag.media.page_info.end_cursor === 'string' ? response.entry_data.TagPage[0].tag.media.page_info.end_cursor : false;
                        setTimeout(function() {
                            $('.igMore', opt.wrapper).removeClass('spinner');
							win.trigger('resize');
                        }, 200);
                    }).error(function(e) {
						_this.notice(e.statusText);
					});
                },
				error: function(e) {
					_this.notice(e.statusText);
				}
            });
		};

		this.setHandler = function() {
			$('.igMore', opt.wrapper).click(function(e) {
				$(this).addClass('spinner');
				_this.setHashFeed();
				e.preventDefault();
			});
		};

		this.notice = function(msg) {
		    $('.igMore', opt.wrapper).removeClass('spinner');
		    alert(msg);
		};

		// IG class 초기화 함수를 호출합니다.
		this.initialize();
	};

}(jQuery));