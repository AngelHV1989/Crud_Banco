<?php
class loginModel Extends Model {
    # Devuvelve objeto user a partir del email
    public function getUserEmail($email){
        try {

            $sql = "SELECT * FROM Users WHERE email = :email LIMIT 1";


            $conexion = $this->db->connect();
            $result = $conexion->prepare($sql);
            $result->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,'user');
            $result->bindParam(":email", $email, PDO::PARAM_STR);
            $result->execute();

            return $result->fetch();

        } catch (PDOException $e) {

            include('template/partials/errordb.php');
            exit(0);
        }
    }

    public function getUserIdPerfil($id){
        try {

            $sql = "SELECT ru.role_id 
            FROM 
                Users u
            INNER JOIN
                roles_users ru ON u.id = ru.user_id
            WHERE 
                u.id = :id 
            LIMIT 1";


            $conexion = $this->db->connect();
            $result = $conexion->prepare($sql);
            $result->setFetchMode(PDO::FETCH_OBJ);
            $result->bindParam(":id", $id, PDO::PARAM_INT);
            $result->execute();

            return $result->fetch()->role_id;

        } catch (PDOException $e) {

            include('template/partials/errordb.php');
            exit(0);
        }
    }
    public function getUserPerfil($id){
        try {

            $sql = "SELECT name
            FROM 
                roles
            
            WHERE 
                id = :id 
            LIMIT 1";


            $conexion = $this->db->connect();
            $result = $conexion->prepare($sql);
            $result->setFetchMode(PDO::FETCH_OBJ);
            $result->bindParam(":id", $id, PDO::PARAM_INT);
            $result->execute();

            return $result->fetch()->name;

        } catch (PDOException $e) {

            include('template/partials/errordb.php');
            exit(0);
        }
    }
}