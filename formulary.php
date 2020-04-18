<html>

<head>

</head>

<body>

    <?php
    include('static.html');
    ?>
    <div id="formulary">
        <h1>¡Envía tu receta!</h1>
        <form action="sendFormulary.php" method="POST">
            <div>
                <label for="name">Nombre</label></br>
                <input type="text" id="name" name="name"/>
            </div>

            <div>
                <label for="email">Email</label></br>
                <input type="text" id="email" name="email"/>
            </div>

            <div id="middleForm">
                <div>
                    <label for="type">Tipo de Receta</label></br>
                    <select name="type" id="type">
                        <option>Seleccionar</option>
                        <option value="1"> Entrantes </option>
                        <option value="2"> Pescados </option>
                        <option value="4"> Carnes </option>
                        <option value="5"> Postres </option>
                        <option value="6"> Básicos </option>
                        <option value="7"> Otros </option>
                    </select>
                </div>

                <div>
                    <label for="ingredients"> Ingredientes:</label></br>
                    <textarea rows="7" id="ingredients" name="ingredients" placeholder="Ponga uno debajo de otro junto a las cantidades/medidas"></textarea>
                </div>
            </div>
            <div>
                <label for="steps"> Preparación</label></br>
                <textarea rows="9" id="steps" name="steps" placeholder="Preparación..."></textarea>
            </div>


            <input type="submit" id="sendFormulary" value="Enviar receta" />
        </form>
    </div>

    
</body>

</html>