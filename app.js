$(document).ready( () => {
    /* Edicion de Informe transferencias diarias */
    if( document.getElementById('operaciones')){
        $('#operaciones').on('change', async function(){
            //instancia un nuevo abjeto de datos y le asigna el archivo subido
            let data = new FormData();
            data.append('file', operaciones.files[0]);
    
            await fetch('Backend/upload.php', {method: 'POST', body: data});
    
        });
    
        $("#transf").submit( function(event){
            event.preventDefault();
            const excl = $("#excl").val().split('\n');
            var excluidos = "data="+JSON.stringify(excl);
            //console.log(excluidos);
    
            /* Ajax */
            var request = new XMLHttpRequest();
            
            request.onload = function() {
                //console.log(this.responseText);
                alert("DOCUMENTO CORREGIDO EXITOSAMENTE");
                downloadFile(this.responseText)
                .then(
                    remuve(this.responseText)
                );
                
            }
            request.open("POST", "Backend/editar.php" , true);
            request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            request.send(excluidos);
            
            const downloadFile = async (file) => {
                const element = document.createElement('a');
                element.setAttribute('href', 'Backend/download/'+file);
                element.setAttribute('download', file);
              
                element.style.display = 'none';
              
                document.body.appendChild(element);
              
                element.click();
                document.body.removeChild(element);
    
    
            }
    
            async function remuve(file){
                var del = new XMLHttpRequest();
                let borrar = 'nombre='+file;
                del.onload = function(){
                    console.log(this.responseText);
                }
                del.open("POST", "Backend/delete.php" , true);
                del.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                del.send(borrar);
            }
        });
    }

    /* Añadir cliente WU */
    if( document.getElementById('WU')){
        document.getElementById('ClienteExt').addEventListener("submit", (e)=>{
            e.preventDefault();
            let sucursal = document.getElementById("sucursal").value;
            let numero_cliente = document.getElementById('cliente').value;
            let tipo_doc = document.getElementById('tipo_documento').value;
            let id = document.getElementById('docIdent').value;
            let cliente = {
                            Suc: sucursal,
                            CtdId: numero_cliente,
                            CtdTDoc: tipo_doc,
                            CtdDoc: id};
            let clienteI = JSON.stringify(cliente);
            data = new FormData();
            fetch( 'Backend/clientes_wu.php', {method:'POST', 
                headers:{'Content-Type': 'application/json'},
                body: clienteI})
                .then((res)=>{ 
                    return res.json(); 
                })
                .then((data)=>{ 
                    // console.log(data);
                    let respuesta = JSON.parse(data);
                    if( respuesta.error == null){
                        alert(respuesta.exito);
                        window.location.href = 'http://localhost/VSHCP/formato_BCP/ClientesWU.php';
                    } 
                    else
                        alert("NO se pudo completar la operacion: "+respuesta.error);
                    
                })
                .catch(
                    (error)=>{
                        console.error(error);
                    }
                )
        });
    }

    /* operaciones con Clientes internos */
    if(document.getElementById('clientes')){
        const objNCliente = document.getElementById('num_cliente');
        const sucursal = document.getElementById('sucursal');
        const muestra_clientes = ()=>{
            let Ncliente = objNCliente.value;
            let data = {cliente: Ncliente, suc: sucursal.value};
            let info = JSON.stringify(data);
            fetch('Backend/clientes_int.php', {method:'POST', 
                headers:{'Content-Type': 'application/json'},
                body: info
            })
            .then(
                (res)=>{
                    return res.json();
                }
            )
            .then( 
                (respuesta)=>{
                    // console.log(respuesta);
                    let template = '';
                    let bloc;
                    let desbloc, habilitar, cDes, chab, habli, bloque;
                    respuesta.forEach(cliente => {
                        bloc = cliente.bloc != '' ? 'Bloq': 'Desbloq';
                        if( cliente.bloc == ""){
                            desbloc = "Desbloquado";
                            cDes = 'success';
                            bloque = "disabled";
                        }
                        else{
                            desbloc = "Desbloquear";
                            cDes = 'danger';
                            bloque = '';
                        }
                        if(cliente.status == 'HAB'){
                            habilitar = 'Habilitado';
                            chab = 'success';
                            habli = "Disabled";
                        }
                        else{
                            habilitar = 'Habilitar';
                            chab = 'danger';
                            habli = '';
                        }
                        template += `
                            <tr cliente='${cliente.idCliente}'>
                                <td >${cliente.idCliente}</td>
                                <td >${cliente.name}</td>
                                <td>${cliente.ci}</td>
                                <td>
                                    <span class="badge badge-pill badge-${chab}">${cliente.status}</span>
                                </td>
                                <td>
                                    <span class="badge badge-pill badge-${cDes}">${bloc}</span>
                                </td>
                                <td>
                                    <div class="container">
                                        <div class="row">
                                            
                                                <button class="m-1 btn col-sm-5 hablilitar   btn-${chab}" ${habli}>${habilitar}</button>
                                                <button class=" m-1 btn col-sm-5 desbloquear btn-${cDes}" ${bloque}>${desbloc}</button>
                                            
                                        </div>
                                    </div> 
                                </td>
                            </tr>`;
                    });
                    //console.log(respuesta);
                    document.getElementById("tabla_clientes").innerHTML = template;
                }
            )
        }
        objNCliente.addEventListener("keyup", (e)=>{
            if(objNCliente.value && sucursal.value != null){
                muestra_clientes();
            }
        })

        if(document.getElementsByClassName("habilitar")){
            $(document).on('click','.hablilitar', function(){
                let element = $(this)[0].parentElement.parentElement.parentElement.parentElement;
                let cliente =$(element).attr('cliente');
                let sucursal = document.getElementById('sucursal').value;
                let hablilitar = {cliente: cliente, suc: sucursal};
                console.log(hablilitar);
                fetch('Backend/hablilitar.php', {method: "POST", 
                    headers:{'Content-Type': 'application/json'},
                    body: JSON.stringify(hablilitar)
                })
                .then(
                    res =>{
                        return res.json();
                    }
                )
                .then(
                    data =>{
                        let respuesta = JSON.parse(data);
                        console.log(respuesta);
                        if( respuesta.error === 'null' ){
                            alert(respuesta.exito);
                            muestra_clientes();
                        } 
                        else
                            alert("NO se pudo completar la operacion: "+respuesta.error);
                        }
                )
                // .catch(
                //     err =>{
                //         console.error(err);
                //     }
                // )
            })

            document.addEventListener('click', (e)=>{
                if(e.target.matches('.desbloquear')){
                    let element = e.target.parentElement.parentElement.parentElement.parentElement;
                    let cliente = element.getAttribute('cliente');
                    let sucursal = document.getElementById('sucursal').value;
                    let desbloquear = {cliente: cliente, suc: sucursal};
                    console.log(desbloquear);
                    fetch('Backend/desbloquear.php', {method: "POST", 
                        headers:{'Content-Type': 'application/json'},
                        body: JSON.stringify(desbloquear)
                    })
                    .then(
                        res =>{
                            return res.json();
                        }
                    )
                    .then(
                        data =>{
                            let respuesta = JSON.parse(data);
                            console.log(respuesta);
                            if( respuesta.error === 'null' ){
                                alert(respuesta.exito);
                                muestra_clientes();
                            } 
                            else
                                alert("NO se pudo completar la operacion: "+respuesta.error);
                            }
                    )
                    .catch(
                            err =>{
                                console.error(err);
                            }
                    )
                }
            })
        }
    }
});