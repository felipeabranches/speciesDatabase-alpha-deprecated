<?php
include_once '../../init.php';
?>
<?php
class Description {
 
    public $sql;
   
    
        function getDescription() {
            global $mysqli;
            
            $sql =  'SELECT
                        sp.id AS id, sp.genus AS genus, sp.specie AS specie, sp.dubious AS dubious, sp.year AS year, sp.revised AS revised, sp.image AS img,
                        GROUP_CONCAT(tx.name) AS taxonomists
                    FROM sp_taxonomists_map AS tx_map
                    LEFT JOIN sp_species AS sp
                        ON tx_map.id_specie = sp.id
                    LEFT JOIN sp_taxonomists AS tx
                        ON tx_map.id_taxonomist = tx.id
                    WHERE sp.published = 1
                        AND validate = 1
                       
                    GROUP BY sp.id
                    ORDER BY id
                    ';
                       
                        
                                        
                                                    ;
              $result = mysqli_query($mysqli,$sql);
              $result_check = mysqli_num_rows($result);
            
                if ($result_check > 0 ) {
                                   
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    echo ' '.$row['id'] . ' ' . $row['genus'] . ' ' . $row['specie'] . ' , catalogado por ' . $row ['taxonomists'] . "<br>";
                                     
                                    
                   
                                                                               }
                                        }
            
            
            
     
               
                                 }

                        }
$teste = new Description(); // TESTANDO OBJETO DA CLASSE
$teste->getDescription();   //TESTANDO A FUNCAO DA CLASSE


?>




     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
