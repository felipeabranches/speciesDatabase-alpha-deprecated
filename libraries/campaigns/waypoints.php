<?php
class Waypoints
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
    
    public function getWaypoints($id, $order_by)
    {
        $id = (!$_GET['id'] || $id == 0 || $id == NULL) ? '' : ' AND wpt.id IN ('.$_GET['id'].')';
        $order_by = (!$_GET['order_by'] || $order_by == NULL) ? 'id' : $_GET['order_by'];

        $sql = 'SELECT
                    wpt.id AS id, wpt.name AS name, wpt.place AS place, wpt.latitude AS latitude, wpt.longitude AS longitude, wpt.elevation AS elevation, wpt.time As time, wpt.note AS note, wpt.image AS image,
                    unit.name AS unit,
                    untt.name AS unitType
                FROM camp_waypoints AS wpt
                LEFT JOIN camp_units AS unit
                    ON unit.id = wpt.id_unit
                LEFT JOIN camp_units_types AS untt
                    ON untt.id = unit.id_type
                WHERE wpt.published = 1'.$id.'
                ORDER BY wpt.'.$order_by.'
                ;';
        
        return $sql;
    }

    public function getWaypoint($id)
    {
        $sql = 'SELECT
                    wpt.id AS id, wpt.name AS name, wpt.latitude AS latitude, wpt.longitude AS longitude, wpt.description AS description, wpt.note AS note, wpt.image AS image
                FROM camp_waypoints AS wpt
                WHERE wpt.published = 1
                    AND wpt.id = '.$id.'
                ';
        
        return $sql;
    }
    
    public function getTombs($id)
    {
        $sql = 'SELECT
                    tb.id AS tombID, tb.name AS tomb, tb.specie_count AS n, tb.note AS tbNote,
                    wpt.id AS wptID, wpt.name AS waypoint, wpt.note AS wptNote,
                    sp.id AS spID, CONCAT(sp.genus, " ", sp.specie) AS nomenclature
                FROM camp_tombs AS tb
                LEFT JOIN camp_waypoints AS wpt
                    ON wpt.id = tb.id_waypoint
                LEFT JOIN sp_species AS sp
                    ON sp.id = tb.id_specie
                WHERE wpt.published = 1
                    AND wpt.id = '.$id.'
                ORDER BY tb.id
                ;';

        return $sql;
    }

    public function getCampaigns($id)
    {
        $sql = 'SELECT
                    DISTINCT cp.id AS id, cp.name AS name, cp.note AS note
                FROM camp_tombs AS tb
                LEFT JOIN camp_campaings AS cp
                    ON cp.id = tb.id_campaing
                LEFT JOIN camp_waypoints AS wpt
                    ON wpt.id = tb.id_waypoint
                WHERE tb.published = 1
                    AND wpt.id = '.$id.'
                ORDER BY cp.id
                ';

        return $sql;
    }

}
?>