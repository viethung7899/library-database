<?php

namespace app\models;

use app\core\Model;

class Reservation extends Model {
    public static function addReservation(string $user_id, string $isbn, date $pickup_date) {
        $statement = self::getDatabase()->prepare("INSERT INTO reservation (user_id, isbn, pickupDate) VALUES (:id, :isbn, :pickup)");
        $statement->bindValue(':id', $user_id);
        $statement->bindValue(':isbn', $isbn);
        $statement->bindValue(':pickup', $pickup_date);
        return $statement->execute();
    }
}
?>