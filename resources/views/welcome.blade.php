<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FineTech Bank - Your Trusted Financial Partner</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #1a5490;
            --secondary-color: #2876bd;
            --accent-color: #f8a01a;
            --dark-color: #0f2d44;
            --light-bg: #f7fbff;
        }

        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            color: #243447;
            overflow-x: hidden;
        }

        .navbar {
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
            font-size: 1.5rem;
        }

        .nav-link {
            color: #2c3e50 !important;
            font-weight: 500;
            margin: 0 8px;
        }

        .hero {
            padding: 110px 0 90px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: #fff;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .btn-primary-custom {
            background: var(--accent-color);
            border: none;
            color: #fff;
            font-weight: 600;
            padding: 10px 24px;
            border-radius: 999px;
        }

        .btn-primary-custom:hover {
            background: #e18e11;
            color: #fff;
        }

        .btn-outline-custom {
            border: 2px solid #fff;
            color: #fff;
            font-weight: 600;
            padding: 8px 24px;
            border-radius: 999px;
        }

        .btn-outline-custom:hover {
            background: #fff;
            color: var(--primary-color);
        }

        .section-title {
            font-weight: 700;
            color: var(--dark-color);
        }

        .service-card {
            border: 0;
            border-radius: 14px;
            padding: 28px 22px;
            height: 100%;
            box-shadow: 0 8px 24px rgba(17, 38, 146, 0.08);
            transition: 0.25s;
            background: #fff;
        }

        .service-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 14px 30px rgba(17, 38, 146, 0.13);
        }

        .service-icon {
            width: 62px;
            height: 62px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: #fff;
            font-size: 1.6rem;
            margin-bottom: 18px;
        }

        .feature-box {
            background: #fff;
            border-radius: 12px;
            padding: 18px;
            border: 1px solid #edf3fa;
            height: 100%;
        }

        .stats {
            background: var(--dark-color);
            color: #fff;
            padding: 72px 0;
        }

        .stat-value {
            font-size: 2.3rem;
            font-weight: 700;
            color: var(--accent-color);
        }

        .footer {
            background: #0b2235;
            color: #d3dbe5;
            padding: 48px 0 18px;
        }

        .footer a {
            color: #d3dbe5;
            text-decoration: none;
        }

        .footer a:hover {
            color: #fff;
        }

        @media (max-width: 991px) {
            .hero h1 {
                font-size: 2.25rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#home"><i class="bi bi-bank2 me-1"></i>FineTech Bank</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>

                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                                <a href="{{ url('/dashboard') }}" class="btn btn-primary-custom">Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                                <a href="{{ route('login') }}" class="btn btn-outline-secondary rounded-pill">Login</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                                    <a href="{{ route('register') }}" class="btn btn-primary-custom">Register</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <section id="home" class="hero">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <h1>Secure Banking For Modern Life</h1>
                    <p class="lead mt-3 mb-4">Manage savings, payments, cards, and investments from one trusted platform built for speed and security.</p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="#services" class="btn btn-primary-custom">Explore Services</a>
                        <a href="#contact" class="btn btn-outline-custom">Talk to Us</a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="https://images.unsplash.com/photo-1601597111158-2fceff292cdc?auto=format&fit=crop&w=900&q=80" class="img-fluid rounded-4 shadow" alt="Banking">
                </div>
            </div>
        </div>
    </section>

    <section id="services" class="py-5" style="background: var(--light-bg);">
        <div class="container py-3">
            <div class="text-center mb-5">
                <h2 class="section-title">Our Banking Services</h2>
                <p class="text-muted mb-0">Everything you need to manage money with confidence</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="service-card">
                        <div class="service-icon"><i class="bi bi-piggy-bank"></i></div>
                        <h5>Savings Account</h5>
                        <p class="text-muted mb-0">High-yield savings with instant access and no hidden fees.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="service-card">
                        <div class="service-icon"><i class="bi bi-credit-card-2-front"></i></div>
                        <h5>Credit Cards</h5>
                        <p class="text-muted mb-0">Smart cards with cashback rewards and strong fraud protection.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="service-card">
                        <div class="service-icon"><i class="bi bi-house-door"></i></div>
                        <h5>Home Loans</h5>
                        <p class="text-muted mb-0">Flexible mortgage options with fast approval process.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="service-card">
                        <div class="service-icon"><i class="bi bi-bar-chart"></i></div>
                        <h5>Investments</h5>
                        <p class="text-muted mb-0">Build wealth with curated portfolios and expert guidance.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="py-5">
        <div class="container py-3">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <img src="https://images.unsplash.com/photo-1553729459-efe14ef6055d?auto=format&fit=crop&w=900&q=80" class="img-fluid rounded-4" alt="About FineTech Bank">
                </div>
                <div class="col-lg-6">
                    <h2 class="section-title">Built On Trust, Powered By Technology</h2>
                    <p class="text-muted mt-3">For 25+ years, FineTech Bank has helped individuals and businesses grow with secure banking products and responsive support.</p>
                    <div class="row g-3 mt-2">
                        <div class="col-6"><div class="feature-box"><i class="bi bi-shield-check text-primary me-1"></i>Secure Platform</div></div>
                        <div class="col-6"><div class="feature-box"><i class="bi bi-lightning-charge text-primary me-1"></i>Instant Transfers</div></div>
                        <div class="col-6"><div class="feature-box"><i class="bi bi-phone text-primary me-1"></i>Mobile Banking</div></div>
                        <div class="col-6"><div class="feature-box"><i class="bi bi-headset text-primary me-1"></i>24/7 Support</div></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="stats">
        <div class="container">
            <div class="row text-center g-4">
                <div class="col-6 col-lg-3">
                    <div class="stat-value" data-count="500">0</div>
                    <div>Thousand+ Customers</div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stat-value" data-count="150">0</div>
                    <div>Branches</div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stat-value" data-count="99">0</div>
                    <div>Service Uptime %</div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stat-value" data-count="25">0</div>
                    <div>Years of Experience</div>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="py-5">
        <div class="container py-3">
            <div class="row g-4">
                <div class="col-lg-5">
                    <h2 class="section-title">Contact Us</h2>
                    <p class="text-muted">Need help choosing a banking plan? Reach us any time.</p>
                    <p class="mb-1"><i class="bi bi-geo-alt-fill text-primary me-2"></i>123 Financial Street, New York</p>
                    <p class="mb-1"><i class="bi bi-telephone-fill text-primary me-2"></i>+1 (800) 123-4567</p>
                    <p class="mb-0"><i class="bi bi-envelope-fill text-primary me-2"></i>support@finetechbank.com</p>
                </div>
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <form>
                                <div class="row g-3">
                                    <div class="col-md-6"><input type="text" class="form-control" placeholder="Your Name"></div>
                                    <div class="col-md-6"><input type="email" class="form-control" placeholder="Your Email"></div>
                                    <div class="col-12"><input type="text" class="form-control" placeholder="Subject"></div>
                                    <div class="col-12"><textarea class="form-control" rows="4" placeholder="Message"></textarea></div>
                                    <div class="col-12"><button type="submit" class="btn btn-primary-custom">Send Message</button></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                <p class="mb-0">© {{ date('Y') }} FineTech Bank. All rights reserved.</p>
                <div class="d-flex gap-3">
                    <a href="#">Privacy</a>
                    <a href="#">Terms</a>
                    <a href="#">Cookies</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
            anchor.addEventListener('click', function (event) {
                const targetId = this.getAttribute('href');
                const target = document.querySelector(targetId);
                if (!target) {
                    return;
                }
                event.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });

        const statElements = document.querySelectorAll('.stat-value');
        const observer = new IntersectionObserver(function (entries, obs) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) {
                    return;
                }
                const el = entry.target;
                const endValue = Number(el.getAttribute('data-count'));
                let current = 0;
                const step = Math.max(1, Math.ceil(endValue / 60));
                const timer = setInterval(function () {
                    current += step;
                    if (current >= endValue) {
                        current = endValue;
                        clearInterval(timer);
                    }
                    el.textContent = current;
                }, 20);
                obs.unobserve(el);
            });
        }, { threshold: 0.4 });

        statElements.forEach(function (el) {
            observer.observe(el);
        });
    </script>
</body>
</html>
