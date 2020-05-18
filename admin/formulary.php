<div id="formulary">
    <?php if (!isset($_GET['editar_receta'])) : ?>
        <h1>Publicar nueva receta</h1>
        <div id="nueva-receta">
        <form action="addRecipes.php" method="post" enctype="multipart/form-data">
    <?php else : ?>
        <h1>Editar receta</h1>
        <form action="addRecipes.php?actualizar_receta=<?php echo $_GET['editar_receta'] ?>" method="post" enctype="multipart/form-data">
        <div id="nueva-receta">
    <?php endif; ?>
            <div>
                <label for="nombre">Nombre de la receta:</label></br>
                <input type="text" id="nombre" name="nombre" maxlength="60" <?php if ($plato  && isset($plato["nombre"])) echo 'value="' . $plato["nombre"] . '"' ?> required />
            </div>

            <div>
                <label for="descripcion">Descripción:</label></br>
                <textarea rows="7" id="descripcion" name="descripcion" placeholder="Desriba brevemente en qué consiste el plato" required><?php if ($plato && isset($plato["descripcion"])) echo htmlentities ($plato["descripcion"]); ?></textarea>
            </div>

            <div>
                <label for="tipo">Tipo de Receta:</label></br>
                <select name="tipo" id="tipo" required>
                    <option>Seleccionar</option>
                    <?php echo $tipos_options; ?>
                </select>
            </div>

            <div id="contenedor-etiquetas">
                <label>Etiquetas:</label>
                <?php echo $etiquetas_checkboxes; ?>
            </div>

            <div>
                <label for="ingredientes">Ingredientes:</label></br>
                <textarea rows="7" id="ingredientes" name="ingredientes" placeholder="Ponga uno debajo de otro junto a las cantidades/medidas" required><?php if ($plato && isset($plato["ingredientes"])) echo str_replace("<br />", "", $plato["ingredientes"]) ?> </textarea>
            </div>
            <div>
                <label for="preparacion">Preparación:</label></br>
                <textarea rows="9" id="preparacion" name="preparacion" placeholder="Preparación..." required><?php if ($plato && isset($plato["preparacion"])) echo str_replace("<br />", "", $plato["preparacion"]); ?></textarea>
            </div>
            <div class="input-number">
                <label for="imagen">Imagen:</label></br>
                <?php if (isset($plato) && $plato["imagen"]) : ?>
                    <br>
                    <a href="<?php echo "../uploads/" . $plato["imagen"] ?>" target="_blank"><img src="<?php echo "../uploads/" . $plato["imagen"] ?>" width="150" ?></a>
                <?php endif; ?>
                <input type="file" name="imagen" id="imagen" />
            </div>
            <div class="input-number">
                <label for="tiempo">Tiempo (min):</label></br>
                <input type="number" name="tiempo" min="1" <?php if (isset($plato) && isset($plato["tiempo"])) echo 'value="' . $plato["tiempo"] . '"' ?> required />
            </div>
            <div class="input-number">
                <label for="dificultad">Dificultad (1 - 5):</label></br>
                <input type="number" name="dificultad" min="1" max="5" <?php if (isset($plato) && isset($plato["dificultad"])) echo 'value="' . $plato["dificultad"] . '"' ?> required />
            </div>
            <div class="input-number">
                <label for="num_personas">Num. personas:</label></br>
                <input type="number" name="num_personas" min="1" <?php if (isset($plato) && isset($plato["num_personas"])) echo 'value="' . $plato["num_personas"] . '"' ?> required />
            </div>
            <?php if (!isset($_GET['editar_receta'])) : ?>
                <input type="submit" id="sendFormulary" value="Crear receta" />
            <?php else : ?>
                <input type="submit" id="sendFormulary" value="Actualizar receta" />
            <?php endif; ?>
            </form>
            </div>
</div>