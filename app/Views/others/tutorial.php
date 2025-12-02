<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=  name_system(); ?></title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/icons/IntelectumLogoFondoBlanco.png')?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #CDD5DB;
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .tutorial-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin: 20px auto;
        }
        
        .welcome-section {
            background: white;
            padding: 40px 30px 30px;
            text-align: center;
            border-bottom: 3px solid #E0F4F4;
        }
        
        .welcome-section .logo {
            width: 100px;
            height: 100px;
            margin: 0 auto 20px;
            background: #17A2B8;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5rem;
            font-weight: bold;
            box-shadow: 0 5px 20px rgba(23, 162, 184, 0.3);
        }
        
        .welcome-section h2 {
            font-size: 1.8rem;
            color: #0A3D62;
            font-weight: 700;
            margin: 0;
        }
        
        .header-section {
            background: white;
            color: #0A3D62;
            padding: 40px 30px 0px 30px;
            text-align: center;
        }
        
        .header-section h1 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: #0A3D62;
        }
        
        .header-section p {
            font-size: 1.1rem;
            color: #555;
            margin: 0;
        }
        
        .video-section {
            padding: 40px 30px;
        }
        
        .video-wrapper {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 aspect ratio */
            height: 0;
            overflow: hidden;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        
        .video-wrapper iframe,
        .video-wrapper video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }
        
        .action-section {
            padding: 30px;
            background: #f8f9fa;
            text-align: center;
        }
        
        .btn-system {
            background: #3F81BB;
            color: white;
            border: none;
            padding: 15px 50px;
            font-size: 1.2rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(23, 162, 184, 0.3);
        }
        
        .btn-system:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px  #3f81bb94;
            background:  #3F81BB;
            color: white;
        }

        #heder-Auth-register{
            background-color: rgb(240, 240, 240);
            border-radius: 20px;
            display: inline-block;
            padding-left: 20px;
            padding-right: 20px;
            padding-top: 10px;
            
        }
        #title-name-Auth{
            font-size:60px;    
            font-weight: bold;
            margin-bottom: 5px;
        }

        #subtitle-Auth{
            text-align: center;
            font-size:30px;
            font-weight: bold;
            position:relative;
            top:-18px;
            color: #3F81BB;
        }  
        .img-logo{
            width: 80px;
        }
        
        @media (max-width: 768px) {
            .header-section h1 {
                font-size: 1.8rem;
            }
            
            .header-section p {
                font-size: 1rem;
            }
            
            .video-section {
                padding: 30px 20px;
            }
            
            .action-section {
                padding: 30px 20px;
            }
            
            .btn-system {
                padding: 12px 40px;
                font-size: 1rem;
            }
            
            .features {
                gap: 30px;
            }
        }
        
        @media (max-width: 576px) {
            .header-section {
                padding: 30px 20px;
            }
            
            .header-section h1 {
                font-size: 1.5rem;
            }
            
            .feature-item {
                min-width: 100%;
            }
            
            .welcome-section {
                padding: 20px;
            }
            
            .welcome-section .logo {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }
            
            .welcome-section h2 {
                font-size: 1.2rem;
            }

            #title-name-Auth{
                font-size:40px;    
            }
            #subtitle-Auth{
      
                font-size:25px;
             
            }  

            .img-logo{
                position:relative;
                top:15px;
              
                width: 65px;
            }
        
        }

        

    </style>
</head>
<body>
    <div class="container">
        
     
        <div class="tutorial-container">
            <div class="text-center mt-5">

                <div  id="heder-Auth-register"> 
                    <div class="d-flex justify-content-center align-items-center" id="title-Auth">
                        <img class="img-logo"  src="<?= base_url('assets/icons/IntelectumLogoFondoBlanco.png')?>" alt="">
                        <span class="ms-1" id="title-name-Auth">Intelectum</span>
                    </div>
                    <div id="subtitle-Auth" >
                        <span>Repositorio</span>
                    </div>
                </div>
            </div>
                
            <!-- Header -->
            <div class="header-section">
                <h1><i class="fas fa-play-circle"></i> Video de Ayuda</h1>
                <p>Aprende a cómo solicitar tu constancia de publicación en minutos</p>
            </div>
            
            <!-- Video Section -->
            <div class="video-section">
                <div class="video-wrapper">
                    <!-- Reemplaza el src con tu URL de video de YouTube o video local -->
                    <iframe 
                        src="https://www.youtube.com/embed/KEj_U2TN9hk?si=7Akj3stiVVkZxku_" 
                        allowfullscreen
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                    </iframe>
                    
                    <!-- Alternativa para video local:
                    <video controls>
                        <source src="tu-video.mp4" type="video/mp4">
                        Tu navegador no soporta el elemento de video.
                    </video>
                    -->
                </div>
            </div>
            
            <!-- Action Section -->
            <div class="action-section">
                <h3 class="mb-4">¿Listo para comenzar?</h3>
                <a href="<?=base_url() ?>" class="btn btn-system">
                    <i class="fas fa-rocket me-2"></i>Ir al Sistema
                </a>
                <p class="mt-3 text-muted">
                    <small><i class="fas fa-info-circle"></i> Puedes volver a ver este tutorial cuando quieras</small>
                </p>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>