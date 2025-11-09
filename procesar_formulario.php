<?php
// Verificar que el formulario fue enviado por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Recibir y limpiar los datos del formulario
    $nombre = htmlspecialchars($_POST['nombre']);
    $email = htmlspecialchars($_POST['email']);
    $telefono = htmlspecialchars($_POST['telefono'] ?? 'No proporcionado');
    $pais = htmlspecialchars($_POST['pais']);
    $region = htmlspecialchars($_POST['region']);
    $presupuesto = htmlspecialchars($_POST['presupuesto'] ?? 'No especificado');
    $fecha_viaje = htmlspecialchars($_POST['fecha_viaje'] ?? 'No especificada');
    $duracion = htmlspecialchars($_POST['duracion'] ?? 'No especificada');
    $personas = htmlspecialchars($_POST['personas']);
    $tipo_turismo = htmlspecialchars($_POST['tipo_turismo']);
    
    // Procesar actividades (checkboxes - array)
    $actividades = isset($_POST['actividades']) ? $_POST['actividades'] : [];
    $actividades_texto = !empty($actividades) ? implode(', ', $actividades) : 'Ninguna seleccionada';
    
    $mensaje = htmlspecialchars($_POST['mensaje']);
    
    // Traducir valores para mejor presentación
    $regiones_nombres = [
        'costa' => 'Costa',
        'sierra' => 'Sierra',
        'amazonia' => 'Amazonía',
        'galapagos' => 'Galápagos',
        'todas' => 'Todas las regiones'
    ];
    
    $tipos_turismo = [
        'natural' => '🌿 Natural - Ecoturismo y vida silvestre',
        'cultural' => '🏛️ Cultural - Historia y tradiciones',
        'aventura' => '🏔️ Aventura - Deportes extremos y trekking',
        'gastronomico' => '🍽️ Gastronómico - Sabores auténticos'
    ];
    
    $region_nombre = $regiones_nombres[$region] ?? $region;
    $tipo_turismo_nombre = $tipos_turismo[$tipo_turismo] ?? $tipo_turismo;
    
} else {
    // Si no se envió por POST, redirigir al formulario
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud Recibida - Ecuador Turístico</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0f1115 0%, #1a1a2e 100%);
            color: #e0e0e0;
            padding: 2rem;
            min-height: 100vh;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            margin-bottom: 3rem;
            padding: 2rem;
            background: linear-gradient(135deg, #16213e 0%, #1a1a2e 100%);
            border-radius: 20px;
            border: 1px solid rgba(160, 216, 239, 0.3);
        }
        
        .header h1 {
            color: #a0d8ef;
            font-size: 2.5rem;
            margin-bottom: 1rem;
            background: linear-gradient(90deg, #a0d8ef, #e63946);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .success-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        
        .subtitle {
            color: #b0bec5;
            font-size: 1.2rem;
        }
        
        .data-table {
            background: #16213e;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(160, 216, 239, 0.2);
            margin-bottom: 2rem;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            background: linear-gradient(135deg, #e63946 0%, #c1121f 100%);
            color: white;
            padding: 1.5rem;
            text-align: left;
            font-size: 1.1rem;
            font-weight: bold;
        }
        
        td {
            padding: 1.2rem 1.5rem;
            border-bottom: 1px solid rgba(160, 216, 239, 0.1);
        }
        
        tr:last-child td {
            border-bottom: none;
        }
        
        tr:nth-child(even) {
            background: rgba(30, 42, 68, 0.5);
        }
        
        tr:hover {
            background: rgba(160, 216, 239, 0.1);
        }
        
        .label {
            color: #a0d8ef;
            font-weight: bold;
            width: 35%;
        }
        
        .value {
            color: #e0e0e0;
        }
        
        .mensaje-completo {
            background: #1e2a44;
            padding: 1.5rem;
            border-radius: 12px;
            border-left: 5px solid #a0d8ef;
            margin: 2rem 0;
        }
        
        .mensaje-completo h3 {
            color: #a0d8ef;
            margin-bottom: 1rem;
        }
        
        .mensaje-completo p {
            line-height: 1.8;
            color: #b0bec5;
        }
        
        .buttons {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            margin-top: 2rem;
        }
        
        .btn {
            padding: 1rem 2.5rem;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #a0d8ef 0%, #6fb3d2 100%);
            color: #0f1115;
            box-shadow: 0 8px 20px rgba(160, 216, 239, 0.4);
        }
        
        .btn-primary:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(160, 216, 239, 0.6);
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            color: white;
            box-shadow: 0 8px 20px rgba(108, 117, 125, 0.4);
        }
        
        .btn-secondary:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(108, 117, 125, 0.6);
        }
        
        .footer-note {
            text-align: center;
            margin-top: 3rem;
            padding: 1.5rem;
            background: rgba(15, 17, 21, 0.7);
            border-radius: 12px;
            border: 1px solid rgba(160, 216, 239, 0.2);
            color: #78909c;
        }
        
        @media (max-width: 768px) {
            .header h1 {
                font-size: 1.8rem;
            }
            
            .buttons {
                flex-direction: column;
            }
            
            .label {
                width: 100%;
            }
            
            th, td {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="success-icon">✅</div>
            <h1>¡Solicitud Recibida con Éxito!</h1>
            <p class="subtitle">Gracias por tu interés en descubrir Ecuador</p>
        </div>
        
        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th colspan="2">📋 Resumen de tu Solicitud de Viaje</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="label">👤 Nombre Completo</td>
                        <td class="value"><?php echo $nombre; ?></td>
                    </tr>
                    <tr>
                        <td class="label">📧 Correo Electrónico</td>
                        <td class="value"><?php echo $email; ?></td>
                    </tr>
                    <tr>
                        <td class="label">📱 Teléfono</td>
                        <td class="value"><?php echo $telefono; ?></td>
                    </tr>
                    <tr>
                        <td class="label">🌍 País de Origen</td>
                        <td class="value"><?php echo $pais; ?></td>
                    </tr>
                    <tr>
                        <td class="label">📍 Región de Interés</td>
                        <td class="value"><?php echo $region_nombre; ?></td>
                    </tr>
                    <tr>
                        <td class="label">💰 Presupuesto Aproximado</td>
                        <td class="value"><?php echo $presupuesto; ?></td>
                    </tr>
                    <tr>
                        <td class="label">📅 Fecha Estimada de Viaje</td>
                        <td class="value"><?php echo $fecha_viaje; ?></td>
                    </tr>
                    <tr>
                        <td class="label">⏱️ Duración del Viaje</td>
                        <td class="value"><?php echo $duracion; ?> días</td>
                    </tr>
                    <tr>
                        <td class="label">👥 Número de Personas</td>
                        <td class="value"><?php echo $personas; ?> persona(s)</td>
                    </tr>
                    <tr>
                        <td class="label">🎯 Tipo de Turismo</td>
                        <td class="value"><?php echo $tipo_turismo_nombre; ?></td>
                    </tr>
                    <tr>
                        <td class="label">✨ Actividades de Interés</td>
                        <td class="value"><?php echo $actividades_texto; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="mensaje-completo">
            <h3>💬 Tu Mensaje</h3>
            <p><?php echo nl2br($mensaje); ?></p>
        </div>
        
        <div class="buttons">
            <a href="index.html" class="btn btn-primary">🏠 Volver al Inicio</a>
            <a href="index.html#contacto" class="btn btn-secondary">📝 Nueva Solicitud</a>
        </div>
        
        <div class="footer-note">
            <p><strong>📬 Próximos pasos:</strong></p>
            <p>Nuestro equipo revisará tu solicitud y te contactaremos en las próximas 24-48 horas para ayudarte a planificar tu viaje perfecto a Ecuador.</p>
            <p style="margin-top: 1rem; color: #a0d8ef;">¡Prepárate para vivir la aventura ecuatoriana! 🇪🇨</p>
        </div>
    </div>
</body>
</html>