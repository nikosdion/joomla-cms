<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_finder
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/*
* This segment of code sets up the autocompleter.
*/
if ($this->params->get('show_autosuggest', 1))
{
	$this->document->getWebAssetManager()->enableAsset('awesomplete');
	$this->document->addScriptOptions('finder-search', array('url' => JRoute::_('index.php?option=com_finder&task=suggestions.suggest&format=json&tmpl=component')));
}

?>

<form action="<?php echo JRoute::_($this->query->toUri()); ?>" method="get" class="js-finder-searchform">
	<?php echo $this->getFields(); ?>

	<?php //DISABLED UNTIL WEIRD VALUES CAN BE TRACKED DOWN. ?>
	<?php if (false && $this->state->get('list.ordering') !== 'relevance_dsc') : ?>
		<input type="hidden" name="o" value="<?php echo $this->escape($this->state->get('list.ordering')); ?>">
	<?php endif; ?>
	<fieldset class="com-finder__search word mb-3">
		<div class="form-inline">
			<label for="q" class="mr-2">
				<?php echo JText::_('COM_FINDER_SEARCH_TERMS'); ?>
			</label>
			<div class="input-group">
				<input type="text" name="q" class="js-finder-search-query form-control" value="<?php echo $this->escape($this->query->input); ?>">
				<span class="input-group-append">
				<?php if ($this->escape($this->query->input) != '' || $this->params->get('allow_empty_query')) : ?>
					<button name="Search" type="submit" class="btn btn-primary">
						<span class="fa fa-search icon-white" aria-hidden="true"></span>
						<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>
					</button>
				<?php else : ?>
					<button name="Search" type="submit" class="btn btn-primary disabled">
						<span class="fa fa-search icon-white" aria-hidden="true"></span>
						<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>
					</button>
				<?php endif; ?>
				<?php if ($this->params->get('show_advanced', 1)) : ?>
					<a href="#advancedSearch" data-toggle="collapse" class="btn btn-secondary" aria-hidden="true">
						<span class="fa fa-search-plus" aria-hidden="true"></span>
						<?php echo JText::_('COM_FINDER_ADVANCED_SEARCH_TOGGLE'); ?></a>
				<?php endif; ?>
				</span>
			</div>
		</div>
	</fieldset>

	<?php if ($this->params->get('show_advanced', 1)) : ?>
		<div id="advancedSearch" class="com-finder__advanced js-finder-advanced collapse<?php if ($this->params->get('expand_advanced', 0)) echo ' show'; ?>">
			<?php if ($this->params->get('show_advanced_tips', 1)) : ?>
				<div class="com-finder__tips card card-outline-secondary mb-3">
					<div class="card-body">
						<?php echo JText::_('COM_FINDER_ADVANCED_TIPS_INTRO'); ?>
						<?php echo JText::_('COM_FINDER_ADVANCED_TIPS_AND'); ?>
						<?php echo JText::_('COM_FINDER_ADVANCED_TIPS_NOT'); ?>
						<?php echo JText::_('COM_FINDER_ADVANCED_TIPS_OR'); ?>
						<?php if ($this->params->get('tuplecount', 1) > 1) : ?>
						<?php echo JText::_('COM_FINDER_ADVANCED_TIPS_PHRASE'); ?>
						<?php endif; ?>
						<?php echo JText::_('COM_FINDER_ADVANCED_TIPS_OUTRO'); ?>
					</div>
				</div>
			<?php endif; ?>
			<div id="finder-filter-window" class="com-finder__filter">
				<?php echo JHtml::_('filter.select', $this->query, $this->params); ?>
			</div>
		</div>
	<?php endif; ?>
</form>