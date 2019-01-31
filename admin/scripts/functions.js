// Side Navigation Menu Slide

$(document).ready(function() {
	$("#nav > li > a.collapsed + ul").slideToggle("medium");
	$("#nav > li > a").click(function() {
		$(this).toggleClass('expanded').toggleClass('collapsed').parent().find('> ul').slideToggle('medium');
	});
});


// Notifications Pop-Up Code

/************************************************************************
 * @name: bPopup
 * @author: Bjoern Klinggaard (http://dinbror.dk/bpopup)
 * @version: 0.4.1.min
 ************************************************************************/ 
(function(a){a.fn.bPopup=function(f,j){function s(){var b=a("input[type=text]",c).length!=0,k=o.vStart!=null?o.vStart:d.scrollTop()+g;c.css({left:d.scrollLeft()+h,position:"absolute",top:k,"z-index":o.zIndex}).appendTo(o.appendTo).hide(function(){b&&c.each(function(){c.find("input[type=text]").val("")});if(o.loadUrl!=null){o.contentContainer=o.contentContainer==null?c:a(o.contentContainer);switch(o.content){case "ajax":o.contentContainer.load(o.loadUrl);break;case "iframe":a('<iframe width="100%" height="100%"></iframe>').attr("src",
o.loadUrl).appendTo(o.contentContainer);break;case "xlink":a("a#bContinue").attr({href:o.loadUrl});a("a#bContinue .btnLink").text(a("a.xlink").attr("title"))}}}).fadeIn(o.fadeSpeed,function(){b&&c.find("input[type=text]:first").focus();a.isFunction(j)&&j()});t()}function i(){o.modal&&a("#bModal").fadeOut(o.fadeSpeed,function(){a("#bModal").remove()});c.fadeOut(o.fadeSpeed,function(){o.loadUrl!=null&&o.content!="xlink"&&o.contentContainer.empty()});o.scrollBar||a("html").css("overflow","auto");a("."+
o.closeClass).die("click");a("#bModal").die("click");d.unbind("keydown.bPopup");e.unbind(".bPopup");c.data("bPopup",null);return false}function u(){if(m){var b=[d.height(),d.width()];return{"background-color":o.modalColor,height:b[0],left:l(),opacity:0,position:"absolute",top:0,width:b[1],"z-index":o.zIndex-1}}else return{"background-color":o.modalColor,height:"100%",left:0,opacity:0,position:"fixed",top:0,width:"100%","z-index":o.zIndex-1}}function t(){a("."+o.closeClass).live("click",i);o.modalClose&&
a("#bModal").live("click",i).css("cursor","pointer");o.follow&&e.bind("scroll.bPopup",function(){c.stop().animate({left:d.scrollLeft()+h,top:d.scrollTop()+g},o.followSpeed)}).bind("resize.bPopup",function(){if(o.modal&&m){var b=[d.height(),d.width()];n.css({height:b[0],width:b[1],left:l()})}b=p(c,o.amsl);g=b[0];h=b[1];c.stop().animate({left:d.scrollLeft()+h,top:d.scrollTop()+g},o.followSpeed)});o.escClose&&d.bind("keydown.bPopup",function(b){b.which==27&&i()})}function l(){return e.width()<a("body").width()?
0:(a("body").width()-e.width())/2}function p(b,k){var q=(e.height()-b.outerHeight(true))/2-k,v=(e.width()-b.outerWidth(true))/2+l();return[q<20?20:q,v]}if(a.isFunction(f)){j=f;f=null}o=a.extend({},a.fn.bPopup.defaults,f);o.scrollBar||a("html").css("overflow","hidden");var c=a(this),n=a('<div id="bModal"></div>'),d=a(document),e=a(window),r=p(c,o.amsl),g=r[0],h=r[1],m=a.browser.msie&&parseInt(a.browser.version)==6&&typeof window.XMLHttpRequest!="object";this.close=function(){o=c.data("bPopup");i()};
return this.each(function(){if(!c.data("bPopup")){o.modal&&n.css(u()).appendTo(o.appendTo).animate({opacity:o.opacity},o.fadeSpeed);c.data("bPopup",o);s()}})};a.fn.bPopup.defaults={amsl:150,appendTo:"body",closeClass:"bClose",content:"ajax",contentContainer:null,escClose:true,fadeSpeed:250,follow:true,followSpeed:500,loadUrl:null,modal:true,modalClose:true,modalColor:"#000",opacity:0.7,scrollBar:true,vStart:null,zIndex:9999}})(jQuery);

// Notifications Pop-Up functionality

	$(document).ready(function(){
	   		$("a.notifypop").bind('click', function(){
		 	 $("#notificationsbox").bPopup();
		  	 return false
			});
		});
	
// Charting script

$(document).ready(function(){
 	$('table.pie').visualize({type: 'pie', height: '300px', width: '620px'});
	$('table.bar').visualize({type: 'bar', height: '300px', width: '620px'});
	$('table.area').visualize({type: 'area', height: '300px', width: '620px'});
	$('table.line').visualize({type: 'line', height: '300px', width: '620px'});
});
		
// Tab Switching

	$(document).ready(function(){
		$("#tabs, #graphs").tabs();
	});

// Select all checkboxes

	$(document).ready(function(){
      $("#checkboxall").click(function()
      {
      var checked_status = this.checked;
      $("input[name=checkall]").each(function() {
      this.checked = checked_status;
      });
      });
      });

// Rich text editor/WYSIWYG

	$(document).ready(function() {
			$('#wysiwyg').wysiwyg();
		});
	

	function addInputError (input){
		if(input.parentElement.innerHTML.match("<label class=\"error\".*")) return;
		input.parentElement.innerHTML = input.parentElement.innerHTML + '<label class="error" for="'+input.id+'">Please enter a valid number.</label>';
	}
	
	function isNumeric(n) {
	    return !isNaN(parseFloat(n)) && isFinite(n);
	}