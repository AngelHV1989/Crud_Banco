<?php

class RegisterModel extends Model
{
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
    public function validarEmail($email)
    {
        try {

            $sql =

                "SELECT * FROM users WHERE email = :email";


            $conexion = $this->db->connect();
            $result = $conexion->prepare($sql);
            $result->bindParam(":email", $email, PDO::PARAM_STR);
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
    public function registrar(User $user)
    {
        try {

            #encriptar password
            $password_encriptado = password_hash($user->password, CRYPT_BLOWFISH);

            $sql = "INSERT INTO users
            VALUES (    
                        null,
                        :name,
                        :email,
                        :password,
                        default,
                        default
                        )";

            $conexion = $this->db->connect();
            $result = $conexion->prepare($sql);
            $result->bindParam(":name", $user->name, PDO::PARAM_STR, 50);
            $result->bindParam(":email", $user->email, PDO::PARAM_STR, 50);
            $result->bindParam(":password", $password_encriptado, PDO::PARAM_STR, 60);
            $result->execute();

            $role_id = 3;
            $sql = "INSERT INTO roles_users
            VALUES (    
                        null,
                        :user_id,
                        :role_id,
                        default,
                        default
                        )";

            $ultimo_id = $conexion->lastInsertId();
            $result = $conexion->prepare($sql);
            $result->bindParam(":user_id", $ultimo_id);
            $result->bindParam(":role_id", $role_id);
            $result->execute();
        } catch (PDOException $e) {

            include('template/partials/errordb.php');
            exit(0);
        }
    }
}
