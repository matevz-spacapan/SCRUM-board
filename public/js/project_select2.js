// JavaScript Document
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

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
