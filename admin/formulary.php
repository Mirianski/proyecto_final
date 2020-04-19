    <div id="formulary">
        <h1>Nueva receta</h1>
        <form action="addRecipes.php" method="post" enctype="multipart/form-data">
            <div>
                <label for="name">Nombre de la receta:</label></br>
                <input type="text" id="name" name="name" required maxlength="60"/>
            </div>

            <div>
                <label for="description">Descripción:</label></br>
                <textarea rows="7" id="description" name="description" placeholder="Desriba brevemente en qué consiste el plato" required></textarea>
            </div>

            <div id="middleForm">
                <div>
                    <label for="type">Tipo de Receta:</label></br>
                    <select name="type" id="type" required>
                        <option>Seleccionar</option>
                        <?php echo $tipos_options; ?>
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
                <input type="file" name="image" id="image">
            </div>
            <div>
                <label for="time">Tiempo (min):</label></br>
                <input type="number" name="time" required />
            </div>

            <div>
                <label for="difficulty">Dificultad (1 - 5):</label></br>
                <input type="number" name="difficulty" required />
            </div>
            <input type="submit" id="sendFormulary" value="Crear receta" />
        </form>
    </div>