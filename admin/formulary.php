    <div id="formulary">
        <h1>Nueva receta</h1>
        <form action="addRecipes.php" method="post" enctype="multipart/form-data">
            <div>
                <label for="name">Nombre de la receta:</label></br>
                <input type="text" id="name" name="name" required/>
            </div>

            <div id="middleForm">
                <div>
                    <label for="type">Tipo de Receta:</label></br>
                    <select name="type" id="type" required>
                        <option>Seleccionar</option>
                        <?php echo $tipos_options;?>
                    </select>
                </div>

                <div>
                    <label for="ingredients">Ingredientes:</label></br>
                    <textarea rows="7" id="ingredients" name="ingredients" placeholder="Ponga uno debajo de otro junto a las cantidades/medidas" required></textarea>
                </div>
            </div>
            <div>
                <label for="steps">Preparación:</label></br>
                <textarea rows="9" id="steps" name="steps" placeholder="Preparación..." required></textarea>
            </div>
            <div>
                <label for="image">Imagen:</label></br>
                <input type="file" name="imagen" id="imagen">
            </div>
            <div>
                <label for="image">Tiempo (min):</label></br>
                <input type="number" name="tiempo" required/>
            </div>
            
            <div>
                <label for="image">Dificultad (1 - 5):</label></br>
                <input type="number" name="dificultad" required/>
            </div>
            <input type="submit" id="sendFormulary" value="Crear receta" />
        </form>
    </div>