<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="../css/style.css" rel="stylesheet" />
</head>

<body>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">Importar de arquivo GPX</button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Carregar arquivo GPX</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Foram encontrados 4 Pontos de Passagem (Waypoints) no arquivo "Ponto de passagem_31-JUL-18"</p>
                    <p>Selicione quais deles deseja importar para o Banco de Dados</p>
                    <div class="form-group form-check form-gpx">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">
                            <div class="gpx">
                                <div class="title">Nome</div>
                                <div>001 Rio Preto do Itambé</div>
                            </div>
                            <div class="gpx">
                                <div class="title">Data</div>
                                <div>2017-06-10T11:39:26Z</div>
                            </div>
                            <div class="gpx">
                                <div class="title">Latitude</div>
                                <div>-19.409089</div>
                            </div>
                            <div class="gpx">
                                <div class="title">Longitude</div>
                                <div>-43.339934</div>
                            </div>
                        </label>
                    </div>
                    <div class="form-group form-check form-gpx">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">
                            <div class="gpx">
                                <div class="title">Nome</div>
                                <div>002 Rio Santo Antônio</div>
                            </div>
                            <div class="gpx">
                                <div class="title">Data</div>
                                <div>2017-06-10T15:59:52Z</div>
                            </div>
                            <div class="gpx">
                                <div class="title">Latitude</div>
                                <div>-19.236591</div>
                            </div>
                            <div class="gpx">
                                <div class="title">Longitude</div>
                                <div>-43.218512</div>
                            </div>
                        </label>
                    </div>
                    <div class="form-group form-check form-gpx">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">
                            <div class="gpx">
                                <div class="title">Nome</div>
                                <div>003 Rio Preto</div>
                            </div>
                            <div class="gpx">
                                <div class="title">Data</div>
                                <div>2017-06-10T17:57:22Z</div>
                            </div>
                            <div class="gpx">
                                <div class="title">Latitude</div>
                                <div>-19.248750</div>
                            </div>
                            <div class="gpx">
                                <div class="title">Longitude</div>
                                <div>-43.333412</div>
                            </div>
                        </label>
                    </div>
                    <div class="form-group form-check form-gpx">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">
                            <div class="gpx">
                                <div class="title">Nome</div>
                                <div>004 Rio do Peixe</div>
                            </div>
                            <div class="gpx">
                                <div class="title">Data</div>
                                <div>2017-06-10T19:18:47Z</div>
                            </div>
                            <div class="gpx">
                                <div class="title">Latitude</div>
                                <div>-19.287896</div>
                            </div>
                            <div class="gpx">
                                <div class="title">Longitude</div>
                                <div>-43.287340</div>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info">Importar para o Banco de Dados</button>
                    <button type="button" class="btn btn btn-outline-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
