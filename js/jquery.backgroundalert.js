/*!!
 * Title Alert 0.7
 * 
 * Copyright (c) 2009 ESN | http://esn.me
 * Jonatan Heyman | http://heyman.info
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 */
 
/* 
 * @name jQuery.titleAlert
 * @projectDescription Show alert message in the browser title bar
 * @author Jonatan Heyman | http://heyman.info
 * @version 0.7.0
 * @license MIT License
 * 
 * @id jQuery.titleAlert
 * @param {String} text The text that should be flashed in the browser title
 * @param {Object} settings Optional set of settings.
 *	 @option {Number} interval The flashing interval in milliseconds (default: 500).
 *	 @option {Number} originalTitleInterval Time in milliseconds that the original title is diplayed for. If null the time is the same as interval (default: null).
 *	 @option {Number} duration The total lenght of the flashing before it is automatically stopped. Zero means infinite (default: 0).
 *	 @option {Boolean} stopOnFocus If true, the flashing will stop when the window gets focus (default: true).
 *   @option {Boolean} stopOnMouseMove If true, the flashing will stop when the browser window recieves a mousemove event. (default:false).
 *	 @option {Boolean} requireBlur Experimental. If true, the call will be ignored unless the window is out of focus (default: false).
 *                                 Known issues: Firefox doesn't recognize tab switching as blur, and there are some minor IE problems as well.
 *
 * @example $.backgroundAlert("Hello World!", {requireBlur:true, stopOnFocus:true, duration:10000, interval:500});
 * @desc Flash title bar with text "Hello World!", if the window doesn't have focus, for 10 seconds or until window gets focused, with an interval of 500ms
 */
(function($){	
	$.backgroundAlert = function(obj,color, settings) {
		// check if it currently flashing something, if so reset it
		if ($.backgroundAlert._running)
			$.backgroundAlert.stop();
		
                $.backgroundAlert._obj = obj;
		// override default settings with specified settings
		$.backgroundAlert._settings = settings = $.extend( {}, $.backgroundAlert.defaults, settings);
		
		// originalTitleInterval defaults to interval if not set
		settings.originalTitleInterval = settings.originalTitleInterval || settings.interval;
		
		$.backgroundAlert._running = true;
                
//		$.backgroundAlert._initialColor = $.backgroundAlert._obj.css('background-color');
//		$.backgroundAlert._obj.css('background-color',color);

                $.backgroundAlert._obj.addClass('error_msg');
                $.backgroundAlert._obj.removeClass('ui-widget-content');

		var showingAlertTitle = true;
		var switchTitle = function() {
			// WTF! Sometimes Internet Explorer 6 calls the interval function an extra time!
			if (!$.backgroundAlert._running)
				return;
			
		    showingAlertTitle = !showingAlertTitle;
//		    $.backgroundAlert._obj.css('background-color',(showingAlertTitle ? color : $.backgroundAlert._initialColor));

                    if (showingAlertTitle == true){
                        $.backgroundAlert._obj.addClass('error_msg');
                        $.backgroundAlert._obj.removeClass('ui-widget-content');
                    }
                    else{
                        $.backgroundAlert._obj.removeClass('error_msg');
                        $.backgroundAlert._obj.addClass('ui-widget-content');
                    }

		    $.backgroundAlert._intervalToken = setTimeout(switchTitle, (showingAlertTitle ? settings.interval : settings.originalTitleInterval));
		}
		$.backgroundAlert._intervalToken = setTimeout(switchTitle, settings.interval);
		
		// check if a duration is specified
		if (settings.duration > 0) {
			$.backgroundAlert._timeoutToken = setTimeout(function() {
				$.backgroundAlert.stop();
			}, settings.duration);
		}
	};
	
	// default settings
	$.backgroundAlert.defaults = {
		interval: 300,
		originalTitleInterval: null,
		duration:2000
	};
	
	// stop current title flash
	$.backgroundAlert.stop = function() {
		clearTimeout($.backgroundAlert._intervalToken);
		clearTimeout($.backgroundAlert._timeoutToken);
//                $.backgroundAlert._obj.css('background-color',$.backgroundAlert._initialColor);
                $.backgroundAlert._obj.removeClass('error_msg');
                $.backgroundAlert._obj.addClass('ui-widget-content');
		
		$.backgroundAlert._timeoutToken = null;
		$.backgroundAlert._intervalToken = null;
		$.backgroundAlert._initialColor = null;
		$.backgroundAlert._running = false;
		$.backgroundAlert._settings = null;
                $.backgroundAlert._obj = null;
	}
	
	$.backgroundAlert._running = false;
        $.backgroundAlert._obj = null;
	$.backgroundAlert._intervalToken = null;
	$.backgroundAlert._timeoutToken = null;
	$.backgroundAlert._initialColor = null;
	$.backgroundAlert._settings = null;

})(jQuery);
