<?php

    Class cuentasModel extends Model{

        // public function __construct(){
        //     parent::__construct();
        // }

        # Extraer todos los cuentas de la base de datos.
        public function get() {
            
                        
                try{
                    $consultaSQL = "SELECT 
                    cuentas.id,
                    cuentas.num_cuenta,
                    clientes.apellidos,
                    clientes.nombre,
                    cuentas.fecha_alta,
                    cuentas.fecha_ul_mov,
                    cuentas.num_movtos,
                    cuentas.saldo
                    
            FROM cuentas
            
                    
                    INNER JOIN Clientes ON cuentas.id_cliente = clientes.id

            ORDER BY cuentas.id";

                        $conexion = $this->db->connect();
                        $resultSet = $conexion->prepare($consultaSQL);
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
        public function getClientes(){
                try{
                        $consultaSQL = "select 
                                        id,
                                        apellidos, 
                                        nombre

                                from Clientes";

                        $conexion = $this->db->connect();
                        $resultSet = $conexion->prepare($consultaSQL);
                        $resultSet->setFetchMode(PDO::FETCH_OBJ);
                        $resultSet->execute();
                        return $resultSet;

                 }
                catch (Exception $e){
                        include("template/partials/errordb.php");
                        exit();

                }
        }
        public function getCliente($indice){
                $sentencia = "select id_cliente from cuentas where id = $indice";
            $id_cliente = $this->db->connect()->query($sentencia)->fetch(PDO::FETCH_OBJ);
            $id_cliente = $id_cliente->id_cliente;
                try{
                        $consultaSQL = "select 
                                        id,
                                        apellidos, 
                                        nombre

                                from Clientes
                                where id= $id_cliente
                                limit 1";

                        $conexion = $this->db->connect();
                        $resultSet = $conexion->prepare($consultaSQL);
                        
                        $resultSet->setFetchMode(PDO::FETCH_OBJ);
                        $resultSet->execute();
                        return $resultSet;

                 }
                catch (Exception $e){
                        include("template/partials/errordb.php");
                        exit();

                }
        }

        
        public function create(cuenta $cuenta){
                try {
                        $sql = 
                        "INSERT INTO cuentas VALUES (
                                        null,
                                        :num_cuenta,
                                        :id_cliente, 
                                        default,
                                        0000-00-00,
                                        0,
                                        0,
                                        null,
                                        null
                                )";

                        $conexion =$this->db->connect();
                        $pdoSt = $conexion -> prepare($sql);
                        $pdoSt -> bindParam(':num_cuenta', $cuenta -> num_cuenta, PDO::PARAM_STR, 20);
                        $pdoSt -> bindParam(':id_cliente', $cuenta -> id_cliente, PDO::PARAM_INT, 10);
                        
                        $pdoSt -> execute();

                } catch(Exception $e){
        
                        include("template/partials/errordb.php");
                        exit();

                } 
        }
        public function read($id){
                try {
                        $consultaSQL = "select * from cuentas where id = :id limit 1";

                        $conexion =$this->db->connect();
                        $result = $conexion -> prepare($consultaSQL);

                        $result->bindparam(':id', $id, PDO::PARAM_INT);
                        $result->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,'cuenta');
                        
                        $result -> execute();
                        return $result->fetch();
                }
                catch(Exception $e){
        
                        include("template/partials/errordb.php");
                        exit();

                } 
        }

        public function update(cuenta $cuenta, $id) {
                try {
                    // Consulta para traer los cuentas y su curso
                    $sql = 'UPDATE cuentas SET
                            num_cuenta = :num_cuenta,
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
                    $pdoSt -> bindParam(':num_cuenta', $cuenta -> num_cuenta, PDO::PARAM_STR, 20);
                        $pdoSt -> bindParam(':id_cliente', $cuenta -> id_cliente, PDO::PARAM_INT, 10);
                        $pdoSt -> bindParam(':fecha_alta', $cuenta -> fecha_alta);
                        $pdoSt -> bindParam(':fecha_ul_mov', $cuenta -> fecha_ul_mov);
                        $pdoSt -> bindParam(':num_movtos', $cuenta -> num_movtos, PDO::PARAM_INT, 10);
                        $pdoSt -> bindParam(':saldo', $cuenta -> saldo);
        
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
                                
                                
                                $sql = "DELETE FROM cuentas

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
                public function order(int $criterio) {

                        try {
                                $consultaSQL = "SELECT 
                                cuentas.id,
                                cuentas.num_cuenta,
                                clientes.apellidos,
                                clientes.nombre,
                                cuentas.fecha_alta,
                                cuentas.fecha_ul_mov,
                                cuentas.num_movtos,
                                cuentas.saldo
                                
                                FROM cuentas
                        
                                
                                INNER JOIN Clientes ON cuentas.id_cliente = clientes.id
                                ORDER BY :criterio
                                ";
                
                            $conexion = $this->db->connect();
                            $result = $conexion->prepare($consultaSQL);
                            $result->bindParam(":criterio",$criterio,PDO::PARAM_INT);
                
                            $result->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,'cuenta');
                            $result->execute();
                            
                            return $result;
                        }
                        catch (Exception $e){
                                include("template/partials/errordb.php");
                                exit();

                        }
                }
                public function filter($Expresion){
                        
                        try{
                                $sql = "SELECT 
                                cuentas.id,
                                cuentas.num_cuenta,
                                clientes.apellidos,
                                clientes.nombre,
                                cuentas.fecha_alta,
                                cuentas.fecha_ul_mov,
                                cuentas.num_movtos,
                                cuentas.saldo
                                
                                FROM cuentas
                        
                                
                                INNER JOIN Clientes ON cuentas.id_cliente = clientes.id
                                
                                 WHERE 
                                        CONCAT_WS(',', cuentas.id,
                                        cuentas.num_cuenta,
                                        clientes.apellidos,
                                        clientes.nombre,
                                        cuentas.fecha_alta,
                                        cuentas.fecha_ul_mov,
                                        cuentas.num_movtos,
                                        cuentas.saldo)
                                                LIKE :Expresion
                                                ORDER BY id ASC";

                                $conexion = $this->db->connect();
                                $resultSet = $conexion->prepare($sql);
                                $resultSet->bindValue(':Expresion', '%'.$Expresion.'%', PDO::PARAM_STR);
                                $resultSet->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,'cuenta');
                                //$resultSet->setFetchMode(PDO::FETCH_OBJ);
                                $resultSet->execute();
                                return $resultSet;
                                
                                

                         }
                        catch (Exception $e){
                                include("template/partials/errordb.php");
                                exit();

                        }
                }
                # Validad Num_Cuenta
                public function validarNum_Cuenta($num_cuenta) {
                        try{
                                $sql = 
                                "SELECT * FROM cuentas WHERE num_cuenta = :num_cuenta";

                                # Conectamos con la base de datos
                                $conexion = $this->db->connect();

                                # Ejecutamos mediante prepate la consulta SQL
                                $resultSet = $conexion->prepare($sql);
                                $resultSet->bindParam(":num_cuenta",$num_cuenta,PDO::PARAM_INT);
                                
                                
                                $resultSet->execute();

                                if ($resultSet->rowCount() == 0){
                                        return TRUE;     
                                }
                                return FALSE;
                                

                        } catch (Exception $e){
                                include("template/partials/errordb.php");
                                exit();
                        }
                }
                # Validad Num_Cuenta
                public function validarId_Cliente($id_cliente) {
                        try{
                                $sql = 
                                "SELECT * FROM clientes WHERE id = :id_cliente";

                                # Conectamos con la base de datos
                                $conexion = $this->db->connect();

                                # Ejecutamos mediante prepate la consulta SQL
                                $resultSet = $conexion->prepare($sql);
                                $resultSet->bindParam(":id_cliente",$id_cliente,PDO::PARAM_INT);
                                
                                
                                $resultSet->execute();

                                if ($resultSet->rowCount() == 0){
                                        return TRUE;     
                                }
                                return FALSE;
                                

                        } catch (Exception $e){
                                include("template/partials/errordb.php");
                                exit();
                        }
                }

                public function cuentasModel(){
                        try{
                                $consultaSQL = "SELECT 
                                cuentas.id,
                                cuentas.num_cuenta,
                                clientes.apellidos,
                                clientes.nombre,
                                cuentas.fecha_alta,
                                cuentas.fecha_ul_mov,
                                cuentas.num_movtos,
                                cuentas.saldo
                                
                        FROM cuentas
                        
                                
                                INNER JOIN Clientes ON cuentas.id_cliente = clientes.id
            
                        ORDER BY cuentas.id";
            
                                    $conexion = $this->db->connect();
                                    $resultSet = $conexion->prepare($consultaSQL);
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
