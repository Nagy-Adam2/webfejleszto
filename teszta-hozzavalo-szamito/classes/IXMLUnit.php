<?php

interface IXMLUnit
{
    function ToXML(SimpleXMLElement $xmlElement) : void;
    static function FromXML(SimpleXMLElement $xmlElement) : Raw_material;
}

?>