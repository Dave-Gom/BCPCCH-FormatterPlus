            <div class="row m-3" id='clientes'>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title w-100 text-center">
                                Clientes
                            </h4>
                            <form id="ClientesInt" class="form-inline p-2">
                                <div class="form-group">
                                    Sucursal: 
                                    <br>
                                    <select required id="sucursal" class='form-control'>
                                        <option value="1" selected>Matriz</option>
                                        <option value="3">Suc Pedro Juan Caballero</option>
                                    </select>
                                </div>
                                
                                <label for="cliente" class="p-2">
                                    Nro Cliente: 
                                    <br>
                                    <input required type="text" class="form-control" placeholder="Numero de cliente" id="num_cliente" autocomplete="off">
                                </label>
                                <label for="docIdent" class="form-group p-2">
                                    Numero de Documento: 
                                    <br>
                                    <input required type="text" class="form-control" placeholder="Documento de identidad" id="docIdent" autocomplete="off">
                                </label>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="container" class="table table-bordered table-responsive-md"> 
                                <thead class="">
                                    <tr class=''>
                                        <th >Nro cliente</th>
                                        <th >Nombre</th>
                                        <th >CI</th>
                                        <th >Estatus</th>
                                        <th >User Block</th>
                                        <th ></th>
                                    </tr>
                                </thead>
                                <tbody id="tabla_clientes">

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>