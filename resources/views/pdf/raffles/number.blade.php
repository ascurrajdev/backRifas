<html>
    <style>
        @page{
            font-family:'Helvetica';
            margin:0;
            padding:0;
            background-color: whitesmoke;
            /* color:dimgray; */
        }
        .flex{
            display: flex;
        }
        .flex-center{
            align-items: center;
            justify-content: center;
        }
        .text-center{
            text-align: center;
        }
        .left{
            float:left;
        }
        .numberContainer{
            background-color: skyblue;
            color:white;
            border-radius: 0px 0px 5px 0px;
            height:2cm;
            width:3cm;
        }
        .px-1{
            padding-left: 1em;
            padding-right: 1em;
        }
        .border{
            border: 1px solid black;
        }
        .titleContainer{
            height: 2cm;
            width: 100%;
        }
        .container-header{
            width: 20cm;
            height: 2cm;
            margin:0;
        }
        .container-body{
            margin-left:10px;
            list-style: none;
            font-size: small;
        }
        .container-footer{
            color:gray;
            text-align: center;
            font-size: 14px;
            height: 1cm;
            margin:0;
        }
        .a-none{
            text-decoration:none;
            text-decoration-style: none;
        }
        .list-none{
            list-style: none;
            margin:0;
        }
    </style>
    <body>
        <div class="container-header">
            <div class="left numberContainer">
                <h2 class="px-1 text-center">N. 67</h2>
            </div>
            <div class="left titleContainer">
                <h4 class="px-1">Rifa Solidaria</h4>
            </div>
        </div>
        <div class="container-body">
            <li>Nombre: Jose Ascurra</li>
            <li>Telefono: 0991631870</li>
            <li>Correo: joseascurra123@gmail.com</li>
            <li>Vendedor: Jose Ascurra</li>
        </div>
        <img src="" alt="" />
        <div class="container-footer">
            <p>Desarrollado por <a class="a-none" href="www.ascurrajdev.co">ascurrajdev</a></p>
        </div>
    </body>
</html>