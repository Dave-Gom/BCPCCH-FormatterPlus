            <div class="row" id='WU'>
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title w-100 text-center">
                                Añadir Cliente Western Union
                            </h4>
                            <form id="ClienteExt">
                                <div class="form-group">
                                    Sucursal:
                                    <select required id="sucursal" class='form-control'>
                                        <option value="">Seleciona</option>
                                        <option value="1">Matriz</option>
                                        <option value="3">Suc Pedro Juan Caballero</option>
                                    </select>
                                </div>
                                
                                    <label for="cliente" class="w-100">
                                        Numero de Cliente:
                                        <input required type="text" class="form-control" placeholder="Numero de cliente" id="cliente" autocomplete="off">
                                    </label>
                                
                                <div class="form-group">
                                    Tipo de documento:
                                    <select id="tipo_documento" class='form-control' required>
                                        <option value="">Seleciona</option>
                                        <option value="CI">CI</option>
                                        <option value="ADM">Pasaporte</option>
                                    </select>
                                </div>
                                <label for="docIdent" class="form-group w-100">
                                    Numero de Documento:
                                    <input required type="text" class="form-control" placeholder="Documento de identidad" id="docIdent" autocomplete="off">
                                </label>
                                
                                <button id="format"  type="submit" class="btn btn-dark btn-block text-center">Agregar</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    
                </div>
            </div>