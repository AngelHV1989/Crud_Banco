<?php
class AuthModel Extends Model {
public function getUserId($id) {
    try {

        $sql = "SELECT * FROM Users WHERE id = :id LIMIT 1";


        $conexion = $this->db->connect();
        $result = $conexion->prepare($sql);
        $result->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,'user');
        $result->bindParam(":id", $id, PDO::PARAM_INT);
        $result->execute();

        return $result->fetch();

    } catch (PDOException $e) {

        include('template/partials/errordb.php');
        exit(0);
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

public function validarName($name)
    {
        try {

            $sql =

                "SELECT * FROM users WHERE name = :name";


            $conexion = $this->db->connect();
            $result = $conexion->prepare($sql);
            $result->bindParam(":name", $name, PDO::PARAM_STR);
            $result->execute();

            if ($result->rowCount() == 0) {
                return TRUE;
            }
            return FALSE;
        } catch (PDOException $e) {

            include('template/partials/errordb.php');
            exit(0);
        }
    }
    public function update (User $user){
        try{
            $sql = "
                    UPDATE users SET
                    name = :name,
                    email = :email
                    WHERE id = :id
                    LIMIT 1
                    ";
                    $conexion = $this->db->connect();
                    $result = $conexion->prepare($sql);
                    $result->bindParam(":name", $user->name, PDO::PARAM_STR, 50);
                    $result->bindParam(":email", $user->email, PDO::PARAM_STR, 50);
                    $result->bindParam(":id", $user->id, PDO::PARAM_INT);
                    $result->execute();
        }catch (PDOException $e){
            include('template/partials/errordb.php');
            exit(0);
        }
    }

    public function update_password (User $user){
        try{
            $password_encriptado = password_hash($user->password, CRYPT_BLOWFISH);
            $sql = "
                    UPDATE users SET
                    password = :password
                    WHERE id = :id
                    LIMIT 1
                    ";
                    $conexion = $this->db->connect();
                    $result = $conexion->prepare($sql);
                    $result->bindParam(":password", $password_encriptado, PDO::PARAM_STR, 60);
                    $result->bindParam(":id", $user->id, PDO::PARAM_INT);
                    $result->execute();
        }catch (PDOException $e){
            include('template/partials/errordb.php');
            exit(0);
        }
    }

    public function delete(User $user){

        try {
                
                
                $sql = "DELETE FROM users

                where id = :id
                Limit 1";

                # Conectar con la base de datos
                $conexion = $this->db->connect();
                        
                // Preparar consulta SQL
                $pdoSt = $conexion->prepare($sql);
                $pdoSt->bindParam(':id', $user->id, PDO::PARAM_INT);
                // var_dump($user->id);
                // exit();
                $pdoSt -> execute();
                


        } catch(Exception $e){

                include("template/partials/errordb.php");
                exit(0);

        }

}

}