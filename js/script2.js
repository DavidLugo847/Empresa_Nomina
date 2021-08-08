
    function Mostrar(){
        document.getElementById("caja").style.display = "block";
        document.getElementById("caja").style.position = "absolute";
        document.getElementById("caja").style.height = "200%";

    }
    function Ocultar(){
        document.getElementById("caja").style.display = "none";    }
    function Mostrar_Ocultar(){
        var caja = document.getElementById("caja");
        
        if(caja.style.display == "none"){
            Mostrar();
            document.getElementById("boton").value = "Ocultar";
        }
        else{
            Ocultar();
            document.getElementById("boton").value = "Mostrar";
        }
    }
    
    

