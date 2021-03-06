<?php

namespace SMS\StoreBundle\Repository;

/**
 * DeliveryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PurchaseRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Get purchases price by price
     *
     * @param SMS/EstablishmentBundle/Entity/Establishment $establishment
     * @return array
     */
    public function findPurchasePriceByMonth($establishment)
    {
        return $this->createQueryBuilder('purchase')
                  ->select("sum(purchaseLine.price * purchaseLine.quantity) as price, MONTH(purchase.purchaseDate) AS month, establishment.id")
                  ->join('purchase.purchaseLines', 'purchaseLine')
                  ->join('purchase.establishment', 'establishment')
                  ->where('establishment.id = :establishment')
                  ->andWhere('purchase.state = 1')
                  ->setParameter('establishment', $establishment->getId())
                  ->groupBy('month')
                  ->getQuery()
                  ->getResult();
    }

    /**
     * Get purchases price by price
     *
     * @param SMS/EstablishmentBundle/Entity/Establishment $establishment
     * @return array
     */
    public function findPurchasePrice($establishment)
    {
        return $this->createQueryBuilder('purchase')
                  ->select(" sum(purchaseLine.price * purchaseLine.quantity) as price, purchase.purchaseDate AS month, establishment.id")
                  ->join('purchase.purchaseLines', 'purchaseLine')
                  ->join('purchase.establishment', 'establishment')
                  ->where('establishment.id = :establishment')
                  ->andWhere('purchase.state = 1')
                  ->setParameter('establishment', $establishment->getId())
                  ->groupBy('purchase')
                  ->getQuery()
                  ->getResult();
    }

    /**
     * Get purchases price by product
     *
     * @param SMS/StoreBundle/Entity/Product $product
     * @return array
     */
    public function findPurchasePriceByProduct($product)
    {
        return $this->createQueryBuilder('purchase')
                  ->select(" sum(purchaseLine.price * purchaseLine.quantity) as price, purchase.purchaseDate AS month")
                  ->join('purchase.purchaseLines', 'purchaseLine')
                  ->join('purchaseLine.product', 'product')
                  ->where('product.id = :product')
                  ->andWhere('purchase.state = 1')
                  ->setParameter('product', $product->getId())
                  ->groupBy('purchase')
                  ->getQuery()
                  ->getResult();
    }

    /**
     * Get purchases price by Provider
     *
     * @param SMS/StoreBundle/Entity/Provider $provider
     * @return array
     */
    public function findPurchasePriceByProvider($provider)
    {
        return $this->createQueryBuilder('purchase')
                  ->select(" sum(purchaseLine.price * purchaseLine.quantity) as price, purchase.purchaseDate AS month")
                  ->join('purchase.purchaseLines', 'purchaseLine')
                  ->join('purchase.provider', 'provider')
                  ->where('provider.id = :provider')
                  ->andWhere('purchase.state = 1')
                  ->setParameter('provider', $provider->getId())
                  ->groupBy('purchase')
                  ->getQuery()
                  ->getResult();
    }
}
