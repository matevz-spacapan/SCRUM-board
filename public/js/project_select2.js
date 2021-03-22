// JavaScript Document
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

var p_insert_html= `<div id="pud_{i}" class="pud col-xs-12 col-sm-12 col-md-12">
	<div class="form-group">
	    <label>Developer:</label>
	    <input type="text" id="input_pud_{i}" class="form_control" name="name_pud[]" disabled value="">
	</div>
	<button id="remove_user_btn_{i}" class="remove_user_btn btn btn-secondary" onClick="remove_user_fun(this.id)" type="button">Remove  developer</button>
	<hr class="w-100">
</div>`

String.prototype.format = function() {
  	a = this;
	a = a.replace("{i}", arguments[0])
  	return a
}

var p_dev_counter= 0
		
$(document).ready(function(){
	$('#s2n1').select2({
		ajax: {
			url: '/ajax-get-users',
			type: "post",
			dataType: 'json',
			delay: 250,
			data: function (params) {
				return {
				_token: CSRF_TOKEN,
				search: params.term // search term
				};
			},
			processResults: function (response) {
				return {
					results: response
			};
		},
		  cache: true
		}
	});
	
	$('#s2n2').select2({
		ajax: {
			url: '/ajax-get-users',
			type: "post",
			dataType: 'json',
			delay: 250,
			data: function (params) {
				return {
				_token: CSRF_TOKEN,
				search: params.term // search term
				};
			},
			processResults: function (response) {
				return {
					results: response
			};
		},
		  cache: true
		}
	});
	
	$('#s2n3').select2({
		ajax: {
			url: '/ajax-get-users',
			type: "post",
			dataType: 'json',
			delay: 250,
			data: function (params) {
				return {
				_token: CSRF_TOKEN,
				search: params.term // search term
				};
			},
			processResults: function (response) {
				return {
					results: response
			};
		},
		  cache: true
		}
	});
});

$('#add_user_btn').click(function() {
	if($('#s2n3').val() != "0") {
		$( "#p_dev_div" ).append( p_insert_html.replaceAll( "{i}", ++p_dev_counter) );
    	$('#input_pud_' + p_dev_counter).val( $('#s2n3').val());
	}
});

function remove_user_fun(clicked_id) {
	//console.log("#pud_{i}".replaceAll( "{i}", clicked_id.match(/\d+/)[0]));
	$( "#pud_{i}".replaceAll( "{i}", clicked_id.match(/\d+/)[0]) ).remove();
}
