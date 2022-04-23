<?php
class crudauto
{
    private $db;
    function __construct($conn)
    {
        $this->db = $conn;
    }

    public function update($id, $matricula, $marca,$modelo,$color,$precio)
    {
        try {
            $stmt = $this->db->prepare("update automovil set matricula= :matricula, marca= :marca, modelo= :modelo, color= :color, precio= :precio where id= :id");
            $stmt->bindParam(":matricula", $matricula);
            $stmt->bindParam(":marca", $marca);
            $stmt->bindParam(":modelo", $modelo);
            $stmt->bindParam(":color", $color);
            $stmt->bindParam(":precio", $precio);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // echo $e->getMessage();
            // return false;
            throw $e;
        }
    }
    public function getID($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM automovil WHERE id=:id");
        $stmt->execute(array(":id" => $id));
        $editRow = $stmt->fetch(PDO::FETCH_ASSOC);
        return $editRow;
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE  FROM automovil WHERE id=:id");
        $stmt->bindparam(":id", $id);
       $stmt->execute();
        return true;
    }

    //Muestra los datos en la tabla
    public function dataauto($query)
    {
        $stmt = $this->db->prepare($query);
        $stmt->execute() > 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['matricula']; ?></td>
                <td><?php echo $row['marca']; ?></td>
                <td><?php echo $row['modelo']; ?></td>
                <td><?php echo $row['color']; ?></td>
                <td>$<?php echo $row['precio']; ?></td>
                <td>
                <a class="btn btn-large btn-success" href="edit_auto.php?edit_id=<?php echo $row['id'] ?>"> Editar</a>
                </td>
                <td>
                <a class="btn btn-large btn-danger" href="eliminar_auto.php?delete_id=<?php echo $row['id'] ?>"><i class="fa fa-trash" aria-hidden="true"></i> Eliminar</a>
                </td>
            </tr>

<?php

        }
    }
}