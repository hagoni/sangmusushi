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
		map: {},
		markers: [],
		gpsMarker: false,
		prevMarker: undefined,
		infoWindow: undefined,
		geocoder: new google.maps.Geocoder(),
		opt: {
			initGeocode: {lat: 36.566535, lng: 127.547796},
			mapOptions: {
				zoom: 8,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			},
			getCurrentPosition: false,
			icon: undefined,
			infoWindow: undefined,
			setMarker: false
		}
	};

	/*
	 * Geomap class 초기화 함수
	 *
	 * @method initialize
	 * @param {String} container 컨테이너의 ID값
	 * @param {Object} options 옵션
	 * @param {Function} callback 콜백 함수
	 */
	Geomap.prototype.initialize = function(container, options, callback) {
		var _this = this;
		for(var prop in options) {
			if(prop === 'mapOptions') for(var property in options.mapOptions) this.opt[prop][property] = options[prop][property];
			else this.opt[prop] = options[prop];
		}
		var opt = this.opt;
		var generateMap = function(geocode) {
			if(typeof opt.mapOptions.center === 'undefined') opt.mapOptions.center = new google.maps.LatLng(geocode.lat, geocode.lng);
			_this.map = new google.maps.Map(document.getElementById(container), opt.mapOptions);
			if(opt.setMarker === true) _this.setClientLocationMarker(geocode);
			if(typeof callback === 'function') callback(geocode);
		};
		if(opt.getCurrentPosition === true) this.getCurrentPosition(generateMap, opt.initGeocode);
		else generateMap(opt.initGeocode);
	};

	/*
	 * 클라이언트의 현재 위치를 구합니다.
	 *
	 * @method getCurrentPosition
	 * @param {Function} callback
	 * @param {Object} geocode
	 */
	Geomap.prototype.getCurrentPosition = function(callback, geocode) {
		if(this.checkMobile() === true) {
			if(typeof navigator.geolocation === 'object') {
				navigator.geolocation.getCurrentPosition(function(response) {
					callback({lat: response.coords.latitude, lng: response.coords.longitude});
				}, function(e) {
					alert('장치의 현재 위치 접근이 차단되었거나 장치의 오류로 인하여 이용자의 현재 위치 정보를 가져올 수 없습니다.');
					callback(geocode);
				});
			} else {
				alert('브라우저가 현재 위치 접근 기능을 지원하지 않습니다.');
				callback(geocode);
			}
		} else {
			callback(geocode);
		}
	};

	/*
	 * 클라이언트의 현재 위치를 지도에 표시합니다.
	 *
	 * @method setClientLocationMarker
	 * @param {Object} geocode 경위도 좌표 값
	 */
	Geomap.prototype.setClientLocationMarker = function(geocode) {
		var marker = new google.maps.Marker({
			position: geocode,
			map: this.map,
			title: '내 위치'
		});
		if(this.gpsMarker != false)this.gpsMarker.setMap(null);
		this.gpsMarker = marker;
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
		if(typeof geo_bound_mode == 'undefined'){
			window.geo_bound_mode = true;
		}
		$.post(requestUrl, data, function(response) {
			var length = response.data.length;
			var latlngbounds = new google.maps.LatLngBounds();
			for(var i=0; i<length; i++) {
				var	placeInfo = response.data[i];
				if(typeof placeInfo.geocode === 'object'){
					_this.marking(placeInfo.geocode , placeInfo, length);
					latlngbounds.extend(new google.maps.LatLng(placeInfo.geocode.lat, placeInfo.geocode.lng));
				} else {
					_this.geocoding(placeInfo.address, function(geocode) {
						_this.marking(geocode, placeInfo, length);
					});
					latlngbounds.extend(new google.maps.LatLng(geocode.lat, geocode.lng));
				}
			}
			/*
			if(typeof data === 'object') {
				if((typeof data.placeAddress === 'string' || typeof data.search === 'string') && length !== 1) {
					if(geo_bound_mode && length > 1){
						_this.map.fitBounds(latlngbounds);
					}else{
						_this.geocoding(data.placeAddress, function(geocode) {
							_this.panToTarget(geocode);
						});
					}
				}
				if(typeof data.placeName === 'string' && length > 1) {
					if(geo_bound_mode){
						_this.map.fitBounds(latlngbounds);
					}else{
						var geocode = {lat: +response.data[0].geocode.lat, lng: +response.data[0].geocode.lng};
						_this.panToTarget(geocode);
					}
				}
			}
			else _this.panToTarget(_this.opt.mapOptions.center);
			if(length == 1){
				_this.map.setZoom(16);
			}else if(length < 1){
				_this.panToTarget(new google.maps.LatLng(36.314130, 127.850604));
				_this.map.setZoom(7);
			}
			*/

			if(length == 0 || !data.search) {
				_this.panToTarget(_this.opt.mapOptions.center);
				//_this.panToTarget(new google.maps.LatLng(_this.opt.initGeocode.lat, _this.opt.initGeocode.lng));
				_this.map.setZoom(_this.opt.mapOptions.zoom);
			}else if(length == 1) {
				_this.map.setZoom(16);
			}else{
				if(geo_bound_mode){
					_this.map.fitBounds(latlngbounds);
				}else{
					var geocode = {lat: +response.data[0].geocode.lat, lng: +response.data[0].geocode.lng};
					_this.panToTarget(geocode);
				}
			}
			google.maps.event.trigger(_this.map,'resize');
			if(typeof callback === 'function') callback(response);
		}).error(function(e) {
			alert(e.statusText);
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
			if(typeof this.opt.infoWindow.calculate === 'boolean' && this.opt.infoWindow.calculate === true) {
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
			if(typeof _this.opt.infoWindow.calculate === 'boolean' && _this.opt.infoWindow.calculate === true) {
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
			if(typeof _this.infoWindow === 'object') _this.infoWindow.close();
			if(typeof _this.prevMarker === 'object') _this.prevMarker.setAnimation(null);
			_this.infoWindow = new google.maps.InfoWindow({
				content: response
			});
			_this.infoWindow.open(_this.map, marker);
			_this.map.panTo(new google.maps.LatLng(marker.getPosition().lat(), marker.getPosition().lng()));
			_this.map.panBy(0, -100);
			marker.setAnimation(google.maps.Animation.BOUNCE);
			google.maps.event.addListener(_this.infoWindow, 'closeclick', function() {
				_this.prevMarker.setAnimation(null);
				if(typeof _this.opt.infoWindow.callback === 'function') _this.opt.infoWindow.callback();
			});
			_this.prevMarker = marker;
		}, 'html').error(function(e) {
			alert(e.statusText);
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
	 * 해당 경위도 좌표 값으로 지도의 중심점을 옮깁니다.
	 *
	 * @method panToTarget
	 * @param {Object} geocode 경위도 좌표 값
	 */
	Geomap.prototype.panToTarget = function(geocode) {
		var marker = new google.maps.Marker({
			position: geocode,
			map: this.map,
			visible: false
		});
		this.map.panTo(marker.getPosition());
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
				var geocodeLat, geocodeLng;
				var i = 0;
				for(var prop in geocode) {
					if(i === 0) geocodeLat = geocode[prop]();
					else geocodeLng = geocode[prop]();
					if(i === 1) break;
					i++;
				}
				callback({lat: geocodeLat, lng: geocodeLng});
			} else if(status === google.maps.GeocoderStatus.ZERO_RESULTS) {
				throw new Error('요청하신 주소와 일치하는 값이 없습니다.');
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
 		var latLng1 = new google.maps.LatLng(this.opt.initGeocode.lat, this.opt.initGeocode.lng);
		if(typeof geocode.lat === 'function') {
			var latLng2 = new google.maps.LatLng(geocode.lat(), geocode.lng());
		} else {
			var latLng2 = new google.maps.LatLng(geocode.lat, geocode.lng);
		}
 		return Math.round(parseInt(google.maps.geometry.spherical.computeDistanceBetween(latLng1, latLng2), 10) / 10) / 100;
 	};

	/*
	 * 현재 위치를 중심으로 정해진 거리만큼 원을 표시합니다.
	 *
	 * @method drawCircle
	 * @param {Number} distance m단위의 거리
	 * @param {Object} options 옵션
	 */
	Geomap.prototype.drawCircle = function(distance, options) {
		var options = options || {};
		var def = {fillOpacity: '0.3', fillColor: '#9C0006', strokeOpacity: '0.5', strokeColor: '#0000FF', strokeWeight: 1};
		for(var prop in def) {
			if(typeof options[prop] === 'undefined') options[prop] = def[prop];
		}
		new google.maps.Circle({
			map: this.map,
			center: this.opt.mapOptions.center,
			radius: distance,
			fillOpacity: options.fillOpacity,
			fillColor: options.fillColor,
			strokeOpacity: options.strokeOpacity,
			strokeColor: options.strokeColor,
			strokeWeight: options.strokeWeight
		});
	};

	/*
	 * 모바일 전용 장치 여부를 체크합니다.
	 *
	 * @method checkMobile
	 */
	Geomap.prototype.checkMobile = function() {
	    if(navigator.userAgent.match(/Android|BlackBerry|Blazer|Bolt|Doris|Dorothy|Fennec|GoBrowser|IEMobile|iPhone|iPod|Iris|Maemo|MIB|Minimo|NetFront|Opera Mini|Opera Mobi|SEMC-Browser|Skyfire|SymbianOS|TeaShark|Teleca|uZardWeb/) !== null) {
	        return true;
	    }
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

		var	container = 'placeLoadMap',
			markerImg = CONST_REQUEST_ROOT + '/design/other/marker.png',
			ajaxFilePath = CONST_REQUEST_ROOT + '/board/view3_modal_map_00/resource';
		var infoWindow = {
			requestUrl: ajaxFilePath + '/place_pop.php'
		};
		var mapOptions = {
			zoomControlOptions: {
				position: google.maps.ControlPosition.RIGHT_TOP
			},
			scrollwheel: false
		};
		var	options = {mapOptions: mapOptions, getCurrentPosition: false, icon: markerImg, infoWindow: infoWindow, setMarker: false};

		/*
		 * Geomapping class 초기화 함수
		 *
		 * @method initialize
		 */
		this.initialize = function() {
			// Geomap을 초기화합니다.
			gmap.initialize(container, options, function() {
				gmap.setPlaceMarkers(ajaxFilePath + '/place_find.php', {board: 'map_01', sca : 'all'});
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
			'인천' : ['계양구','남구','남동구','동구','부평구','서구','연수구','중구','강화군','옹진군'],
			'광주' : ['광산구','남구','동구','북구','서구'],
			'대전' : ['대덕구','동구','서구','유성구','중구'],
			'울산' : ['남구','동구','북구','중구','울주군'],
			'강원' : ['강릉시','동해시','삼척시','속초시','원주시','춘천시','태백시','고성군','양구군','양양군','영월군','인제군','정선군','철원군','평창군','홍천군','화천군','횡성군'],
			'경기' : ['고양시 덕양구','고양시 일산동구','고양시 일산서구','과천시','광명시','광주시','구리시','군포시','김포시','남양주시','동두천시','부천시 소사구','부천시 오정구','부천시 원미구','성남시 분당구','성남시 수정구','성남시 중원구','수원시 권선구','수원시 영통구','수원시 장안구','수원시 팔달구','시흥시','안산시 단원구','안산시 상록구','안성시','안양시 동안구','안양시 만안구','양주시','오산시','용인시 기흥구','용인시 수지구','용인시 처인구','의왕시','의정부시','이천시','파주시','평택시','포천시','하남시','화성시','가평군','양평군','여주군','연천군'],
			'경남' : ['거제시','김해시','마산시','밀양시','사천시','양산시','진주시','진해시','창원시','통영시','거창군','고성군','남해군','산청군','의령군','창녕군','하동군','함안군','함양군','합천군'],
			'경북' : ['경산시','경주시','구미시','김천시','문경시','상주시','안동시','영주시','영천시','포항시 남구','포항시 북구','고령군','군위군','봉화군','성주군','영덕군','영양군','예천군','울릉군','울진군','의성군','청도군','청송군','칠곡군'],
			'전남' : ['광양시','나주시','목포시','순천시','여수시','강진군','고흥군','곡성군','구례군','담양군','무안군','보성군','신안군','영광군','영암군','완도군','장성군','장흥군','진도군','함평군','해남군','화순군'],
			'전북' : ['군산시','김제시','남원시','익산시','전주시 덕진구','전주시 완산구','정읍시','고창군','무주군','부안군','순창군','완주군','임실군','장수군','진안군'],
			'제주' : ['제주시','서귀포시'],
			'충남' : ['계룡시','공주시','논산시','보령시','서산시','아산시','천안시 동남구','천안시 서북구','금산군','당진군','부여군','서천군','연기군','예산군','청양군','태안군','홍성군'],
			'충북' : ['제천시','청주시 상당구','청주시 흥덕구','충주시','괴산군','단양군','보은군','영동군','옥천군','음성군','증평군','진천군','청원군'],
			'세종' : []
		};
		var updateDisable = false;
		var findWrap = $('#placeFindWrap'),
			local1Wrap = $('#local1ListWrap'),
			local2Wrap = $('#local2ListWrap'),
			local1Btn = $('#local1Button'),
			local2Btn = $('#local2Button'),
			findInput = $('#placeName'),
			findForm = $('.placefindbyname'),
			local1 = $('#local1'),
			local2 = $('#local2'),
			local1BtnDef = local1Btn.text(),
			local2BtnDef = local2Btn.text(),
			local1Val = null,
			local2Val = null;

		var ajaxFilePath = CONST_REQUEST_ROOT + '/board/view3_modal_map_00/resource',
			requestUrl = ajaxFilePath + '/place_find.php';

		var contentsWrap = '.store-contents',
			listUrl = CONST_ROOT + '/index.html';

		/*
		 * GeomapFind class 초기화 함수
		 *
		 * @method initialize
		 */
		this.initialize = function() {
			local1Btn.click(this.local1Spread);
			local2Btn.click(this.local2Spread);
			findWrap.on('click', '#local1 > li > a', this.local1Action);
			findWrap.on('click', '#local2 > li > a', this.local2Action);
			findWrap.on('click', '#btnFindSubmit', this.findAction);
			findWrap.on('submit',findForm, this.findAction)
			$('#placeFindWrap .cols.select').mouseleave(this.selectBoxInit);
			new Labeling($('#placeName'));
			if(typeof param_select !== 'undefined' && param_select.trim() == 'addr_road||addr_number'){
				if(typeof param_search !== 'undefined' && param_search.trim() != ''){
					var searchSplit = param_search.split(' ');
					updateDisable = true;
					$('#local1 > li > a[data-value="'+searchSplit.shift()+'"]').trigger('click');
					$('#local2 > li > a[data-value="'+searchSplit.join(' ')+'"]').trigger('click');
					updateDisable = false;
				}
			}else if(typeof param_search !== 'undefined' && param_search.trim() != ''){
				findInput.val(param_search.trim());
				$('[for="placeName"]', findInput.parent()).trigger('click');
				findInput.trigger('blur');
			}
		};

		/*
		 * 첫 번째 select box를 활성화합니다.
		 *
		 * @method local1Spread
		 */
		this.local1Spread = function() {
			if(local1Wrap.is(':hidden') === true) {
				local1Wrap.stop().slideDown(300, function() {
					$(this).mCustomScrollbar({
						autoDraggerLength: false,
						scrollInertia: 80
					});
				});
				if(local2Btn.text() !== local2BtnDef) local2Btn.text(local2BtnDef);
				local2Val = null;
			}
		};

		/*
		 * 두 번째 select box를 활성화합니다.
		 *
		 * @method local2Spread
		 */
		this.local2Spread = function() {
			if(local1Val !== null && local2Wrap.is(':hidden') === true) {
				local2Wrap.stop().slideDown(300, function() {
					$(this).mCustomScrollbar({
						autoDraggerLength: false,
						scrollInertia: 80
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
			window.geo_bound_mode = true;
			_this.selectBoxInit();
			findInput.val('');
			findInput.trigger('blur');
			var self = $(this);
			var localText = self.text();
			local1Btn.text(localText);
			local1Val = self.attr('data-value');
			var depth2 = district[local1Val];
			local2.empty();
			local2.append('<li><a href="#none" data-value="'+local1Val+'">전체</a></li>');
			if(typeof depth2 === 'object') {
				for(var i=0; i<depth2.length; i++) {
					local2.append('<li><a href="#none" data-value="'+depth2[i]+'">'+depth2[i]+'</a></li>');
				}
				if(local2Val === null) var addr = local1Val;
				else var addr = local1Val+' '+local2Val;
				var query = {board: 'map_01', select: 'addr_road||addr_number', search: addr};
			} else {
				var query = {board: 'map_01', search: ''};
			}
			if(updateDisable == false){
				gmap.setPlaceMarkers(requestUrl, query);
				_this.updateList(query);
			}
			e.preventDefault();
		};

		/*
		 * 두 번째 select box의 값을 고르면 해당 위치를 검색합니다.
		 *
		 * @method local2Action
		 * @param {Object} e event 객체
		 */
		this.local2Action = function(e) {
			window.geo_bound_mode = true;
			_this.selectBoxInit();
			findInput.val('');
			findInput.trigger('blur');
			var self = $(this);
			var localText = self.text();
			local2Btn.text(localText);
			local2Val = self.attr('data-value');
			if(typeof local1Val === 'string') {
				if(local2Val === local1Val) var addr = local2Val;
				else var addr = local1Val+' '+local2Val;
				var query = {board: 'map_01', select: 'addr_road||addr_number', search: addr};
				if(updateDisable == false){
					gmap.setPlaceMarkers(requestUrl, query);
					_this.updateList(query);
				}
			}
			e.preventDefault();
		};

		/*
		 * select box를 비활성화합니다.
		 *
		 * @method selectBoxInit
		 */
		this.selectBoxInit = function() {
			if(local1Wrap.is(':visible')) {
				local1Wrap.hide(0, function() {
					$(this).mCustomScrollbar('destroy');
				});
			}
			if(local2Wrap.is(':visible')) {
				local2Wrap.hide(0, function() {
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
			window.geo_bound_mode = true;
			var value = findInput.val();
			local1Btn.text('광역시/도');
			local2Btn.text('시/군/구');
			local2.empty();
			if(updateDisable == false){
				var query = {board: 'map_01', select: 'addr_road||addr_number||title_01', search: value};
				gmap.setPlaceMarkers(requestUrl, query);
				_this.updateList(query);

			}
			e.preventDefault();
		};

		/*
		 * 검색 결과에 따라 하단 리스트를 업데이트 합니다.
		 *
		 * @method updateList
		 * @param {Object} query
		 */
		this.updateList = function(query) {
			$.get(listUrl, query, function(response) {
				$(contentsWrap).html($(response).find(contentsWrap).html());
			}, 'html').error(function(e) {
				alert(e.statusText);
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