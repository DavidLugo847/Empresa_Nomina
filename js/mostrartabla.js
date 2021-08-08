function Mostrar2(){
        document.getElementById("caja2").style.display = "block";

    }
        function MostrarCaja1(){
        document.getElementById("caja1").style.display = "block";

        }
    function Ocultar2(){
        document.getElementById("caja2").style.display = "none";    }
    function OcultarCaja1(){
        document.getElementById("caja1").style.display = "none";    }
    
    
    function Mostrar_Ocultar2(){
        var caja = document.getElementById("caja2");
        var caja1 = document.getElementById("caja1");
        
        
        if(caja1.style.display == "none"){
            MostrarCaja1();
        }
        else{
            OcultarCaja1();
        }
        if(caja.style.display == "none"){
            Mostrar2();
            document.getElementById("boton").value = "Ocultar";
        }
        else{
            Ocultar2();
            document.getElementById("boton").value = "Mostrar";
        }
    }