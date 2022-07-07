<?php

    Class movimientosModel extends Model{

        // public function __construct(){
        //     parent::__construct();
        // }

        # Extraer todos los movimientos de la base de datos.
        
        public function get($id_cuenta) {
                
                       
                try{
                    $consultaSQL = "SELECT 
                    movimientos.id,
                    cuentas.num_cuenta,
                    movimientos.fecha_hora,
                    movimientos.concepto,
                    movimientos.tipo,
                    movimientos.cantidad,
                    movimientos.saldo
                    
            FROM movimientos
            
                    
                    INNER JOIN cuentas ON movimientos.id_cuenta = cuentas.id
                    where movimientos.id_cuenta = :id_cuenta

            ";

                        $conexion = $this->db->connect();
                        $resultSet = $conexion->prepare($consultaSQL);
                        $resultSet->bindParam(":id_cuenta",$id_cuenta,PDO::PARAM_INT);
                        //$resultSet->setFetchMode(PDO::FETCH_CLASS, 'cliente');
                        //$resultSet->setFetchMode(PDO::FETCH_OBJ);
                        $resultSet->setFetchMode(PDO::FETCH_OBJ);
                        $resultSet->execute();
                        return $resultSet;
                        //return $resultSet->fetchAll();
                        

              
                 }
                catch (Exception $e){
                        include("template/partials/errordb.php");
                        exit();

                }


        
        
            
        }
        
        
        public function create(movimiento $movimiento){
                $sentencia = "select saldo from cuentas where id = $movimiento->id_cuenta";
            $saldo = $this->db->connect()->query($sentencia)->fetch(PDO::FETCH_OBJ);
            $saldo = $saldo->saldo;
                 if($movimiento->tipo == "I"){
                         $saldo = $saldo + $movimiento->cantidad;
                 }
                 else if($movimiento->tipo == "R"){
                         $saldo = $saldo - $movimiento->cantidad;   
                 }
                 $sentenciaNumMovtos = "select num_movtos from cuentas where id = $movimiento->id_cuenta";
                 $numMovtos = $this->db->connect()->query($sentenciaNumMovtos)->fetch(PDO::FETCH_OBJ);
                 $numMovtos = $numMovtos->num_movtos;
                 $numMovtos = $numMovtos + 1;
                 $sentenciaFechaUltMov = "select fecha_ul_mov from cuentas where id = $movimiento->id_cuenta";
                 $fechaUltMov = $this->db->connect()->query($sentenciaFechaUltMov)->fetch(PDO::FETCH_OBJ);
                 $fechaUltMov = $fechaUltMov->fecha_ul_mov;
                try {
                        $sql = 
                        "INSERT INTO movimientos VALUES (
                                        null,
                                        :id_cuenta,
                                        :fecha_hora, 
                                        :concepto,
                                        :tipo,
                                        :cantidad,
                                        :saldo,
                                        null,
                                        null
                                        
                                )";
$sentenciaCuenta = "update cuentas set saldo = $saldo, num_movtos = $numMovtos, fecha_ul_mov = now() where id = $movimiento->id_cuenta";
                        $conexion =$this->db->connect();
                        $pdoSt = $conexion -> prepare($sql);
                        $pdoSt -> bindParam(':id_cuenta', $movimiento -> id_cuenta, PDO::PARAM_STR, 20);
                        $pdoSt -> bindParam(':fecha_hora', $movimiento -> fecha_hora);
                        $pdoSt -> bindParam(':concepto', $movimiento -> concepto, PDO::PARAM_STR, 50);
                        $pdoSt -> bindParam(':tipo', $movimiento -> tipo);
                        $pdoSt -> bindParam(':cantidad', $movimiento -> cantidad);
                        $pdoSt -> bindParam(':saldo', $saldo);
                        //$pdoSt->bindParam(":id_cuenta",$id_cuenta,PDO::PARAM_INT);
                        
                        
                        $pdoSt -> execute();
                        $resultado = $conexion->prepare($sentenciaCuenta);
                        $resultado -> execute();
                        //return $pdoSt -> fetchAll();

                } catch(Exception $e){
        
                        include("template/partials/errordb.php");
                        exit();

                } 
        }
        public function read($id){
                try {
                        $consultaSQL = "select * from movimientos where id = :id limit 1";

                        $conexion =$this->db->connect();
                        $result = $conexion -> prepare($consultaSQL);

                        $result->bindparam(':id', $id, PDO::PARAM_INT);
                        $result->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,'movimiento');
                        
                        $result -> execute();
                        return $result->fetch();
                }
                catch(Exception $e){
        
                        include("template/partials/errordb.php");
                        exit();

                } 
        }

        public function update(movimiento $movimiento, $id) {
                try {
                    // Consulta para traer los movimientos y su curso
                    $sql = 'UPDATE movimientos SET
                            num_movimiento = :num_movimiento,
                            id_cliente = :id_cliente,
                            fecha_alta = :fecha_alta,
                            fecha_ul_mov = :fecha_ul_mov,
                            num_movtos = :num_movtos,
                            saldo = :saldo
                            
        
                            WHERE id = :id
                            LIMIT 1';
        
        
                    # Conectar con la base de datos
                    $conexion = $this->db->connect();
        
                    // Preparar consulta SQL
                    $pdoSt = $conexion->prepare($sql);
        
                    // Parámetros
                    $pdoSt->bindParam(':id', $id, PDO::PARAM_INT);
                    $pdoSt -> bindParam(':num_movimiento', $movimiento -> num_movimiento, PDO::PARAM_STR, 20);
                        $pdoSt -> bindParam(':id_cliente', $movimiento -> id_cliente, PDO::PARAM_INT, 10);
                        $pdoSt -> bindParam(':fecha_alta', $movimiento -> fecha_alta);
                        $pdoSt -> bindParam(':fecha_ul_mov', $movimiento -> fecha_ul_mov);
                        $pdoSt -> bindParam(':num_movtos', $movimiento -> num_movtos, PDO::PARAM_INT, 10);
                        $pdoSt -> bindParam(':saldo', $movimiento -> saldo);
        
                    // Ejecutar consulta SQL
                    $pdoSt->execute();
        
                    // Si hay resultados, retornar array
                    return $pdoSt -> fetchAll();
                    // En caso de excepción
                } catch(Exception $e){
        
                        include("template/partials/errordb.php");
                        exit();

                }
            }

            public function delete($indice){

                        try {
                                
                                
                                $sql = "DELETE FROM movimientos

                                where id = :id
                                Limit 1";

                                # Conectar con la base de datos
                                $conexion = $this->db->connect();
                                        
                                // Preparar consulta SQL
                                $pdoSt = $conexion->prepare($sql);
                                $pdoSt->bindParam(':id', $indice, PDO::PARAM_INT);
                                
                                
                                $pdoSt -> execute();
                                //return $pdoSt -> fetchAll();
                                

                                

                        } catch(Exception $e){
                
                                include("template/partials/errordb.php");
                                exit();

                        }

                }
                public function order(int $criterio, $id_cuenta) {

                        try {
                                $consultaSQL = "SELECT 
                                movimientos.id,
                                cuentas.num_cuenta,
                                movimientos.fecha_hora,
                                movimientos.concepto,
                                movimientos.tipo,
                                movimientos.cantidad,
                                movimientos.saldo
                                
                        FROM movimientos
                        
                                
                                INNER JOIN cuentas ON movimientos.id_cuenta = cuentas.id
                                where movimientos.id_cuenta = :id_cuenta
                                ORDER BY :criterio
                                ";
                
                            $conexion = $this->db->connect();
                            $result = $conexion->prepare($consultaSQL);
                            $result->bindParam(":criterio",$criterio,PDO::PARAM_INT);
                            $result->bindParam(":id_cuenta",$id_cuenta,PDO::PARAM_INT);
                            $result->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,'movimiento');
                            $result->execute();
                            
                            return $result;
                        }
                        catch (Exception $e){
                                include("template/partials/errordb.php");
                                exit();

                        }
                }
                public function filter($Expresion, $id_cuenta){
                        
                        try{
                                $sql = "SELECT 
                                movimientos.id,
                                cuentas.num_cuenta,
                                movimientos.fecha_hora,
                                movimientos.concepto,
                                movimientos.tipo,
                                movimientos.cantidad,
                                movimientos.saldo
                                
                        FROM movimientos
                        
                                
                                INNER JOIN cuentas ON movimientos.id_cuenta = cuentas.id
                                
                                
                                 WHERE 
                                 movimientos.id_cuenta = :id_cuenta and
                                        CONCAT_WS(',', movimientos.id,
                                cuentas.num_cuenta,
                                movimientos.fecha_hora,
                                movimientos.concepto,
                                movimientos.tipo,
                                movimientos.cantidad,
                                movimientos.saldo)
                                                LIKE :Expresion
                                                ORDER BY id ASC";

                                $conexion = $this->db->connect();
                                $resultSet = $conexion->prepare($sql);
                                $resultSet->bindParam(":id_cuenta",$id_cuenta,PDO::PARAM_INT);
                                $resultSet->bindValue(':Expresion', '%'.$Expresion.'%', PDO::PARAM_STR);
                                $resultSet->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,'movimiento');
                                //$resultSet->setFetchMode(PDO::FETCH_OBJ);
                                $resultSet->execute();
                                return $resultSet;
                                
                                

                         }
                        catch (Exception $e){
                                include("template/partials/errordb.php");
                                exit();

                        }
                }

                public function movimientosModel($id_cuenta){
                        try{
                                $consultaSQL = "SELECT 
                                movimientos.id,
                                cuentas.num_cuenta,
                                movimientos.fecha_hora,
                                movimientos.concepto,
                                movimientos.tipo,
                                movimientos.cantidad,
                                movimientos.saldo
                                
                        FROM movimientos
                        
                                
                                INNER JOIN cuentas ON movimientos.id_cuenta = cuentas.id
                                where movimientos.id_cuenta = :id_cuenta
            
                        ";
            
                                    $conexion = $this->db->connect();
                                    $resultSet = $conexion->prepare($consultaSQL);
                                    $resultSet->bindParam(":id_cuenta",$id_cuenta,PDO::PARAM_INT);
                                    //$resultSet->setFetchMode(PDO::FETCH_CLASS, 'cliente');
                                    //$resultSet->setFetchMode(PDO::FETCH_OBJ);
                                    $resultSet->setFetchMode(PDO::FETCH_OBJ);
                                    $resultSet->execute();
                                    return $resultSet;
                                    //return $resultSet->fetchAll();
                                    
            
                          
                             }
                            catch (Exception $e){
                                    include("template/partials/errordb.php");
                                    exit();
            
                            }
                }
                

    }
