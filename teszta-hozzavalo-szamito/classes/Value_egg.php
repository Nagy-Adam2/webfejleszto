<?php

class Value_egg extends Raw_material
{
    private int $price;
    private string $unitTwo;
    private int $pieceTwo;
    
    public function getPrice(): int {
        return $this->price;
    }
    
    public function geUnitTwo(): string {
        return $this->unitTwo;
    }
    
    public function getPieceTwo(): int {
        return $this->pieceTwo;
    }
    
    public function __construct(string $name, string $unit, int $piece, int $width, int $height, int $price, string $unitTwo, int $pieceTwo)
    {
        parent::__construct($name, $unit, $piece, $width, $height);
        $this->price = $price;
        $this->unitTwo = $unitTwo;
        $this->pieceTwo = $pieceTwo;
    }
    
    #[\Override]
    public function ToXML(SimpleXMLElement $xmlElement): void
    {
        parent::ToXML($xmlElement);
        $ve = $xmlElement->addChild("Value_egg");
        $ve->addAttribute("price", $this->price);
        $ve->addAttribute("unit", $this->unitTwo);
        $ve->addAttribute("piece", $this->pieceTwo);
    }
}

?>
