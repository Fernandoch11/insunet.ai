<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estimar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            /*
            display: flex;
            justify-content: center;
            align-items: center;
            */
        }
        .form-scroll-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 90vw;
            max-height: 80vh;
            padding: 20px;
            overflow-y: auto;
            margin: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            font-size: 1rem;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 1rem;
            box-sizing: border-box;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }
        button:hover {
            background-color: #218838;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 1rem;
            box-sizing: border-box;
            background-color: white;
            appearance: none;
        }

        #tipoestimacion {
            width: 24%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 1rem;
            box-sizing: border-box;
            background-color: white;
            appearance: none;
        }

        #tipomodelo {
            width: 30%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 1rem;
            box-sizing: border-box;
            background-color: white;
            appearance: none;
        }

        @media (max-width: 600px) {
            .form-scroll-container {
                max-width: 98vw;
                padding: 10px;
            }
            label, input[type="text"], button {
                font-size: 0.95rem;
            }
        }

        #tit {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        

        .main-content {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
        }


        /* Fondo oscuro */
.modal {
  display: none; /* oculto por defecto */
  position: fixed;
  z-index: 1000;
  left: 0; top: 0;
  width: 100%; height: 100%;
  background-color: rgba(0,0,0,0.5);
  justify-content: center;
  align-items: center;
}

/* Contenido del modal */
.modal-content {
  background-color: white;
  padding: 20px;
  border-radius: 10px;
  animation: fadeIn 0.3s ease;
}

/* Animación de entrada */
@keyframes fadeIn {
  from { opacity: 0; transform: scale(0.9);}
  to { opacity: 1; transform: scale(1);}
}

/* Botón de cerrar */
.close {
  float: right;
  font-size: 24px;
  cursor: pointer;
}

#excelFile{
    margin-bottom: 20px;
}
    </style>
    <link rel="stylesheet" href="./src/nav_bar.css">

</head>
<body>
    <?php  require('topmenu.php'); ?>
    <div class="main-content">
    
        <div class="form-scroll-container">
            <h2 id="tit">Datos para la Estimación</h2>

            <div id="form">
                <form id="Sendapi" action="" method="POST">
                                <div class="typeform">
                <select name="tipoestimacion" id="tipoestimacion">
                    <option value="unico" default>Individual</option>
                    <option value="masivo">Masivo</option>
                </select>

                <select name="tipomodelo" id="tipomodelo">
                    <option value="rf" default>Modelo RF</option>
                    <option value="svm" default>Modelo SVM</option>
                    <option value="rl">Modelo RL</option>
                </select>
            </div>

            <hr style="margin: 10px 0; margin-bottom: 25px;">
            
                    <label for="edad">Edad:</label>
                    <input type="text" id="edad" name="edad">

                    <label for="genero">Género:</label>
                    <select id="genero" name="genero">
                        <option value="0">Masculino</option>
                        <option value="1">Femenino</option>
                    </select>

                    <label for="etnia">Etnia:</label>
                    <select id="etnia" name="etnia">
                        <option value="0">Caucásico</option>
                        <option value="1">Americano - Africano</option>
                        <option value="2">Asiático</option>
                        <option value="3">Otro</option>
                    </select>

                    <label for="imc">IMC:</label>
                    <input type="text" id="imc" name="imc">

                    <label for="fumar">Fuma:</label>
                    <select id="fumar" name="fumar">
                        <option value="0">No</option>
                        <option value="1">Sí</option>
                    </select>

                    <label for="consumo_alcohol">Consumo de Alcohol:</label>
                    <select id="consumo_alcohol" name="consumo_alcohol">
                        <?php for ($i = 0; $i <= 20; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>

                    <label for="actividad_fisica">Actividad Física:</label>
                    <select id="actividad_fisica" name="actividad_fisica">
                        <?php for ($i = 0; $i <= 10; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>

                    <label for="calidad_dieta">Calidad de la Dieta:</label>
                    <select id="calidad_dieta" name="calidad_dieta">
                        <?php for ($i = 0; $i <= 10; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>

                    <label for="calidad_sueno">Calidad del Sueño:</label>
                    <select id="calidad_sueno" name="calidad_sueno">
                        <?php for ($i = 4; $i <= 10; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>

                    <label for="historial_familiar_diabetes">Historial Familiar de Diabetes:</label>
                    <select id="historial_familiar_diabetes" name="historial_familiar_diabetes">
                        <option value="0">No</option>
                        <option value="1">Sí</option>
                    </select>

                    <label for="hipertension">Hipertensión:</label>
                    <select id="hipertension" name="hipertension">
                        <option value="0">No</option>
                        <option value="1">Sí</option>
                    </select>

                    <label for="presion_sistolica">Presión Sistólica:</label>
                    <input type="text" id="presion_sistolica" name="presion_sistolica" placeholder="mmHg">

                    <label for="presion_diastolica">Presión Diastólica:</label>
                    <input type="text" id="presion_diastolica" name="presion_diastolica" placeholder="mmHg">

                    <label for="azucar_ayuno">Azúcar en Ayuno:</label>
                    <input type="text" id="azucar_ayuno" name="azucar_ayuno" placeholder="mg/dL">

                    <label for="hba1c">HbA1c:</label>
                    <input type="text" id="hba1c" name="hba1c">

                    <label for="colesterol_total">Colesterol Total:</label>
                    <input type="text" id="colesterol_total" name="colesterol_total" placeholder="mg/dL">

                    <label for="colesterol_ldl">Colesterol LDL:</label>
                    <input type="text" id="colesterol_ldl" name="colesterol_ldl" placeholder="mg/dL">

                    <label for="colesterol_hdl">Colesterol HDL:</label>
                    <input type="text" id="colesterol_hdl" name="colesterol_hdl" placeholder="mg/dL">

                    <label for="colesterol_trigliceridos">Triglicéridos:</label>
                    <input type="text" id="colesterol_trigliceridos" name="colesterol_trigliceridos" placeholder="mg/dL">

                    <label for="orina_frecuente">Orina Frecuente:</label>
                    <select id="orina_frecuente" name="orina_frecuente">
                        <option value="0">No</option>
                        <option value="1">Sí</option>
                    </select>
                    <label for="niveles_fatiga">Niveles de Fatiga:</label>
                    <select id="niveles_fatiga" name="niveles_fatiga">
                        <?php for ($i = 0; $i <= 10; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>

                    <label for="vision_borrosa">Visión Borrosa:</label>
                    <select id="vision_borrosa" name="vision_borrosa">
                        <option value="0">No</option>
                        <option value="1">Sí</option>
                    </select>
                    <label for="heridas_lentas">Heridas de Cicatrización Lenta:</label>
                    <select id="heridas_lentas" name="heridas_lentas">
                        <option value="0">No</option>
                        <option value="1">Sí</option>
                    </select>

                    <label for="hormigueo_manos_pies">Hormigueo en Manos y Pies:</label>
                    <select id="hormigueo_manos_pies" name="hormigueo_manos_pies">
                        <option value="0">No</option>
                        <option value="1">Sí</option>
                    </select>
                    <label for="calidad_agua">Calidad del Agua:</label>
                    <select id="calidad_agua" name="calidad_agua">
                        <option value="0">Buena</option>
                        <option value="1">Mala</option>
                    </select>

                    <input type="hidden" name="formid" value="a8b9c0d1e2f3">
                    <button id="env" type="submit">Enviar</button>
                </form>
            </div>
        </div>
    </div>

    <div id="myModal" class="modal">
  <div class="modal-content">
    <span id="closeModalBtn" class="close">&times;</span>
    <div style="text-align: center;">
        <h2 id="diabetesProbability" style="color: #28a745;">0%</h2>
        <p id="apiMessage" style="font-size: 1.2rem; color: #555;">Esperando respuesta...</p>
    </div>
  </div>
</div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./functions/functions.js"></script>
</body>
</html>