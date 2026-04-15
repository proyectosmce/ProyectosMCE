<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enlaces Proyectos MCE</title>
    <meta name="description" content="Elige a donde quieres ir: web, redes sociales o contacto directo de Proyectos MCE.">
    <link rel="icon" href="favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            font-family: "Segoe UI", Roboto, Arial, sans-serif;
            background:
                radial-gradient(circle at 20% 15%, rgba(255, 215, 0, 0.22), transparent 38%),
                linear-gradient(135deg, #08172f 0%, #12386f 52%, #1f4a99 100%);
            color: #ffffff;
            display: grid;
            place-items: center;
            padding: 20px;
        }

        .card {
            width: min(520px, 100%);
            background: rgba(5, 15, 34, 0.62);
            border: 1px solid rgba(255, 215, 0, 0.35);
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.35);
            backdrop-filter: blur(6px);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .brand img {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid rgba(255, 215, 0, 0.55);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.25);
        }

        .brand-title {
            font-size: 1.15rem;
            font-weight: 800;
            letter-spacing: 0.25px;
            color: #ffd700;
        }

        .brand-sub {
            font-size: 0.82rem;
            color: #d9e7ff;
        }

        h1 {
            font-size: 1.6rem;
            line-height: 1.2;
            margin: 8px 0 8px;
        }

        .lead {
            color: #d9e7ff;
            line-height: 1.45;
            margin-bottom: 18px;
            font-size: 0.95rem;
        }

        .links {
            display: grid;
            gap: 10px;
        }

        .link-btn {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            background: rgba(255, 255, 255, 0.06);
            text-decoration: none;
            color: #ffffff;
            font-weight: 700;
            transition: transform 0.15s ease, background 0.15s ease, border-color 0.15s ease;
        }

        .link-btn:hover {
            transform: translateY(-1px);
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(255, 215, 0, 0.4);
        }

        .link-left {
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .link-icon {
            width: 30px;
            text-align: center;
            color: #ffd700;
            font-size: 1rem;
        }

        .go {
            color: #ffd700;
            font-size: 0.82rem;
            letter-spacing: 0.1px;
        }

        .foot {
            margin-top: 14px;
            text-align: center;
            color: #c5d8ff;
            font-size: 0.78rem;
        }
    </style>
</head>
<body>
    <main class="card">
        <div class="brand">
            <img src="MCE.jpg" alt="Logo Proyectos MCE">
            <div>
                <p class="brand-title">PROYECTOS MCE</p>
                <p class="brand-sub">Software a medida</p>
            </div>
        </div>

        <h1>Elige donde quieres ir</h1>
        <p class="lead">Selecciona una opcion para abrir nuestra web, redes sociales o contacto directo.</p>

        <section class="links" aria-label="Enlaces de Proyectos MCE">
            <a class="link-btn" href="https://proyectosmce.com">
                <span class="link-left"><i class="fas fa-globe link-icon"></i>Pagina Web</span>
                <span class="go">Abrir</span>
            </a>
            <a class="link-btn" href="https://wa.me/573114125971?text=Hola%21%20Vengo%20desde%20el%20QR%20de%20Proyectos%20MCE">
                <span class="link-left"><i class="fab fa-whatsapp link-icon"></i>WhatsApp</span>
                <span class="go">Abrir</span>
            </a>
            <a class="link-btn" href="https://www.instagram.com/proyectosmce/">
                <span class="link-left"><i class="fab fa-instagram link-icon"></i>Instagram</span>
                <span class="go">Abrir</span>
            </a>
            <a class="link-btn" href="https://www.facebook.com/proyectosmce">
                <span class="link-left"><i class="fab fa-facebook-f link-icon"></i>Facebook</span>
                <span class="go">Abrir</span>
            </a>
            <a class="link-btn" href="https://www.linkedin.com/company/proyectosmce/">
                <span class="link-left"><i class="fab fa-linkedin-in link-icon"></i>LinkedIn</span>
                <span class="go">Abrir</span>
            </a>
            <a class="link-btn" href="https://www.tiktok.com/@proyectosmce">
                <span class="link-left"><i class="fab fa-tiktok link-icon"></i>TikTok</span>
                <span class="go">Abrir</span>
            </a>
            <a class="link-btn" href="https://t.me/proyectosmce">
                <span class="link-left"><i class="fab fa-telegram-plane link-icon"></i>Telegram</span>
                <span class="go">Abrir</span>
            </a>
            <a class="link-btn" href="mailto:contacto@proyectosmce.com">
                <span class="link-left"><i class="far fa-envelope link-icon"></i>Correo</span>
                <span class="go">Abrir</span>
            </a>
        </section>

        <p class="foot">proyectosmce.com</p>
    </main>
</body>
</html>
