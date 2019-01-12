<?php
class Taxonomists
{
    public function __construct()
    {
        //echo __CLASS__.' class instanciated!<br />';
    }

    public function __destruct()
    {
        //echo __CLASS__.' class destructed!<br />';
    }

    public function getTaxonomists($id, $order_by,$filter_by)
    {
        $id = (!$_GET['id'] || $id == 0 || $id == NULL) ? '' : ' AND tt.id IN ('.$_GET['id'].')';
        $order_by = (!$_GET['order_by'] || $order_by == NULL) ? 'id' : $_GET['order_by'];
        $filter_by = ($filter_by =='published') ? '' : ' OR tt.published = 0';
        $sql = 'SELECT
                    tt.id AS id, tt.name AS name, tt.description AS description, tt.note AS note, tt.image AS image, tt.published AS published
                FROM sp_taxonomists AS tt
                WHERE (tt.published = 1'.$filter_by.')'.$id.'
                ORDER BY tt.'.$order_by.'
                ;';

        return $sql;
    }

    public function getTaxonomist($id)
    {
        $sql = 'SELECT
                    tt.id AS id, tt.name AS name, tt.description AS description, tt.note AS note, tt.image AS image
                FROM sp_taxonomists AS tt
                WHERE tt.published = 1
                    AND tt.id = '.$id.'
                ;';

        return $sql;
    }

    public function getSpecies($id)
    {
        $sql = 'SELECT
                    sp.id AS spID, sp.year AS year
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
