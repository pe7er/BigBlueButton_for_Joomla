<?php 
/**
 * @version 1.2
 * @package    joomla
 * @subpackage Bigbluebutton
 * @author	   	Jibon Lawrence Costa
 *  @copyright  	Copyright (C) 2015, Jibon Lawrence Costa. All rights reserved.
 *  @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die('Restricted access');	

JHtml::_('jquery.framework');
 
JFactory::getDocument()->addScriptDeclaration('
	jQuery("document").ready(function($){
		$("#bbbLoginFrom").submit(function(e){
			e.preventDefault();
			var data = $(this).serialize();
			$.ajax({
				method: "GET",
				dataType: "jsonp",
				url: "index.php?"+data,
				jsonp: "callback",
				
				beforeSend: function(){
					$("#status").html("<img style=\"height: 60px; width: 60px;\" src=\''.JURI::root().'components/com_bigbluebutton/assets/images/ajax.gif\' alt=\'loading..\'/>");
				},
				success: function(res){
					$("#status").html("");
					if(res.status){
						$("#status").html("'.JText::_("COM_BIGBLUEBUTTON_REDIRECTING").'....");
						window.location = res.url;
					}else{
						$("#status").html("'.JText::_("COM_BIGBLUEBUTTON_CANT_LOGIN").'");
					}
				},
				error: function(res){
					$("#status").html("'.JText::_("COM_BIGBLUEBUTTON_CANT_LOGIN").'");
				}
			})
		})
	})
');
?>
<form id="bbbLoginFrom" class="<?php echo $params->get( 'classname'); ?> uk-form uk-form-horizontal">
    <fieldset>
		<div style="color: red; margin-bottom: 10px;" id="status"></div>

        <div class="uk-form-row">
			<label class="uk-form-label" for=""><?php echo JText::_('COM_BIGBLUEBUTTON_MEETING_ROOM'); ?></label>
			<div class="uk-form-controls">
				<?php echo JHtmlSelect::genericlist($options, 'meetingId', 'class="meeting"', 'value', 'text'); ?>
			</div>
		</div>
		
        <div class="uk-form-row">
			<label class="uk-form-label" for=""><?php echo JText::_('COM_BIGBLUEBUTTON_NAME'); ?></label>
			<div class="uk-form-controls">
				<input name="name" required type="text" placeholder="<?php echo JText::_('COM_BIGBLUEBUTTON_NAME'); ?>">
			</div>
		</div>
		
		<div class="uk-form-row">
			<label class="uk-form-label" for=""><?php echo JText::_('COM_BIGBLUEBUTTON_PASSWORD'); ?></label>
			<div class="uk-form-controls">
				<input type="password" required name="password" placeholder="<?php echo JText::_('COM_BIGBLUEBUTTON_PASSWORD'); ?>">
			</div>
		</div>
		<input type="hidden" name="option" value="com_bigbluebutton">
		<input type="hidden" name="task" value="ajax.login">
		<input type="hidden" name="format" value="json">
		<input type="hidden" name="token" value="<?php echo JSession::getFormToken(); ?>">
		<div class="uk-form-row">
			<div class="uk-form-controls">
				<button class="btn btn-success" type="submit"><?php echo JText::_('COM_BIGBLUEBUTTON_LOGIN'); ?></button>
				<button class="btn btn-danger" type="reset"><?php echo JText::_('COM_BIGBLUEBUTTON_RESET'); ?></button>
			</div>
		</div>
   </fieldset>
</form>  