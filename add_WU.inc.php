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
                                        <option value="1" selected>Matriz</option>
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
                                        <option value="CI">Cedula de identidad Paraguaya</option>
                                        <option value="RUC"> RUC </option>
                                        <option value="RPC">Identificaion Tributaria Paraguay</option>
                                        <option value="ADM">Admision Permanente</option>
                                        <option value="PAS">Pasaporte</option>
                                        <option value="CIA">Cedula de identidad Argentina</option>
                                        <option value="CIC">Cedula de identidad Chile</option>
                                        <option value="CIP">Paraguay</option>
                                        <option value="CIV">Cedula de identidad Venezuela</option>
                                        <option value="CPI">No posee Identificacion</option>
                                        <option value="DNI">DNI Argentina</option>
                                        <option value="FIC">Ficha del Cliente</option>
                                        <option value="IDE">Cedula de identidad Uruguay</option>
                                        <option value="INS">I.N.S.S Identificacion Laboral Brasil</option>
                                        <option value="IVA">Formulario IVA</option>
                                        <option value="LCI">Libreta Civica Argentina</option>
                                        <option value="OPS">Identificacion Laboral Resto del Mundo</option>
                                        <option value="REG"> Identifiacion registral todos los Paises</option>
                                        <option value="RG">Registro General</option>
                                        <option value="RPC">RPC - Identificacion Tributaria Paraguay</option>
                                        <option value="RUT">Registro Unico tributario Chile</option>
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