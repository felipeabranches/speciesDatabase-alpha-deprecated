<?php
class Campaigns
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
    
    public function getCampaigns($id, $order_by)
    {
        $id = (!$_GET['id'] || $id == 0 || $id == NULL) ? '' : ' AND cp.id IN ('.$_GET['id'].')';
        $order_by = (!$_GET['order_by'] || $order_by == NULL) ? 'id' : $_GET['order_by'];

        $sql = 'SELECT
                    cp.id AS id, cp.name AS name, cp.entity AS entity, cp.date AS date, cp.note AS note, cp.image AS image
                FROM camp_campaigns AS cp
                WHERE cp.published = 1'.$id.'
                ORDER BY cp.'.$order_by.'
                ;';
        
        return $sql;
    }

    public function getCampaign($id)
    {
        $sql = 'SELECT
                    cp.id AS id, cp.name AS name, cp.entity AS entity, cp.date AS date, cp.description AS description, cp.note AS note, cp.image AS image
                FROM camp_campaigns AS cp
                WHERE cp.published = 1
                    AND cp.id = '.$id.'
                ';
        
        return $sql;
    }

    public function getWaypoints($id)
    {
        $sql = 'SELECT
                    DISTINCT wpt.id AS wptID, wpt.name AS name, wpt.note AS note
                FROM camp_tombs AS tb
                LEFT JOIN camp_campaigns AS cp
                    ON cp.id = tb.id_campaign
                LEFT JOIN wpt_waypoints AS wpt
                    ON wpt.id = tb.id_waypoint
                WHERE tb.published = 1
                    AND cp.id = '.$id.'
                ORDER BY wpt.id
                ';

        return $sql;
    }

}
?>
