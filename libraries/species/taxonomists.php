<?php
class Taxonomists
{
    public $prop1 = "Sou um propriedade de classe!";

    public function __construct()
    {
        //echo 'A classe "', __CLASS__, '" foi instanciada!<br />';
    }

    public function __destruct()
    {
        //echo 'A classe "', __CLASS__, '" foi destruída.<br />';
    }

    public function __toString()
    {
        echo "Usando o método toString: ";
        return $this->getProperty();
    }

    public function setProperty($newval)
    {
        $this->prop1 = $newval;
    }

    public function getProperty()
    {
        return $this->prop1 . "<br />";
    }
    
    public function getTaxonomists($id, $order_by)
    {
        $id = (!$_GET['id'] || $id == 0 || $id == NULL) ? '' : ' AND tt.id IN ('.$_GET['id'].')';

        $sql = 'SELECT tt.id AS ttID, tt.name AS author, tt.description AS description, tt.note AS note, tt.image AS image
                FROM sp_taxonomists AS tt
                WHERE tt.published = 1'.$id.'
                ORDER BY tt.'.$order_by.'
                ;';
        
        return $sql;
    }

    public function getTaxonomist($id)
    {
        $sql = 'SELECT tt.id AS ttID, tt.name AS author, tt.description AS description, tt.note AS note, tt.image AS image
                FROM sp_taxonomists AS tt
                WHERE tt.published = 1
                    AND tt.id = '.$id.'
                ;';
        
        return $sql;
    }

    public function getSpecies($id)
    {
        $sql = 'SELECT sp.id AS spID, CONCAT(sp.genus, " ", sp.specie) AS nomenclature, sp.year AS year
                FROM sp_taxonomists AS tt
                LEFT JOIN sp_taxonomists_map AS sptt
                    ON tt.id = sptt.id_taxonomist
                LEFT JOIN sp_species AS sp
                    ON sp.id = sptt.id_specie
                WHERE tt.published = 1
                    AND tt.id = '.$id.'
                    AND sp.published = 1
                    AND sp.validate = 1
                ;';
        
        return $sql;
    }

}
?>