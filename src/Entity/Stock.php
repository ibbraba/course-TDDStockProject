<?php

namespace App\Entity;

use App\Repository\StockRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StockRepository::class)
 */
class Stock
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=4)
     */
    public  $symbol;

    /**
     * @ORM\Column(type="string", length=5)
     */
    public  $currency;

    /**
     * @ORM\Column(type="string", precision=10, scale=0)
     */
    public  $exchangeName;

    /**
     * @ORM\Column(type="float", precision=10, scale=0, nullable=true)
     */
    public  $priceChange;

    /**
     * @ORM\Column(type="float", precision=10, scale=0, nullable=true)
     */
    public  $price;

    /**
     * @ORM\Column(type="float", precision=10, scale=0, nullable=true)
     */
    public  $previousClose;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public  $shortName;

    /**
     * @ORM\Column(type="string", length=5)
     */
    public  $region;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): self
    {
        $this->symbol = $symbol;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getExchangeName(): ?string
    {
        return $this->exchangeName;
    }

    public function setExchangeName(string $exchangeName): self
    {
        $this->exchangeName = $exchangeName;

        return $this;
    }

    public function getPriceChange(): ?float
    {
        return $this->priceChange;
    }

    public function setPriceChange(float $priceChange): self
    {
        $this->priceChange = $priceChange;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPreviousClose(): ?float
    {
        return $this->previousClose;
    }

    public function setPreviousClose(float $previousClose): self
    {
        $this->previousClose = $previousClose;

        return $this;
    }

    public function getShortName(): ?string
    {
        return $this->shortName;
    }

    public function setShortName(string $shortName): self
    {
        $this->shortName = $shortName;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }
}
