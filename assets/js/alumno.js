'use strict';
var Alumno = function(){
	function isInWindow(){
		$(window).focus(function() {
			console.log("Hola");
		});

		$(window).blur(function() {
	   		console.log("CHAO");
		});
	};

	return {
		isInWindow : function(){
						isInWindow();
					}
	};
}();