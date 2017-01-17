<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.tooltip');
 
?>
    <h2>Update Member Information</h2>
 
    <form class="form-validate" action="<?php echo JRoute::_('index.php'); ?>" method="post" id="updatemember" name="updatemember">
		<fieldset>
        	<dl>
          	    
        	    <dt><?php echo $this->form->getLabel('MemberHomeAddress'); ?></dt>
        	    <dd><?php echo $this->form->getInput('MemberHomeAddress'); ?></dd>
                <dt></dt><dd></dd>
                <dt></dt>
            	<dd><input type="hidden" name="option" value="com_members" />
            	    <input type="hidden" name="task" value="updatemember.submit" />
                </dd>
                <dt></dt>
                <dd><button type="submit" class="button"><?php echo JText::_('Submit'); ?></button>
			                <?php echo JHtml::_('form.token'); ?>
                </dd>
        	</dl>
        </fieldset>
    </form>
    <div class="clr"></div>
