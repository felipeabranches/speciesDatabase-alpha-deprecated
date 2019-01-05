<?php include_once '../../init.php'; ?>
<?php
class Species
{
    public $sql;

    function getNomenclature()
    {
        global $mysqli;

        $sql = 'SELECT
                    sp.id AS id, sp.genus AS genus, sp.specie AS specie, sp.dubious AS dubious
                FROM sp_species as sp
                ORDER BY id
                ';

        $result = mysqli_query($mysqli, $sql);
        $result_check = mysqli_num_rows($result);

        if ($result_check > 0)
        {
            // Imprime as abreviações se uma especie e dubious
            while ($row = mysqli_fetch_assoc($result))
            {
                $dubious = $row['dubious'];

                if ($dubious == 0)
                {
                    echo $row['id'] . ' ' . $row['genus'] . ' ' . $row['specie'] . "<br>";
                }

                if ($dubious == 1)
                {
                    echo $row['id'] . ' ' . $row['genus'] . ' ' . 'affinis' . "<br>";
                }

                if ($dubious == 2)
                {
                    echo $row['id'] . ' ' . $row['genus'] . ' ' . 'cf.'.' '.$row['specie'] . "<br>";
                }

                if ($dubious == 3)
                {
                    echo $row['id'] . ' ' . $row['genus'] . ' ' . $row['specie'] . 'sp.'. "<br>";
                }
            }
        }
    }

    function getTaxonomists()
    {
        global $mysqli;
        
        $sql = 'SELECT
                    sp.id AS id, sp.revised AS revised, sp.year AS year, 
                    GROUP_CONCAT(tt.name) AS taxonomists
                FROM sp_taxonomists_map AS sptt
                LEFT JOIN sp_species AS sp
                    ON sptx.id_specie = sp.id
                LEFT JOIN sp_taxonomists AS tt
                    ON sptx.id_taxonomist = tt.id 
                WHERE sp.published = 1
                    AND sp.validate = 1
                GROUP BY sp.id
                ';
        
        $result = mysqli_query($mysqli, $sql);
        $result_check = mysqli_num_rows($result);

        if ($result_check > 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                // Consulta o numero de taxonomistas, se esta revisado e o ano, imprime de acordo com o tratamento necessario
                $taxonomist = explode (',', $row['taxonomists']);
                $count = count ($taxonomist);
                $revised = $row['revised'];
                $year = $row['year'];

                if ($count == 1 AND $revised== 1)
                {
                    echo $row['id']. ' '.'('.$row['taxonomists'] .' '. $year.')'."<br>";
                }

                if ($count == 1 AND $revised !=1)
                {
                    echo $row['id']. ' '.$row['taxonomists'] .' '. $year."<br>";
                }

                if ($count!=1 AND $revised ==1)
                {
                    $last = array_pop ($taxonomist);
                    $firsts = implode (',', $taxonomist);
                    $taxonomist = sprintf ('%s & %s', $firsts, $last);
                    echo $row['id'].' '.'('. $taxonomist .' '. $year.')'. "<br>";
                }

                if ($count!=1 AND $revised !=1)
                {
                    $last = array_pop ($taxonomist);
                    $firsts = implode (',', $taxonomist);
                    $taxonomist = sprintf ('%s & %s', $firsts, $last);
                    echo $row['id'].' '. $taxonomist .' '. $year. "<br>";
                }

                /*
                $last = array_pop ($taxonomist);
                $firsts = implode (',', $taxonomist);
                $taxonomist = sprintf ('%s & %s', $firsts, $last);
                echo $row['id'].' '. $taxonomist . "<br>";
                */
            }
        }
    }
}

// TESTANDO OBJETO DA CLASSE
$teste = new Species();
// TESTANDO A FUNCAO DA CLASSE
$teste->getNomenclature();

$teste2 = new Species();
$teste2->getTaxonomists();
?>
