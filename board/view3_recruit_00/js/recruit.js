(function($) {
    $(document).ready(function() {
        function validateCheck() {
            for(var i=0; i<f.length; i++) {
                if($(f[i]).closest(_steps).data('step') > step) continue;
    			if(f[i].required) {
                    var valid = true;
    				if(f[i].type === 'text' || f[i].type === 'password' || f[i].type === 'select-one' || f[i].type === 'textarea') {
    					if($.trim(f[i].value) === '') valid = false;
    				} else if(f[i].type === 'checkbox') {
    					if(f[i].checked === false) valid = false;
    				} else if(f[i].type === 'radio') {
    					if(f[i].form[f[i].name].value === '') valid = false;
    				}
    				if(valid === false) {
    					f[i].focus();
    					alert('필수입력항목을 빠짐 없이 입력해주세요.');
    					return false;
    				}
    			}
    			if(f[i].name === 'name_kr' && f[i].value.match(/^[ㄱ-ㅎㅏ-ㅣ가-힣]{2,}$/) === null) {
    				f[i].value = '';
    				f[i].focus();
    				alert('정확한 한글이름을 입력해주세요.');
    				return false;
    			}
    			if(f[i].name === 'tel' && f[i].value.match(/^(01[016789]{1}|02|0[3-9]{1}[0-9]{1})-?[0-9]{3,4}-?[0-9]{4}$/) === null) {
    				f[i].value = '';
    				f[i].focus();
    				alert('정확한 연락처를 입력해주세요.');
    				return false;
    			}
    		}
            return true;
        }

        function setProxyData() {
            $(_proxyFieldContainer).each(function() {
                if($(this).data('type') === 'json') {
                    var value = {};
                    if($(this).find(_changeableFieldLists).length > 0) {
                        $(this).find(_changeableFieldList).each(function(i) {
                            value[i] = getFieldData($(this));
                            if(checkEmpty(value[i]) === false) delete value[i];
                        });
                    } else {
                        value = getFieldData($(this));
                    }
                    var v = checkEmpty(value) === true ? JSON.stringify(value) : '';
                } else if($(this).data('type') === 'multiple-text') {
                    var value = [];
                    $(this).find(_field).each(function(i) {
                        if($.trim($(this).val()) !== '') value.push($(this).val());
                    });
                    var v = value.join($(this).data('delimiter'));
                }
                f[$(this).data('field')].value = v;
            });
        }

        function getFieldData($t) {
            var data = {};
            $t.find(_field).each(function(i) {
                var $key = $(this).data('key');
                var $val = $(this).val();
                if($.trim($key) === '' || $.trim($val) === '') return true;
                data[$key] = $val;
            });
            return data;
        }

        function checkEmpty(o) {
            for(var p in o) return true;
            return false;
        }

        function navigation() {
            f.step.value = step;
            var data = typeof FormData === 'function' ? new FormData(f) : $(f).serialize();
            $.ajax({
                url: CONST_ROOT + '/board/view3_recruit_00/set_session.php',
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                }
            })
            $(_steps).filter(':visible').hide(0);
            $(_steps).eq(step).show(0, function() {
                $('html, body').scrollTop(0);
            });
            if(step > 0) {
                if($(_tabs_wrap).is(':hidden')) $(_tabs_wrap).show(0);
                $(_tabs).filter('.on').removeClass('on');
                $(_tabs).eq(step - 1).addClass('on');
            }
        }

        function getByteLength(s,callback,b,i,c,n) {
            for(b=0,i=0,n='';c=s.charCodeAt(i++);b+=c>>11?1:c>>7?1:1) {
                if(b < 1000) n += s[i];
                else callback(n);
            }
            return b;
        }

        var $container = $('#applyApplication');
        var f = document['apply-form'];
        var _steps = '.apply-steps';
        var _tabs_wrap = '.steps_guide';
        var _tabs = '.steps_guide li';
        var _goNext = '.apply_next';
        var _goPrev = '.apply_prev';
        var _goTo = '.apply_goto';
        var step = 0;

        var _proxyFieldContainer = '.proxy-field-container';
        var _field = '.proxy-field';
        var _changeableFieldContainer = '.changeable-field-container';
        var _changeableFieldLists = '.changeable-field-lists';
        var _changeableFieldList = '.changeable-field-list';
        var _addButton = '.field-add';

        $container.on('submit', function(e) {
            e.preventDefault();
            setProxyData();
            if(validateCheck() === true) {
                f.submit();
            }
        });

        $container.on('click', _goNext, function(e) {
            e.preventDefault();
            if(step === 0) {
                if($('#agreed01').is(':checked') === false) {
                    $('#agreed01').focus();
                    alert('개인정보 수집 및 이용에 관한 동의 후 지원서 작성이 가능합니다.');
                    e.preventDefault();
                    return false;
                } else if($('#agreed02').is(':checked') === false) {
                    $('#agreed02').focus();
                    alert('민감정보 수집 및 이용에 관한 동의 후 지원서 작성이 가능합니다.');
                    e.preventDefault();
                    return false;
                }
            }
            step = +f.step.value;
            setProxyData();
            if(validateCheck() === true) {
                step = $(this).data('step');
                navigation();
            }
        });

        $container.on('click', _goPrev, function(e) {
            e.preventDefault();
            step = $(this).data('step');
            navigation();
        });

        $container.on('click', _goTo, function(e) {
            e.preventDefault();
            setProxyData();
            if(validateCheck() === true) {
                step = $(this).data('step');
                navigation();
            }
        });

        // 달력
        var _datepicker = '.datepicker-field',
            _button = '.btn-datepicker';

        var dateFormat = 'yy-mm-dd';
        var datepickerOption = {
            dateFormat: dateFormat,
            changeMonth: true,
            changeYear: true,
            currentText: '이번달',
            prevText: '이전 달',
            nextText: '다음 달',
            closeText: '닫기',
            monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            dayNamesShort: ['일','월','화','수','목','금','토'],
            dayNamesMin: ['일','월','화','수','목','금','토'],
            dayNames: ['일','월','화','수','목','금','토'],
            showMonthAfterYear: true,
            showButtonPanel: true,
        };

        $(_datepicker).each(function() {
            $(this).datepicker(datepickerOption);
            if($(this).data('def')) $(this).datepicker('option', 'defaultDate', $(this).data('def') + 'y');
        });

        //지우기 기능
        var picker_update = $.datepicker._updateDatepicker;
        $.datepicker._updateDatepicker = function(inst){
            picker_update.call(this, inst);
            var buttonPane = $(this).datepicker('widget').find('.ui-datepicker-buttonpane');
            $('<button type="button" class="ui-datepicker-clean ui-state-default ui-priority-primary ui-corner-all">지우기</button>').appendTo(buttonPane).click(function(ev) {
                $.datepicker._clearDate(inst.input);
            });
        }

        $container.on('click', _button, function() {
            $(this).siblings(_datepicker).focus();
        });

        // 정책 동의
        $container.on('click', '#agreeAll', function(e) {
            $('#agreed01').click();
            $('#agreed02').click();
        });

        // 이미지 미리보기
        $container.on('change', '#file00', function(e) {
            if(this.files && this.files[0]) {
                var reader = new FileReader();
                $(reader).on('load', function(e) {
                    $('#imgPreview').css("background-image", "url('"+e.target.result+"')");
                    f.figure.value = e.target.result;
                });
                reader.readAsDataURL(this.files[0]);
            }
        });

        // 주소찾기
        $container.on('click', '.addr_search', function(e) {
            new daum.Postcode({
                oncomplete: function(data) {
                    if(data.roadAddress) document.getElementById('addr_01').value = data.roadAddress;
                    if(data.zonecode) document.getElementById('zipcode').value = data.zonecode;
                    document.getElementById('addr_02').focus();
                }
            }).open();
        });

        // 항목 추가
        $container.on('click', _addButton, function(e) {
            e.preventDefault();
            var $parent = $(this).closest(_changeableFieldContainer);
            $parent.find(_datepicker).removeAttr('id').datepicker('destroy');
            var $clone = $parent.find(_changeableFieldList).last().clone();
            $clone.find('input, select, textarea').val('');
            $clone.appendTo($parent.find(_changeableFieldLists));
            $parent.find(_changeableFieldLists).find(_datepicker).each(function() {
                $(this).datepicker(datepickerOption);
                if($(this).data('def')) $(this).datepicker('option', 'defaultDate', $(this).data('def') + 'y');
            });
        });

        // 텍스트 길이 체크
        $container.on('keyup focusout', '.intro_textarea', function(e) {
            var $this = $(this);
            var bytes = getByteLength($this.val(), function(s) {
                $this.val(s);
            });
            $this.parent().find('.text-length-notice').text(bytes);
        });
    });
}(jQuery));