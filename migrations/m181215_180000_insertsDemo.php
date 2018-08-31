<?php

use yii\db\Migration;

/**
 * Class m181215_180000_insertsDemo
 */
class m181215_180000_insertsDemo extends Migration
{
    public function up(){
        /// CLASE
        $this->insert('patrimonio_clase',array(//id=1
            'nombre'      => 'Vehiculos',
            'codigo'            => '1',
            'tasa_depreciacion' => 0.25,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('patrimonio_clase',array(//id=2
            'nombre'      => 'Vehiculo de Carga Pesada',
            'patrimonio_clase_padre_id' => 1,
            'codigo'            => '1.1',
            'tasa_depreciacion' => 0.02,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('patrimonio_clase',array(//id=3
            'nombre'      => 'Camioneta',
            'patrimonio_clase_padre_id' => 1,
            'codigo'            => '1.2',
            'tasa_depreciacion' => 0.2,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('patrimonio_clase',array(//id4
            'nombre'      => 'Computadoras',
            'codigo'            => '2',
            'tasa_depreciacion' => 0.25,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('patrimonio_clase',array(//id5
            'nombre'      => 'Laptop',
            'patrimonio_clase_padre_id' => 4,
            'codigo'            => '2.1',
            'tasa_depreciacion' => 0.1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('patrimonio_clase',array(//id6
            'patrimonio_clase_padre_id' => 4,
            'nombre'      => 'MacBook',
            'codigo'            => '2.2',
            'tasa_depreciacion' => 0.05,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));


        /// Ubicaciones
        
        
        $this->insert('ubicacion',array(
            'nombre'      => 'Oficina Av. Ejercito',
            'codigo'            => 1,
            'descripcion'       => 'Oficina',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));


        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Tipo_Flujo_CH',
            'codigo'            => 1,
            'descripcion'       => 'Flujo Test 1',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Tipo_Flujo_CH',
            'codigo'            => 2,
            'descripcion'       => 'Flujo Test 2',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        // Entidades Bancarias
        
        $this->insert('pnia_ent_financiera',array(
            'tipo_entidad' => 14,
            'razon_social' => 'Banco Falabella',
            'cuenta_bancaria' => 98723981312,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('pnia_ent_financiera',array(
            'tipo_entidad' => 13,
            'razon_social' => 'Caja Arequipa',
            'cuenta_bancaria' => 2373981312,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('pnia_ent_financiera',array(
            'tipo_entidad' => 14,
            'razon_social' => 'Banco BCP',
            'cuenta_bancaria' => 123412381312,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));


/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////  USUARIOS DEMO  /////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
        $this->insert('staff_persona',array(
            'dni'                    => '64090087',
            'nombres'                => 'Juan Adolfo',
            'apellido_paterno'       => 'Perez',
            'apellido_materno'       => 'Cueva',
            'codigo_pnia'            => '1001',
            'ruc'                    => '10640900879',
            'nivel'                  => 1,
            'cuenta_bancaria'        => '10926600012',
            'pnia_ent_financiera_id' => 3,
            'creado_en'              => date('Y-m-d H:i:s'),
            'actualizado_en'         => date('Y-m-d H:i:s'),
            'creado_por'             => 1,
            'actualizado_por'        => 1,
        ));
        $this->insert('staff_persona',array(
            'dni'                    => '63009238',
            'nombres'                => 'Marco ',
            'apellido_paterno'       => 'Gonzales',
            'apellido_materno'       => 'Lopez',
            'codigo_pnia'            => '1002',
            'ruc'                    => '10630092389',
            'nivel'                  => 1,
            'cuenta_bancaria'        => '10926602039',
            'pnia_ent_financiera_id' => 2,
            'creado_en'              => date('Y-m-d H:i:s'),
            'actualizado_en'         => date('Y-m-d H:i:s'),
            'creado_por'             => 1,
            'actualizado_por'        => 1,
        ));
        $this->insert('staff_persona',array(
            'dni'                    => '12345678',
            'nombres'                => 'Carlos',
            'apellido_paterno'       => 'Perez',
            'apellido_materno'       => 'Muñoz',
            'codigo_pnia'            => '1003',
            'ruc'                    => '10123456789',
            'nivel'                  => 1,
            'cuenta_bancaria'        => '9879879',
            'pnia_ent_financiera_id' => 2,
            'creado_en'              => date('Y-m-d H:i:s'),
            'actualizado_en'         => date('Y-m-d H:i:s'),
            'creado_por'             => 1,
            'actualizado_por'        => 1,
        ));
        $this->insert('staff_persona',array(
            'dni'                    => '12346698',
            'nombres'                => 'Maria',
            'apellido_paterno'       => 'Ramoz',
            'apellido_materno'       => 'Del Carpio',
            'codigo_pnia'            => '1004',
            'ruc'                    => '10123454444',
            'nivel'                  => 1,
            'cuenta_bancaria'        => '333334444',
            'pnia_ent_financiera_id' => 2,
            'creado_en'              => date('Y-m-d H:i:s'),
            'actualizado_en'         => date('Y-m-d H:i:s'),
            'creado_por'             => 1,
            'actualizado_por'        => 1,
        ));
        $this->insert('staff_persona',array(
            'dni'                    => '54678965',
            'nombres'                => 'Miguel',
            'apellido_paterno'       => 'Sanchez',
            'apellido_materno'       => 'Cornejo',
            'codigo_pnia'            => '1005',
            'ruc'                    => '10123114444',
            'nivel'                  => 1,
            'cuenta_bancaria'        => '333334424',
            'pnia_ent_financiera_id' => 2,
            'creado_en'              => date('Y-m-d H:i:s'),
            'actualizado_en'         => date('Y-m-d H:i:s'),
            'creado_por'             => 1,
            'actualizado_por'        => 1,
        ));
        $this->insert('staff_persona',array(
            'dni'                    => '45780123',
            'nombres'                => 'Diana',
            'apellido_paterno'       => 'Paredes',
            'apellido_materno'       => 'Rosa',
            'codigo_pnia'            => '1006',
            'ruc'                    => '12567890166',
            'nivel'                  => 1,
            'cuenta_bancaria'        => '33333442455',
            'pnia_ent_financiera_id' => 2,
            'creado_en'              => date('Y-m-d H:i:s'),
            'actualizado_en'         => date('Y-m-d H:i:s'),
            'creado_por'             => 1,
            'actualizado_por'        => 1,
        ));
        $this->insert('staff_persona',array(
            'dni'                    => '56783451',
            'nombres'                => 'Diego',
            'apellido_paterno'       => 'Peralta',
            'apellido_materno'       => 'Rondo',
            'codigo_pnia'            => '1007',
            'ruc'                    => '65789054366',
            'nivel'                  => 1,
            'cuenta_bancaria'        => '4343253232',
            'pnia_ent_financiera_id' => 2,
            'creado_en'              => date('Y-m-d H:i:s'),
            'actualizado_en'         => date('Y-m-d H:i:s'),
            'creado_por'             => 1,
            'actualizado_por'        => 1,
        ));
        $this->insert('staff_persona',array(
            'dni'                    => '56703456',
            'nombres'                => 'Gonzalo',
            'apellido_paterno'       => 'Camino',
            'apellido_materno'       => 'Fernandez',
            'codigo_pnia'            => '1008',
            'ruc'                    => '65789543210',
            'nivel'                  => 1,
            'cuenta_bancaria'        => '434325323211',
            'pnia_ent_financiera_id' => 2,
            'creado_en'              => date('Y-m-d H:i:s'),
            'actualizado_en'         => date('Y-m-d H:i:s'),
            'creado_por'             => 1,
            'actualizado_por'        => 1,
        ));
        $this->insert('staff_persona',array(
            'dni'                    => '45673445',
            'nombres'                => 'Luigi',
            'apellido_paterno'       => 'Pinto',
            'apellido_materno'       => 'Pinto',
            'codigo_pnia'            => '1009',
            'ruc'                    => '56547867563',
            'nivel'                  => 1,
            'cuenta_bancaria'        => '434356723211',
            'pnia_ent_financiera_id' => 2,
            'creado_en'              => date('Y-m-d H:i:s'),
            'actualizado_en'         => date('Y-m-d H:i:s'),
            'creado_por'             => 1,
            'actualizado_por'        => 1,
        ));
        $this->insert('staff_persona',array(
            'dni'                    => '34663389',
            'nombres'                => 'Manuel',
            'apellido_paterno'       => 'Rondon',
            'apellido_materno'       => 'Carpio',
            'codigo_pnia'            => '1010',
            'ruc'                    => '12345675463',
            'nivel'                  => 1,
            'cuenta_bancaria'        => '43435672321561',
            'pnia_ent_financiera_id' => 2,
            'creado_en'              => date('Y-m-d H:i:s'),
            'actualizado_en'         => date('Y-m-d H:i:s'),
            'creado_por'             => 1,
            'actualizado_por'        => 1,
        ));
        $this->insert('staff_persona',array(
            'dni'                    => '14678945',
            'nombres'                => 'Jose María',
            'apellido_paterno'       => 'Pinto',
            'apellido_materno'       => 'Delgado',
            'codigo_pnia'            => '1011',
            'ruc'                    => '12345633344',
            'nivel'                  => 1,
            'cuenta_bancaria'        => '434444631561',
            'pnia_ent_financiera_id' => 2,
            'creado_en'              => date('Y-m-d H:i:s'),
            'actualizado_en'         => date('Y-m-d H:i:s'),
            'creado_por'             => 1,
            'actualizado_por'        => 1,
        ));
        
        $this->insert('staff_persona',array(
            'dni'                    => '45678544',
            'nombres'                => 'Rodrigo Manuel',
            'apellido_paterno'       => 'Perales',
            'apellido_materno'       => 'Cornejo',
            'codigo_pnia'            => '1012',
            'ruc'                    => '12345633789',
            'nivel'                  => 1,
            'cuenta_bancaria'        => '434444631450',
            'pnia_ent_financiera_id' => 2,
            'creado_en'              => date('Y-m-d H:i:s'),
            'actualizado_en'         => date('Y-m-d H:i:s'),
            'creado_por'             => 1,
            'actualizado_por'        => 1,
        ));
        
        $this->insert('staff_persona',array(
            'dni'                    => '45634566',
            'nombres'                => 'Diego Renzo',
            'apellido_paterno'       => 'Camino',
            'apellido_materno'       => 'Sanchez',
            'codigo_pnia'            => '1013',
            'ruc'                    => '12345638890',
            'nivel'                  => 1,
            'cuenta_bancaria'        => '431765631450',
            'pnia_ent_financiera_id' => 2,
            'creado_en'              => date('Y-m-d H:i:s'),
            'actualizado_en'         => date('Y-m-d H:i:s'),
            'creado_por'             => 1,
            'actualizado_por'        => 1,
        ));
        
        $this->insert('staff_persona',array(
            'dni'                    => '45634566',
            'nombres'                => 'Diana María',
            'apellido_paterno'       => 'Morales',
            'apellido_materno'       => 'Sanz',
            'codigo_pnia'            => '1014',
            'ruc'                    => '12311633290',
            'nivel'                  => 1,
            'cuenta_bancaria'        => '431765630480',
            'pnia_ent_financiera_id' => 2,
            'creado_en'              => date('Y-m-d H:i:s'),
            'actualizado_en'         => date('Y-m-d H:i:s'),
            'creado_por'             => 1,
            'actualizado_por'        => 1,
        ));
        
        $this->insert('staff_persona',array(
            'dni'                    => '45634566',
            'nombres'                => 'Rodolfo',
            'apellido_paterno'       => 'Perez',
            'apellido_materno'       => 'Delgado',
            'codigo_pnia'            => '1015',
            'ruc'                    => '12441633290',
            'nivel'                  => 1,
            'cuenta_bancaria'        => '433265630480',
            'pnia_ent_financiera_id' => 2,
            'creado_en'              => date('Y-m-d H:i:s'),
            'actualizado_en'         => date('Y-m-d H:i:s'),
            'creado_por'             => 1,
            'actualizado_por'        => 1,
        ));
        
        $this->insert('staff_persona',array(
            'dni'                    => '45634566',
            'nombres'                => 'Winston',
            'apellido_paterno'       => 'Paredes',
            'apellido_materno'       => 'Piero',
            'codigo_pnia'            => '1016',
            'ruc'                    => '17891633290',
            'nivel'                  => 1,
            'cuenta_bancaria'        => '431169630480',
            'pnia_ent_financiera_id' => 2,
            'creado_en'              => date('Y-m-d H:i:s'),
            'actualizado_en'         => date('Y-m-d H:i:s'),
            'creado_por'             => 1,
            'actualizado_por'        => 1,
        ));


        // $this->insert('staff_area',array(
        //     'codigo'                 => 'a1',
        //     'descripcion'            => 'Área de informática ',
        //     'cargo'                  => 'Jefe de informática',
        //     'responsable'            => 1,//Juan
        //     'creado_en'              => date('Y-m-d H:i:s'),
        //     'actualizado_en'         => date('Y-m-d H:i:s'),
        //     'creado_por'             => 1,
        //     'actualizado_por'        => 1,
        // ));
        // $this->insert('staff_area',array(
        //     'codigo'                 => 'a2',
        //     'descripcion'            => 'Área de logística ',
        //     'cargo'                  => 'Jefe de logística',
        //     'responsable'            => 2,//Marco
        //     'creado_en'              => date('Y-m-d H:i:s'),
        //     'actualizado_en'         => date('Y-m-d H:i:s'),
        //     'creado_por'             => 1,
        //     'actualizado_por'        => 1,
        // ));

        // $this->insert('arbol_pnia',array(
        //     'descripcion'            => 'Arbol 1',
        //     'creado_en'              => date('Y-m-d H:i:s'),
        //     'actualizado_en'         => date('Y-m-d H:i:s'),
        //     'creado_por'             => 1,
        //     'actualizado_por'        => 1,
        // ));

        $this->insert('usuario',array(  
            'alias' => 'juan',
            'password_hash' => '$2y$13$M/gOwqCl8CQwsbU9Q1vTbeEVGTe62b7Oe1jvVUw1BLu3JF7QSr9Ce',
                //('MiPassword1'),
            'persona_id' => 1,//juan
            'clave_autenticacion' => 'non',
            'token_de_acceso' => 'AccToken'
        ));
        $this->insert('usuario',array(  
            'alias' => 'marco',
            'password_hash' => '$2y$13$M/gOwqCl8CQwsbU9Q1vTbeEVGTe62b7Oe1jvVUw1BLu3JF7QSr9Ce',
                //('MiPassword1'),
            'persona_id' => 2,//marco
            'clave_autenticacion' => 'non',
            'token_de_acceso' => 'AccToken'
        ));
        $this->insert('usuario',array(  
            'alias' => 'carlos',
            'password_hash' => '$2y$13$M/gOwqCl8CQwsbU9Q1vTbeEVGTe62b7Oe1jvVUw1BLu3JF7QSr9Ce',
                //('MiPassword1'),
            'persona_id' => 3,//carlos
            'clave_autenticacion' => 'non',
            'token_de_acceso' => 'AccToken'
        ));
        $this->insert('usuario',array(  
            'alias' => 'maria',
            'password_hash' => '$2y$13$M/gOwqCl8CQwsbU9Q1vTbeEVGTe62b7Oe1jvVUw1BLu3JF7QSr9Ce',
                //('MiPassword1'),
            'persona_id' => 4,
            'clave_autenticacion' => 'non',
            'token_de_acceso' => 'AccToken'
        ));
        $this->insert('usuario',array(  
            'alias' => 'miguel',
            'password_hash' => '$2y$13$M/gOwqCl8CQwsbU9Q1vTbeEVGTe62b7Oe1jvVUw1BLu3JF7QSr9Ce',
                //('MiPassword1'),
            'persona_id' => 5,
            'clave_autenticacion' => 'non',
            'token_de_acceso' => 'AccToken'
        ));
        $this->insert('usuario',array(  
            'alias' => 'diana',
            'password_hash' => '$2y$13$M/gOwqCl8CQwsbU9Q1vTbeEVGTe62b7Oe1jvVUw1BLu3JF7QSr9Ce',
                //('MiPassword1'),
            'persona_id' => 6,
            'clave_autenticacion' => 'non',
            'token_de_acceso' => 'AccToken'
        ));
        $this->insert('usuario',array(  
            'alias' => 'manuel',
            'password_hash' => '$2y$13$M/gOwqCl8CQwsbU9Q1vTbeEVGTe62b7Oe1jvVUw1BLu3JF7QSr9Ce',
                //('MiPassword1'),
            'persona_id' => 10,
            'clave_autenticacion' => 'non',
            'token_de_acceso' => 'AccToken'
        ));
        $this->insert('usuario',array(  
            'alias' => 'diego',
            'password_hash' => '$2y$13$M/gOwqCl8CQwsbU9Q1vTbeEVGTe62b7Oe1jvVUw1BLu3JF7QSr9Ce',
                //('MiPassword1'),
            'persona_id' => 7,
            'clave_autenticacion' => 'non',
            'token_de_acceso' => 'AccToken'
        ));
        $this->insert('usuario',array(  
            'alias' => 'gonzalo',
            'password_hash' => '$2y$13$M/gOwqCl8CQwsbU9Q1vTbeEVGTe62b7Oe1jvVUw1BLu3JF7QSr9Ce',
                //('MiPassword1'),
            'persona_id' => 8,
            'clave_autenticacion' => 'non',
            'token_de_acceso' => 'AccToken'
        ));
        $this->insert('usuario',array(  
            'alias' => 'luigi',
            'password_hash' => '$2y$13$M/gOwqCl8CQwsbU9Q1vTbeEVGTe62b7Oe1jvVUw1BLu3JF7QSr9Ce',
                //('MiPassword1'),
            'persona_id' => 9,
            'clave_autenticacion' => 'non',
            'token_de_acceso' => 'AccToken'
        ));
        $this->insert('usuario',array(  
            'alias' => 'josemaria',
            'password_hash' => '$2y$13$M/gOwqCl8CQwsbU9Q1vTbeEVGTe62b7Oe1jvVUw1BLu3JF7QSr9Ce',
                //('MiPassword1'),
            'persona_id' => 11,
            'clave_autenticacion' => 'non',
            'token_de_acceso' => 'AccToken'
        ));
        
        $this->insert('usuario',array(  
            'alias' => 'rodrigo',
            'password_hash' => '$2y$13$M/gOwqCl8CQwsbU9Q1vTbeEVGTe62b7Oe1jvVUw1BLu3JF7QSr9Ce',
                //('MiPassword1'),
            'persona_id' => 12,
            'clave_autenticacion' => 'non',
            'token_de_acceso' => 'AccToken'
        ));
        
        $this->insert('usuario',array(  
            'alias' => 'diegos',
            'password_hash' => '$2y$13$M/gOwqCl8CQwsbU9Q1vTbeEVGTe62b7Oe1jvVUw1BLu3JF7QSr9Ce',
                //('MiPassword1'),
            'persona_id' => 13,
            'clave_autenticacion' => 'non',
            'token_de_acceso' => 'AccToken'
        ));
        
        $this->insert('usuario',array(  
            'alias' => 'dianas',
            'password_hash' => '$2y$13$M/gOwqCl8CQwsbU9Q1vTbeEVGTe62b7Oe1jvVUw1BLu3JF7QSr9Ce',
                //('MiPassword1'),
            'persona_id' => 14,
            'clave_autenticacion' => 'non',
            'token_de_acceso' => 'AccToken'
        ));
        
        $this->insert('usuario',array(  
            'alias' => 'rodolfo1',
            'password_hash' => '$2y$13$M/gOwqCl8CQwsbU9Q1vTbeEVGTe62b7Oe1jvVUw1BLu3JF7QSr9Ce',
                //('MiPassword1'),
            'persona_id' => 15,
            'clave_autenticacion' => 'non',
            'token_de_acceso' => 'AccToken'
        ));
        
        $this->insert('usuario',array(  
            'alias' => 'winston',
            'password_hash' => '$2y$13$M/gOwqCl8CQwsbU9Q1vTbeEVGTe62b7Oe1jvVUw1BLu3JF7QSr9Ce',
                //('MiPassword1'),
            'persona_id' => 16,
            'clave_autenticacion' => 'non',
            'token_de_acceso' => 'AccToken'
        ));
        

        $this->insert('rol_usuario',array(
            'rol_id'      => 1,
            'usuario_id'       => 2,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('rol_usuario',array(
            'rol_id'      => 1,
            'usuario_id'       => 3,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('rol_usuario',array(
            'rol_id'      => 1,
            'usuario_id'       => 4,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('rol_usuario',array(
            'rol_id'      => 1,
            'usuario_id'       => 5,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('rol_usuario',array(
            'rol_id'      => 1,
            'usuario_id'       => 6,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('rol_usuario',array(
            'rol_id'      => 1,
            'usuario_id'       => 7,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('rol_usuario',array(
            'rol_id'      => 1,
            'usuario_id'       => 8,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('rol_usuario',array(
            'rol_id'      => 1,
            'usuario_id'       => 9,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('rol_usuario',array(
            'rol_id'      => 1,
            'usuario_id'       => 10,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('rol_usuario',array(
            'rol_id'      => 1,
            'usuario_id'       => 11,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('rol_usuario',array(
            'rol_id'      => 1,
            'usuario_id'       => 12,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        
         $this->insert('rol_usuario',array(
            'rol_id'      => 10,
            'usuario_id'       => 13,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
         
         //para seguridad
         $this->insert('rol_usuario',array(
            'rol_id'      => 7,
            'usuario_id'       => 14,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
         //para rrhh
         $this->insert('rol_usuario',array(
            'rol_id'      => 8,
            'usuario_id'       => 14,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
         
         //para logistica
         //por ahora con rol master
         $this->insert('rol_usuario',array(
            'rol_id'      => 1,
            'usuario_id'       => 15,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
         
         //rofoldo1
         $this->insert('rol_usuario',array(
            'rol_id'      => 1,
            'usuario_id'       => 16,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
         
         //winston
         $this->insert('rol_usuario',array(
            'rol_id'      => 1,
            'usuario_id'       => 17,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

////////STAFF_AREA////////
//        $this->insert('staff_area',array(
//            'codigo'      => '1',
//            'descripcion'      => 'Área de presupuesto',
//            'cargo'      => 'Jefe de presupuestos',
//            'responsable'       => 1,
//            'area_superior'      => null,
//            'creado_en'         => date('Y-m-d H:i:s'),
//            'actualizado_en'    => date('Y-m-d H:i:s'),
//            'creado_por'        => 1,
//            'actualizado_por'   => 1,
//        ));
//        $this->insert('staff_area',array(
//            'codigo'      => '2',
//            'descripcion'      => 'Área de logística',
//            'cargo'      => 'Jefe de logística',
//            'responsable'       => 2,
//            'area_superior'      => null,
//            'creado_en'         => date('Y-m-d H:i:s'),
//            'actualizado_en'    => date('Y-m-d H:i:s'),
//            'creado_por'        => 1,
//            'actualizado_por'   => 1,
//        ));
//        $this->insert('staff_area',array(
//            'codigo'      => '3',
//            'descripcion'      => 'Área de Contabilidad',
//            'cargo'      => 'Contador',
//            'responsable'       => 1,
//            'area_superior'      => null,
//            'creado_en'         => date('Y-m-d H:i:s'),
//            'actualizado_en'    => date('Y-m-d H:i:s'),
//            'creado_por'        => 1,
//            'actualizado_por'   => 1,
//        ));
        $this->insert('staff_area',array(
            'codigo'      => '1',
            'descripcion'      => 'Gerencia General - Gerente General',
            'cargo'      => 'Gerencia General - Gerente General',
            'responsable'       => 3,
            'area_superior'      => null,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('staff_area',array(
            'codigo'      => '1.1',
            'descripcion'      => 'Gerencia General - Secretaria de Gerencia',
            'cargo'      => 'Gerencia General - Secretaria de Gerencia',
            'responsable'       => 4,
            'area_superior'      => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('staff_area',array(
            'codigo'      => '2',
            'descripcion'      => 'Departamento de Contabilidad - Gerente de Contabilidad',
            'cargo'      => 'Departamento de Contabilidad - Gerente de Contabilidad',
            'responsable'       => 7,
            'area_superior'      => null,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('staff_area',array(
            'codigo'      => '2.1',
            'descripcion'      => 'Departamento de Contabilidad - Tesorero',
            'cargo'      => 'Departamento de Contabilidad - Tesorero',
            'responsable'       => 8,
            'area_superior'      => 3,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
         $this->insert('staff_area',array(
            'codigo'      => '2.2',
            'descripcion'      => 'Departamento de Contabilidad - Contador',
            'cargo'      => 'Departamento de Contabilidad - Contador',
            'responsable'       => 11,
            'area_superior'      => 3,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('staff_area',array(
            'codigo'      => '3',
            'descripcion'      => 'Gerencia de Administración - Gerente de Administración',
            'cargo'      => 'Gerencia de Administración - Gerente de Administración',
            'responsable'       => 5,
            'area_superior'      => null,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('staff_area',array(
            'codigo'      => '3.1',
            'descripcion'      => 'Gerencia de Administración - Secretaria de Administración',
            'cargo'      => 'Gerencia de Administración - Secretaria de Administración',
            'responsable'       => 6,
            'area_superior'      => 6,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('staff_area',array(
            'codigo'      => '4',
            'descripcion'      => 'Gerencia de Proyectos - Gerente de Proyectos',
            'cargo'      => 'Gerencia de Proyectos - Gerente de Proyectos',
            'responsable'       => 9,
            'area_superior'      => null,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('staff_area',array(
            'codigo'      => '4.1',
            'descripcion'      => 'Gerencia de Proyectos - Gestor de Proyectos',
            'cargo'      => 'Gerencia de Proyectos - Gestor de Proyectos',
            'responsable'       => 10,
            'area_superior'      => 8,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('staff_area',array(
            'codigo'      => '4.2',
            'descripcion'      => 'Gerencia de Proyectos - Gestor de Informes',
            'cargo'      => 'Gerencia de Proyectos - Gestor de Informes',
            'responsable'       => 13,
            'area_superior'      => 8,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        
         $this->insert('staff_area',array(
            'codigo'      => '5',
            'descripcion'      => 'Departamento de Logística - Asistente de Adquisiciones',
            'cargo'      => 'Departamento de logística - Asistente de Adquisiciones',
            'responsable'       => 14,
            'area_superior'      => null,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
         
         $this->insert('staff_area',array(
            'codigo'      => '6',
            'descripcion'      => 'Especialista de Planificación SIAF',
            'cargo'      => 'Especialista de Planificación SIAF',
            'responsable'       => 15,
            'area_superior'      => null,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
         
         $this->insert('staff_area',array(
            'codigo'      => '7',
            'descripcion'      => 'Asistente Legal de Contratos',
            'cargo'      => 'Asistente Legal de Contratos',
            'responsable'       => 16,
            'area_superior'      => null,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        
        
       

////////FLUJO FLUJO////////
        ///ADQUISICIÓN
        $this->insert('flujo_flujo',array(
            'nombre_flujo'      => 'Flujo de Adquisición - Gestor de Proyectos',
            'tipo_flujo_metacodigo'       => 37,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
//        $this->insert('flujo_flujo',array(
//            'nombre_flujo'      => 'Desembolso',
//            'tipo_flujo_metacodigo'       => 39,
//            'creado_en'         => date('Y-m-d H:i:s'),
//            'actualizado_en'    => date('Y-m-d H:i:s'),
//            'creado_por'        => 1,
//            'actualizado_por'   => 1,
//        ));
//        $this->insert('flujo_flujo',array(
//            'nombre_flujo'      => 'Contrato - Gestor de proyectos',
//            'tipo_flujo_metacodigo'       => 41,
//            'creado_en'         => date('Y-m-d H:i:s'),
//            'actualizado_en'    => date('Y-m-d H:i:s'),
//            'creado_por'        => 1,
//            'actualizado_por'   => 1,
//        ));
        $this->insert('flujo_flujo',array(
            'nombre_flujo'      => 'Trámite Documentario - Gestor de proyectos',
            'tipo_flujo_metacodigo'       => 42,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        
        ///PARA VIATICO
        $this->insert('flujo_flujo',array(
            'nombre_flujo'      => 'Flujo de Viático - Gestor de Proyectos',
            'tipo_flujo_metacodigo'       => 23,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        //PARA CCH
        $this->insert('flujo_flujo',array(
            'nombre_flujo'      => 'Flujo de Caja Chica - Secretaria de Gerencia',
            'tipo_flujo_metacodigo'       => 25,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        //PARA DESEMBOLSO
        $this->insert('flujo_flujo',array(
            'nombre_flujo'      => 'Flujo de Desembolso - Gestor de Proyectos',
            'tipo_flujo_metacodigo'       => 27,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        //PARA ENTREGA
        $this->insert('flujo_flujo',array(
            'nombre_flujo'      => 'Flujo de Entrega - Gestor de Proyectos',
            'tipo_flujo_metacodigo'       => 26,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_flujo',array(
            'nombre_flujo'      => 'Adquisición BM - Gestor de Proyectos',
            'tipo_flujo_metacodigo'       => 37,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        

////////FLUJO PASO////////
        //ADQUISICIÓN
        $this->insert('flujo_paso',array(
            'flujo'      => 1,
            'nombre_paso'      => 'En digitación',
            'estado_paso_metacodigo'       => 31,
            'area_responsable_id'       => 9,
            'primer_flujo_paso'       => 1,
            'nivel'       => 1,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 1,
            'nombre_paso'      => 'Por Aprobar',
            'estado_paso_metacodigo'       => 32,
            'area_responsable_id'       => 8,
            'primer_flujo_paso'       => 1,
            'nivel'       => 2,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 1,
            'nombre_paso'      => 'Aprobado',
            'estado_paso_metacodigo'       => 67,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 1,
            'nivel'       => 3,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
            'proceso_presupuesto' => 'Comprometido'
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 1,
            'nombre_paso'      => 'Desaprobada',
            'estado_paso_metacodigo'       => 34,
            'area_responsable_id'       => 9,
            'primer_flujo_paso'       => 1,
            'nivel'       => 3,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        
        $this->insert('flujo_paso',array(
            'flujo'      => 1,
            'nombre_paso'      => 'FECHA DE INFORME O ACTA DE EVALUACIÓN',
            'estado_paso_metacodigo'       => 38,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 1,
            'nivel'       => 8,
            'cantidad_dias'       => 5,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 1,
            'nombre_paso'      => 'FECHA DE ENVIO DEL ACTA DE EVALUACIÓN TÉCNICO ECONÓMICA',
            'estado_paso_metacodigo'       => 38,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 1,
            'nivel'       => 9,
            'cantidad_dias'       => 5,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 1,
            'nombre_paso'      => 'FECHA DE NOB DEL BANCO A LA EVALUACIÓN',
            'estado_paso_metacodigo'       => 38,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 1,
            'nivel'       => 10,
            'cantidad_dias'       => 5,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 1,
            'nombre_paso'      => 'FECHA DE APERTURA DE SOBRES ECONÓMICOS',
            'estado_paso_metacodigo'       => 38,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 1,
            'nivel'       => 11,
            'cantidad_dias'       => 5,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 1,
            'nombre_paso'      => 'JUSTIFICACIÓN DE SELECCIÓN DIRECTA',
            'estado_paso_metacodigo'       => 38,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 1,
            'nivel'       => 12,
            'cantidad_dias'       => 5,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 1,
            'nombre_paso'      => 'INVITACIÓN AL CONSULTOR IDENTIFICADO / SELECCIONADO',
            'estado_paso_metacodigo'       => 38,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 1,
            'nivel'       => 13,
            'cantidad_dias'       => 5,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 1,
            'nombre_paso'      => 'BORRADOR DE CONTRATO',
            'estado_paso_metacodigo'       => 40,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 1,
            'nivel'       => 14,
            'cantidad_dias'       => 5,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 1,
            'nombre_paso'      => 'NOTIFICACIÓN DE ADJUDICACIÓN',
            'estado_paso_metacodigo'       => 38,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 1,
            'nivel'       => 15,
            'cantidad_dias'       => 5,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 1,
            'nombre_paso'      => 'FIRMA DE CONTRATO',
            'estado_paso_metacodigo'       => 38,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 1,
            'nivel'       => 16,
            'cantidad_dias'       => 5,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 1,
            'nombre_paso'      => 'ADENDAS DE CONTRATO',
            'estado_paso_metacodigo'       => 38,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 1,
            'nivel'       => 17,
            'cantidad_dias'       => 5,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 1,
            'nombre_paso'      => 'CIERRE DE CONTRATO',
            'estado_paso_metacodigo'       => 38,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 1,
            'nivel'       => 18,
            'cantidad_dias'       => 5,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        
        




//        
//        $this->insert('flujo_paso',array(
//            'flujo'      => 2,
//            'nombre_paso'      => 'Comprometido',
//            'proceso_presupuesto' => 'Comprometido',
//            'estado_paso_metacodigo'       => 32,
//            'area_responsable_id'       => 4,
//            'primer_flujo_paso'       => 16,
//            'nivel'       => 1,
//            'cantidad_dias'       => 5,
//            'creado_en'         => date('Y-m-d H:i:s'),
//            'actualizado_en'    => date('Y-m-d H:i:s'),
//            'creado_por'        => 1,
//            'actualizado_por'   => 1,
//        ));
//        $this->insert('flujo_paso',array(
//            'flujo'      => 2,
//            'nombre_paso'      => 'Ejecutado',
//            'proceso_presupuesto' => 'Ejecutado',
//            'estado_paso_metacodigo'       => 33,
//            'area_responsable_id'       => 4,
//            'primer_flujo_paso'       => 16,
//            'nivel'       => 2,
//            'cantidad_dias'       => 5,
//            'creado_en'         => date('Y-m-d H:i:s'),
//            'actualizado_en'    => date('Y-m-d H:i:s'),
//            'creado_por'        => 1,
//            'actualizado_por'   => 1,
//        ));


//        $this->insert('flujo_paso',array(
//            'flujo'      => 3,
//            'nombre_paso'      => 'En digitación',
//            'estado_paso_metacodigo'       => 31,
//            'area_responsable_id'       => 9,
//            'primer_flujo_paso'       => 18,
//            'nivel'       => 1,
//            'cantidad_dias'       => 0,
//            'creado_en'         => date('Y-m-d H:i:s'),
//            'actualizado_en'    => date('Y-m-d H:i:s'),
//            'creado_por'        => 1,
//            'actualizado_por'   => 1,
//        ));
//        $this->insert('flujo_paso',array(
//            'flujo'      => 3,
//            'nombre_paso'      => 'Por aprobar',
//            'estado_paso_metacodigo'       => 32,
//            'area_responsable_id'       => 9,
//            'primer_flujo_paso'       => 18,
//            'nivel'       => 2,
//            'cantidad_dias'       => 5,
//            'creado_en'         => date('Y-m-d H:i:s'),
//            'actualizado_en'    => date('Y-m-d H:i:s'),
//            'creado_por'        => 1,
//            'actualizado_por'   => 1,
//        ));
//        $this->insert('flujo_paso',array(
//            'flujo'      => 3,
//            'nombre_paso'      => 'Aprobado',
//            'estado_paso_metacodigo'       => 33,
//            'area_responsable_id'       => 9,
//            'primer_flujo_paso'       => 18,
//            'nivel'       => 3,
//            'cantidad_dias'       => 0,
//            'creado_en'         => date('Y-m-d H:i:s'),
//            'actualizado_en'    => date('Y-m-d H:i:s'),
//            'creado_por'        => 1,
//            'actualizado_por'   => 1,
//        ));
        
//        //para rendiciones
//        $this->insert('flujo_paso',array(
//            'flujo'      => 5,
//            'nombre_paso'      => 'Por Aprobar',
//            'estado_paso_metacodigo'       => 37,
//            'area_responsable_id'       => 12,
//            'primer_flujo_paso'       => 21,
//            'nivel'       => 1,
//            'cantidad_dias'       => 0,
//            'creado_en'         => date('Y-m-d H:i:s'),
//            'actualizado_en'    => date('Y-m-d H:i:s'),
//            'creado_por'        => 1,
//            'actualizado_por'   => 1,
//        ));
//        $this->insert('flujo_paso',array(
//            'flujo'      => 5,
//            'nombre_paso'      => 'Aprobado',
//            'estado_paso_metacodigo'       => 38,
//            'area_responsable_id'       => 12,
//            'primer_flujo_paso'       => 21,
//            'nivel'       => 2,
//            'cantidad_dias'       => 0,
//            'creado_en'         => date('Y-m-d H:i:s'),
//            'actualizado_en'    => date('Y-m-d H:i:s'),
//            'creado_por'        => 1,
//            'actualizado_por'   => 1,
//        ));
//        $this->insert('flujo_paso',array(
//            'flujo'      => 5,
//            'nombre_paso'      => 'Cancelado',
//            'estado_paso_metacodigo'       => 39,
//            'area_responsable_id'       => 3,
//            'primer_flujo_paso'       => 21,
//            'nivel'       => 2,
//            'cantidad_dias'       => 0,
//            'creado_en'         => date('Y-m-d H:i:s'),
//            'actualizado_en'    => date('Y-m-d H:i:s'),
//            'creado_por'        => 1,
//            'actualizado_por'   => 1,
//        ));
//        
//        $this->insert('flujo_paso',array(
//            'flujo'      => 6,
//            'nombre_paso'      => 'Por Aprobar',
//            'estado_paso_metacodigo'       => 37,
//            'area_responsable_id'       => 1,
//            'primer_flujo_paso'       => 24,
//            'nivel'       => 1,
//            'cantidad_dias'       => 0,
//            'creado_en'         => date('Y-m-d H:i:s'),
//            'actualizado_en'    => date('Y-m-d H:i:s'),
//            'creado_por'        => 1,
//            'actualizado_por'   => 1,
//        ));
//        $this->insert('flujo_paso',array(
//            'flujo'      => 6,
//            'nombre_paso'      => 'Aprobado',
//            'estado_paso_metacodigo'       => 38,
//            'area_responsable_id'       => 3,
//            'primer_flujo_paso'       => 24,
//            'nivel'       => 2,
//            'cantidad_dias'       => 0,
//            'creado_en'         => date('Y-m-d H:i:s'),
//            'actualizado_en'    => date('Y-m-d H:i:s'),
//            'creado_por'        => 1,
//            'actualizado_por'   => 1,
//        ));
//        $this->insert('flujo_paso',array(
//            'flujo'      => 6,
//            'nombre_paso'      => 'Cancelado',
//            'estado_paso_metacodigo'       => 39,
//            'area_responsable_id'       => 3,
//            'primer_flujo_paso'       => 24,
//            'nivel'       => 2,
//            'cantidad_dias'       => 0,
//            'creado_en'         => date('Y-m-d H:i:s'),
//            'actualizado_en'    => date('Y-m-d H:i:s'),
//            'creado_por'        => 1,
//            'actualizado_por'   => 1,
//        ));
//        
//        $this->insert('flujo_paso',array(
//            'flujo'      => 7,
//            'nombre_paso'      => 'Por Aprobar',
//            'estado_paso_metacodigo'       => 37,
//            'area_responsable_id'       => 1,
//            'primer_flujo_paso'       => 27,
//            'nivel'       => 1,
//            'cantidad_dias'       => 0,
//            'creado_en'         => date('Y-m-d H:i:s'),
//            'actualizado_en'    => date('Y-m-d H:i:s'),
//            'creado_por'        => 1,
//            'actualizado_por'   => 1,
//        ));
//        $this->insert('flujo_paso',array(
//            'flujo'      => 7,
//            'nombre_paso'      => 'Aprobado',
//            'estado_paso_metacodigo'       => 38,
//            'area_responsable_id'       => 3,
//            'primer_flujo_paso'       => 27,
//            'nivel'       => 2,
//            'cantidad_dias'       => 0,
//            'creado_en'         => date('Y-m-d H:i:s'),
//            'actualizado_en'    => date('Y-m-d H:i:s'),
//            'creado_por'        => 1,
//            'actualizado_por'   => 1,
//        ));
//        $this->insert('flujo_paso',array(
//            'flujo'      => 7,
//            'nombre_paso'      => 'Cancelado',
//            'estado_paso_metacodigo'       => 39,
//            'area_responsable_id'       => 3,
//            'primer_flujo_paso'       => 27,
//            'nivel'       => 2,
//            'cantidad_dias'       => 0,
//            'creado_en'         => date('Y-m-d H:i:s'),
//            'actualizado_en'    => date('Y-m-d H:i:s'),
//            'creado_por'        => 1,
//            'actualizado_por'   => 1,
//        ));
        
        ///PARA VIATICO///
        $this->insert('flujo_paso',array(
            'flujo'      => 3,
            'nombre_paso'      => 'En digitación',
            'estado_paso_metacodigo'       => 31,
            'area_responsable_id'       => 9,
            'primer_flujo_paso'       => 16,
            'nivel'       => 1,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 3,
            'nombre_paso'      => 'Por Aprobar',
            'estado_paso_metacodigo'       => 32,
            'area_responsable_id'       => 8,
            'primer_flujo_paso'       => 16,
            'nivel'       => 2,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 3,
            'nombre_paso'      => 'Fondo Aprobado',
            'estado_paso_metacodigo'       => 33,
            'area_responsable_id'       => 9,
            'primer_flujo_paso'       => 16,
            'nivel'       => 3,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 3,
            'nombre_paso'      => 'Fondo Desaprobado',
            'estado_paso_metacodigo'       => 34,
            'area_responsable_id'       => 9,
            'primer_flujo_paso'       => 16,
            'nivel'       => 3,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 3,
            'nombre_paso'      => 'Enviar fondo para aprobación',
            'estado_paso_metacodigo'       => 32,
            'area_responsable_id'       => 4,
            'primer_flujo_paso'       => 16,
            'nivel'       => 4,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 3,
            'nombre_paso'      => 'Monto de viático aprobado',
            'estado_paso_metacodigo'       => 33,
            'area_responsable_id'       => 9,
            'primer_flujo_paso'       => 16,
            'nivel'       => 5,
            'cantidad_dias'       => 1,
            'proceso_presupuesto' => 'Ejecutado',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 3,
            'nombre_paso'      => 'Monto de viático desaprobado',
            'estado_paso_metacodigo'       => 34,
            'area_responsable_id'       => 9,
            'primer_flujo_paso'       => 16,
            'nivel'       => 5,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 3,
            'nombre_paso'      => 'Enviar rendición para revisión',
            'estado_paso_metacodigo'       => 32,
            'area_responsable_id'       => 5,
            'primer_flujo_paso'       => 16,
            'nivel'       => 6,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 3,
            'nombre_paso'      => 'Rendición Aprobada',
            'estado_paso_metacodigo'       => 33,
            'area_responsable_id'       => 9,
            'primer_flujo_paso'       => 16,
            'nivel'       => 7,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 3,
            'nombre_paso'      => 'Rendición desaprobada',
            'estado_paso_metacodigo'       => 34,
            'area_responsable_id'       => 9,
            'primer_flujo_paso'       => 16,
            'nivel'       => 7,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        
        
        ///PARA CAJA CHICA///
        $this->insert('flujo_paso',array(
            'flujo'      => 4,
            'nombre_paso'      => 'En digitación',
            'estado_paso_metacodigo'       => 31,
            'area_responsable_id'       => 2,
            'primer_flujo_paso'       => 26,
            'nivel'       => 1,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 4,
            'nombre_paso'      => 'Por Aprobar',
            'estado_paso_metacodigo'       => 32,
            'area_responsable_id'       => 1,
            'primer_flujo_paso'       => 26,
            'nivel'       => 2,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 4,
            'nombre_paso'      => 'Fondo de caja chica aprobado',
            'estado_paso_metacodigo'       => 33,
            'area_responsable_id'       => 2,
            'primer_flujo_paso'       => 26,
            'nivel'       => 3,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 4,
            'nombre_paso'      => 'Fondo de caja chica desaprobado',
            'estado_paso_metacodigo'       => 34,
            'area_responsable_id'       => 2,
            'primer_flujo_paso'       => 26,
            'nivel'       => 3,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 4,
            'nombre_paso'      => 'Enviar fondo de caja chica para aprobación',
            'estado_paso_metacodigo'       => 32,
            'area_responsable_id'       => 4,
            'primer_flujo_paso'       => 26,
            'nivel'       => 4,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 4,
            'nombre_paso'      => 'Monto de caja chica aprobado',
            'estado_paso_metacodigo'       => 33,
            'area_responsable_id'       => 2,
            'primer_flujo_paso'       => 26,
            'nivel'       => 5,
            'cantidad_dias'       => 1,
            'proceso_presupuesto' => 'Ejecutado',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 4,
            'nombre_paso'      => 'Monto de caja chica desaprobado',
            'estado_paso_metacodigo'       => 34,
            'area_responsable_id'       => 2,
            'primer_flujo_paso'       => 26,
            'nivel'       => 5,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 4,
            'nombre_paso'      => 'Enviar rendición de caja chica para revisión',
            'estado_paso_metacodigo'       => 32,
            'area_responsable_id'       => 5,
            'primer_flujo_paso'       => 26,
            'nivel'       => 6,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 4,
            'nombre_paso'      => 'Rendición de caja chica aprobada',
            'estado_paso_metacodigo'       => 33,
            'area_responsable_id'       => 2,
            'primer_flujo_paso'       => 26,
            'nivel'       => 7,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 4,
            'nombre_paso'      => 'Rendición de caja chica desaprobada',
            'estado_paso_metacodigo'       => 34,
            'area_responsable_id'       => 2,
            'primer_flujo_paso'       => 26,
            'nivel'       => 7,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        ///PARA DESEMBOLSO///
        $this->insert('flujo_paso',array(
            'flujo'      => 5,
            'nombre_paso'      => 'En digitación',
            'estado_paso_metacodigo'       => 31,
            'area_responsable_id'       => 9,
            'primer_flujo_paso'       => 36,
            'nivel'       => 1,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 5,
            'nombre_paso'      => 'Por aprobar requerimiento de desembolso',
            'estado_paso_metacodigo'       => 32,
            'area_responsable_id'       => 8,
            'primer_flujo_paso'       => 36,
            'nivel'       => 2,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 5,
            'nombre_paso'      => 'Requerimiento de Desembolso aprobado',
            'estado_paso_metacodigo'       => 33,
            'area_responsable_id'       => 9,
            'primer_flujo_paso'       => 36,
            'nivel'       => 3,
            'cantidad_dias'       => 1,
            //'proceso_presupuesto' => 'Ejecutado',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 5,
            'nombre_paso'      => 'Requerimiento de Desembolso desaprobado',
            'estado_paso_metacodigo'       => 34,
            'area_responsable_id'       => 9,
            'primer_flujo_paso'       => 36,
            'nivel'       => 3,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 5,
            'nombre_paso'      => 'Enviar fondo de desembolso para aprobación',
            'estado_paso_metacodigo'       => 32,
            'area_responsable_id'       => 8,
            'primer_flujo_paso'       => 36,
            'nivel'       => 4,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 5,
            'nombre_paso'      => 'Requerimiento de Desembolso aprobado',
            'estado_paso_metacodigo'       => 33,
            'area_responsable_id'       => 9,
            'primer_flujo_paso'       => 36,
            'nivel'       => 5,
            'cantidad_dias'       => 1,
            'proceso_presupuesto' => 'Ejecutado',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 5,
            'nombre_paso'      => 'Requerimiento de Desembolso desaprobado',
            'estado_paso_metacodigo'       => 34,
            'area_responsable_id'       => 9,
            'primer_flujo_paso'       => 36,
            'nivel'       => 5,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        
        ///PARA ENTREGA///
        $this->insert('flujo_paso',array(
            'flujo'      => 6,
            'nombre_paso'      => 'En digitación',
            'estado_paso_metacodigo'       => 31,
            'area_responsable_id'       => 9,
            'primer_flujo_paso'       => 40,
            'nivel'       => 1,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 6,
            'nombre_paso'      => 'Por Aprobar',
            'estado_paso_metacodigo'       => 32,
            'area_responsable_id'       => 8,
            'primer_flujo_paso'       => 40,
            'nivel'       => 2,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 6,
            'nombre_paso'      => 'Entrega aprobada',
            'estado_paso_metacodigo'       => 33,
            'area_responsable_id'       => 9,
            'primer_flujo_paso'       => 40,
            'nivel'       => 3,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 6,
            'nombre_paso'      => 'Entrega desaprobada',
            'estado_paso_metacodigo'       => 34,
            'area_responsable_id'       => 9,
            'primer_flujo_paso'       => 40,
            'nivel'       => 3,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 6,
            'nombre_paso'      => 'Enviar monto de entrega para aprobación',
            'estado_paso_metacodigo'       => 32,
            'area_responsable_id'       => 4,
            'primer_flujo_paso'       => 40,
            'nivel'       => 4,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 6,
            'nombre_paso'      => 'Monto de entrega aprobado',
            'estado_paso_metacodigo'       => 33,
            'area_responsable_id'       => 9,
            'primer_flujo_paso'       => 40,
            'nivel'       => 5,
            'cantidad_dias'       => 1,
            'proceso_presupuesto' => 'Ejecutado',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 6,
            'nombre_paso'      => 'Monto de entrega desaprobado',
            'estado_paso_metacodigo'       => 34,
            'area_responsable_id'       => 9,
            'primer_flujo_paso'       => 40,
            'nivel'       => 5,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 6,
            'nombre_paso'      => 'Enviar rendición de entrega para revisión',
            'estado_paso_metacodigo'       => 32,
            'area_responsable_id'       => 5,
            'primer_flujo_paso'       => 40,
            'nivel'       => 6,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 6,
            'nombre_paso'      => 'Rendición de la entrega aprobada',
            'estado_paso_metacodigo'       => 33,
            'area_responsable_id'       => 9,
            'primer_flujo_paso'       => 40,
            'nivel'       => 7,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 6,
            'nombre_paso'      => 'Rendición de la entrega desaprobada',
            'estado_paso_metacodigo'       => 34,
            'area_responsable_id'       => 9,
            'primer_flujo_paso'       => 40,
            'nivel'       => 7,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        


        ///ASAS////AS/AS/A/SA/S/AS/////AS///////////
        $this->insert('flujo_paso',array(
            'flujo'      => 1,
            'nombre_paso'      => 'TÉRMINOS DE REFERENCIA',
            'estado_paso_metacodigo'       => 38,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 1,
            'nivel'       => 4,
            'cantidad_dias'       => 5,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 1,
            'nombre_paso'      => 'EXPRESIÓN DE INTERÉS',
            'estado_paso_metacodigo'       => 38,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 1,
            'nivel'       => 5,
            'cantidad_dias'       => 5,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 1,
            'nombre_paso'      => 'EVALUACIÓN DE EXPRESIÓN DE INTERÉS - LISTA CORTA',
            'estado_paso_metacodigo'       => 38,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 1,
            'nivel'       => 6,
            'cantidad_dias'       => 5,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 1,
            'nombre_paso'      => 'FECHA DE RECEPCIÓN Y APERTURA DE SOBRES',
            'estado_paso_metacodigo'       => 38,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 1,
            'nivel'       => 7,
            'cantidad_dias'       => 5,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        
        
        //PASOS PARA FLUJO DE ADQUISICION BM
        $this->insert('flujo_paso',array(
            'flujo'      => 7,
            'nombre_paso'      => 'En digitación',
            'estado_paso_metacodigo'       => 31,
            'area_responsable_id'       => 9,
            'primer_flujo_paso'       => 57,
            'nivel'       => 1,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 7,
            'nombre_paso'      => 'Por Aprobar',
            'estado_paso_metacodigo'       => 32,
            'area_responsable_id'       => 8,
            'primer_flujo_paso'       => 57,
            'nivel'       => 2,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 7,
            'nombre_paso'      => 'Aprobado',
            'estado_paso_metacodigo'       => 67,
            'area_responsable_id'       => 9,
            'primer_flujo_paso'       => 57,
            'nivel'       => 3,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 7,
            'nombre_paso'      => 'Desaprobado',
            'estado_paso_metacodigo'       => 34,
            'area_responsable_id'       => 9,
            'primer_flujo_paso'       => 57,
            'nivel'       => 3,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 7,
            'nombre_paso'      => 'Certificación',
            'estado_paso_metacodigo'       => 32,
            'area_responsable_id'       => 12,
            'primer_flujo_paso'       => 57,
            'nivel'       => 4,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 7,
            'nombre_paso'      => 'Certificación Aprobada',
            'estado_paso_metacodigo'       => 33,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 57,
            'nivel'       => 5,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 7,
            'nombre_paso'      => 'Certificación Desaprobada',
            'estado_paso_metacodigo'       => 34,
            'area_responsable_id'       => 9,
            'primer_flujo_paso'       => 57,
            'nivel'       => 5,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 7,
            'nombre_paso'      => 'Tipo de Adquisición 1',
            'estado_paso_metacodigo'       => 38,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 57,
            'nivel'       => 6,
            'cantidad_dias'       => 1,
            'nivel_siguiente'  => 7,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 7,
            'nombre_paso'      => 'Tipo de Adquisición 2',
            'estado_paso_metacodigo'       => 38,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 57,
            'nivel'       => 6,
            'cantidad_dias'       => 1,
            'nivel_siguiente'  => 8,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 7,
            'nombre_paso'      => 'Tipo de Adquisición 3',
            'estado_paso_metacodigo'       => 38,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 57,
            'nivel'       => 6,
            'cantidad_dias'       => 1,
            'nivel_siguiente'  => 9,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 7,
            'nombre_paso'      => 'Estudio de Mercado 1',
            'estado_paso_metacodigo'       => 32,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 57,
            'nivel'       => 7,
            'cantidad_dias'       => 1,
            'nivel_siguiente'  => 10,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 7,
            'nombre_paso'      => 'Estudio de Mercado 2',
            'estado_paso_metacodigo'       => 32,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 57,
            'nivel'       => 8,
            'cantidad_dias'       => 1,
            'nivel_siguiente'  => 16,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 7,
            'nombre_paso'      => 'Estudio de Mercado 3',
            'estado_paso_metacodigo'       => 32,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 57,
            'nivel'       => 9,
            'cantidad_dias'       => 1,
            'nivel_siguiente'  => 21,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 7,
            'nombre_paso'      => 'Estudio de Mercado 1 Aprobado',
            'estado_paso_metacodigo'       => 33,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 57,
            'nivel'       => 10,
            'cantidad_dias'       => 1,
            'nivel_siguiente'  => 11,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 7,
            'nombre_paso'      => 'Estudio de Mercado 1 Desaprobado',
            'estado_paso_metacodigo'       => 34,
            'area_responsable_id'       => 9,
            'primer_flujo_paso'       => 57,
            'nivel'       => 10,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 7,
            'nombre_paso'      => 'Revisión TDR',
            'estado_paso_metacodigo'       => 38,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 57,
            'nivel'       => 11,
            'cantidad_dias'       => 1,
            'nivel_siguiente'  => 12,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 7,
            'nombre_paso'      => 'Expresión de Interés',
            'estado_paso_metacodigo'       => 38,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 57,
            'nivel'       => 12,
            'cantidad_dias'       => 1,
            'nivel_siguiente'  => 13,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 7,
            'nombre_paso'      => 'Evaluación de Expresión de Interés',
            'estado_paso_metacodigo'       => 32,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 57,
            'nivel'       => 13,
            'cantidad_dias'       => 1,
            'nivel_siguiente'  => 14,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 7,
            'nombre_paso'      => 'Resultado de expresión de interés cubierto',
            'estado_paso_metacodigo'       => 33,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 57,
            'nivel'       => 14,
            'cantidad_dias'       => 1,
            'nivel_siguiente'  => 15,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 7,
            'nombre_paso'      => 'Resultado de expresión de interés no cubierto',
            'estado_paso_metacodigo'       => 34,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 57,
            'nivel'       => 14,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 7,
            'nombre_paso'      => 'Negociación de Contrato',
            'estado_paso_metacodigo'       => 40,
            'area_responsable_id'       => 13,
            'primer_flujo_paso'       => 57,
            'nivel'       => 15,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 7,
            'nombre_paso'      => 'Expresión de Interés',
            'estado_paso_metacodigo'       => 38,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 57,
            'nivel'       => 16,
            'cantidad_dias'       => 1,
            'nivel_siguiente'  => 17,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 7,
            'nombre_paso'      => 'Lista Corta',
            'estado_paso_metacodigo'       => 38,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 57,
            'nivel'       => 17,
            'cantidad_dias'       => 1,
            'nivel_siguiente'  => 18,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 7,
            'nombre_paso'      => 'Evaluación de Lista Corta',
            'estado_paso_metacodigo'       => 32,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 57,
            'nivel'       => 18,
            'cantidad_dias'       => 1,
            'nivel_siguiente'  => 19,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 7,
            'nombre_paso'      => 'Ganador Lista Corta',
            'estado_paso_metacodigo'       => 33,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 57,
            'nivel'       => 19,
            'cantidad_dias'       => 1,
            'nivel_siguiente'  => 20,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 7,
            'nombre_paso'      => 'Lista Corta Desierta',
            'estado_paso_metacodigo'       => 34,
            'area_responsable_id'       => 9,
            'primer_flujo_paso'       => 57,
            'nivel'       => 19,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 7,
            'nombre_paso'      => 'Negociación de Contrato',
            'estado_paso_metacodigo'       => 40,
            'area_responsable_id'       => 13,
            'primer_flujo_paso'       => 57,
            'nivel'       => 20,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 7,
            'nombre_paso'      => 'Justificación de Adjudicación Directa',
            'estado_paso_metacodigo'       => 38,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 57,
            'nivel'       => 21,
            'cantidad_dias'       => 1,
            'nivel_siguiente'  => 22,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 7,
            'nombre_paso'      => 'Resultado de Adjudicación Directa',
            'estado_paso_metacodigo'       => 38,
            'area_responsable_id'       => 11,
            'primer_flujo_paso'       => 57,
            'nivel'       => 22,
            'cantidad_dias'       => 1,
            'nivel_siguiente'  => 23,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('flujo_paso',array(
            'flujo'      => 7,
            'nombre_paso'      => 'Negociación de Contrato',
            'estado_paso_metacodigo'       => 40,
            'area_responsable_id'       => 13,
            'primer_flujo_paso'       => 57,
            'nivel'       => 23,
            'cantidad_dias'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        
        
        
        ////UPDATES DESPUES DE INSERTS/////
        //Actualiza el valor de  staff_area_id, donde  staff_persona_id = 1
//        $this->update('staff_persona', ['staff_area_id' => 1], ['staff_persona_id' => 1]);
//        $this->update('staff_persona', ['staff_area_id' => 2], ['staff_persona_id' => 2]);
//        $this->update('staff_persona', ['staff_area_id' => 3], ['staff_persona_id' => 1]);
        
        $this->update('staff_persona', ['staff_area_id' => 1], ['staff_persona_id' => 3]);
        $this->update('staff_persona', ['staff_area_id' => 2], ['staff_persona_id' => 4]);
        $this->update('staff_persona', ['staff_area_id' => 6], ['staff_persona_id' => 5]);
        $this->update('staff_persona', ['staff_area_id' => 7], ['staff_persona_id' => 6]);
        $this->update('staff_persona', ['staff_area_id' => 3], ['staff_persona_id' => 7]);
        $this->update('staff_persona', ['staff_area_id' => 4], ['staff_persona_id' => 8]);
        $this->update('staff_persona', ['staff_area_id' => 8], ['staff_persona_id' => 9]);
        $this->update('staff_persona', ['staff_area_id' => 9], ['staff_persona_id' => 10]);
        $this->update('staff_persona', ['staff_area_id' => 5], ['staff_persona_id' => 11]);
        $this->update('staff_persona', ['staff_area_id' => 9], ['staff_persona_id' => 13]);
        $this->update('staff_persona', ['staff_area_id' => 10], ['staff_persona_id' => 12]);
        $this->update('staff_persona', ['staff_area_id' => 11], ['staff_persona_id' => 14]);
        $this->update('staff_persona', ['staff_area_id' => 12], ['staff_persona_id' => 15]);
        $this->update('staff_persona', ['staff_area_id' => 13], ['staff_persona_id' => 16]);
    }

}
