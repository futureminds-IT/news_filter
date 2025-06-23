<?php

if (!defined('TYPO3')) {
    die('Access denied.');
}

$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['Domain/Repository/AbstractDemandedRepository.php']['findDemanded']['news_filter']
    = \GeorgRinger\NewsFilter\Hooks\Repository::class . '->modify';

$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['classes']['Domain/Repository/CategoryRepository'][] = 'news_filter';


$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['Controller/NewsController.php']['createDemandObjectFromSettings']['news_filter']
 = \GeorgRinger\NewsFilter\Hooks\EnrichDemandObject::class . '->run';
