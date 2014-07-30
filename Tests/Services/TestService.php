<?php
namespace Ssa\SsaBundle\Services;

use ssa\SsaBundle\Entity\Product;
use Doctrine\ORM\EntityManager;

/**
 * Description of TestService
 *
 * @author thomas
 */
class TestService {
 
    /**
     *
     * @var EntityManager 
     */
    private $doctrine;
    
    public function __construct($doctrine) {
        $this->doctrine = $doctrine;
    }
    
    /**
     * 
     * @param \ssa\SsaBundle\Entity\Product $product the product to add
     */
    public function insertProduct(Product $product) {
        $this->doctrine->persist($product);
        $this->doctrine->flush();
        return $product;
    }
    
    /**
     * return the product info
     * 
     * @param \ssa\SsaBundle\Entity\Product $product
     * @return \ssa\SsaBundle\Entity\Product
     */
    public function getProductInfo(Product $product) {
        return $product;
    }
}
