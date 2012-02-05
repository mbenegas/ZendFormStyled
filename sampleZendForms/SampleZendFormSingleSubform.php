<?php
class Ext_Form_Default_Development_SampleZendFormSingleSubform extends Zend_Form
{
    function __construct($options = null)
    {
        parent::__construct($options);
        $translator = Zend_Registry::get('Zend_Translate');
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('save')
               ->setAttrib('class','btn-submit')
        ;
        
          // deleteable
        $deleteable = new Zend_Form_Element_Select('deleteable');
        $deleteable
            ->setLabel('pageMightBeDeleting')
            ->addMultiOptions(array(
                0 => $translator->translate('no'),
                1 => $translator->translate('yes')
            ))
            ;
            
          // comments_availability
//          @FIXME disabled comments for now
//        $commentsAvailability = new Zend_Form_Element_Select('comments-availability');
//        $commentsAvailability
//            ->setLabel('Komentarze')
//            ->addMultiOptions(array(
//                StaticPageConfig::COMMENTS_DISABLED => 'wyłączone',
//                StaticPageConfig::COMMENTS_ENABLED => 'zawsze włączone',
//                StaticPageConfig::COMMENTS_ADMINS_DECISION => 'decyduje administator'
//            ))
//            ;
        
        //config description
        $description = new Zend_Form_Element_Text('description');
        $description
            ->setLabel('description')
            ->addValidator(new Zend_Validate_StringLength(3,128))
            ->addFilter(new Zend_Filter_StripTags)
            ->setRequired(true)
            ;
            
        //layout_view
        $layout_view = new Zend_Form_Element_Text('layout_view');
        $layout_view
            ->setLabel('viewScript')
            ->setDescription('fileWithoutExtensionDefaultShow')
            ->addValidator(new Zend_Validate_StringLength(3,128))
            ->addFilter(new Zend_Filter_StripTags)
            ->setRequired(true)
            ;           
            
        
        $bodyElements = array();
        
        for ($i = 1; $i < 5; $i++) {
            // body_enabled
            $bodyEnabled = new Zend_Form_Element_Checkbox('body'.$i.'_enabled');
            $bodyEnabled
              ->setLabel($translator->translate('content')." $i ".$translator->translate('enabled'))
              ;
              
            // body_field_name
            $bodyFieldName = new Zend_Form_Element_Text('body'.$i.'_field_name');
            $bodyFieldName
              ->setLabel($translator->translate('fieldsName').$i)
              ->addValidator(new Zend_Validate_StringLength(1,128))
              ->addFilter(new Zend_Filter_StripTags)
              ->setRequired(false)
              ;
              
            // body_type
            $bodyType = new Zend_Form_Element_Select('body'.$i.'_type');
            $bodyType
                ->setLabel($translator->translate('TypeFieldContent').$i)
                ;
                
            // body_tiny_mce_config
            $bodyTinyMceConfig = new Zend_Form_Element_Select('body'.$i.'_tiny_mce_config');
            $bodyTinyMceConfig
                ->setLabel($translator->translate('content')." $i TinyMce")
                ->setDescription('ifSelectedTextarea')
                ;
                
            $bodyElements[] = array(
                $bodyEnabled,
                $bodyFieldName,
                $bodyType,
                $bodyTinyMceConfig
            );
        }
            
            
            
        // children_enabled
        $childrenEnabled = new Zend_Form_Element_Checkbox('children_enabled');
        $childrenEnabled
          ->setLabel('pageMayHaveChildren')
          ;
          
          
        // children_cnt_max
        $childrenCntMax = new Zend_Form_Element_Text('children_cnt_max');
        $childrenCntMax
          ->setLabel('maximumNumberOfChildren')
          ->addValidator(new Zend_Validate_Between(1, 100000))
          ->addValidator(new Zend_Validate_Int())
          ;

        // children_sort_type
        $children_sort_type = new Zend_Form_Element_Select('children_sort_type');
        $children_sort_type
          ->setLabel('howToSortChildren')
          ;
        
        // static_page_config_child_id
        $staticPageConfigChild = new Zend_Form_Element_Select('static_page_config_child_id');
        $staticPageConfigChild
            ->setLabel('setConfigForPageChildren')
            ->addMultiOption(0, '--'.$translator->translate('choose').'--')
            ;
            
            
        // children_use_pager
        $childrenUsePager = new Zend_Form_Element_Checkbox('children_use_pager');
        $childrenUsePager
          ->setLabel('userPagerForDisplayingChildren')
          ;
          
        // children_pager_pages_cnt
        $childrenPagerPagesCnt = new Zend_Form_Element_Text('children_pager_pages_cnt');
        $childrenPagerPagesCnt
          ->setLabel('displayChildrenPerPage')
          ->addValidator(new Zend_Validate_Between(1, 100000))
          ->addValidator(new Zend_Validate_Int())
          ;
            
            
        // parts_enabled
        $parts_enabled = new Zend_Form_Element_Checkbox('paragraph_enabled');
        $parts_enabled
          ->setLabel('pageHasParagraphs')
          ;
          
        // parts_cnt_max
        $parts_cnt_max = new Zend_Form_Element_Text('paragraph_cnt_max');
        $parts_cnt_max
          ->setLabel('paragraphsAmount')
          ->addValidator(new Zend_Validate_Between(1, 100000))
          ->addValidator(new Zend_Validate_Int())
          ;
          
            
        // parts_sort_type
        $parts_sort_type = new Zend_Form_Element_Select('paragraph_sort_type');
        $parts_sort_type
          ->setLabel('howToSortParagraphs')
          ;
          
        // paragraph_use_pager
        $paragraphUsePager = new Zend_Form_Element_Checkbox('paragraph_use_pager');
        $paragraphUsePager
          ->setLabel('userPagerForDisplayingParagraphs')
          ;
          
        // paragraph_pager_pages_cnt
        $paragraphPagerPagesCnt = new Zend_Form_Element_Text('paragraph_pager_pages_cnt');
        $paragraphPagerPagesCnt
          ->setLabel('displayPPerPage')
          ->addValidator(new Zend_Validate_Between(1, 100000))
          ->addValidator(new Zend_Validate_Int())
          ;
            

          
        // gallery_enabled
        $gallery_enabled = new Zend_Form_Element_Checkbox('gallery_enabled');
        $gallery_enabled
          ->setLabel('pageHasGallery')
          ;
          
        // gallery_images_cnt_max
        $gallery_images_cnt_max = new Zend_Form_Element_Text('gallery_images_cnt_max');
        $gallery_images_cnt_max
          ->setLabel('maxNumberPhotosInGallery')
          ->addValidator(new Zend_Validate_Between(1, 100000))
          ->addValidator(new Zend_Validate_Int())
          ;
          
        // gallery_config_id
        $gallery_config_id = new Zend_Form_Element_Text('gallery_config_id');
        $gallery_config_id
          ->setLabel('idConfigGallery')
          ->addValidator(new Zend_Validate_Between(1, 100000))
          ->addValidator(new Zend_Validate_Int())
          ;
          
            
        // file_attachments_enabled
        $file_attachments_enabled = new Zend_Form_Element_Checkbox('file_attachments_enabled');
        $file_attachments_enabled
          ->setLabel('pageMayHasAttachments')
          ;
          
        // file_attachments_cnt_max
        $file_attachments_cnt_max = new Zend_Form_Element_Text('file_attachments_cnt_max');
        $file_attachments_cnt_max
          ->setLabel('maxAttachments')
          ->addValidator(new Zend_Validate_Between(1, 100000))
          ->addValidator(new Zend_Validate_Int())
          ;

        // optional edittable form fields
        $publication_date = new Zend_Form_Element_Checkbox('publication_date');
        $publication_date
            ->setLabel('editablePublishDate')
            ;
            
        // optional edittable form fields
        $might_be_link = new Zend_Form_Element_Checkbox('might_be_link');
        $might_be_link
            ->setLabel('mightBeLink')
            ;            
            
        // tag module enabled / disabled 
        $tags_enabled = new Zend_Form_Element_Checkbox('tags_enabled');
        $tags_enabled
            ->setLabel('tagsEnabled')
            ;                 
            
        $subform = new Zend_Form_SubForm();
        $subform->setLegend('Subform legend');
        
        
        foreach ($bodyElements as $elements) {
            $subform->addElements($elements);
        }
        
        
        $subform->addElements(array(
            $description,
            $layout_view,
            $deleteable,
//          $commentsAvailability,
            $childrenEnabled,
            $childrenCntMax,
            $children_sort_type,
            $staticPageConfigChild,
            $childrenUsePager,
            $childrenPagerPagesCnt,
            $parts_enabled,
            $parts_cnt_max,
            $parts_sort_type,
            $paragraphUsePager,
            $paragraphPagerPagesCnt,
            
            $gallery_enabled,
            $gallery_config_id,
            $gallery_images_cnt_max,
            
            $file_attachments_enabled,
            $file_attachments_cnt_max,
            $publication_date,
            $might_be_link,
            $tags_enabled
        ));

        $this->addSubForm($subform, 'configStaticPage', -1);
        $this->addElement($submit);
        
//        $this->setAttrib('class', 'twoColumns');
    }
    
}
