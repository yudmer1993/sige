<?php
include("../../config/database.php");

$id = $_GET["id"];

$sql = "SELECT * FROM iglesias WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<form method="POST" action="actualizar.php" class="form-grid">
    <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">

    <div class="form-group">
        <label>Nombre Iglesia</label>
        <input type="text" name="nombre" value="<?php echo $row["nombre"]; ?>" required>
    </div>

    <div class="form-group">
        <label>País</label>
        <input type="text" name="pais" value="<?php echo $row["pais"]; ?>">
    </div>

    <div class="form-group">
        <label>Ciudad</label>
        <input type="text" name="ciudad" value="<?php echo $row["ciudad"]; ?>">
    </div>

    <div class="form-group">
        <label>Dirección</label>
        <input type="text" name="direccion" value="<?php echo $row["direccion"]; ?>">
    </div>

    <div class="form-group">
        <label>Teléfono</label>
        <input type="text" name="telefono" value="<?php echo $row["telefono"]; ?>">
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="<?php echo $row["email"]; ?>">
    </div>

    <div class="form-group">
        <label>Fecha Fundación</label>
        <input type="date" name="fecha_fundacion" value="<?php echo $row["fecha_fundacion"]; ?>">
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-gold">Actualizar</button>
    </div>
</form>