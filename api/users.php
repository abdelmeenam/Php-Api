<?php
class users
{
    private $con;

    public function __construct()
    {
        $this->con = new mysqli('localhost', 'root', '', 'api');
        if ($this->con->connect_error) {
            die("Connection failed: " . $this->con->connect_error);
        }
    }

    public function all()
    {
        $sql = "SELECT * FROM users";
        $result = $this->con->query($sql);

        if ($result->num_rows > 0) {
            $user_arr = [];
            while ($row = $result->fetch_assoc()) {
                $user_arr[] = $row;
            }
            return $user_arr;
        } else {
            echo "0 results";
        }
        $this->con->close();
    }

    public function add($name, $email, $password)
    {
        $sql = "INSERT INTO `users` (`name`,`email`,`password`) VALUES ('$name', '$email', '$password')";
        $res = $this->con->query($sql);
        return $res;
    }

    public  function update($name, $id)
    {
        $sql = "UPDATE `users` SET `name`= '$name' WHERE `id`='$id'";
        $res = $this->con->query($sql);
        return $res;
    }

    public function delete($id)
    {
        $sql = "DELETE FROM `users` WHERE `id`='$id'";
        $res = $this->con->query($sql);
        return $res;
    }
}
