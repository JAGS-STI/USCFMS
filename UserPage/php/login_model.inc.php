<?php 

    declare(strict_types=1);

    function get_email(object $pdo, string $email) {
        $query = "SELECT * FROM useraccount WHERE email = :email;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function get_concernDetail(object $pdo, string $accID) {
        $sql = "SELECT * FROM concernDetail WHERE accID = :accID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":accID", $accID);
        $stmt->execute();

        $userConcernList = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $userConcernList;
    }

    function get_messageDetail(object $pdo, string $accID) {
        $sql = "SELECT messageconcern.concernID, message, messageconcern.dateReceived 
                FROM messageconcern JOIN concerndetail ON messageconcern.concernID = concerndetail.concernID 
                WHERE concerndetail.accID = :accID ORDER BY dateReceived DESC;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":accID", $accID);
        $stmt->execute();

        $userConcernList = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $userConcernList;
    }

?>