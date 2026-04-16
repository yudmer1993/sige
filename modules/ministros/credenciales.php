<?php
include("../../includes/auth.php");
include("../../config/database.php");

$sql = "SELECT m.id, 
               m.usuario_id,
               m.tipo_ministro,
               m.estado_ministerial,
               u.usuario, 
               u.email, 
               u.nombres, 
               u.apellidos, 
               u.rol,
               u.estado,
               u.telefono,
               u.foto AS foto_usuario,
               i.nombre AS iglesia_nombre
        FROM ministros m
        LEFT JOIN usuarios u ON m.usuario_id = u.id
        LEFT JOIN iglesias i ON m.iglesia_dirige = i.id
        ORDER BY u.nombres ASC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credenciales de Ministros</title>
    <link rel="stylesheet" href="../../assets/css/ministros.css">
    <style>
        .header-panel {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 8px;
        }

        .header-panel h1 {
            color: white;
            margin: 0;
            font-size: 28px;
        }

        .header-panel p {
            color: rgba(255, 255, 255, 0.8);
            margin: 5px 0 0 0;
        }

        .view-toggle {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .view-btn {
            padding: 10px 16px;
            border: 2px solid #ddd;
            background: white;
            color: #333;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .view-btn.active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .view-btn:hover {
            border-color: #667eea;
        }

        .search-container {
            margin-bottom: 25px;
            display: flex;
            gap: 10px;
        }

        .search-container input {
            flex: 1;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .search-container input:focus {
            outline: none;
            border-color: #667eea;
        }

        .btn-excel {
            padding: 12px 20px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .btn-excel:hover {
            background-color: #229954;
        }

        .carnet-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .carnet-digital {
            perspective: 1000px;
            height: 100%;
        }

        .carnet-contenedor {
            position: relative;
            width: 100%;
            height: 520px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            padding: 20px;
            color: white;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.3s;
        }

        .carnet-digital:hover .carnet-contenedor {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
        }

        .carnet-header {
            text-align: center;
            border-bottom: 2px solid rgba(255, 255, 255, 0.3);
            padding-bottom: 12px;
            margin-bottom: 15px;
        }

        .carnet-titulo {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.8;
            font-weight: 600;
        }

        .carnet-logo {
            font-size: 24px;
            margin-top: 5px;
        }

        .carnet-body {
            flex: 1;
            display: flex;
            gap: 15px;
            align-items: flex-start;
        }

        .carnet-foto {
            width: 120px;
            height: 140px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .carnet-foto img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .carnet-info {
            flex: 1;
        }

        .carnet-nombre {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 8px;
            line-height: 1.2;
        }

        .carnet-miniatura {
            font-size: 11px;
            opacity: 0.9;
            margin-bottom: 10px;
            line-height: 1.3;
        }

        .carnet-dato {
            font-size: 10px;
            margin-bottom: 5px;
            display: flex;
            gap: 8px;
            opacity: 0.95;
        }

        .carnet-dato-label {
            min-width: 70px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .carnet-dato-valor {
            word-break: break-word;
        }

        .carnet-footer {
            border-top: 2px solid rgba(255, 255, 255, 0.3);
            padding-top: 12px;
            text-align: center;
            font-size: 9px;
            opacity: 0.85;
        }

        .carnet-id {
            font-family: 'Courier New', monospace;
            font-weight: 600;
            letter-spacing: 1px;
            margin-top: 3px;
        }

        .carnet-actions {
            display: flex;
            gap: 8px;
            margin-top: 15px;
            flex-wrap: wrap;
        }

        .carnet-btn {
            flex: 1;
            min-width: 100px;
            padding: 10px;
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid white;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            font-size: 11px;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            text-align: center;
        }

        .carnet-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
        }

        #carnetContainer {
            display: none;
        }

        #tablaContainer {
            display: block;
        }

        .credentials-card {
            background: white;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-left: 5px solid #667eea;
        }

        .credentials-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .minister-name {
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }

        .minister-meta {
            display: flex;
            gap: 10px;
            margin-top: 5px;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-type {
            background-color: #e3f2fd;
            color: #1976d2;
        }

        .badge-status {
            background-color: #f3e5f5;
            color: #7b1fa2;
        }

        .badge-status.activo {
            background-color: #e8f5e9;
            color: #388e3c;
        }

        .credentials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 15px;
        }

        .credential-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px;
            background: #f5f5f5;
            border-radius: 6px;
        }

        .credential-item label {
            min-width: 100px;
            font-weight: 600;
            color: #666;
            font-size: 12px;
            text-transform: uppercase;
        }

        .credential-item .value {
            flex: 1;
            font-family: 'Courier New', monospace;
            color: #333;
            word-break: break-all;
            font-size: 14px;
        }

        .copy-btn {
            padding: 6px 12px;
            background-color: #667eea;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: background-color 0.3s;
            white-space: nowrap;
        }

        .copy-btn:hover {
            background-color: #5568d3;
        }

        .copy-btn.copied {
            background-color: #27ae60;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .btn-link {
            padding: 8px 16px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 12px;
            transition: background-color 0.3s;
        }

        .btn-link:hover {
            background-color: #2980b9;
        }

        .btn-send {
            padding: 8px 16px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: background-color 0.3s;
        }

        .btn-send:hover {
            background-color: #229954;
        }

        .no-results {
            text-align: center;
            padding: 40px 20px;
            color: #999;
            background: white;
            border-radius: 8px;
        }

        .ministry-info {
            display: flex;
            gap: 20px;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #eee;
            font-size: 13px;
        }

        .info-col {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            color: #999;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .info-value {
            color: #333;
            font-weight: 600;
        }

        .photo-container {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            overflow: hidden;
            background: #f0f0f0;
        }

        .photo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .header-action {
            display: flex;
            gap: 10px;
        }

        @media print {
            .search-container,
            .action-buttons,
            .copy-btn,
            .header-action,
            .view-toggle,
            .carnet-actions,
            body > *:not(.carnet-digital) {
                display: none;
            }

            .carnet-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 20px !important;
                page-break-inside: avoid;
            }

            .carnet-contenedor {
                height: 480px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1) !important;
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>

<div class="page-wrapper">
    <div class="container">
        <div class="header-panel">
            <div>
                <h1>Credenciales de Ministros</h1>
                <p>Consulta de usuario y contraseña de acceso para ministros</p>
            </div>
            <div class="header-action">
                <button class="btn-excel" onclick="exportarExcel()">📊 Exportar Excel</button>
                <a href="listar.php" class="btn-excel" style="background-color: #95a5a6;">← Volver</a>
            </div>
        </div>

        <div class="search-container">
            <input type="text" id="busqueda" placeholder="Buscar por nombre, usuario o email..." onkeyup="filtrarCredenciales()">
        </div>

        <div class="view-toggle">
            <button class="view-btn active" onclick="cambiarVista('tabla')">📋 Vista Tabla</button>
            <button class="view-btn" onclick="cambiarVista('carnet')">🎫 Vista Carnet</button>
        </div>

        <div id="tablaContainer">
            <div id="credencialesContainer">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="credentials-card" data-search="<?php echo htmlspecialchars(strtolower($row['nombres'] . ' ' . $row['apellidos'] . ' ' . $row['usuario'] . ' ' . $row['email'])); ?>">
                        
                        <div class="credentials-card-header">
                            <div>
                                <div class="minister-name">
                                    <?php echo htmlspecialchars($row['nombres'] . " " . $row['apellidos']); ?>
                                </div>
                                <div class="minister-meta">
                                    <span class="badge badge-type"><?php echo ucfirst(htmlspecialchars($row['tipo_ministro'])); ?></span>
                                    <span class="badge badge-status <?php echo $row['estado_ministerial'] == 'activo' ? 'activo' : ''; ?>">
                                        <?php echo ucfirst(htmlspecialchars($row['estado_ministerial'])); ?>
                                    </span>
                                </div>
                            </div>
                            <?php if(!empty($row['foto_usuario'])): ?>
                                <div class="photo-container">
                                    <img src="../../uploads/<?php echo htmlspecialchars($row['foto_usuario']); ?>" alt="Foto">
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="credentials-grid">
                            <div class="credential-item">
                                <label>Usuario:</label>
                                <span class="value"><?php echo htmlspecialchars($row['usuario']); ?></span>
                                <button class="copy-btn" onclick="copiarAlPortapapeles('<?php echo htmlspecialchars($row['usuario']); ?>', this)">Copiar</button>
                            </div>

                            <div class="credential-item">
                                <label>Email:</label>
                                <span class="value"><?php echo htmlspecialchars($row['email']); ?></span>
                                <button class="copy-btn" onclick="copiarAlPortapapeles('<?php echo htmlspecialchars($row['email']); ?>', this)">Copiar</button>
                            </div>

                            <div class="credential-item">
                                <label>Rol:</label>
                                <span class="value"><?php echo htmlspecialchars($row['rol']); ?></span>
                            </div>

                            <div class="credential-item">
                                <label>Teléfono:</label>
                                <span class="value"><?php echo htmlspecialchars($row['telefono'] ?: '-'); ?></span>
                            </div>
                        </div>

                        <div class="ministry-info">
                            <div class="info-col">
                                <span class="info-label">Iglesia</span>
                                <span class="info-value"><?php echo !empty($row['iglesia_nombre']) ? htmlspecialchars($row['iglesia_nombre']) : 'No asignada'; ?></span>
                            </div>
                            <div class="info-col">
                                <span class="info-label">Estado</span>
                                <span class="info-value"><?php echo ucfirst(htmlspecialchars($row['estado'])); ?></span>
                            </div>
                        </div>

                        <div class="action-buttons" style="margin-top: 15px;">
                            <button class="btn-send" onclick="enviarCredenciales('<?php echo htmlspecialchars($row['email']); ?>', '<?php echo htmlspecialchars($row['nombres']); ?>')">
                                📧 Enviar Credenciales
                            </button>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-results">
                    <p>No hay ministros registrados.</p>
                </div>
            <?php endif; ?>
            </div>
        </div>

        <div id="carnetContainer">
            <div class="carnet-grid">
            <?php 
            // Reiniciar la consulta para la vista de carnet
            $result->data_seek(0);
            if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="carnet-digital" data-search="<?php echo htmlspecialchars(strtolower($row['nombres'] . ' ' . $row['apellidos'] . ' ' . $row['usuario'] . ' ' . $row['email'])); ?>">
                        <div class="carnet-contenedor">
                            <div class="carnet-header">
                                <div class="carnet-titulo">🕊️ CARNET DE MINISTRO</div>
                                <div class="carnet-logo">⛪</div>
                            </div>

                            <div class="carnet-body">
                                <?php if(!empty($row['foto_usuario'])): ?>
                                    <div class="carnet-foto">
                                        <img src="../../uploads/<?php echo htmlspecialchars($row['foto_usuario']); ?>" alt="Foto">
                                    </div>
                                <?php endif; ?>
                                
                                <div class="carnet-info">
                                    <div class="carnet-nombre">
                                        <?php echo htmlspecialchars($row['nombres'] . " " . $row['apellidos']); ?>
                                    </div>
                                    <div class="carnet-miniatura">
                                        <?php echo ucfirst(htmlspecialchars($row['tipo_ministro'])); ?>
                                    </div>
                                    
                                    <div class="carnet-dato">
                                        <span class="carnet-dato-label">Usuario:</span>
                                        <span class="carnet-dato-valor"><?php echo htmlspecialchars($row['usuario']); ?></span>
                                    </div>
                                    
                                    <div class="carnet-dato">
                                        <span class="carnet-dato-label">Email:</span>
                                        <span class="carnet-dato-valor" style="font-size: 9px;"><?php echo htmlspecialchars($row['email']); ?></span>
                                    </div>

                                    <div class="carnet-dato">
                                        <span class="carnet-dato-label">Iglesia:</span>
                                        <span class="carnet-dato-valor"><?php echo !empty($row['iglesia_nombre']) ? htmlspecialchars(substr($row['iglesia_nombre'], 0, 20)) : '-'; ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="carnet-footer">
                                <div class="carnet-id">ID: <?php echo str_pad($row['usuario_id'], 6, '0', STR_PAD_LEFT); ?></div>
                                <div style="margin-top: 5px;">Estado: <?php echo ucfirst(htmlspecialchars($row['estado'])); ?></div>
                            </div>

                            <div class="carnet-actions">
                                <button class="carnet-btn" onclick="copiarCarnetDatos('<?php echo htmlspecialchars($row['usuario']); ?>', '<?php echo htmlspecialchars($row['email']); ?>')">📋 Copiar</button>
                                <button class="carnet-btn" onclick="imprimirCarnet()">🖨️ Imprimir</button>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
            </div>
        </div>

        <div class="contenedor-volver" style="margin-top: 30px;">
            <a href="../../dashboard/dashboard.php" class="btn btn-silver">Volver al Dashboard</a>
        </div>
    </div>
</div>

<script>
function copiarAlPortapapeles(texto, boton) {
    navigator.clipboard.writeText(texto).then(function() {
        const textoOriginal = boton.textContent;
        boton.textContent = "✓ Copiado";
        boton.classList.add("copied");
        
        setTimeout(function() {
            boton.textContent = textoOriginal;
            boton.classList.remove("copied");
        }, 2000);
    }).catch(function(err) {
        alert("Error al copiar: " + err);
    });
}

function copiarCarnetDatos(usuario, email) {
    const datos = `Usuario: ${usuario}\nEmail: ${email}`;
    navigator.clipboard.writeText(datos).then(function() {
        alert("✓ Datos copiados al portapapeles");
    }).catch(function(err) {
        alert("Error al copiar: " + err);
    });
}

function filtrarCredenciales() {
    const searchValue = document.getElementById("busqueda").value.toLowerCase();
    const credCards = document.querySelectorAll(".credentials-card");
    const carnetCards = document.querySelectorAll(".carnet-digital");
    
    credCards.forEach(function(card) {
        const searchData = card.getAttribute("data-search");
        if (searchData.includes(searchValue)) {
            card.style.display = "";
        } else {
            card.style.display = "none";
        }
    });

    carnetCards.forEach(function(card) {
        const searchData = card.getAttribute("data-search");
        if (searchData.includes(searchValue)) {
            card.style.display = "";
        } else {
            card.style.display = "none";
        }
    });
}

function cambiarVista(vista) {
    const tablaContainer = document.getElementById("tablaContainer");
    const carnetContainer = document.getElementById("carnetContainer");
    const botones = document.querySelectorAll(".view-btn");
    
    botones.forEach(function(btn) {
        btn.classList.remove("active");
    });
    
    if (vista === "tabla") {
        tablaContainer.style.display = "block";
        carnetContainer.style.display = "none";
        botones[0].classList.add("active");
    } else {
        tablaContainer.style.display = "none";
        carnetContainer.style.display = "block";
        botones[1].classList.add("active");
    }
    
    // Replicar búsqueda si existe
    const searchInput = document.getElementById("busqueda");
    if (searchInput.value) {
        filtrarCredenciales();
    }
}

function exportarExcel() {
    const tabla = document.getElementById("credencialesContainer");
    let html = `<table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Teléfono</th>
                <th>Iglesia</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>`;
    
    document.querySelectorAll(".credentials-card").forEach(function(card) {
        const nombre = card.querySelector(".minister-name").textContent;
        const usuario = card.querySelector(".credential-item:nth-child(1) .value").textContent;
        const email = card.querySelector(".credential-item:nth-child(2) .value").textContent;
        const rol = card.querySelector(".credential-item:nth-child(3) .value").textContent;
        const telefono = card.querySelector(".credential-item:nth-child(4) .value").textContent;
        const iglesia = card.querySelector(".info-col:nth-child(1) .info-value").textContent;
        const estado = card.querySelector(".info-col:nth-child(2) .info-value").textContent;
        
        html += `<tr>
            <td>${nombre}</td>
            <td>${usuario}</td>
            <td>${email}</td>
            <td>${rol}</td>
            <td>${telefono}</td>
            <td>${iglesia}</td>
            <td>${estado}</td>
        </tr>`;
    });
    
    html += `</tbody></table>`;
    
    const wb = XLSX.utils.table_to_book(
        { html: html },
        { sheet: "Credenciales" }
    );
    
    // Fallback manual si XLSX no está disponible
    if (typeof XLSX === 'undefined') {
        const csv = generarCSV();
        descargarCSV(csv, 'credenciales_ministros.csv');
    } else {
        XLSX.writeFile(wb, 'credenciales_ministros_' + new Date().getTime() + '.xlsx');
    }
}

function generarCSV() {
    let csv = "Nombre,Usuario,Email,Rol,Teléfono,Iglesia,Estado\n";
    
    document.querySelectorAll(".credentials-card").forEach(function(card) {
        const nombre = card.querySelector(".minister-name").textContent;
        const usuario = card.querySelector(".credential-item:nth-child(1) .value").textContent;
        const email = card.querySelector(".credential-item:nth-child(2) .value").textContent;
        const rol = card.querySelector(".credential-item:nth-child(3) .value").textContent;
        const telefono = card.querySelector(".credential-item:nth-child(4) .value").textContent;
        const iglesia = card.querySelector(".info-col:nth-child(1) .info-value").textContent;
        const estado = card.querySelector(".info-col:nth-child(2) .info-value").textContent;
        
        csv += `"${nombre}","${usuario}","${email}","${rol}","${telefono}","${iglesia}","${estado}"\n`;
    });
    
    return csv;
}

function descargarCSV(csv, nombre) {
    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement("a");
    const url = URL.createObjectURL(blob);
    
    link.setAttribute("href", url);
    link.setAttribute("download", nombre);
    link.style.visibility = 'hidden';
    
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function enviarCredenciales(email, nombre) {
    if (confirm(`¿Enviar credenciales a ${email}?`)) {
        // Aquí iría la lógica para enviar credenciales por email
        alert(`Función de envío de credenciales a ${nombre} - A implementar con backend de email`);
        // fetch('../../services/enviar_credenciales.php', {
        //     method: 'POST',
        //     body: JSON.stringify({ email: email, nombre: nombre })
        // })
    }
}

function imprimirCarnet() {
    window.print();
}

// Función para imprimir
function imprimirCredenciales() {
    window.print();
}
</script>

</body>
</html>
