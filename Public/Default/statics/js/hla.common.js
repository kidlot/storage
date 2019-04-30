/**
 * @author FHT
 */

//省市县联动
function change_region(type) {
    //0为省联动，1为市联动
    if (0 === type) {
        var data = {
            type: 'province',
            id: $('#province').val()
        };
    } else if (1 === type) {
        var data = {
            type: 'city',
            id: $('#city').val()
        };
    }

    $.ajax({
        type: 'POST',
        url: '/Backstage/Region/getRegion',
        data: data,
        success: function (res) {
            if (res.status < 0) {
                alert(res.message);
                return;
            }
            if (0 === type) {
                $("#city").empty();
                $('#city').append("<option value=''>请选择</option>");
                for (var key in res.content) {
                    $('#city').append("<option value='" + res.content[key].id + "'>" + res.content[key].name + "</option>");
                }
                $("#country").empty();
                $('#country').append("<option value=''>请选择</option>");
            } else if (1 === type) {
                $("#country").empty();
                $('#country').append("<option value=''>请选择</option>");
                for (var key in res.content) {
                    $('#country').append("<option value='" + res.content[key].id + "'>" + res.content[key].name + "</option>");
                }
            }

        },
        dataType: 'json'
    });
}
window.updateAlert = function (text,c) {
	text = text||'default';
	c = c||false;
	if ( text!='default' ) {
		top_alert.find('.alert-content').text(text);
		if (top_alert.hasClass('block')) {
		} else {
			top_alert.addClass('block').slideDown(200);
			// content.animate({paddingTop:'+=55'},200);
		}
	} else {
		if (top_alert.hasClass('block')) {
			top_alert.removeClass('block').slideUp(200);
			// content.animate({paddingTop:'-=55'},200);
		}
	}
	if ( c!=false ) {
		top_alert.removeClass('alert-error alert-warn alert-info alert-success').addClass(c);
	}
	setTimeout(function(){
		if($('#top-alert').is(":visible")){
			$('#top-alert').find('.close').click();
		}
	},2000)
	
};
