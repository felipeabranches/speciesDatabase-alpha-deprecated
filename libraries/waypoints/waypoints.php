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
                FROM wpt_waypoints AS wpt
                LEFT JOIN wpt_units AS unit
                    ON unit.id = wpt.id_unit
                LEFT JOIN wpt_units_types AS untt
                    ON untt.id = unit.id_type
                WHERE wpt.published = 1'.$id.'
                ORDER BY wpt.'.$order_by.'
                ;';
        
        //if ($debug_mode) echo $sql;

        return $sql;
    }

    public function getWaypoint($id)
    {
        $sql = 'SELECT
                    wpt.id AS id, wpt.name AS name, wpt.latitude AS latitude, wpt.longitude AS longitude, wpt.description AS description, wpt.note AS note, wpt.image AS image
                FROM wpt_waypoints AS wpt
                WHERE wpt.published = 1
                    AND wpt.id = '.$id.'
                ';
        
        return $sql;
    }
    
    public function getCampaigns($id)
    {
        $sql = 'SELECT
                    DISTINCT cp.id AS id, cp.name AS name, cp.note AS note
                FROM camp_tombs AS tb
                LEFT JOIN camp_campaigns AS cp
                    ON cp.id = tb.id_campaign
                LEFT JOIN wpt_waypoints AS wpt
                    ON wpt.id = tb.id_waypoint
                WHERE tb.published = 1
                    AND wpt.id = '.$id.'
                ORDER BY cp.id
                ';

        //if ($debug_mode) echo $sql;

        return $sql;
    }

}
?>
