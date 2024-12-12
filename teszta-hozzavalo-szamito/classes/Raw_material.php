<?php

abstract class Raw_material implements IXMLUnit
{
    private string $name, $unit;
    private int $piece, $width, $height;
    
    public function getName(): string {
        return $this->name;
    }

    public function getUnit(): string {
        return $this->unit;
    }

    public function getPiece(): int {
        return $this->piece;
    }

    public function getWidth(): int {
        return $this->width;
    }

    public function getHeight(): int {
        return $this->height;
    }
    
    protected function __construct(string $name, string $unit, int $piece, int $width, int $height)
    {
        $this->name = $name;
        $this->unit = $unit;
        $this->piece = $piece;
        $this->width = $width;
        $this->height = $height;
    }
    
    public function __toString(): string
    {
        return "Raw_material[name=" . $this->name
                . ", unit=" . $this->unit
                . ", piece=" . $this->piece
                . ", width=" . $this->width
                . ", height=" . $this->height
                . "]";
    }
    
    #[\Override]
    public function ToXML(SimpleXMLElement $xmlElement): void
    {
        $xmlElement->addAttribute("name", $this->name);
        $xmlElement->addAttribute("unit", $this->unit);
        $xmlElement->addAttribute("piece", $this->piece);
        $xmlElement->addAttribute("width", $this->width);
        $xmlElement->addAttribute("height", $this->height);
    }
    
    #[\Override]
    public static function FromXML(SimpleXMLElement $xmlElement): Raw_material
    {
        $child = null;
        foreach ($xmlElement->children() as $subElement)
        {
            $child = $subElement;
            break;
        }
        if($child !== null)
        {
            switch($child->getName())
            {
                case "Value_egg":
                    return new Value_egg($xmlElement["name"], $xmlElement["unit"], intval($xmlElement["piece"]), intval($xmlElement["width"]), intval($xmlElement["height"]), intval($child["price"]), $child["unit"], intval($child["piece"]));
                case "Value_flour":
                    return new Value_flour($xmlElement["name"], $xmlElement["unit"], intval($xmlElement["piece"]), intval($xmlElement["width"]), intval($xmlElement["height"]), intval($child["price"]), $child["unit"], intval($child["piece"]));
                case "Value_sugar":
                    return new Value_sugar($xmlElement["name"], $xmlElement["unit"], intval($xmlElement["piece"]), intval($xmlElement["width"]), intval($xmlElement["height"]), intval($child["price"]), $child["unit"], intval($child["piece"]));
            }
        }
        throw new XMLParseException("A megadott XML node nem feldolgozható!");
    }
}

?>


