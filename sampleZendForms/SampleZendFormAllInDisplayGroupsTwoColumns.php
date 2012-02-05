<?php
class Ext_Form_Default_Development_SampleZendFormAllInDisplayGroupsTwoColumns extends  Ext_Form_Default_Development_SampleZendFormAllInDisplayGroups
{
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setAttrib('class', 'twoColumns');
    }
}
?>