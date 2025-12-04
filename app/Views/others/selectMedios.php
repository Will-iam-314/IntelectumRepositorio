<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de Constancia URL</title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/icons/IntelectumLogoFondoBlanco.png')?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="100" height="100" patternUnits="userSpaceOnUse"><path d="M 100 0 L 0 0 0 100" fill="none" stroke="rgba(0,0,0,0.02)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            pointer-events: none;
        }
        
        .container {
            position: relative;
            z-index: 1;
        }
        
        .header-section {
            text-align: center;
            margin-bottom: 4rem;
            animation: fadeInDown 0.8s ease;
        }
        
        .main-title {
            font-size: 3rem;
            font-weight: 800;
            color: #013D73;
            margin: 3rem 0 1rem;
            text-shadow: 2px 4px 10px rgba(1, 61, 115, 0.1);
            letter-spacing: 1px;
        }
        
        .subtitle {
            font-size: 1.8rem;
            color: #20313fff;
            font-weight: 300;
        }
        
        .card-custom {
            background: white;
            border: none;
            border-radius: 20px;
            padding: 4rem 2rem;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            cursor: pointer;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 320px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            position: relative;
            overflow: hidden;
        }
        
        .card-custom::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: #3F81BB ;
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }
        
        .card-custom:hover::before {
            transform: scaleX(1);
        }
        
        .card-custom:hover {
            transform: translateY(-15px) scale(1.02);
            
        }
        
        .icon-wrapper {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            background:  #3F81BB;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(63, 129, 187, 0.3);
            transition: transform 0.3s ease;
        }
        
      
        
        .icon-wrapper svg {
            width: 40px;
            height: 40px;
            stroke: white;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }
        
        .card-title-custom {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #2d3748;
            line-height: 1.4;
        }
        
        .card-description {
            font-size: 1.3rem;
            color: #718096;
            line-height: 1.6;
       
        }
        
     
        
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .card-wrapper {
            animation: fadeInUp 0.8s ease;
            animation-fill-mode: both;
        }
        
        .card-wrapper:nth-child(1) {
            animation-delay: 0.2s;
        }
        
        .card-wrapper:nth-child(2) {
            animation-delay: 0.4s;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @media (max-width: 768px) {
            .main-title {
                font-size: 2rem;
                margin: 2rem 0 1rem;
            }
            
            .subtitle {
                font-size: 1rem;
            }
            
            .card-custom {
                padding: 3rem 1.5rem;
                min-height: 280px;
                margin-bottom: 2rem;
            }
            
            .card-title-custom {
                font-size: 1.3rem;
            }
            
            .card-description {
                font-size: 0.95rem;
            }
            
            .icon-wrapper {
                width: 70px;
                height: 70px;
            }
        }
        
        @media (max-width: 576px) {
            .main-title {
                font-size: 1.6rem;
                margin: 1.5rem 0 0.5rem;
                padding: 0 1rem;
            }
            
            .subtitle {
                font-size: 0.9rem;
                padding: 0 1rem;
            }
            
            .card-custom {
                padding: 3rem 1rem;
                min-height: 260px;
            }
            
            .card-title-custom {
                font-size: 1.1rem;
                margin-bottom: 1rem;
            }
            
            .icon-wrapper {
                width: 60px;
                height: 60px;
                margin-bottom: 1rem;
            }
            
            .icon-wrapper svg {
                width: 30px;
                height: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="header-section">
            <h1 class="main-title">SOLICITUD DE CONSTANCIA URL</h1>
            <p class="subtitle">Seleccione el trámite que desea realizar</p>
        </div>
        
        <div class="row g-4 justify-content-center">
            <!-- Card 1: Nueva Solicitud -->
            <div class="col-lg-5 col-md-6 col-sm-12 card-wrapper">
                <div class="card-custom" onclick="handleNewRequest()">
                    <div>
                        <div class="icon-wrapper">
                            <svg viewBox="0 0 24 24">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="12" y1="18" x2="12" y2="12"></line>
                                <line x1="9" y1="15" x2="15" y2="15"></line>
                            </svg>
                        </div>
                        <h2 class="card-title-custom">Nueva Solicitud</h2>
                        <p class="card-description">Si el trámite a realizar es uno nuevo y no ha sido presentado anteriormente</p>
                    </div>
                   
                </div>
            </div>
            
            <!-- Card 2: Subsanar Observación -->
            <div class="col-lg-5 col-md-6 col-sm-12 card-wrapper">
                <div class="card-custom" onclick="handleSubsanar()">
                    <div>
                        <div class="icon-wrapper">
                            <svg viewBox="0 0 24 24">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </div>
                        <h2 class="card-title-custom">Subsanar Observaciónes o Rectificación de Constancia</h2>
                        <p class="card-description">Solo si el trámite inicial se hizo con el formulario de Google </p>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        function handleNewRequest() {
     
            // Aquí puedes agregar la URL de redirección
             window.location.href = '<?= base_url("videoTutorial")?>';
        }
        
        function handleSubsanar() {
           
            // Aquí puedes agregar la URL de redirección
            window.location.href = 'https://docs.google.com/forms/d/e/1FAIpQLScuSQf7jKx6hIg-7tsQfxC1BQownv9wFzPnd6UQ_ueOGNrG3w/viewform';
        }
    </script>
</body>
</html>