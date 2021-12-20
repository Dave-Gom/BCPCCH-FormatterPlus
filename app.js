$(document).ready( () => {
    
    $('#operaciones').on('change', async function(){
        //instancia un nuevo abjeto de datos y le asigna el archivo subido
        let data = new FormData();
        data.append('file', operaciones.files[0]);

        await fetch('upload.php', {method: 'POST', body: data});

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
        request.open("POST", "editar.php" , true);
        request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        request.send(excluidos);
        
        const downloadFile = async (file) => {
            const element = document.createElement('a');
            element.setAttribute('href', 'download/'+file);
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
            del.open("POST", "delete.php" , true);
            del.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            del.send(borrar);
        }
    });
});