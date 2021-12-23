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
});