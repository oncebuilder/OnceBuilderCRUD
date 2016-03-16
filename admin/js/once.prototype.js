$.fn.scrollTo = function( target, options, callback ){
  if(typeof options == 'function' && arguments.length == 2){ callback = options; options = target; }
  var settings = $.extend({
    scrollTarget  : target,
    offsetTop     : 50,
    duration      : 500,
    easing        : 'swing'
  }, options);
  return this.each(function(){
    var scrollPane = $(this);
    var scrollTarget = (typeof settings.scrollTarget == "number") ? settings.scrollTarget : $(settings.scrollTarget);
    var scrollY = (typeof scrollTarget == "number") ? scrollTarget : scrollTarget.offset().top + scrollPane.scrollTop() - parseInt(settings.offsetTop);
    scrollPane.animate({scrollTop : scrollY }, parseInt(settings.duration), settings.easing, function(){
      if (typeof callback == 'function') { callback.call(this); }
    });
  });
}

function getURL(url, c) {
    var xhr = new XMLHttpRequest();
    xhr.open("get", url, true);
    xhr.send();
    xhr.onreadystatechange = function() {
      if (xhr.readyState != 4) return;
      if (xhr.status < 400) return c(null, xhr.responseText);
      var e = new Error(xhr.responseText || "No response");
      e.status = xhr.status;
      c(e);
    };
  }


function rawurlencode (str) {
    str = (str+'').toString();        
    return encodeURIComponent(str).replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28').
                                                                                    replace(/\)/g, '%29').replace(/\*/g, '%2A');
}
function rawurldecode (str) {
    // From: http://phpjs.org/functions
    // +   original by: Brett Zamir (http://brett-zamir.me)
    // +      input by: travc
    // +      input by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +      input by: Ratheous
    // +   reimplemented by: Brett Zamir (http://brett-zamir.me)
    // +      input by: lovio
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // %        note 1: Please be aware that this function expects to decode from UTF-8 encoded strings, as found on
    // %        note 1: pages served as UTF-8
    // *     example 1: rawurldecode('Kevin+van+Zonneveld%21');
    // *     returns 1: 'Kevin+van+Zonneveld!'
    // *     example 2: rawurldecode('http%3A%2F%2Fkevin.vanzonneveld.net%2F');
    // *     returns 2: 'http://kevin.vanzonneveld.net/'
    // *     example 3: rawurldecode('http%3A%2F%2Fwww.google.nl%2Fsearch%3Fq%3Dphp.js%26ie%3Dutf-8%26oe%3Dutf-8%26aq%3Dt%26rls%3Dcom.ubuntu%3Aen-US%3Aunofficial%26client%3Dfirefox-a');
    // *     returns 3: 'http://www.google.nl/search?q=php.js&ie=utf-8&oe=utf-8&aq=t&rls=com.ubuntu:en-US:unofficial&client=firefox-a'
    // *     example 4: rawurldecode('-22%97bc%2Fbc');
    // *     returns 4: '-22—bc/bc'
    // *     example 4: urldecode('%E5%A5%BD%3_4');
    // *     returns 4: '\u597d%3_4'
    return decodeURIComponent((str + '').replace(/%(?![\da-f]{2})/gi, function () {
        // PHP tolerates poorly formed escape sequences
        return '%25';
    }));
}

Array.max = function( array ){
    return Math.max.apply( Math, array );
};
Array.min = function( array ){
    return Math.min.apply( Math, array );
};

function removeKey(arrayName,key){
	var x;
	var tmpArray = new Array();
	for(x in arrayName){
		if(x!=key && typeof(arrayName[x])!=='function') {tmpArray.push(arrayName[x]);}
	}
	return tmpArray;
}

function a(v){
	if((typeof v == "object") && (v !== null)){
		var output = '';
		for (property in v) {
		  output += property + ': ' + v[property]+'; ';
		}
		alert(output);
	}else{
		alert(v);
	}
}

function ab(a,b){
	alert(a+"<>"+b);
}

function reload_js(src) {
    $('script[src="' + src + '"]').remove();
    $('<script>').attr('src', src).appendTo('head');
}

function microtime (get_as_float) {
  // http://kevin.vanzonneveld.net
  // +   original by: Paulo Freitas
  // *     example 1: timeStamp = microtime(true);
  // *     results 1: timeStamp > 1000000000 && timeStamp < 2000000000
  var now = new Date().getTime() / 1000;
  var s = parseInt(now, 10);

  return (get_as_float) ? now : (Math.round((now - s) * 1000) / 1000) + ' ' + s;
}

(function($) {
	$.fn.extend({
		mktips: function() {//mk-tooltip function -> $(obj).mktips();
			var setPosition=function(e){
				var tooltipX=e.pageX-8;
				var tooltipY=e.pageY+8;
				if($(window).width()-tooltipX<600)
				var tooltipX=tooltipX-(600-($(window).width()-tooltipX))-30;
				$('div.mktips').css({top: tooltipY, left: tooltipX});
			};
			var showTip=function(e) {
				$('div.mktips').remove();
				$('<div class="mktips">'+$(this).attr("title")+'</div>').appendTo('body');
				setPosition(e);
			};
			var hideTip=function() {
				$('div.mktips').remove();
			};
			//return function
            return this.each(function() {
				//the object 
                var obj = $(this);
				
				//handle click event
                obj.bind({
					mousemove : setPosition,
					mouseenter : showTip,
					mouseleave: hideTip
				});

			});
		},
		once: function() {//mk-data luncher -> $(obj).once();
			function executeFunctionByName(functionName, context, obj) {
				//var args = Array.prototype.slice.call(arguments).splice(2);
				var namespaces = functionName.split(".");
				var func = namespaces.pop();
				for(var i = 0; i < namespaces.length; i++) {
				context = context[namespaces[i]];
				}
				return context[func].apply(this, [obj]);
			}
			
			//return function
            return this.each(function(e) {
				//the object 
                var obj = $(this);
				var clickFunction=obj.data('click-action');
				var mouseFunction=obj.data('mouse-action');
				var readyFunction=obj.data('ready-action');
				var keyupFunction=obj.data('keyup-action');

				var staticFunction=obj.data('click-static');
				if(staticFunction && staticFunction!=undefined){
					//handle click
					obj.click(function(e) {//all files
						e.stopPropagation();
						var staticFunctions=staticFunction.split(" ");
						for(i=0;i<staticFunctions.length;i++){	
							executeFunctionByName(staticFunctions[i], window, obj);
						}
					});
				}
				
				if(clickFunction && clickFunction!=undefined){
					//handle click event window["mk"]["test"]
					obj.click(function(e) {//all files
						e.stopPropagation();
						executeFunctionByName(clickFunction, window, obj);
					});
				}
				
				if(mouseFunction && mouseFunction!=undefined){
					//handle click event window["mk"]["test"]
					obj.mouseenter(function() {//all files
						executeFunctionByName(mouseFunction, window, obj);
					});
				}
				
				if(readyFunction && readyFunction!=undefined){
					//handle click event window["mk"]["test"]
					obj.ready(function() {//all files
						executeFunctionByName(readyFunction, window, obj);
					});
				}
				
				if(keyupFunction && keyupFunction!=undefined){
					//handle click event window["mk"]["test"]
					obj.keyup(function() {//all files
						executeFunctionByName(keyupFunction, window, obj);
					});
				}
			});
		},
		update: function() {//mk-update $(obj).once();
			var makeForm=function(event){
				var str='';
				str+='<form method="post" id="test" style="padding: 0px; margin: 0px;">'
				str+='<input style="width: 50px; height: 10px;" type="text" name="value" value="0" />'
				str+='<input type="hidden" name="this_id" value="" />'
				str+='<input type="hidden" name="world_id" value="" />'
				str+='<input type="hidden" name="sub_data" value="ok" />'
				str+='<input style="width: 20px; height: 10px;" type="submit" onclick="sendAjax()" value="Ok" /></form>';
				$(this).html(str);
			};

			var sendAjax=function(event){
				$.get("/once/once.php?data", function(data) {
				
				});
			};
			
			//return function
            return this.each(function() {
				//the object 
				obj = $(this);
				
				//handle click event
                obj.bind({
					dblclick : makeForm
				});
			});
		},
	});
})(jQuery);

function args(string){
	var result=string.split("|cmd|");
	return result;
}

function getURLParam(){
	var strReturn = "";
	var strHref = window.location.pathname;//
	var strQueryString = strHref.substr(1).toLowerCase();
	if(strQueryString.lastIndexOf('/')>0){
		strQueryString = strQueryString.substr(0,strQueryString.lastIndexOf('/'));
	}
	return strQueryString;
}

// reverse strings
if (!String.prototype.reverse){
	String.prototype.reverse = function () {
		return this.split("").reverse().join("");
	}
};
if (!String.prototype.trim){
	String.prototype.trim = function() {
		return this.replace(/^\s+|\s+$/g, "");
	};
};

if (!String.prototype.replaceAll){
	String.prototype.replaceAll = function (patern,replace) {
		var string=this;
		if(string==undefined)
		return string;
		while(string.indexOf(patern)>=0){
			string=string.replace(patern,replace); 
		}
		return string;
	}
};


function strtok (str, tokens) {
  // http://kevin.vanzonneveld.net
  // +   original by: Brett Zamir (http://brett-zamir.me)
  // %        note 1: Use tab and newline as tokenizing characters as well
  // *     example 1: $string = "\t\t\t\nThis is\tan example\nstring\n";
  // *     example 1: $tok = strtok($string, " \n\t");
  // *     example 1: $b = '';
  // *     example 1: while ($tok !== false) {$b += "Word="+$tok+"\n"; $tok = strtok(" \n\t");}
  // *     example 1: $b
  // *     returns 1: "Word=This\nWord=is\nWord=an\nWord=example\nWord=string\n"
  // BEGIN REDUNDANT
  this.php_js = this.php_js || {};
  // END REDUNDANT
  if (tokens === undefined) {
    tokens = str;
    str = this.php_js.strtokleftOver;
  }
  if (str.length === 0) {
    return false;
  }
  if (tokens.indexOf(str.charAt(0)) !== -1) {
    return this.strtok(str.substr(1), tokens);
  }
  for (var i = 0; i < str.length; i++) {
    if (tokens.indexOf(str.charAt(i)) !== -1) {
      break;
    }
  }
  this.php_js.strtokleftOver = str.substr(i + 1);
  return str.substring(0, i);
}


// replace all in strings
function replaceAll(string,patern,replace){
	if(string==undefined)
	return string;

	while(string.indexOf(patern)>=0){
		string=string.replace(patern,replace); 
	}
	return string;
}

// access by calling "someArray.inArray(value);"
if (!Array.prototype.inArray){
	Array.prototype.inArray=function(val){
		for (key in this){
			if (this[key]===val){
				return true; // If you want the key of the matched value, change "true" to "key"
			}
		}
		return false;
	};
};

// Array Remove - By John Resig (MIT Licensed)
if (!Array.prototype.remove){
	Array.prototype.remove = function(from, to) {
		var rest = this.slice((to || from) + 1 || this.length);
		this.length = from < 0 ? this.length + from : from;
		return this.push.apply(this, rest);
	};
};

// executeFunctionByName
function executeFunctionByName(functionName, context, obj) {
	//var args = Array.prototype.slice.call(arguments).splice(2);
	var namespaces = functionName.split(".");
	var func = namespaces.pop();
	for(var i = 0; i < namespaces.length; i++) {
	context = context[namespaces[i]];
	}
	return context[func].apply(this, [obj]);
}

function progressHandlingFunction(e){
    if(e.lengthComputable){
        $('progress').attr({value:e.loaded,max:e.total});
    }
}