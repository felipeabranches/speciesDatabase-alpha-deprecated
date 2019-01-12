<?php
/*
 *  Taxa recursive tree
 */
function taxa_recursive_tree($id)
{
    global $mysqli;
    $sql = 'SELECT t.id AS id, t.name AS name, t.id_parent AS parentId, t.id_type AS level, tt.name AS typeName
                FROM sp_taxa AS t
            LEFT JOIN sp_taxa_types AS tt
                ON t.id_type = tt.id
            WHERE t.published = 1
                AND id_parent = '.$id.'
            ORDER BY t.name
            ';
    
    if(!$result = mysqli_query($mysqli, $sql))
    {
        echo '<span>No entries</span>';
    }
    else
    {
        while($taxon = mysqli_fetch_object($result))
        {
            $i = 0;
            if ($i == 0) echo '<ul>';
            echo '<li><span class="badge badge-light">'.$taxon->name.'</span>';
            taxa_recursive_tree($taxon->id);
            
            // Species class
            require_once 'libraries/species/species.php';
            $species = new Species();

            $subsql = 'SELECT
                        sp.id AS id, sp.image AS img
                    FROM sp_taxonomists_map AS tx_map
                    LEFT JOIN sp_species AS sp
                        ON tx_map.id_specie = sp.id
                    LEFT JOIN sp_taxonomists AS tx
                        ON tx_map.id_taxonomist = tx.id
                    WHERE sp.published = 1
                        AND validate = 1
                        AND sp.id_taxon = '.$taxon->id.'
                    GROUP BY sp.id
                    ORDER BY sp.genus, sp.specie
                    ';
            if($subresult = mysqli_query($mysqli,$subsql))
            {
                if($subresult->num_rows)
                {
                    echo '<ul>'."\n";
                    while($sp = mysqli_fetch_object($subresult))
                    {
                        echo '<li>'."\n";
                        // Nomenclature
                        echo '<span class="badge badge-light"><a href="specie.php?id='.$sp->id.'" target="_blank">'.$species->getNomenclature($sp->id).' </a></span>'."\n";
                        // Authoring
                        if($species->getAuthoring($sp->id)) echo ' <span class="badge badge-light">'.$species->getAuthoring($sp->id).'</span>'."\n";
                        // Image
                        echo ($sp->img != '' && file_exists($sp->img)) ? '<i class="fas fa-image"></i>' : '';

                        // Tombed badges
                        $tomb = 'SELECT sp.id AS spID
                                FROM camp_tombs AS t
                                LEFT JOIN sp_species AS sp
                                    ON sp.id = t.id_specie
                                WHERE t.published = 1
                                    AND sp.id = '.$sp->id.'
                                ';
                        if ($tombed = mysqli_query($mysqli, $tomb))
                        {
                            if ($tombed->num_rows)
                            {
                                echo ' <span class="badge badge-primary">Tombado</span>'."\n";
                            }
                            // Free result set
                            mysqli_free_result($tombed);
                        }
                        echo '</li>'."\n";
                    }
                    echo '</ul>'."\n";
                    // Free result set
                    mysqli_free_result($subresult);
                }
            }
            echo '</li>';
            $i++;
            if($i > 0) echo '</ul>';
        }
    }
    mysqli_free_result($result);
}
?>
