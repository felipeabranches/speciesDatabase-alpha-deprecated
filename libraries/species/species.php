<?php

class Species
{
    public $sql;

    /*
     *
     */
    function getNomenclature($id)
    {
        global $mysqli;

        $sql = 'SELECT
                    sp.genus AS genus, sp.specie AS species, sp.dubious AS dubious
                FROM sp_species as sp
                WHERE sp.id = '.$id.'
                ';

        $result = mysqli_query($mysqli, $sql);
        $result_check = mysqli_num_rows($result);

        if ($result_check > 0)
        {
            $row = mysqli_fetch_object($result);

            // Associates integer data to its corresponding HTML
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

            // If species isn't blank return a space and the value
            $species = (!$row->species) ? '' : ' '.$row->species;

            // Put all nomenclature information into a variable
            $nomenclature = '<em>'.$row->genus.$dubious.$species.'</em>';

            return $nomenclature;
        }
    }

    /*
     *
     */
    function getAuthoring($id)
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
                ';

        $result = mysqli_query($mysqli, $sql);
        $result_check = mysqli_num_rows($result);

        if ($result_check > 0)
        {
            $row = mysqli_fetch_object($result);
 
            // If a species has authorig, return its value (eg: a genus sp. wouldn't have, and shouldn't return nothing)
            if ($row->taxonomists)
            {
                // Process how to display the taxonomists
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

                // Put all authoring information into a variable, with parentesis only if it's revised
                $authoring = $taxonomist.', '.$row->year;
                if($row->revised)
                {
                    $authoring = '('.$authoring.')';
                }

                return $authoring;
            }
        }
    }
    
    function getSynonims($id)
    {
        global $mysqli;
        
        $sql = 'SELECT
                    sp.id AS id, sp.validate AS validate, sp.redirect AS redirect
                FROM sp_species AS sp
                WHERE sp.id = '.$id.'
                
                ';
        

        $result = mysqli_query($mysqli, $sql);
        $result_check = mysqli_num_rows($result);

        if ($result_check > 0)
        {
            
            while ($row = mysqli_fetch_object($result))
            {
             
            if (!$row->redirect)
            {   
                echo 'No entries for synonims';
            }
            
           
            
                if ($row->redirect)
                {   
                    if (!$row->validate)
                    {
                        $id_redirect = $row->redirect;
                        $synonim = $this->getNomenclature   ($id_redirect);
                            return $synonim;
                    
                    }
                
                }   
                
            }
                
        }
        
    }   

}

?>


