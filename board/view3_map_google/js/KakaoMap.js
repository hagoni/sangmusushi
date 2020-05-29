/**************************************************************************************************
 * KakaoMap | Kakao map api를 이용하여 지도를 출력합니다.
 *
 * @class KakaoMap
 * @constructor
 * @version 1.0
 *
 * @param {String} container 지도를 출력할 요소의 ID 값
 * @param {Object} options 옵션 객체
 *
 **************************************************************************************************/
window.KakaoMap = function(container, options) {

	'use strict';

	if(this instanceof KakaoMap === false) {
		return new KakaoMap(container, options);
	}

	var _this = this;

	var map,
		mapContainer = document.getElementById(container),
		mapOptions = {level: 3},
		marker,
		markerOptions,
        rv,
        resizeTimer = null;

    var opt = {
        mapTypeControl: true,
        zoomControl: true
    };

    for(var prop in options) {
		opt[prop] = options[prop];
	}

	/*
	 * KakaoMap class 초기화 함수
	 *
	 * @method initialize
	 */
	this.initialize = function() {
        if(typeof opt.scrollwheel === 'boolean') mapOptions.scrollwheel = false;
        if(typeof opt.level === 'number') mapOptions.level = opt.level;
		if(typeof opt.geocode === 'object') {
            mapOptions.center = new daum.maps.LatLng(opt.geocode.lat, opt.geocode.lng);
            _this.mapping();
            if(typeof opt.roadView === 'object') _this.roadView();
        } else {
            _this.geocoding(opt.address, function() {
                _this.mapping();
                if(typeof opt.roadView === 'object') _this.roadView();
            });
        }
	};

	/*
	 * 주소를 경위도 좌표로 변환합니다.
	 *
	 * @method geocoding
	 * @param {String} addr 주소
	 * @param {Function} callback 콜백 함수
	 */
	this.geocoding = function(addr, callback) {
		var geocoder = new daum.maps.services.Geocoder();
		geocoder.addressSearch(addr, function(result, status) {
			if(status === daum.maps.services.Status.OK) {
				mapOptions.center = new daum.maps.LatLng(result[0].y, result[0].x);
				callback();
			}
		});
	};

	/*
	 * 지도를 출력합니다.
	 *
	 * @method mapping
	 */
	this.mapping = function() {
		map = new daum.maps.Map(mapContainer, mapOptions);
		this.addMarker();
		this.addControl();
        this.addHandler();
	};

	/*
	 * 마커를 표시합니다.
	 *
	 * @method addMarker
	 */
	this.addMarker = function() {
		markerOptions = {
			position: mapOptions.center
		};
		if(typeof opt.marker === 'object' && typeof opt.marker.src === 'string') markerOptions.image = new daum.maps.MarkerImage(opt.marker.src, new daum.maps.Size(opt.marker.size.x, opt.marker.size.y), {offset: new daum.maps.Point(opt.marker.offset.x, opt.marker.offset.y)});
		var marker = new daum.maps.Marker(markerOptions);
		marker.setMap(map);
	};

	/*
	 * 컨트롤을 올립니다.
	 *
	 * @method addControl
	 */
	this.addControl = function() {
		map.addControl(new daum.maps.MapTypeControl(), daum.maps.ControlPosition.TOPRIGHT);
		map.addControl(new daum.maps.ZoomControl(), daum.maps.ControlPosition.RIGHT);
	};

	/*
	 * 로드뷰를 출력합니다.
	 *
	 * @method roadView
	 */
	this.roadView = function() {
		var rvOptions = opt.roadView;
		rv = new daum.maps.Roadview(document.getElementById(rvOptions.container));
		var rvClient = new daum.maps.RoadviewClient();

		rvClient.getNearestPanoId(mapOptions.center, 50, function(panoId) {
			rv.setPanoId(panoId, mapOptions.center);
		});
	};

    this.addHandler = function() {
        win.resize(this.resize);
    };

    this.resize = function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            map.relayout();
            map.setCenter(mapOptions.center);
            if(typeof opt.roadView === 'object') rv.relayout();
        }, 100);
    };

	// KakaoMap class 초기화 함수를 호출합니다.
	this.initialize();
};