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


jimport('joomla.form.formfield');
class JFormFieldPositions extends JFormField
{
    public $type = 'positions';

    public function getInput()
    {
        $db   = JFactory::getDBO();

        $query = $db->getQuery(true)
            ->select('DISTINCT template AS text')
            ->select('template AS value')
            ->from('#__template_styles')
            ->where('client_id = 0');
        $db->setQuery($query);
        $templates = $db->loadObjectList();

        $query = $db->getQuery(true)
            ->select('DISTINCT position')
            ->from('#__modules')
            ->where('client_id = 0');
        $db->setQuery($query);
        $positions = $db->loadColumn();
        $positions = (is_array($positions)) ? $positions : array();

        for ($i = 0, $n = count($templates); $i < $n; $i++) {
            $path         = JPATH_SITE . '/templates/' . $templates[$i]->value;
            $xmlPath      = $path . '/templateDetails.xml';

            if (file_exists($xmlPath)) {
                $xml = simplexml_load_file($xmlPath);

                if (isset($xml->positions[0])) {
                    foreach ($xml->positions[0] as $position) {
                        $positions[] = (string) $position;
                    }
                }
            }
        }

        $positions = array_unique($positions);
        sort($positions);

        $options[] = JHTML::_('select.option', '', JText::_('MOD_JW_TS_NONE_SELECTED'), 'id', 'title');
        foreach ($positions as $position) {
            if ($position) {
                $options[] = JHTML::_('select.option', $position, $position, 'id', 'title');
            }
        }

        $output = JHTML::_('select.genericlist', $options, $this->name, 'class="inputbox"', 'id', 'title', $this->value);

        return $output;
    }
}
