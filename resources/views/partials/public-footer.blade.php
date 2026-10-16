
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --footer-bg: #0d0d0d;
            --footer-accent: #1B5E20;
            --footer-accent-light: #4CAF50;
            --footer-accent-hover: #2e7d32;
            --footer-text: #fff;
            --footer-text-muted: #aaa;
            --footer-text-dim: #777;
            --footer-border: rgba(255, 255, 255, 0.08);
            --footer-social-bg: rgba(255, 255, 255, 0.06);
            --footer-social-border: rgba(255, 255, 255, 0.08);
            --footer-input-bg: rgba(255, 255, 255, 0.05);
            --footer-input-border: rgba(255, 255, 255, 0.1);
            --footer-input-focus-border: #1B5E20;
            --footer-contact-icon-bg: rgba(27, 94, 32, 0.15);
            --footer-contact-icon-color: #4CAF50;
        }

        .site-footer {
            background: var(--footer-bg);
            color: var(--footer-text);
            font-family: 'Montserrat', sans-serif;
            position: relative;
            overflow: hidden;
            width: 100%;
        }

        .site-footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #1B5E20, #4CAF50, #2e7d32, #1B5E20);
            background-size: 300% 100%;
            animation: footerGradient 6s ease infinite;
            z-index: 2;
        }

        @keyframes footerGradient {
            0%, 100% { background-position: 0% 0%; }
            50% { background-position: 100% 0%; }
        }

        .site-footer::after {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 350px;
            height: 350px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(27, 94, 32, 0.15) 0%, transparent 70%);
            pointer-events: none;
            z-index: 1;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 20px 40px;
            position: relative;
            z-index: 2;
        }

        .footer-top-row {
            display: flex;
            flex-wrap: wrap;
            gap: 50px;
            margin-bottom: 50px;
        }

        .footer-brand-col {
            flex: 1.5;
            min-width: 280px;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .footer-logo .brand-logo-image {
            width: 40px;
            height: 40px;
            object-fit: contain;
            border-radius: 10px;
            background: #fff;
        }

        .footer-logo-text {
            display: flex;
            flex-direction: column;
        }

        .footer-logo-text .bold-text {
            font-weight: 900;
            font-size: 1.3rem;
            color: var(--footer-text);
            letter-spacing: 0.5px;
        }

        .footer-logo-text .bold-text.green {
            color: var(--footer-accent-light);
        }

        .footer-brand-desc {
            font-size: 0.9rem;
            color: var(--footer-text-muted);
            line-height: 1.8;
            margin-bottom: 25px;
            max-width: 350px;
        }

        .footer-social-links {
            display: flex;
            gap: 12px;
        }

        .footer-social-link {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: var(--footer-social-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ccc;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            border: 1px solid var(--footer-social-border);
        }

        .footer-social-link:hover {
            background: var(--footer-accent);
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(27, 94, 32, 0.4);
            border-color: var(--footer-accent);
        }

        .footer-links-col {
            flex: 1;
            min-width: 180px;
        }

        .footer-links-col h4 {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--footer-text);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-links-col h4::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 30px;
            height: 3px;
            background: var(--footer-accent);
            border-radius: 2px;
        }

        .footer-links-col ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links-col ul li {
            margin-bottom: 12px;
        }

        .footer-links-col ul li a {
            color: var(--footer-text-muted);
            text-decoration: none;
            font-size: 0.88rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .footer-links-col ul li a:hover {
            color: var(--footer-accent-light);
            transform: translateX(5px);
        }

        .footer-links-col ul li a i {
            font-size: 0.7rem;
            color: var(--footer-accent-light);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .footer-links-col ul li a:hover i {
            opacity: 1;
        }

        .footer-newsletter-col {
            flex: 1.5;
            min-width: 280px;
        }

        .footer-newsletter-col h4 {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--footer-text);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-newsletter-col h4::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 30px;
            height: 3px;
            background: var(--footer-accent);
            border-radius: 2px;
        }

        .footer-newsletter-desc {
            font-size: 0.88rem;
            color: var(--footer-text-muted);
            line-height: 1.7;
            margin-bottom: 20px;
        }

        .footer-newsletter-form {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .footer-newsletter-input {
            flex: 1;
            padding: 14px 18px;
            border-radius: 30px;
            border: 1px solid var(--footer-input-border);
            background: var(--footer-input-bg);
            color: var(--footer-text);
            font-family: 'Montserrat', sans-serif;
            font-size: 0.85rem;
            outline: none;
            transition: all 0.3s ease;
            min-width: 0;
        }

        .footer-newsletter-input::placeholder {
            color: #777;
        }

        .footer-newsletter-input:focus {
            border-color: var(--footer-input-focus-border);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 20px rgba(27, 94, 32, 0.2);
        }

        .footer-newsletter-btn {
            padding: 14px 22px;
            border-radius: 30px;
            background: var(--footer-accent);
            color: #fff;
            border: none;
            cursor: pointer;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .footer-newsletter-btn:hover {
            background: var(--footer-accent-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(27, 94, 32, 0.4);
        }

        .footer-contact-info {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .footer-contact-item {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #ccc;
            font-size: 0.88rem;
        }

        .footer-contact-item i {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--footer-contact-icon-bg);
            color: var(--footer-contact-icon-color);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 0.9rem;
        }

        .footer-bottom-bar {
            border-top: 1px solid var(--footer-border);
            padding-top: 25px;
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .footer-copyright {
            font-size: 0.8rem;
            color: var(--footer-text-dim);
        }

        .footer-bottom-links {
            display: flex;
            gap: 20px;
        }

        .footer-bottom-links a {
            font-size: 0.8rem;
            color: var(--footer-text-dim);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-bottom-links a:hover {
            color: var(--footer-accent-light);
        }

        .footer-badge {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.78rem;
            color: var(--footer-text-dim);
        }

        .footer-badge i {
            color: var(--footer-accent-light);
        }

        @media (max-width: 992px) {
            .footer-top-row {
                gap: 35px;
            }
            .footer-brand-col {
                flex: 1 1 100%;
            }
            .footer-newsletter-col {
                flex: 1 1 100%;
            }
        }

        @media (max-width: 600px) {
            .footer-container {
                padding: 40px 15px 30px;
            }
            .footer-top-row {
                gap: 30px;
                margin-bottom: 30px;
            }
            .footer-newsletter-form {
                flex-direction: column;
            }
            .footer-bottom-bar {
                flex-direction: column;
                text-align: center;
            }
            .footer-bottom-links {
                flex-wrap: wrap;
                justify-content: center;
            }
            .footer-social-link {
                width: 38px;
                height: 38px;
                font-size: 1rem;
            }
        }
    </style>


    
    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-top-row">
                
                <div class="footer-brand-col">
                    <div class="footer-logo">
                        <img class="brand-logo-image" src="{{ asset('icons/icon-192.png') }}?v={{ filemtime(public_path('icons/icon-192.png')) }}" alt="" aria-hidden="true" width="40" height="40">
                        <div class="footer-logo-text">
                            <span class="bold-text green">aislagratis</span>
                        </div>
                    </div>
                    <p class="footer-brand-desc">
                        Especialistas en aislamiento térmico y eficiencia energética. Te ayudamos a mejorar el confort de tu vivienda y acceder a las ayudas CAE.
                    </p>
                    <div class="footer-social-links">
                        <a href="#" class="footer-social-link" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="footer-social-link" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="footer-social-link" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="#" class="footer-social-link" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                        <a href="#" class="footer-social-link" aria-label="X"><i class="fa-brands fa-x-twitter"></i></a>
                    </div>
                </div>

                
                <div class="footer-links-col">
                    <h4>Enlaces útiles</h4>
                    <ul>
                        <li><a href="{{ route('home') }}"><i class="fa-solid fa-chevron-right"></i> Inicio</a></li>
                        <li><a href="{{ route('services.index') }}"><i class="fa-solid fa-chevron-right"></i> Servicios</a></li>
                        <li><a href="{{ route('about') }}"><i class="fa-solid fa-chevron-right"></i> Sobre nosotros</a></li>
                        <li><a href="{{ route('leads.create') }}"><i class="fa-solid fa-chevron-right"></i> Solicitar estudio</a></li>
                        <li><a href="{{ route('home') }}#metricas"><i class="fa-solid fa-chevron-right"></i> Resultados</a></li>
                        <li><a href="{{ route('home') }}#cobertura"><i class="fa-solid fa-chevron-right"></i> Cobertura</a></li>
                    </ul>
                </div>

                
                <div class="footer-links-col">
                    <h4>Información legal</h4>
                    <ul>
                        <li><a href="{{ route('legal.privacy') }}"><i class="fa-solid fa-chevron-right"></i> Política de privacidad</a></li>
                        <li><a href="{{ route('legal.cookies') }}"><i class="fa-solid fa-chevron-right"></i> Política de cookies</a></li>
                        <li><a href="{{ route('legal.terms') }}"><i class="fa-solid fa-chevron-right"></i> Términos y condiciones</a></li>
                    </ul>
                </div>

                
                <div class="footer-newsletter-col">
                    <h4>Mantente informado</h4>
                    <p class="footer-newsletter-desc">
                        Suscríbete para recibir novedades sobre ayudas y consejos de eficiencia energética.
                    </p>
                    <form class="footer-newsletter-form" action="#" method="POST" onsubmit="return false;">
                        <input type="email" class="footer-newsletter-input" placeholder="Tu email..." required>
                        <button type="submit" class="footer-newsletter-btn">Suscribirme</button>
                    </form>
                    <div class="footer-contact-info">
                        <div class="footer-contact-item">
                            <i class="fa-solid fa-phone"></i>
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', config('aislaplus.phone')) }}">
                                {{ config('aislaplus.phone') }}
                            </a>
                        </div>
                        <div class="footer-contact-item">
                            <i class="fa-solid fa-envelope"></i>
                            <span>comunicaciones@mbaenergiaverde.com</span>
                        </div>
                        <div class="footer-contact-item">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>España - Servicio en todo el territorio</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-bottom-bar">
                <div class="footer-copyright">
                    © Copyright {{ date('Y') }} aislagratis. Todos los derechos reservados.
                </div>
                <div class="footer-bottom-links">
                    <a href="{{ route('legal.privacy') }}">Privacidad</a>
                    <a href="{{ route('legal.cookies') }}">Cookies</a>
                    <a href="{{ route('legal.terms') }}">Términos</a>
                </div>
                <div class="footer-badge">
                    <i class="fa-solid fa-leaf"></i>
                    <span>Comprometidos con el medio ambiente</span>
                </div>
            </div>
        </div>
    </footer>
