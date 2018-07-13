/* global jQuery */
/*
  FileDrop jQuery Plugin
  by Chris Barr
  https://github.com/chrismbarr/FileDrop/
*/


(function ($) {
	'use strict';
	
	var exitTimer = null;
	
	function normalizeOptions(options) {
		if ($.isFunction(options)) {
			options = {
				onFileRead: options
			};
		}
	
		var opts = $.extend({}, $.fn.fileDrop.defaults, options);
		
		opts.decodeBase64
		&& (opts.removeDataUriScheme = true);
		
		opts.addClassTo = $(opts.addClassTo);
		
		if (!$.isFunction(opts.onFileRead)) {
			throw ('The option "onFileRead" is not set to a function!');
		}
		
		return opts;
	}

	function setEvents(el, opts) {
		el.addEventListener('dragenter', function (ev) {
			$(opts.addClassTo).addClass(opts.overClass);
			oFiles.stopEvent(ev);
		}, false);
		
		el.addEventListener('dragover', function (ev) {
			clearTimeout(exitTimer);
			exitTimer = setTimeout(function () {
				$(opts.addClassTo).removeClass(opts.overClass);
			}, 100);
			oFiles.stopEvent(ev);
		}, false);
		
		el.addEventListener('drop', function (ev) {
			oFiles.drop(ev, opts);
		}, false);
	}

	$.removeUriScheme = function (str) {
		return str.replace(/^data:.*;base64,/, '');
	};

	$.support.fileDrop = (function () {
		return !!window.FileList;
	})();
	
	$.fn.fileDrop = function (options) {
		var opts = normalizeOptions(options);

		return this.each(function () {
			var perElementOptions = opts;

			perElementOptions.addClassTo.length === 0
			&& (perElementOptions.addClassTo = $(this));

			setEvents(this, perElementOptions);
		});
	};

	$.fn.fileDrop.defaults = {
		overClass: 'state-over',
		addClassTo: null,
		onFileRead: null,
		removeDataUriScheme: true,
		decodeBase64: false
	};
})(jQuery);