<?php
class Tombs
{
    public function __construct()
    {
        //if ($debug_mode) echo 'A classe "', __CLASS__, '" foi instanciada!<br />';
    }

    public function __destruct()
    {
        //if ($debug_mode) echo 'A classe "', __CLASS__, '" foi destruída!<br />';
    }

    /*
     *  $id         int or array
     *  $where      string
     *  $order_by   string
     */
    public function getTombs($id, $where, $order_by)
    {
        $clause  = ($id || $where) ? 'WHERE ' : '';
        $clause .= ($id != 0) ? 'tb.id IN ('.$_GET['id'].')' : '';
        $clause .= ($id && $where) ? ' AND ' : '';
        $clause .= ($where) ? $where : '';
        
        $order_by = (!$order_by || $order_by == NULL) ? 'tb.id' : $_GET['order_by'];
        
        $sql = 'SELECT
                    tb.id AS tbID, tb.name AS tomb, tb.entity AS tbEntity, tb.date AS tbDate, tb.specie_count AS n, tb.note AS tbNote, tb.published AS published,
                    cp.id AS cpID, cp.name AS campaign, cp.date AS cpDate, cp.entity AS cpEntity,
                    wpt.id AS wptID, wpt.name AS waypoint, wpt.place AS place, wpt.latitude AS latitude, wpt.longitude AS longitude, wpt.note AS wptNote,
                    un.name AS unit,
                    sp.id AS spID, sp.genus AS genus, sp.specie AS specie
                FROM camp_tombs AS tb
                LEFT JOIN camp_campaigns AS cp
                    ON cp.id = tb.id_campaign
                LEFT JOIN wpt_waypoints AS wpt
                    ON wpt.id = tb.id_waypoint
                LEFT JOIN wpt_units AS un
                    ON un.id = wpt.id_unit
                LEFT JOIN sp_species AS sp
                    ON sp.id = tb.id_specie
                '.$clause.'
                ORDER BY '.$order_by.
                ';';
        
        //if ($debug_mode) echo '<pre>'.$sql.'</pre>';

        return $sql;
    }

    /*
     *  $id         int or array
     *  $where      string
     *  $order_by   string
     *  $scope      string (tb, cp, wpt, sp)
     */
    public function getTinyTombs($id, $where, $order_by, $scope)
    {
        $sql  = 'SELECT
                    tb.id AS tbID, tb.name AS tomb, tb.specie_count AS n, tb.note AS tbNote,
                    cp.id AS cpID, cp.name AS campaign,
                    wpt.id AS wptID, wpt.name AS waypoint, wpt.note AS wptNote,
                    sp.id AS spID, CONCAT(sp.genus, " ", sp.specie) AS nomenclature
                FROM camp_tombs AS tb
                LEFT JOIN camp_campaigns AS cp
                    ON cp.id = tb.id_campaign
                LEFT JOIN wpt_waypoints AS wpt
                    ON wpt.id = tb.id_waypoint
                LEFT JOIN sp_species AS sp
                    ON sp.id = tb.id_specie'."\n";
        $sql .= ($where) ? ' '.$where : ' ';
        $sql .= ($scope != 'tb') ? ' AND '.$scope.'.id = '.$id : ' ';
        $sql .= ' ORDER BY '.$order_by.
        $sql .= ';';
        
        //if ($debug_mode) echo '<pre>'.$sql.'</pre>';

        return $sql;
    }
    
    public function getTomb($id)
    {
        $sql = '';
        
        return $sql;
    }

}
?>
