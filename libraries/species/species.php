<?php
class Species
{
    public function __construct()
    {
        //echo __CLASS__.' class instanciated!<br />';
    }

    public function __destruct()
    {
        //echo __CLASS__.' class destructed!<br />';
    }

    /*
     *  $id             int     The Species' ID.
     *  $stripTags      bool    0 for maintain <em> and <abbr> on Nomenclature, 1 for strip. Default 0.
     */
    public function getNomenclature($id, $stripTags = 0)
    {
        global $mysqli;

        $sql = 'SELECT
                    sp.genus AS genus, sp.specie AS species, sp.dubious AS dubious
                FROM sp_species as sp
                WHERE sp.id = '.$id.'
                ;';

        $result = mysqli_query($mysqli, $sql);

        if (!$result->num_rows)
        {
            return 'Species not found!';
        }
        else
        {
            $row = mysqli_fetch_object($result);

            // Associates Dubious' integer data to its corresponding HTML
            switch ($row->dubious)
            {
                case 0:
                    $dubious = '';
                    break;
                case 1:
                    $dubious = ' <abbr title="affinis">aff.</abbr>';
                    break;
                case 2:
                    $dubious = ' <abbr title="conferre">cf.</abbr>';
                    break;
                case 3:
                    $dubious = ' <abbr title="species">sp.</abbr>';
                    break;
                default:
                    $dubious = '';
            }

            // If Species isn't blank return a space and the value
            $species = (!$row->species) ? '' : ' '.$row->species;

            // Put all Nomenclature information into a variable
            $nomenclature = '<em>'.$row->genus.$dubious.$species.'</em>';

            // If stripTags' on, then strip tags from Nomenclature
            if ($stripTags) $nomenclature = strip_tags($nomenclature);

            return $nomenclature;
        }
    }

    /*
     *  $id             int     The Species' ID
     *  $yearSeparator  string  Wich string separates the Taxonomists from the Year. Default ' '
     */
    public function getAuthoring($id, $yearSeparator = ' ')
    {
        global $mysqli;

        $sql = 'SELECT
                    sp.revised AS revised, sp.year AS year,
                    GROUP_CONCAT(tt.name) AS taxonomists
                FROM sp_taxonomists_map AS sptt
                LEFT JOIN sp_species AS sp
                    ON sptt.id_specie = sp.id
                LEFT JOIN sp_taxonomists AS tt
                    ON sptt.id_taxonomist = tt.id
                WHERE sp.id = '.$id.'
                GROUP BY sp.id
                ;';

        $result = mysqli_query($mysqli, $sql);

        if ($result->num_rows)
        {
            $row = mysqli_fetch_object($result);
 
            // If a Species has Authorig, return its value (eg: a Genus sp. wouldn't have, and shouldn't return nothing)
            if ($row->taxonomists)
            {
                // Process how to display the Taxonomists
                $taxonomist = explode(',', $row->taxonomists);
                if (count($taxonomist) == 1)
                {
                    $taxonomist = $row->taxonomists;
                }
                else
                {
                    $last = array_pop($taxonomist);
                    $firsts = implode(', ', $taxonomist);
                    $taxonomist = sprintf('%s & %s', $firsts, $last);
                }

                // Put all Authoring information into a variable
                $authoring = $taxonomist.$yearSeparator.$row->year;

                // Put Authoring inside a parentesis only if it's revised
                if ($row->revised) $authoring = '('.$authoring.')';

                return $authoring;
            }
        }
    }

    /*
     *  $id     int     The Species' ID
     */
    public function getSynonyms($id)
    {
        $sql = 'SELECT
                    sp.id AS id
                FROM sp_species AS sp
                WHERE sp.redirect = '.$id.'
                    AND sp.validate = 0
                ;';

        return $sql;
    }
}
?>
