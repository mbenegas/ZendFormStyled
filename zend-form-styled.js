/**
 * Universal Zend_Form styling
 * Javascript fixes, jquery required!
 * Here is everything needed for proper Zend_Form rendering that I couldn't achieve in CSS...
 * @author Wojtek Iskra wojtek@domeq.net
 * @version 2.0, 2012-03-27
 */

(function( $ ) {
  var methods = {
      init: function (options) {
          var settings = $.extend( {
                                      'automaticRestyle'                        :   true,
                                      'allowFormRestore'                        :   false,
                                      'hideEmptyDt'                             :   true,
                                      'moveHiddenElements'                      :   true,
                                      'adjustColumnHeights'                     :   true,
                                      'addErrorClassToInvalidElement'           :   true,
                                      'removeErrorClassOnInvalidElementBlur'    :   false,
                                      'submitContainerClass'                    :   'submit-container'
                                   }, options);

          // first initialization
          this.zendFormStyled('style', settings);
          
          if (settings.automaticRestyle) {
              var self = this;
              // restyle all forms after successful AJAX request - their code might have changed
              // @TODO would be great to detect and restyle only the forms that changed...
              $('html').ajaxComplete(function() {
                  self.zendFormStyled('style', settings);
              });
          }
      },
      style: function(settings) {
          return this.each(function(){
              var self = $(this);
              
              self.addClass('zendFormStyled');
              
              /**
               * First we check what kind of Zend_Form we're dealing with...
               * It can either be:
               * - Zend_Form with Zend_Form_Elements in it ('elementsOnly' class added),
               * - Zend_Form with Zend_Form_Subform(s), Zend_Form_Elements in it,
               *   but all elements are groupped in DisplayGroups ('allInDisplayGroups' class added),
               * - Zend_Form with Zend_Form_Subform(s) and Zend_Form_Elements in it, can also contain DisplayGroups
               *   ('subformAndDisplayGroups' class added).
               * We add classes to each form.
               * If you want to force certain type of styling despite form contents,
               * set one of the classes in Zend_Form, it will override jquery.
               */
              
              if (!self.hasClass('allInDisplayGroups') && 
                      !self.hasClass('subformAndDisplayGroups') && 
                      !self.hasClass('elementsOnly')
                     ) {
                      if ($('fieldset fieldset', self).length > 0) {
                          self.addClass('allInDisplayGroups');
                      }
                      else if ($('dl.zend_form>dd>fieldset>dl>dd>fieldset', self).length > 0) {
                          self.addClass('subformAndDisplayGroups');
                      }
                      else if ($('dl.zend_form>dd>fieldset>dl>dd>input', self).length > 0) {
                          self.addClass('subformsOnly');
                      }
                      else {
                          self.addClass('elementsOnly');
                      }
              }
              
              if (settings.moveHiddenElements) {
                  // move all input[type=hidden] to the end of the form and drop their dt/dd containers
                  $("dl.zend_form input[type='hidden']", self).each(function(index, element) {
                      var hiddenElement = $(element);
                      var parentForm = hiddenElement.parents('form:first');
                      
                      // check if it's not a hidden field connected with a checkbox (from Zend decorator)
                      if (hiddenElement.next("input[type='checkbox']").length == 0 &&
                          hiddenElement.next("input[type='file']").length == 0
                         ) {
                          hiddenElement.parent('dd').prev('dt').remove();
                          hiddenElement.parent('dd').remove();
                          hiddenElement.appendTo(parentForm);
                      }
                  });
              }
              
              
              if (settings.hideEmptyDt) {
                  /**
                   * Hiding empty dt elements rendered by Zend_Form only for validation purposes.
                   */
                  $('dl.zend_form dt', self).each(function(index, element) {
                      if($(element).html() == '&nbsp;') {
                          $(element).hide();
                      }
                  });
              }
              
              
              if (settings.adjustColumnHeights) {
                  /**
                   * Equalizing boxes heights in each row (for twoColumns layout).
                   * @TODO rewrite this completely!
                   */
                  if (self.hasClass('twoColumns') && self.hasClass('subformsOnly')) {
                      $('dl.zend_form>dd:even', self).each(function(index, element) {
                          var height = 0;
                              if($(element).children('fieldset').height() < $(element).next().next().children('fieldset').height())
                                  $(element).children('fieldset').css('height', $(element).next().next().children('fieldset').height());
                              else if($(element).children('fieldset').height() > $(element).next().next().children('fieldset').height())
                                  $(element).next().next().children('fieldset').css('height', $(element).children('fieldset').height());
                      });
                  }
                  
                  else if (self.hasClass('twoColumns')) {
                      $('dl.zend_form>dd>fieldset', self).each(function(index, subform) {
                          var height = 0;
                          $('dl>dd:even', $(subform)).each(function(index, element) {
                              if($(element).children('fieldset').height() < $(element).next().next().children('fieldset').height())
                                  $(element).children('fieldset').css('height', $(element).next().next().children('fieldset').height());
                              else if($(element).children('fieldset').height() > $(element).next().next().children('fieldset').height())
                                  $(element).next().next().children('fieldset').css('height', $(element).children('fieldset').height());
                          });
                      });
                  }
              }
              
              if (settings.addErrorClassToInvalidElement) {
                  /**
                   * Adding 'error' class to form element which did not pass validation.
                   * (standard Zend_Form decorators do not do that...)
                   */
                  $('ul.errors', self).each(function(index, element) {
                      $(element).prev().addClass('error');
                  });
              }
              
              if (settings.removeErrorClassOnInvalidElementBlur) {
                  /**
                   * Removing 'error' class after leaving the element (not sure if it's reasonable though...)
                   */
                  $('.error', self).bind('blur', function() {
                        $(this).removeClass('error');
                  });
              }
              
              if (settings.submitContainerClass) {
                  /**
                   * Adding 'submit' class to button's container
                   */
                  $("input[type='submit']", self).parent().addClass(settings.submitContainerClass);
              }
              
          });          
      }
  };
  
  $.fn.zendFormStyled = function(method) {
      // Method calling logic
      if ( methods[method] ) {
        return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
      } else if ( typeof method === 'object' || ! method ) {
        return methods.init.apply( this, arguments );
      } else {
        $.error( 'Method ' +  method + ' does not exist on jQuery.zendFormStyled' );
      }   
  };
})( jQuery );