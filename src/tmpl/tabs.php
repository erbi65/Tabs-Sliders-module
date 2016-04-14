<?php
/**
 * @package    Tabs & Sliders (module)
 * @contact    www.alledia.com, hello@alledia.com
 * @author     JoomlaWorks - http://www.joomlaworks.net
 * @author     Alledia - http://www.alledia.com
 * @copyright  Copyright (c) 2006 - 2015 JoomlaWorks Ltd. All rights reserved.
 * @copyright  Copyright (c) 2016 Open Source Training, LLC. All rights reserved
 * @license    GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/*
Here we call the stylesheet style.css from a folder called 'css' and located at the same directory with this template file. If Joomla!'s cache is turned on, we print out the CSS include within a script tag so we're valid and the styling is included properly (it's how Joomla! works unfortunately).
*/
$filePath = substr(JURI::base(), 0, -1) . str_replace(JPATH_SITE, '', dirname(__FILE__));

?>

<?php if ($mainframe->getCfg('caching') && $params->get('cache') == 1) : ?>
<?php if (!defined('JW_TS_MOD_CSS')) : ?>
<script type="text/javascript">
	//<![CDATA[
	document.write('\
	<style type="text/css" media="all">\
		@import "<?php echo $filePath; ?>/css/template.css";\
	</style>\
	');
	//]]>
</script>
<?php define('JW_TS_MOD_CSS', true); ?>
<?php endif; ?>
<?php else : ?>
<?php $document->addStyleSheet($filePath.'/css/template.css'); ?>
<?php endif; ?>

<div id="jwTabsAndSlidersModule<?php echo $module->id; ?>" class="jwts_tabber<?php if ($params->get('moduleclass_sfx')) echo ' ' . $params->get('moduleclass_sfx'); ?>">
	<?php foreach ($modulesInPosition as $mod) : ?>
	<div class="jwts_tabbertab" title="<?php echo $mod->title; ?>">
		<h2>
			<a href="javascript:void(null);" name="advtab">
				<?php echo $mod->title; ?>
			</a>
		</h2>
		<?php if ($jwts_showmodtitle) : ?>
		<div class="jwts_modtitle">
			<?php echo $mod->title; ?>
		</div>
		<?php endif; ?>
		<?php echo $jwts_renderer->render($mod, $jwts_params); ?>
	</div>
	<?php endforeach; ?>
</div>
<div class="jwts_clr"></div>
