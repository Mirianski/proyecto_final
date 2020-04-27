<div id="formulary">
    <h1>Nueva receta</h1>
    <form action="addRecipes.php" method="post" enctype="multipart/form-data">
        <div>
            <label for="nombre">Nombre de la receta:</label></br>
            <input type="text" id="nombre" name="nombre"  maxlength="60" 
            <?php if($plato  && isset($plato["nombre"])) echo 'value="'.$plato["nombre"].'"'?> required/>
        </div>

        <div>
            <label for="descripcion">Descripción:</label></br>
            <textarea rows="7" id="descripcion" name="descripcion" placeholder="Desriba brevemente en qué consiste el plato" 
            <?php if($plato && isset($plato["descripcion"])) echo 'value="'.$plato["descripcion"].'"'?> required></textarea>
        </div>

        <div>
            <label for="tipo">Tipo de Receta:</label></br>
            <select name="tipo" id="tipo" required>
                <option>Seleccionar</option>
                <?php echo $tipos_options; ?>
            </select>
        </div>

        <div>
            <label>Etiquetas:</label></br>
            <?php echo $etiquetas_checkboxes; ?>
        </div>

        <div>
            <label for="ingredientes">Ingredientes:</label></br>
            <textarea rows="7" id="ingredientes" name="ingredientes" placeholder="Ponga uno debajo de otro junto a las cantidades/medidas" 
            <?php if($plato && isset($plato["ingredientes"])) echo 'value="'.$plato["ingredientes"].'"'?> required></textarea>
        </div>
        <div>
            <label for="preparacion">Preparación:</label></br>
            <textarea rows="9" id="preparacion" name="preparacion" placeholder="Preparación..."  
            <?php if($plato && isset($plato["preparacion"])) echo 'value="'.$plato["preparacion"].'"'?> required></textarea>
        </div>
        <div>
            <label for="imagen">Imagen:</label></br>
            <input type="file" name="imagen" id="imagen" <?php if($plato) echo 'value="'.$plato["imagen"].'"'?> />
        </div>
        <div>
            <label for="tiempo">Tiempo (min):</label></br>
            <input type="number" name="tiempo" <?php if($plato && isset($plato["tiempo"])) echo 'value="'.$plato["tiempo"].'"'?> required />
        </div>
        <div>
            <label for="dificultad">Dificultad (1 - 5):</label></br>
            <input type="number" name="dificultad" <?php if($plato && isset($plato["dificultad"])) echo 'value="'.$plato["dificultad"].'"'?> required />
        </div>
        <div>
            <label for="num_personas">Num. personas:</label></br>
            <input type="number" name="num_personas"  <?php if($plato && isset($plato["num_personas"])) echo 'value="'.$plato["num_personas"].'"'?> required />
        </div>
        <input type="submit" id="sendFormulary" value="Crear receta" />
    </form>
</div>