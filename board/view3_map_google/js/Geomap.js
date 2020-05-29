/**************************************************************************************************
 * Geomap | Google Maps Javascript API v3를 이용하여 위치 기반 어플리케이션을 만듭니다.
 *
 * @class Geomap
 * @constructor
 * @version 1.0
 *
 **************************************************************************************************/
(function($) {

	'use strict';

	window.Geomap = function() {
		if(this instanceof Geomap === false) {
			return new Geomap();
		}
	};

	// Geomap class의 prototype 객체에 기본 property를 추가합니다.
	Geomap.prototype = {
		map: null,
		center: null,
		markers: [],
		infoWindow: null,
		prevMarker: null,
		useGeolocation: location.protocol.toLowerCase().indexOf('https') > -1 && typeof navigator.geolocation === 'object',
		geolocator: null,
		geomarker: null,
		isWebkit: true,
		geocoder: new google.maps.Geocoder(),
		opt: {
			initGeocode: {lat: 36.64912730597337, lng: 127.64642533629605},
			mapOptions: {
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				zoom: 7,
				zoomControlOptions: {
					position: google.maps.ControlPosition.RIGHT_TOP
				},
				streetViewControl: false,
				scrollwheel: false,
			},
			getCurrentPosition: true,
			icon: null,
			infoWindow: {
				calculate: true
			}
		}
	};

	/*
	 * Geomap class 초기화 함수
	 *
	 * @method initialize
	 * @param {String} _container 컨테이너의 ID값
	 * @param {Object} options 옵션
	 * @param {Function} callback 콜백 함수
	 */
	Geomap.prototype.initialize = function(_container, options, callback) {
		this.isWebkit = this.checkWebkitBrowser();
		for(var prop in options) {
			if(prop === 'mapOptions' || prop === 'infoWindow') {
				for(var property in options[prop]) {
					this.opt[prop][property] = options[prop][property];
				}
			}
			else this.opt[prop] = options[prop];
		}
		var opt = this.opt;
		opt.mapOptions.center = new google.maps.LatLng(opt.initGeocode.lat, opt.initGeocode.lng);
		this.center = {lat: opt.initGeocode.lat, lng: opt.initGeocode.lng};
		this.map = new google.maps.Map(document.getElementById(_container), opt.mapOptions);
		if(opt.getCurrentPosition) this.getCurrentPosition();
		if(typeof callback === 'function') callback();
	};

	/*
	 * 클라이언트의 현재 위치를 구합니다.
	 *
	 * @method getCurrentPosition
	 * @param {Object} geocode
	 * @param {Function} callback
	 */
	Geomap.prototype.getCurrentPosition = function(callback) {
		function setPosition() {
			if(!_this.geolocator) {
				_this.geolocator = document.getElementById('geolocator');
				_this.geolocator.style.display = 'block';
			}
			_this.map.panTo(_this.center);
			if(!_this.geomarker) _this.setClientLocationMarker();
			else _this.geomarker.setPosition(_this.center);
			_this.map.setZoom(14);
			if(typeof callback === 'function') callback();
		}

		var _this = this;
		if(this.useGeolocation) {
			navigator.geolocation.getCurrentPosition(function(response) {
				if(_this.isWebkit) {
					_this.center = {lat: response.coords.latitude, lng: response.coords.longitude};
					setPosition();
				} else {
					if(!sessionStorage.geolocation) {
						$.getJSON(_this.opt.geolocationApiUrl, function(r) {
							if(r.returnCode === 0) {
								var obj = {lat: r.geoLocation.lat, lng: r.geoLocation.long};
								sessionStorage.geolocation = JSON.stringify(obj);
								_this.center = obj;
								setPosition();
							} else {
								if(typeof callback === 'function') callback();
							}
						}).error(function(e) {
							console.log(e.statusText);
						});
					} else {
						var obj = JSON.parse(sessionStorage.geolocation);
						_this.center = {lat: obj.lat, lng: obj.lng};
						setPosition();
					}
				}
			}, function(e) {
				if(typeof callback === 'function') callback();
			}, {
				enableHighAccuracy: true
			});
		} else {
			if(typeof callback === 'function') callback();
		}
	};

	/*
	 * 클라이언트의 현재 위치를 지도에 표시합니다.
	 *
	 * @method setClientLocationMarker
	 */
	Geomap.prototype.setClientLocationMarker = function() {
		this.geomarker = new google.maps.Marker({
			position: this.center,
			map: this.map,
			title: '내 위치'
		});
	};

	/*
	 * 특정 자원에서 위치 정보를 가져온 뒤 marking method를 호출합니다.
	 *
	 * @method setPlaceMarkers
	 * @param {String} requestUrl 위치 정보를 요청할 자원의 url
	 * @param {Object} data requestUrl에 전달할 쿼리
	 * @param {Function} callback 콜백 함수
	 */
	Geomap.prototype.setPlaceMarkers = function(requestUrl, data, callback) {
		var _this = this;
		this.deletePlaceMarkers();
		this.markers = [];
		$.getJSON(requestUrl, data, function(response) {
			var latlngbounds = new google.maps.LatLngBounds();
			var length = response.data.length;
			for(var i=0; i<length; i++) {
				var	placeInfo = response.data[i];
				if(typeof placeInfo.geocode === 'object') {
					latlngbounds.extend(new google.maps.LatLng(placeInfo.geocode.lat, placeInfo.geocode.lng));
					_this.marking(placeInfo.geocode, placeInfo, length, i);
				}
			}
			if(!data.search && length > 0) {
				if(data.geolocation) {
					_this.map.panTo(_this.center);
					if(_this.geolocator) _this.map.setZoom(14);
				} else {
					_this.map.fitBounds(latlngbounds);
				}
			} else if(data.search && length > 0) {
				_this.map.fitBounds(latlngbounds);
				if(length === 1) _this.map.setZoom(18);
			} else if(data.search && length === 0) {
				_this.geocoding(data.search, function(geocode) {
					_this.map.panTo(geocode);
					_this.map.setZoom(12);
				});
			}
			if(typeof callback === 'function') callback(response);
		}).error(function(e) {
			console.log(e.statusText);
		});
	};

	/*
	 * 획득한 위치 정보를 바탕으로 지도에 마커를 표시합니다.
	 * info_w property의 값으로 객체가 할당되었다면  bindInfoWindow method를 호출합니다.
	 * 위치 정보가 하나라면 activateMarker method를 호출합니다.
	 *
	 * @method marking
	 * @param {Object} geocode 경위도 좌표 값
	 * @param {Ojbect} placeInfo 위치 정보
	 * @param {Number} length 획득한 위치 정보의 갯수
	 */
	Geomap.prototype.marking = function(geocode, placeInfo, length) {
		var	marker = new google.maps.Marker({
			map: this.map,
			position: {lat: +geocode.lat, lng: +geocode.lng},
			title: placeInfo.subject,
			animation: google.maps.Animation.DROP,
			icon: this.opt.icon
		});
		this.markers.push(marker);
		if(typeof this.opt.infoWindow === 'object') this.bindInfoWindow(marker, placeInfo);
		if(length === 1) {
			if(this.opt.infoWindow.calculate) {
				placeInfo.distance = this.calculateDistance(geocode);
			}
			this.activateMarker(marker, placeInfo);
		}
	};

	/*
	 * 마커에 click 이벤트 핸들러를 추가합니다.
	 *
	 * @method bindInfoWindow
	 * @param {Ojbect} marker 객체 인스턴스
	 * @param {Ojbect} placeInfo 위치 정보
	 */
	Geomap.prototype.bindInfoWindow = function(marker, placeInfo) {
		var _this = this;
		google.maps.event.addListener(marker, 'click', function(e) {
			if(_this.opt.infoWindow.calculate) {
				placeInfo.distance = _this.calculateDistance(e.latLng);
			}
			_this.openInfoWindow(marker, placeInfo);
		});
	};

	/*
	 * 마커를 click하면 특정 url로부터 내용을 가져와 모달창을 엽니다.
	 *
	 * @method openInfoWindow
	 * @param {Ojbect} maker 객체 인스턴스
	 * @param {Ojbect} placeInfo 위치 정보
	 */
	Geomap.prototype.openInfoWindow = function(marker, placeInfo) {
		var _this = this;
		$.post(this.opt.infoWindow.requestUrl, placeInfo, function(response) {
			if(_this.infoWindow !== null) _this.infoWindow.close();
			if(_this.prevMarker !== null) _this.prevMarker.setAnimation(null);
			_this.infoWindow = new google.maps.InfoWindow({
				content: response
			});
			_this.infoWindow.open(_this.map, marker);
			_this.map.panTo(marker.getPosition());
			marker.setAnimation(google.maps.Animation.BOUNCE);
			google.maps.event.addListener(_this.infoWindow, 'closeclick', function() {
				_this.prevMarker.setAnimation(null);
				if(typeof _this.opt.infoWindow.callback === 'function') _this.opt.infoWindow.callback();
			});
			_this.prevMarker = marker;
		}, 'html').error(function(e) {
			console.log(e.statusText);
		});;
	};

	/*
	 * 해당 마커로 지도의 중심점을 이동하고 모달창을 엽니다.
	 *
	 * @method activateMaker
	 * @param {Ojbect} marker 객체 인스턴스
	 * @param {Ojbect} placeInfo 위치 정보
	 */
	Geomap.prototype.activateMarker = function(marker, placeInfo) {
		this.map.panTo(marker.getPosition());
		this.openInfoWindow(marker, placeInfo);
	};

	/*
	 * 표시 중인 마커를 지웁니다.
	 *
	 * @method deletePlaceMarkers
	 */
	Geomap.prototype.deletePlaceMarkers = function() {
		for(var i=0; i<this.markers.length; i++) {
			this.markers[i].setMap(null);
		}
	};

	/*
	 * 문자열 주소를 경위도 좌표 값으로 변환한 뒤 callback 함수를 호출합니다.
	 *
	 * @method geocoding
	 * @param {String} address 변환할 주소
	 * @param {Function} callback 콜백 함수
	 */
	Geomap.prototype.geocoding = function(address, callback) {
		this.geocoder.geocode({address: address}, function(results, status) {
			if(status === google.maps.GeocoderStatus.OK) {
				var geocode = results[0].geometry.location;
				callback({lat: geocode.lat(), lng: geocode.lng()});
			}
		});
	};

	/*
	 * 두 위치 간의 거리를 구해 km 단위로 반환합니다.
	 *
	 * @method calculateDistance
	 * @param {Object} geocode 경위도 좌표 값
	 * @return {Number} 위치 간의 거리
	 */
	Geomap.prototype.calculateDistance = function(geocode) {
 		var latLng1 = this.opt.mapOptions.center;
		if(typeof geocode.lat === 'function') {
			var latLng2 = new google.maps.LatLng(geocode.lat(), geocode.lng());
		} else {
			var latLng2 = new google.maps.LatLng(geocode.lat, geocode.lng);
		}
 		return Math.round(parseInt(google.maps.geometry.spherical.computeDistanceBetween(latLng1, latLng2), 10) / 10) / 100;
 	};

	/*
	 * 웹킷 계열의 브라우저인지 체크합니다.
	 *
	 * @method checkWebkitBrowser
	 */
	Geomap.prototype.checkWebkitBrowser = function() {
		var userAgent = navigator.userAgent.toLowerCase();
		if(userAgent.indexOf('applewebkit') > -1) {
			return true;
		}
		return false;
	};

}(jQuery));


(function($) {

	'use strict';

	var win = $(window), doc = $(document);

	var gmap = new Geomap();

/****************************************
 ** Geomapping **************************
 ****************************************/

	/*
	 * 특정 데이터를 기반으로 원하는 위치 정보를 제공합니다.
	 *
	 * @class Geomapping
	 * @constructor
	 */
	var Geomapping = function() {

		var	_this = this;

		var	_container = 'placeLoadMap',
			ajaxFilePath = CONST_SKIN_PATH + '/resource';

		var	options = {
			getCurrentPosition: true,
			geolocationApiUrl: ajaxFilePath + '/geolocation.php',
			mapOptions: {},
			icon: CONST_REQUEST_ROOT + '/design/other/marker.png',
			infoWindow: {
				requestUrl: ajaxFilePath + '/place_pop.php'
			},
		};

		/*
		 * Geomapping class 초기화 함수
		 *
		 * @method initialize
		 */
		this.initialize = function() {
			// Geomap을 초기화합니다.
			gmap.initialize(_container, options, function() {
				gmap.setPlaceMarkers(ajaxFilePath + '/place_find.php', placeOptions);
			});

			$('body').on('click', '#geolocator', function() {
				gmap.getCurrentPosition(function() {
					gmap.setPlaceMarkers(ajaxFilePath + '/place_find.php', placeOptions);
				});
			});
		};

		// Geomapping class 초기화 함수를 호출합니다.
		this.initialize();
	};

/****************************************
 ** GeomapFind **************************
 ****************************************/

	/*
	 * 특정 데이터를 기반으로 위치를 검색합니다.
	 *
	 * @class GeomapFind
	 * @constructor
	 */
	var GeomapFind = function() {

		var _this = this;

		var district = {
			'서울' : ['강남구','강동구','강북구','강서구','관악구','광진구','구로구','금천구','노원구','도봉구','동대문구','동작구','마포구','서대문구','서초구','성동구','성북구','송파구','양천구','영등포구','용산구','은평구','종로구','중구','중랑구'],
			'부산' : ['강서구','금정구','남구','동구','동래구','부산진구','북구','사상구','사하구','서구','수영구','연제구','영도구','중구','해운대구','기장군'],
			'대구' : ['남구','달서구','동구','북구','서구','수성구','중구','달성군'],
			'인천' : ['계양구','남구','남동구','동구','미추홀구','부평구','서구','연수구','중구','강화군','옹진군'],
			'광주' : ['광산구','남구','동구','북구','서구'],
			'대전' : ['대덕구','동구','서구','유성구','중구'],
			'울산' : ['남구','동구','북구','중구','울주군'],
			'세종' : [],
			'경기' : ['고양시 덕양구','고양시 일산동구','고양시 일산서구','과천시','광명시','광주시','구리시','군포시','김포시','남양주시','동두천시','부천시','성남시 분당구','성남시 수정구','성남시 중원구','수원시 권선구','수원시 영통구','수원시 장안구','수원시 팔달구','시흥시','안산시 단원구','안산시 상록구','안성시','안양시 동안구','안양시 만안구','양주시','오산시','용인시 기흥구','용인시 수지구','용인시 처인구','의왕시','의정부시','이천시','파주시','평택시','포천시','하남시','화성시','가평군','양평군','여주군','연천군'],
			'강원' : ['강릉시','동해시','삼척시','속초시','원주시','춘천시','태백시','고성군','양구군','양양군','영월군','인제군','정선군','철원군','평창군','홍천군','화천군','횡성군'],
			'충북' : ['제천시','청주시 상당구','청주시 흥덕구','충주시','괴산군','단양군','보은군','영동군','옥천군','음성군','증평군','진천군','청원군'],
			'충남' : ['계룡시','공주시','논산시','보령시','서산시','아산시','천안시 동남구','천안시 서북구','금산군','당진시','부여군','서천군','연기군','예산군','청양군','태안군','홍성군'],
			'전북' : ['군산시','김제시','남원시','익산시','전주시 덕진구','전주시 완산구','정읍시','고창군','무주군','부안군','순창군','완주군','임실군','장수군','진안군'],
			'전남' : ['광양시','나주시','목포시','순천시','여수시','강진군','고흥군','곡성군','구례군','담양군','무안군','보성군','신안군','영광군','영암군','완도군','장성군','장흥군','진도군','함평군','해남군','화순군'],
			'경북' : ['경산시','경주시','구미시','김천시','문경시','상주시','안동시','영주시','영천시','포항시 남구','포항시 북구','고령군','군위군','봉화군','성주군','영덕군','영양군','예천군','울릉군','울진군','의성군','청도군','청송군','칠곡군'],
			'경남' : ['거제시','김해시','마산시','밀양시','사천시','양산시','진주시','진해시','창원시','통영시','거창군','고성군','남해군','산청군','의령군','창녕군','하동군','함안군','함양군','합천군'],
			'제주' : ['제주시','서귀포시'],
		};

		var $findWrap = $('#placeFindWrap'),
			$local1Wrap = $('#local1ListWrap'),
			$local2Wrap = $('#local2ListWrap'),
			$local1Btn = $('#local1Button'),
			$local2Btn = $('#local2Button'),
			$findInput = $('#placeName'),
			$local1 = $('#local1'),
			$local2 = $('#local2'),
			local1BtnDef = $local1Btn.text(),
			local2BtnDef = $local2Btn.text(),
			local1Val = null,
			local2Val = null;

		var ajaxFilePath = CONST_SKIN_PATH + '/resource',
			requestUrl = ajaxFilePath + '/place_find.php';

		var _listContainer = '.store_list_wrap',
			listUrl = CONST_ROOT + '/board/index.php';

		/*
		 * GeomapFind class 초기화 함수
		 *
		 * @method initialize
		 */
		this.initialize = function() {
			$local1Btn.on('click', this.local1Spread);
			$local2Btn.on('click', this.local2Spread);
			$findWrap.find('.select.cols').on('mouseleave', this.selectBoxInit);
			$findWrap.on('click', '#local1 > li > a', this.local1Action);
			$findWrap.on('click', '#local2 > li > a', this.local2Action);
			$findWrap.on('submit', '.placefindbyname', this.findAction);
			new Labeling($findInput);
			if($.trim(placeOptions.search) !== '') {
				$('.placefindbyname').trigger('click');
				$findInput.val(placeOptions.search);
			}
		};

		/*
		 * 첫 번째 select box를 활성화합니다.
		 *
		 * @method local1Spread
		 */
		this.local1Spread = function() {
			if($local1Wrap.is(':hidden')) {
				$local1Wrap.stop().slideDown(300, function() {
					$(this).mCustomScrollbar({
						autoDraggerLength: false,
						scrollInertia: 80,
						mouseWheel: {
							preventDefault: true
						}
					});
				});
				if($local2Btn.text() !== local2BtnDef) $local2Btn.text(local2BtnDef);
				local2Val = null;
			}
		};

		/*
		 * 두 번째 select box를 활성화합니다.
		 *
		 * @method local2Spread
		 */
		this.local2Spread = function() {
			if(local1Val !== null && $local2Wrap.is(':hidden')) {
				$local2Wrap.stop().slideDown(300, function() {
					$(this).mCustomScrollbar({
						autoDraggerLength: false,
						scrollInertia: 80,
						mouseWheel: {
							preventDefault: true
						}
					});
				});
			}
		};

		/*
		 * 첫 번째 select box의 값을 고르면 두 번째 select box를 활성화하거나 위치를 검색합니다.
		 *
		 * @method local1Action
		 * @param {Object} e event 객체
		 */
		this.local1Action = function(e) {
			e.preventDefault();
			_this.selectBoxInit();
			$findInput.empty().trigger('blur');
			var $self = $(this);
			$local1Btn.text($self.text());
			local1Val = $self.data('value');
			var depth2 = district[local1Val];
			$local2.empty().append('<li><a href="#none" data-value="'+local1Val+'">전체</a></li>');
			if(typeof depth2 === 'object') {
				for(var i=0; i<depth2.length; i++) {
					$local2.append('<li><a href="#none" data-value="'+depth2[i]+'">'+depth2[i]+'</a></li>');
				}
				var search = local1Val + (typeof local2Val === 'string' ? ' '+local2Val : '');
				var query = {board: CONST_BOARD, sca: placeOptions.sca, skin: placeOptions.skin, search: search, select: 'addr_road||addr_number'};
			} else {
				var query = {board: CONST_BOARD, sca: placeOptions.sca, skin: placeOptions.skin};
			}
			gmap.setPlaceMarkers(requestUrl, query);
			_this.updateList(query);
		};

		/*
		 * 두 번째 select box의 값을 고르면 해당 위치를 검색합니다.
		 *
		 * @method local2Action
		 * @param {Object} e event 객체
		 */
		this.local2Action = function(e) {
			e.preventDefault();
			_this.selectBoxInit();
			$findInput.empty().trigger('blur');
			var $self = $(this);
			$local2Btn.text($self.text());
			local2Val = $self.data('value');
			if(typeof local1Val === 'string') {
				var search = local2Val === local1Val ? local2Val : local1Val+' '+local2Val;
				var query = {board: CONST_BOARD, sca: placeOptions.sca, skin: placeOptions.skin, search: search, select: 'addr_road||addr_number'};
				gmap.setPlaceMarkers(requestUrl, query);
				_this.updateList(query);
			}
		};

		/*
		 * select box를 비활성화합니다.
		 *
		 * @method selectBoxInit
		 */
		this.selectBoxInit = function() {
			if($local1Wrap.is(':visible')) {
				$local1Wrap.hide(0, function() {
					$(this).mCustomScrollbar('destroy');
				});
			}
			if($local2Wrap.is(':visible')) {
				$local2Wrap.hide(0, function() {
					$(this).mCustomScrollbar('destroy');
				});
			}
		};

		/*
		 * 검색어를 이용해 위치 정보를 검색합니다.
		 *
		 * @method findAction
		 * @param {Object} e event 객체
		 */
		this.findAction = function(e) {
			e.preventDefault();
			$local1Btn.text('광역시/도');
			$local2Btn.text('시/군/구');
			$local2.empty();
			var query = {board: CONST_BOARD, sca: placeOptions.sca, skin: placeOptions.skin, search: $findInput.val(), select: 'addr_road||addr_number||title_01'};
			gmap.setPlaceMarkers(requestUrl, query);
			_this.updateList(query);
		};

		/*
		 * 검색 결과에 따라 하단 리스트를 업데이트 합니다.
		 *
		 * @method updateList
		 * @param {Object} query
		 */
		this.updateList = function(query) {
			$.get(listUrl, query, function(response) {
				$(_listContainer).html($(response).find(_listContainer).html());
			}, 'html').error(function(e) {
				console.log(e.statusText);
			});;
		};

		// GeomapFind class 초기화 함수를 호출합니다.
		this.initialize();
	};

	doc.ready(function() {
		new Geomapping();
		new GeomapFind();
	});

}(jQuery));