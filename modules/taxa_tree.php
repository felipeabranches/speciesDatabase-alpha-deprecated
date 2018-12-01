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

            $subsql = 'SELECT
                        sp.id AS id, sp.genus AS genus, sp.specie AS specie, sp.dubious AS dubious, sp.year AS year, sp.revised AS revised, sp.image AS img,
                        GROUP_CONCAT(tx.name) AS taxonomists
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
                        // Nomenclature
                        switch($sp->dubious)
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
                        $nomenclature = $sp->genus.$dubious.' '.$sp->specie;
                        // Identification
                        $taxonomist = explode(',', $sp->taxonomists);
                        if(count($taxonomist) == 1)
                        {
                            $taxonomist = $sp->taxonomists;
                        }
                        else
                        {
                            $last = array_pop($taxonomist);
                            $firsts = implode(', ', $taxonomist);
                            $taxonomist = sprintf('%s & %s', $firsts, $last);
                        }
                        $identification = (!$sp->revised) ? $taxonomist.' '.$sp->year : '('.$taxonomist.' '.$sp->year.')';
                        echo '<li>'."\n";
                        echo '<span class="badge badge-light"><a href="specie.php?id='.$sp->id.'" target="_blank">'.$nomenclature.' </a></span>'."\n";
                        if($taxonomist) echo ' <span class="badge badge-light">'.$identification.'</span>'."\n";
                        // Image
                        echo ($sp->img != '' && file_exists($sp->img)) ? '<i class="fas fa-image"></i>' : '';

                        $tomb = 'SELECT sp.id AS spID
                                FROM camp_tombs AS t
                                LEFT JOIN sp_species AS sp
                                    ON sp.id = t.id_specie
                                WHERE t.published = 1
                                    AND sp.id = '.$sp->id.'
                                ';
                        if($result1=mysqli_query($mysqli,$tomb))
                        {
                            if($result1->num_rows)
                            {
                                echo ' <span class="badge badge-primary">Tombado</span>'."\n";
                            }
                            // Free result set
                            mysqli_free_result($result1);
                        }
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
    mysqli_free_result($result);
}
?>