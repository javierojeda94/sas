<?php

/* @var $this yii\web\View */

use yii\bootstrap\Carousel;

$this->title = 'Sistema Administrativo de Solicitudes';
?>
<?php
echo Carousel::widget([
    'items' => [
        [
            'content' => '<img src="../images/slide2.jpg"/>',
            'caption' => '<h1>Bienvenido</h1><p>Al Sistema Administrativo de Solicitudes (SAS) donde puedes registrar dudas, peticiones,
                quejas, etc. sobre la Facultad de Matemáticas y se te responderá a la brevedad posible.</p>'
        ],
        ['content' => '<img src="../images/slide3.jpg"/>',
            'caption' => '<h1>Bienvenido</h1><p>Al Sistema Administrativo de Solicitudes (SAS) donde puedes registrar dudas, peticiones,
                quejas, etc. sobre la Facultad de Matemáticas y se te responderá a la brevedad posible.</p>'
        ],
        ['content' => '<img src="../images/slide4.jpg"/>',
            'caption' => '<h1>Bienvenido</h1><p>Al Sistema Administrativo de Solicitudes (SAS) donde puedes registrar dudas, peticiones,
                quejas, etc. sobre la Facultad de Matemáticas y se te responderá a la brevedad posible.</p>'
        ],
    ]
])
?>
<div class="site-index">
    <div class="body-content">
        <div class="steps row">
            <div class="col-lg-4">

                <p><img src="../images/icons/Compose.png"/></p>
                <h3> Registra tu solicitud</h3>
            </div>
            <div class="col-lg-4">
                <p><img src="../images/icons/Envelope.png"/></p>
                <h3>Recibe un correo cuando vayas a ser atendido</h3>

            </div>
            <div class="col-lg-4">

                <p><img src="../images/icons/Communication.png"/></p>
                <h3>Intercambia información sobre el avance de tu solicitud</h3>

            </div>
        </div>

    </div>
</div>
