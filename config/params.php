<?php

return [
    'adminEmail' => 'admin@example.com',
    					 //CLAVE      LO QUE EL cliente llenara
	'tipoFlujo' => [
        'tipo_viatico'      => 'Viático',
        'tipo_rendicion'    => 'Rención',
        'tipo_caja_chica'   => 'Caja Chica',
        'tipo_entrega'      => 'Entrega',
        'tipo_desembolso'   => 'Desembolso'
    ],
    'presupuesto_estado' => [
        'primer_estado' => 'En Planificación'
                            ],
    'metacodigoFlags' => [  'Movimiento' => 'Movimiento',
    					    'Sexo' => 'Sexo',
    					    'Condición' => 'Condición',
                            'Estado' => 'Estado',
                            'Tipo_Entidad' => 'Tipo_Entidad',
                            'Tipo_Entidad_Financiera' => 'Tipo_Entidad_Financiera',
                            'Estado_de_Entregable' =>  'Estado_de_Entregable',
                            'Concepto_Distribucion' => 'Concepto_Distribucion',
                            'Escala_Distribucion' => 'Escala_Distribucion',
                            'flg_es_staff' => 'flg_es_staff',
                            'Tipo_flujo' => 'Tipo_flujo',
                            'Estado_Rendicion_CH' => 'Estado_Rendicion_CH',
                            'Tipo_Flujo_CH' => 'Tipo_Flujo_CH',
                            'Estado_paso' => 'Estado_paso',
                            'Estado_Rendicion_Viatico' => 'Estado_Rendicion_Viatico',
                            'Estado_Presupuesto' => 'Estado_Presupuesto',
                            'Tipo_Bien_Servicio' => 'Tipo_Bien_Servicio',
                            'Tipo_Documento_Rendicion' => 'Tipo_Documento_Rendicion',
                            'Tipo_Garantia' => 'Tipo_Garantia'
                        ],
	'textoEspañol' => [
		'mensajeCabecera' => 'Las columnas pueden ser escaladas arrastrando los bordes.',
		'crearMas' => 'Crear otro',
		'webNoEncontrada' => 'La página requerida no está disponible.',
		'tituloConfirmaciónBorrar' => '¿Está usted seguro(a)?',
		'mensajeConfirmaciónBorrar' => '¿Desea borrar este elemento?',
        'paginaNoEncontrada' => 'La página requerida no existe.',
	],
];
