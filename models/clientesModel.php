<?php

    Class clientesModel extends Model{

        // public function __construct(){
        //     parent::__construct();
        // }

        # Extraer todos los clientes de la base de datos.
        public function get() {
            
                        
                try{
                    $consultaSQL = "SELECT 
                    clientes.id,
                    clientes.apellidos,
                    clientes.nombre,
                    clientes.telefono,
                    clientes.ciudad,
                    clientes.dni,
                    clientes.email
                    
            FROM clientes

            ORDER BY clientes.id";

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

        
        public function create(cliente $cliente){
                try {
                        $sql = 
                        "INSERT INTO clientes VALUES (
                                        null,
                                        :apellidos, 
                                        :nombre, 
                                        :telefono,
                                        :ciudad,
                                        :dni,
                                        :email,
                                        null,
                                        null
                                )";

                        $conexion =$this->db->connect();
                        $pdoSt = $conexion -> prepare($sql);

                        $pdoSt -> bindParam(':apellidos', $cliente -> apellidos, PDO::PARAM_STR, 45);
                        $pdoSt -> bindParam(':nombre', $cliente -> nombre, PDO::PARAM_STR, 20);
                        $pdoSt -> bindParam(':telefono', $cliente -> telefono, PDO::PARAM_INT, 9);
                        $pdoSt -> bindParam(':ciudad', $cliente -> ciudad, PDO::PARAM_STR, 30);
                        $pdoSt -> bindParam(':dni', $cliente -> dni, PDO::PARAM_STR, 9);
                        $pdoSt -> bindParam(':email', $cliente -> email, PDO::PARAM_STR, 45);
                        
                        $pdoSt -> execute();
                        //return $pdoSt -> fetchAll();

                } catch(Exception $e){
        
                        include("template/partials/errordb.php");
                        exit();

                } 
        }
        public function read($id){
                try {
                        $consultaSQL = "select * from clientes where id = :id limit 1";

                        $conexion =$this->db->connect();
                        $result = $conexion -> prepare($consultaSQL);

                        $result->bindparam(':id', $id, PDO::PARAM_INT);
                        $result->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,'cliente');
                        
                        $result -> execute();
                        return $result->fetch();
                }
                catch(Exception $e){
        
                        include("template/partials/errordb.php");
                        exit();

                } 
        }

        public function update(cliente $cliente, $id) {
                try {
                    // Consulta para traer los clientes y su curso
                    $sql = 'UPDATE clientes SET
                            apellidos = :apellidos,
                            nombre = :nombre,
                            telefono = :telefono,
                            ciudad = :ciudad,
                            dni = :dni,
                            email = :email
                            
        
                            WHERE id = :id
                            LIMIT 1';
        
        
                    # Conectar con la base de datos
                    $conexion = $this->db->connect();
        
                    // Preparar consulta SQL
                    $pdoSt = $conexion->prepare($sql);
        
                    // Parámetros
                    $pdoSt->bindParam(':id', $id, PDO::PARAM_INT);
                    $pdoSt->bindParam(':apellidos', $cliente->apellidos, PDO::PARAM_STR, 45);
                    $pdoSt->bindParam(':nombre', $cliente->nombre, PDO::PARAM_STR, 20);
                    $pdoSt -> bindParam(':telefono', $cliente -> telefono, PDO::PARAM_INT, 9);
                    $pdoSt->bindParam(':ciudad', $cliente->ciudad, PDO::PARAM_STR, 30);
                    $pdoSt->bindParam(':dni', $cliente->dni, PDO::PARAM_STR, 9);
                    $pdoSt->bindParam(':email', $cliente->email, PDO::PARAM_STR, 45);
        
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
                                
                                
                                $sql = "DELETE FROM clientes

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
                                $consultaSQL = "select 
                                c.id, 
                                c.apellidos,
                                c.nombre,
                                c.telefono,
                                c.ciudad,
                                c.email
                                from clientes AS c
                                ORDER BY :criterio
                                ";
                
                            $conexion = $this->db->connect();
                            $result = $conexion->prepare($consultaSQL);
                            $result->bindParam(":criterio",$criterio,PDO::PARAM_INT);
                
                            $result->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,'cliente');
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
                                $sql = "select 
                                clientes.id,
                                clientes.apellidos,
                                clientes.nombre,
                                clientes.telefono,
                                clientes.ciudad,
                                clientes.email

                                FROM clientes 
                                
                                 WHERE 
                                        CONCAT_WS(',', clientes.id,
                                                        clientes.apellidos,
                                                        clientes.nombre,
                                                        clientes.telefono,
                                                        clientes.ciudad,
                                                        clientes.email)
                                                LIKE :Expresion
                                                ORDER BY id ASC";

                                $conexion = $this->db->connect();
                                $resultSet = $conexion->prepare($sql);
                                $resultSet->bindValue(':Expresion', '%'.$Expresion.'%', PDO::PARAM_STR);
                                $resultSet->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,'cliente');
                                //$resultSet->setFetchMode(PDO::FETCH_OBJ);
                                $resultSet->execute();
                                return $resultSet;
                                
                                

                         }
                        catch (Exception $e){
                                include("template/partials/errordb.php");
                                exit();

                        }
                }

                # Validad Email
                public function validarEmail($email) {
                        try {
                
                            $sql = 
                                    
                                "SELECT * FROM clientes WHERE email = :email";
                            
                            
                            $conexion = $this->db->connect();
                            $result = $conexion->prepare($sql);
                            $result->bindParam(":email",$email,PDO::PARAM_STR);
                            $result->execute();
                
                            if($result->rowCount() == 0){
                
                                return TRUE;
                            }
                                
                            return FALSE;
                            // return $result->fetch();
                        } 
                    
                        catch (PDOException $e) {	
                    
                                include('template/partials/errordb.php');
                                exit();
                            }
                    
                    }
                # Validad Dni
                public function validarDni($dni) {
                        try{
                                $sql = 
                                "SELECT * FROM clientes WHERE dni = :dni";

                                # Conectamos con la base de datos
                                $conexion = $this->db->connect();

                                # Ejecutamos mediante prepate la consulta SQL
                                $resultSet = $conexion->prepare($sql);
                                $resultSet->bindParam(":dni",$dni,PDO::PARAM_STR);
                                
                                
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
                public function validarTelefono($telefono) {
                        try{
                                $sql = 
                                "SELECT * FROM clientes WHERE telefono = :telefono";

                                # Conectamos con la base de datos
                                $conexion = $this->db->connect();

                                # Ejecutamos mediante prepate la consulta SQL
                                $resultSet = $conexion->prepare($sql);
                                $resultSet->bindParam(":telefono",$telefono,PDO::PARAM_STR);
                                
                                
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
                public function clientesModel(){
                        try{
                                $consultaSQL = "SELECT 
                                clientes.id,
                                clientes.apellidos,
                                clientes.nombre,
                                clientes.telefono,
                                clientes.ciudad,
                                clientes.dni,
                                clientes.email
                                
                        FROM clientes
            
                        ORDER BY clientes.id";
            
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
    

?>