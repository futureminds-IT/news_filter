<?php

namespace GeorgRinger\NewsFilter\Hooks;

use GeorgRinger\News\Domain\Repository\NewsRepository;
use GeorgRinger\NewsFilter\Domain\Model\Dto\Demand;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

class Repository
{
    public function modify(array $params, $newsRepository): void
    {
        if (!($newsRepository instanceof NewsRepository) || \get_class($params['demand']) !== Demand::class) {
            return;
        }
        $this->updateConstraints($params['demand'], $params['query'], $params['constraints']);
    }

    /**
     * @param Demand $demand
     * @param QueryInterface $query
     * @param array $constraints
     */
    protected function updateConstraints(Demand $demand, QueryInterface $query, array &$constraints)
    {
        // dates
        $dateField = 'datetime';
        $dateFrom = $demand->getFromDate();
        if ($dateFrom) {
            $date = strtotime($dateFrom);
            if ($date) {
                $constraints[] = $query->greaterThanOrEqual($dateField, $date);
            }
        }
        $dateTo = $demand->getToDate();
        if ($dateTo) {
            $date = strtotime($dateTo);
            if ($date) {
                $date += 86400;
                $constraints[] = $query->lessThanOrEqual($dateField, $date);
            }
        }

        // categories
        $categories = $demand->getFilteredCategories();
        $categoryConstraint = null;
        if (!empty($categories)) {
            $categoryConstraintArr = [];
            foreach ($categories as $category) {
                $categoryConstraintArr[] = $query->contains('categories', $category);
            }
            $categoryConstraint = $query->logicalOr(...$categoryConstraintArr);
        }

        // tags
        $tags = $demand->getFilteredTags();
        $tagConstraint = null;
        if (!empty($tags)) {
            $tagConstraintArr = [];
            foreach ($tags as $tag) {
                $tagConstraintArr[] = $query->contains('tags', $tag);
            }
            $tagConstraint = $query->logicalOr(...$tagConstraintArr);
        }

        // Combine tag and category constraints with AND logic
        if ($categoryConstraint && $tagConstraint) {
            $constraints[] = $query->logicalAnd($categoryConstraint, $tagConstraint);
        } elseif ($categoryConstraint) {
            $constraints[] = $categoryConstraint;
        } elseif ($tagConstraint) {
            $constraints[] = $tagConstraint;
        }
    }
}
