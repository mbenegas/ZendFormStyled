<?php
class Ext_Form_Default_Development_SampleZendFormNotAllInDisplayGroupsTwoColumns extends  Ext_Form_Default_Development_SampleZendFormNotAllInDisplayGroups
{
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setAttrib('class', 'subformAndDisplayGroups twoColumns inlineLabels');
    }
}
?>