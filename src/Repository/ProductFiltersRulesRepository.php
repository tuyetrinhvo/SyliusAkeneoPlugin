<?php

declare(strict_types=1);

namespace Synolia\SyliusAkeneoPlugin\Repository;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Synolia\SyliusAkeneoPlugin\Entity\ProductFiltersRules;

final class ProductFiltersRulesRepository extends EntityRepository
{
    public function getProductFiltersRules(): ?ProductFiltersRules
    {
        $productfiltersRules = $this->findAll();
        if (count($productfiltersRules) === 0) {
            return null;
        }

        return $productfiltersRules[0];
    }
}
