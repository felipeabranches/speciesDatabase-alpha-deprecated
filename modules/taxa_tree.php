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
    
    if($result = mysqli_query($mysqli, $sql))
    {
        while($taxon = mysqli_fetch_object($result))
        {
            $i = 0;
            if ($i == 0) echo '<ul>';
            echo '<li><span class="badge badge-light">'.$taxon->name.'</span>';
            taxa_recursive_tree($taxon->id);

            $subsql = 'SELECT sp.id AS id, sp.gender AS gender, sp.specie AS specie, sp.dubious AS dubious, sp.year AS year, sp.revised AS revised, GROUP_CONCAT(tx.name) AS taxonomists
                    FROM sp_taxonomists_map AS tx_map
                    LEFT JOIN sp_species AS sp
                        ON tx_map.id_specie = sp.id
                    LEFT JOIN sp_taxonomists AS tx
                        ON tx_map.id_taxonomist = tx.id
                    WHERE sp.published = 1
                        AND validate = 1
                        AND sp.id_taxon = '.$taxon->id.'
                    GROUP BY sp.id
                    ORDER BY sp.gender, sp.specie
                    ';
            if($subresult = mysqli_query($mysqli,$subsql))
            {
                if($subresult->num_rows)
                {
                    echo '<ul>'."\n";
                    while($specie = mysqli_fetch_object($subresult))
                    {
                        // Nomenclature
                        switch($specie->dubious)
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
                                $dubious = ' <abbr title="specie">sp.</abbr>';
                                break;
                            default:
                                $dubious = '';
                        }
                        $nomenclature = $specie->gender.$dubious.' '.$specie->specie;
                        // Identification
                        $taxonomist = explode(',', $specie->taxonomists);
                        if(count($taxonomist) == 1)
                        {
                            $taxonomist = $specie->taxonomists;
                        }
                        else
                        {
                            $last = array_pop($taxonomist);
                            $firsts = implode(', ', $taxonomist);
                            $taxonomist = sprintf('%s & %s', $firsts, $last);
                        }
                        if(!$specie->revised)
                        {
                            $identification = $taxonomist.', '.$specie->year;
                        }
                        else
                        {
                            $identification = '('.$taxonomist.', '.$specie->year.')';
                        }
                        echo '<li>'."\n";
                        echo '<a class="badge badge-id" href="specie.php?id='.$specie->id.'" target="_blank">'.$nomenclature.' </a>'."\n";
                        if($taxonomist) echo ' <span class="badge badge-light">'.$identification.'</span>'."\n";
                        //echo (!$specie->tombs) ? '' : ' <span class="badge badge-primary">Tombado</span>'."\n";
                        /*echo ' <span class="badge badge-brd">BRD*</span>'."\n";
                        echo ' <span class="badge badge-danger">Gênero</span>'."\n";
                        echo ' <span class="changed">Leporinus mormyrops</span>'."\n";*/
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
    else
    {
        echo 'No entries';
    }
    mysqli_free_result($result);
}
?>