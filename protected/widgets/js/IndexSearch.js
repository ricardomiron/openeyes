/* Global Variables */
var show_children = true;
var last_search_pos;
var is_loading_timeout;
/* End of Global varaibles */

/*
* jQuery Search Widget:
* Generic code that shows, hides and highlights text in a HTML structure
* that has been generated by eyedrawconfigload yii command
*/
(function($) {
  "use strict";
  let opts;
  let search_term;
  $.fn.search = function(options) {
    opts = $.extend({}, $.fn.search.defaults, options);
    let $results = $("#results");
    let $parent = $results.parent();
    this.keyup(function() {
      //temporarily detaches div from DOM to reduce unnecessary rendering
      $results.detach();
      search_term = ($(this).val() + "").toLowerCase();
      let last_level,$this,$element,highlighted_string,alias,selector,match_pos
          ,plain_text,no_match_text,match_text,$alias,highlighted_aliases;
      for (selector of opts.selectors) {
        //determines whether the index selecor is for the last level i.e  the index has no children
        last_level = opts.selectors[0] == selector;
        $results.find(selector).each(function() {
          $this = $(this);
          $element = get_element($this);
          $alias = $element.children(':first').next('.index_row').find('.alias:first');
          alias = $this.data("alias").toLowerCase();
          if ((match_pos = alias.indexOf(search_term)) == -1) { //no matches
            $this.html($this.text()); //removes highlighted text
            $alias.html($alias.text());
            if (!last_level && $element.children().find("li[style!='display: none;']").length != 0) {
              $element.show(); //has visible children index so should be visible to maintain tree structure
            } else {
              $element.hide(); //has no visible children so hide
            }
          } else { //match found
            //clear previous highlights and slice up to the start of match
            //uses the indexOf used to check presence to slice string
            //benefitical if the alias list is very long as it means
            //length of string is likely less
            plain_text = $this.text();
            no_match_text = plain_text.slice(0,(match_pos-1) < 0 ? 0 : (match_pos)); //may over slice
            match_text = plain_text.slice(match_pos);
            highlighted_string = no_match_text + replace_matched_string(match_text);
            $this.html(highlighted_string);
            highlighted_aliases = replace_matched_string($alias.text());
            $alias.html(highlighted_aliases);

            $element.show();
            if (!last_level) { //does it have children?
              if (show_children == true) { //is the toggle show children on?
                $element.children().find("li[style='display: none;']").show(); //show index descendents
              }
            }
          }
        });
      }
      $parent.append($results); //reattaches the result to the DOM to be rendered
    });
    return this;
  };
  $.fn.search.defaults = {
    selectors: [".lvl3", ".lvl2", ".lvl1"], //order of selection
    ancestor_to_change: 2, //how many times parent() need to be used to get from text to block
    matched_string_tag: ["<em class='search_highlight'>", "</em>"] //surround matched text with
  };

  function replace_matched_string(old_string) { //highlights text with matched_string_tag in opts
    if (search_term === undefined || search_term === "" || old_string.toLowerCase().indexOf(search_term.toLowerCase()) == -1) {
      return old_string;
    }
    if (old_string === "") {
      return "";
    }
    const match_start = old_string.toLowerCase().indexOf("" + search_term.toLowerCase() + "");
    const match_end = match_start + search_term.length - 1;
    const before_match = old_string.slice(0, match_start);
    const match_text = old_string.slice(match_start, match_end + 1);
    const after_match = old_string.slice(match_end + 1);
    const new_string = before_match + opts.matched_string_tag[0] + match_text + opts.matched_string_tag[1] + replace_matched_string(after_match);
    return new_string;
  }

  function get_element($this) { //gets to element from the text
    let i;
    for (i = 0; i < opts.ancestor_to_change; i++) {
      $this = $this.parent();
    }

    //allows widget to be chainable
    return $this;
  }
}(jQuery));
/* End of jQuery Search Widget*/


/*
* Initialisation:
* Attaches event listeners to the DOM
* for the IndexSearch Widget
*/
$(document).ready(function(){
  $("#search_bar_right").search();
  $("#search_bar_left").search();
  $("#search_bar_right").focus(function(){
    $('#search_bar_left').val('');
    last_search_pos = "right";
    $('#search_bar_right').trigger("keyup");
    show_results();
  });
  $("#search_bar_left").focus(function(){
    $('#search_bar_right').val('');
    last_search_pos = "left";
    $('#search_bar_left').trigger("keyup");
    show_results();
  });

  $('.result_item, .result_item_with_icon').click(function(event){
    $('#is_loading').show();
    //if ajax call is very slow hide loading gif so user can perform other actions
    is_loading_timeout = setTimeout(()=>$('#is_loading').hide(),6000);
    //Index has been clicked
    event.stopPropagation();
    hide_results();
    index_clicked($(this));
  });

  $('body').append('<div id="dim_rest" class="ui-widget-overlay" style="display : none; width: 1280px; height: 835px; z-index: 180;"></div>');
  $('body').append("<div id=\"is_loading\"style=\"display : none; position: fixed; background-color: black; width: 100%; height: 1000px; z-index: 1000; opacity: 0.8; top:0px; \"><img src=\"https://itopia.com/wp-content/themes/itopia/img-cloud/loader.gif\" style=\" position: fixed; z-index: 1000; height: 64px; width: 64px; top: 33%; left: 50%;\"></div>");
  $('#description_toggle').change(function(){
    if (this.checked) {
      $('.description_icon,.description_note').show();
    } else {
      $('.description_icon,.description_note').hide();
    }
    event.stopPropagation();
  });
  $('#children_toggle').change(function(){
    let current_search_bar = "#search_bar_"+last_search_pos;
    if (this.checked) {
      show_children = true;
      $(current_search_bar).trigger('keyup');
    } else {
      show_children = false;
      $(current_search_bar).trigger('keyup');
    }
    event.stopPropagation();
  });

  $(window).click(function() {
    hide_results();
  });

  $('#big_cross').click(function(){
    hide_results();
  });

  $('.switch,#results,#search_bar_right,#search_bar_left').click(function(){
    event.stopPropagation();
  });

  //prevents body mousedown event being triggered
  //as this would cause the doodle popup to hide
  $('#results').mousedown(function(){
    event.stopPropagation();
  });
  if ($('.event-actions li:contains(Create)').length > 0) {
    $('#search_options_container').css('width','290px');
  }

});
/* End of Initialisation */


/*
* Auxilary Functions:
* Frequently used code
*/
function get_controls_id(elementId, position){
  return "#ed_canvas_edit_"+position+"_"+elementId+"_controls";
}

function get_doodle_button(elementId, doodleClassName, position) {
  let doodle_id = "#"+doodleClassName+position+"_"+elementId;
  let $item = $(doodle_id).children();
  return $item;
}

function show_results(){
  var body = document.body,
  html = document.documentElement;
  var height = Math.max( body.scrollHeight, body.offsetHeight,
    html.clientHeight, html.scrollHeight, html.offsetHeight );
    $('#dim_rest').css("height", height);
    $('#dim_rest').show();
    $("body").css("overflow","hidden");
    $("#results").show();
    $(".switch").show();
    $("#children_toggle_container,#description_toogle_container").css("display","inline-block");
  }

  function hide_results(){
    $('#search_bar_right,#search_bar_left').val('');
    $('#results').scrollTop(0);
    $('#dim_rest').hide();
    $("body").css("overflow","auto");
    $("#results").hide();
    $(".switch").hide();
    $("#children_toggle_container,#description_toogle_container").css("display","none");
  }
  /*End of Auxilary Functions*/


  /*
  * Action Code
  * Code that handles what happens when
  * an index is clicked
  */
  /* Promise wrapper for old-style callback method */
  function index_clicked($this){
    let parameters = {};
    parameters["element_name"] = $this.data('elementName');
    parameters["element_id"] = $this.data('elementId');
    parameters["doodle_name"] = $this.data('doodleClassName');
    parameters["property_name"] = $this.data('property');
    //can revese order have different length chains etc
    //Chains can be made conditional based on content of parameters
    //Guarantees funcion execution order (even for asyncrounous functions)
    click_element(parameters).then(result => click_doodle(result)).then(result => click_property(result)).catch(() => {
      $('#is_loading').hide();
      clearTimeout(is_loading_timeout);
      return;
    });
  }

  function click_element(parameters){
    //get side bar item
    let $item = $(".oe-event-sidebar-edit li a:contains("+parameters.element_name+")");
    return click_sidebar_element($item).then(function (){
      return new Promise(function(resolve, reject) {
        //see if parameters are set for doodle
        if (parameters.doodle_name) {
          resolve(parameters);
        } else {
          reject();
        }
      });
    });
  }

  function click_doodle(parameters){
    ED.Checker.storeCanvasId("ed_canvas_edit_"+last_search_pos+"_"+parameters.element_id);
    return onAllCanvasesReady().then(function(){
      return new Promise(function(resolve, reject) {
          let ed_canvas = ED.Checker.getInstanceByIdSuffix(last_search_pos+"_"+parameters.element_id);
          let dropdown_box_selector = "#eyedrawwidget_"+last_search_pos+"_"+parameters.element_id;
          let $doodle = get_doodle_button(parameters.element_id,parameters.doodle_name,last_search_pos);
          let doodle_name = ED.titles[parameters.doodle_name];
          let $selected_doodle = $(dropdown_box_selector).find("#ed_example_selected_doodle").children().find("option:contains("+doodle_name+")");
          if ($selected_doodle.length == 0) {
            ed_canvas.addDoodle(parameters.doodle_name);
          } else {
            $(dropdown_box_selector).find("#ed_example_selected_doodle").children().find("option").removeAttr('selected');
            $selected_doodle.attr('selected','selected');
            $(dropdown_box_selector).find("#ed_example_selected_doodle").trigger('change');
          }
          //Ensures Promise chains breaks if parameter(s) for next promise are not present
          if (parameters.property_name) {
            resolve(parameters);
          } else {
            reject();
          }
        //wrap onAllReady in Promise
      });
    });
  }

  function click_property(parameters){
    return new Promise(function(resolve, reject) {
      let control_id = get_controls_id(parameters.element_id,last_search_pos);
      $(control_id).find("div:contains("+parameters.property_name+")").effect("highlight", {}, 6000);
      /* Breaks the Promise chain as nothing should be called after property,
      based on the current code */
      if (1 == 2) {
        resolve(parameters);
      } else {
        reject();
      }
    });
  }
  //wrapper for old-style callback
  function click_sidebar_element($item) {
    return new Promise(function(resolve, reject) {
      event_sidebar.loadClickedItem($item,{},resolve);
    });
  }

  //wrapper for old-style callback
    function onAllCanvasesReady() {
      return new Promise(function(resolve, reject) {
      ED.Checker.onAllReady(resolve);
    });
  }
    /* End of Promise code */

    /* End of my code */

    /* Shortcut plugin not my code*/
    /**
 * http://www.openjs.com/scripts/events/keyboard_shortcuts/
 * Version : 2.01.B
 * By Binny V A
 * License : BSD
 */
shortcut = {
	'all_shortcuts':{},//All the shortcuts are stored in this array
	'add': function(shortcut_combination,callback,opt) {
		//Provide a set of default options
		var default_options = {
			'type':'keydown',
			'propagate':false,
			'disable_in_input':false,
			'target':document,
			'keycode':false
		}
		if(!opt) opt = default_options;
		else {
			for(var dfo in default_options) {
				if(typeof opt[dfo] == 'undefined') opt[dfo] = default_options[dfo];
			}
		}

		var ele = opt.target;
		if(typeof opt.target == 'string') ele = document.getElementById(opt.target);
		var ths = this;
		shortcut_combination = shortcut_combination.toLowerCase();

		//The function to be called at keypress
		var func = function(e) {
			e = e || window.event;

			if(opt['disable_in_input']) { //Don't enable shortcut keys in Input, Textarea fields
				var element;
				if(e.target) element=e.target;
				else if(e.srcElement) element=e.srcElement;
				if(element.nodeType==3) element=element.parentNode;

				if(element.tagName == 'INPUT' || element.tagName == 'TEXTAREA') return;
			}

			//Find Which key is pressed
			if (e.keyCode) code = e.keyCode;
			else if (e.which) code = e.which;
			var character = String.fromCharCode(code).toLowerCase();

			if(code == 188) character=","; //If the user presses , when the type is onkeydown
			if(code == 190) character="."; //If the user presses , when the type is onkeydown

			var keys = shortcut_combination.split("+");
			//Key Pressed - counts the number of valid keypresses - if it is same as the number of keys, the shortcut function is invoked
			var kp = 0;

			//Work around for stupid Shift key bug created by using lowercase - as a result the shift+num combination was broken
			var shift_nums = {
				"`":"~",
				"1":"!",
				"2":"@",
				"3":"#",
				"4":"$",
				"5":"%",
				"6":"^",
				"7":"&",
				"8":"*",
				"9":"(",
				"0":")",
				"-":"_",
				"=":"+",
				";":":",
				"'":"\"",
				",":"<",
				".":">",
				"/":"?",
				"\\":"|"
			}
			//Special Keys - and their codes
			var special_keys = {
				'esc':27,
				'escape':27,
				'tab':9,
				'space':32,
				'return':13,
				'enter':13,
				'backspace':8,

				'scrolllock':145,
				'scroll_lock':145,
				'scroll':145,
				'capslock':20,
				'caps_lock':20,
				'caps':20,
				'numlock':144,
				'num_lock':144,
				'num':144,

				'pause':19,
				'break':19,

				'insert':45,
				'home':36,
				'delete':46,
				'end':35,

				'pageup':33,
				'page_up':33,
				'pu':33,

				'pagedown':34,
				'page_down':34,
				'pd':34,

				'left':37,
				'up':38,
				'right':39,
				'down':40,

				'f1':112,
				'f2':113,
				'f3':114,
				'f4':115,
				'f5':116,
				'f6':117,
				'f7':118,
				'f8':119,
				'f9':120,
				'f10':121,
				'f11':122,
				'f12':123
			}

			var modifiers = {
				shift: { wanted:false, pressed:false},
				ctrl : { wanted:false, pressed:false},
				alt  : { wanted:false, pressed:false},
				meta : { wanted:false, pressed:false}	//Meta is Mac specific
			};

			if(e.ctrlKey)	modifiers.ctrl.pressed = true;
			if(e.shiftKey)	modifiers.shift.pressed = true;
			if(e.altKey)	modifiers.alt.pressed = true;
			if(e.metaKey)   modifiers.meta.pressed = true;

			for(var i=0; k=keys[i],i<keys.length; i++) {
				//Modifiers
				if(k == 'ctrl' || k == 'control') {
					kp++;
					modifiers.ctrl.wanted = true;

				} else if(k == 'shift') {
					kp++;
					modifiers.shift.wanted = true;

				} else if(k == 'alt') {
					kp++;
					modifiers.alt.wanted = true;
				} else if(k == 'meta') {
					kp++;
					modifiers.meta.wanted = true;
				} else if(k.length > 1) { //If it is a special key
					if(special_keys[k] == code) kp++;

				} else if(opt['keycode']) {
					if(opt['keycode'] == code) kp++;

				} else { //The special keys did not match
					if(character == k) kp++;
					else {
						if(shift_nums[character] && e.shiftKey) { //Stupid Shift key bug created by using lowercase
							character = shift_nums[character];
							if(character == k) kp++;
						}
					}
				}
			}

			if(kp == keys.length &&
						modifiers.ctrl.pressed == modifiers.ctrl.wanted &&
						modifiers.shift.pressed == modifiers.shift.wanted &&
						modifiers.alt.pressed == modifiers.alt.wanted &&
						modifiers.meta.pressed == modifiers.meta.wanted) {
				callback(e);

				if(!opt['propagate']) { //Stop the event
					//e.cancelBubble is supported by IE - this will kill the bubbling process.
					e.cancelBubble = true;
					e.returnValue = false;

					//e.stopPropagation works in Firefox.
					if (e.stopPropagation) {
						e.stopPropagation();
						e.preventDefault();
					}
					return false;
				}
			}
		}
		this.all_shortcuts[shortcut_combination] = {
			'callback':func,
			'target':ele,
			'event': opt['type']
		};
		//Attach the function with the event
		if(ele.addEventListener) ele.addEventListener(opt['type'], func, false);
		else if(ele.attachEvent) ele.attachEvent('on'+opt['type'], func);
		else ele['on'+opt['type']] = func;
	},

	//Remove the shortcut - just specify the shortcut and I will remove the binding
	'remove':function(shortcut_combination) {
		shortcut_combination = shortcut_combination.toLowerCase();
		var binding = this.all_shortcuts[shortcut_combination];
		delete(this.all_shortcuts[shortcut_combination])
		if(!binding) return;
		var type = binding['event'];
		var ele = binding['target'];
		var callback = binding['callback'];

		if(ele.detachEvent) ele.detachEvent('on'+type, callback);
		else if(ele.removeEventListener) ele.removeEventListener(type, callback, false);
		else ele['on'+type] = false;
	}
}

shortcut.add("Ctrl+Shift+R",function() {
  $("#search_bar_right").trigger("focus");
});
shortcut.add("Ctrl+Shift+L",function() {
  $("#search_bar_left").trigger("focus");
});
shortcut.add("Esc",function() {
  $("#search_bar_right,#search_bar_left").trigger("blur");
  hide_results();
});
    /* End of Shortcut code */
